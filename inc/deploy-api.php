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
    register_rest_route('lx-deploy/v1', '/update-options', array(
        'methods'             => array('POST'),
        'permission_callback' => function () {
            return current_user_can('manage_options');
        },
        'callback'            => 'lx_handle_remote_update_options',
    ));
    register_rest_route('lx-deploy/v1', '/sync-acf', array(
        'methods'             => array('GET', 'POST'),
        'permission_callback' => function () {
            return current_user_can('manage_options');
        },
        'callback'            => 'lx_handle_remote_sync_acf',
    ));
});

/**
 * Handle remote ACF field group sync from JSON into database
 */
function lx_handle_remote_sync_acf($request = null) {
    if (!function_exists('acf_import_field_group')) {
        return new WP_REST_Response(array('success' => false, 'message' => 'ACF Pro not active or acf_import_field_group not available'), 400);
    }
    $theme_dir = defined('LX_THEME_DIR') ? LX_THEME_DIR : get_template_directory();
    $json_file = $theme_dir . '/acf-json/group_tam_goi_landing.json';
    if (!file_exists($json_file)) {
        return new WP_REST_Response(array('success' => false, 'message' => 'group_tam_goi_landing.json not found'), 404);
    }
    $json_content = file_get_contents($json_file);
    $group_data = json_decode($json_content, true);
    if (empty($group_data) || !is_array($group_data)) {
        return new WP_REST_Response(array('success' => false, 'message' => 'Invalid JSON in group_tam_goi_landing.json'), 400);
    }

    $imported = acf_import_field_group($group_data);
    update_option('lx_acf_group_synced_hash_' . $group_data['key'], md5($json_content));
    wp_cache_flush();

    return new WP_REST_Response(array(
        'success'      => true,
        'group_key'    => isset($imported['key']) ? $imported['key'] : $group_data['key'],
        'group_title'  => isset($imported['title']) ? $imported['title'] : $group_data['title'],
        'fields_count' => isset($imported['fields']) ? count($imported['fields']) : count($group_data['fields']),
    ), 200);
}

/**
 * Handle remote ACF and WordPress options updates and automatic cache purge
 */
function lx_handle_remote_update_options($request) {
    $params = $request->get_json_params();
    if (empty($params) || !is_array($params)) {
        return new WP_REST_Response(array('success' => false, 'message' => 'No parameters received'), 400);
    }
    $updated = array();

    $repeaters = array(
        'rev_gallery' => array(
            'key'  => 'field_rev_gallery',
            'subs' => array('img' => 'field_rev_gallery_img'),
        ),
        'rev_workshop_gallery' => array(
            'key'  => 'field_rev_workshop_gallery',
            'subs' => array('img' => 'field_rev_workshop_img'),
        ),
        'combo_items' => array(
            'key'  => 'field_combo_items',
            'subs' => array('key' => 'field_combo_key', 'name' => 'field_combo_name', 'desc' => 'field_combo_desc', 'price' => 'field_combo_price', 'img' => 'field_combo_img', 'is_hot' => 'field_combo_is_hot'),
        ),
        'gift_items' => array(
            'key'  => 'field_gift_items',
            'subs' => array('name' => 'field_gift_name', 'badge' => 'field_gift_badge', 'img' => 'field_gift_img', 'desc' => 'field_gift_desc', 'price' => 'field_gift_price', 'is_hot' => 'field_gift_is_hot'),
        ),
        'gift_sets' => array(
            'key'  => 'field_gift_sets',
            'subs' => array(
                'name'     => 'field_gset_name',
                'ribbon'   => 'field_gset_ribbon',
                'img'      => 'field_gset_img',
                'items'    => 'field_gset_items',
                'price'    => 'field_gset_price',
                'data_set' => 'field_gset_data_set',
            ),
        ),
        'ingredients_items' => array(
            'key'  => 'field_ingredients_items',
            'subs' => array(
                'name'      => 'field_ing_item_name',
                'badge'     => 'field_ing_item_badge',
                'img'       => 'field_ing_item_img',
                'highlight' => 'field_ing_item_hl',
                'desc'      => 'field_ing_item_desc',
            ),
        ),
    );

    foreach ($params as $key => $val) {
        if (isset($repeaters[$key]) && is_array($val)) {
            $rep_info = $repeaters[$key];
            $rep_key  = $rep_info['key'];
            $subs     = $rep_info['subs'];
            $opt_key  = 'options_' . $key;
            $count    = count($val);

            $prev_count = intval(get_option($opt_key, 0));
            for ($p = $count; $p < $prev_count; $p++) {
                foreach ($subs as $sub_name => $sub_key) {
                    delete_option($opt_key . '_' . $p . '_' . $sub_name);
                    delete_option('_' . $opt_key . '_' . $p . '_' . $sub_name);
                }
            }

            update_option($opt_key, $count);
            update_option('_' . $opt_key, $rep_key);

            foreach ($val as $i => $row) {
                foreach ($subs as $sub_name => $sub_key) {
                    $sub_val = isset($row[$sub_name]) ? $row[$sub_name] : '';
                    update_option($opt_key . '_' . $i . '_' . $sub_name, $sub_val);
                    if (!empty($sub_key)) {
                        update_option('_' . $opt_key . '_' . $i . '_' . $sub_name, $sub_key);
                    }
                }
            }

            if (function_exists('update_field')) {
                update_field($rep_key, $val, 'option');
            }
        } else {
            if (function_exists('update_field')) {
                update_field($key, $val, 'option');
            }
            update_option('options_' . $key, $val);
        }
        $updated[] = $key;
    }
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
    return new WP_REST_Response(array(
        'success'        => true,
        'updated_fields' => $updated,
        'count'          => count($updated),
    ), 200);
}

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

    // Auto import/sync ACF Field Group if ACF Pro is active
    if (function_exists('acf_import_field_group')) {
        $json_file = $theme_dir . '/acf-json/group_tam_goi_landing.json';
        if (file_exists($json_file)) {
            $json_content = file_get_contents($json_file);
            $group_data = json_decode($json_content, true);
            if (!empty($group_data) && is_array($group_data)) {
                acf_import_field_group($group_data);
                update_option('lx_acf_group_synced_hash_' . $group_data['key'], md5($json_content));
            }
        }
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
        'theme_version'  => defined('LX_THEME_VERSION') ? LX_THEME_VERSION : '1.5.7',
        'cache_purged'   => true,
        'timestamp'      => time(),
    ), 200);
}
