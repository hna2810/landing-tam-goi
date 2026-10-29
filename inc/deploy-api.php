<?php
/**
 * Instant Deployment Handler via WordPress REST API
 *
 * Allows rapid deployment directly via WordPress Application Passwords or admin session.
 * Accepts direct ZIP payload or pulls latest commit from GitHub repository.
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('rest_api_init', function () {
    register_rest_route('lx-deploy/v1', '/sync', array(
        'methods'             => array('GET', 'POST'),
        'permission_callback' => function () {
            return current_user_can('manage_options');
        },
        'callback'            => 'lx_handle_remote_deploy',
    ));
});

/**
 * Native recursive copy to guarantee 100% file overwrite regardless of filesystem abstraction
 */
function lx_recursive_copy($src, $dst, &$count = 0) {
    if (!is_dir($src)) {
        return false;
    }
    if (!is_dir($dst)) {
        @mkdir($dst, 0755, true);
    }
    $dir = opendir($src);
    while (false !== ($file = readdir($dir))) {
        if ($file !== '.' && $file !== '..') {
            $src_path = $src . '/' . $file;
            $dst_path = $dst . '/' . $file;
            if (is_dir($src_path)) {
                lx_recursive_copy($src_path, $dst_path, $count);
            } else {
                if (@copy($src_path, $dst_path)) {
                    @chmod($dst_path, 0644);
                    $count++;
                }
            }
        }
    }
    closedir($dir);
    return true;
}

/**
 * Handle remote theme deployment and automatic cache purge
 *
 * @param WP_REST_Request $request REST API request.
 * @return WP_REST_Response
 */
function lx_handle_remote_deploy($request) {
    $start_time = microtime(true);
    $theme_dir  = defined('LX_THEME_DIR') ? LX_THEME_DIR : get_template_directory();

    if (!function_exists('WP_Filesystem')) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }
    WP_Filesystem();

    $upload_dir = wp_upload_dir();
    $temp_zip   = $upload_dir['basedir'] . '/theme-deploy-' . time() . '.zip';
    $temp_dir   = $upload_dir['basedir'] . '/theme-deploy-temp-' . time();

    $body_content = $request->get_body();
    $method_used  = 'github_pull';

    // 1. Direct ZIP upload via POST body
    if (!empty($body_content) && strlen($body_content) > 1000 && substr($body_content, 0, 4) === "PK\x03\x04") {
        $method_used = 'direct_zip_payload';
        file_put_contents($temp_zip, $body_content);
    } else {
        // 2. Fallback: Pull from GitHub repository
        $github_url = 'https://github.com/hna2810/landing-tam-goi/archive/refs/heads/main.zip';
        $response   = wp_remote_get($github_url, array(
            'timeout'   => 30,
            'sslverify' => false,
        ));

        if (is_wp_error($response)) {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Failed to download from GitHub: ' . $response->get_error_message(),
            ), 500);
        }

        $code = wp_remote_retrieve_response_code($response);
        if ($code !== 200) {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'GitHub returned HTTP status ' . $code,
            ), 500);
        }

        file_put_contents($temp_zip, wp_remote_retrieve_body($response));
    }

    if (!file_exists($temp_zip)) {
        return new WP_REST_Response(array(
            'success' => false,
            'message' => 'Temporary zip file could not be written.',
        ), 500);
    }

    // Unzip archive
    $unzip_res = unzip_file($temp_zip, $temp_dir);
    if (is_wp_error($unzip_res)) {
        @unlink($temp_zip);
        return new WP_REST_Response(array(
            'success' => false,
            'message' => 'Unzip failed: ' . $unzip_res->get_error_message(),
        ), 500);
    }

    // Find root theme files
    $source_dir = $temp_dir;
    $items = scandir($temp_dir);
    foreach ($items as $item) {
        if ($item !== '.' && $item !== '..' && is_dir($temp_dir . '/' . $item)) {
            if (file_exists($temp_dir . '/' . $item . '/style.css')) {
                $source_dir = $temp_dir . '/' . $item;
                break;
            }
        }
    }

    // Copy files using robust native recursive copy
    $copied_count = 0;
    lx_recursive_copy($source_dir, $theme_dir, $copied_count);

    // Clean up temporary files
    global $wp_filesystem;
    if ($wp_filesystem) {
        $wp_filesystem->delete($temp_dir, true);
    }
    @unlink($temp_zip);

    // Reset PHP OPcache so new PHP code takes effect immediately
    if (function_exists('opcache_reset')) {
        @opcache_reset();
    }

    // Purge LiteSpeed Cache & WordPress Object Cache
    if (class_exists('LiteSpeed_Cache_API')) {
        LiteSpeed_Cache_API::purge_all();
    }
    if (function_exists('litespeed_purge_all')) {
        litespeed_purge_all();
    }
    do_action('litespeed_purge_all');

    if (!headers_sent()) {
        header('X-LiteSpeed-Purge: *');
    }
    wp_cache_flush();

    $elapsed = round((microtime(true) - $start_time) * 1000);

    return new WP_REST_Response(array(
        'success'        => true,
        'message'        => 'Landing theme deployed successfully in ' . $elapsed . 'ms via Admin API!',
        'method'         => $method_used,
        'files_copied'   => $copied_count,
        'time_ms'        => $elapsed,
        'theme_version'  => '1.5.2',
        'cache_purged'   => true,
        'timestamp'      => time(),
    ), 200);
}
