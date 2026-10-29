<?php
/**
 * Helper functions for LX Landing Theme
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Safely get ACF field value with intelligent default handling
 *
 * If the field has NEVER been saved/configured in ACF, returns $default.
 * If the field was configured and then cleared/erased by the user in ACF, returns empty/null
 * so that templates can conditionally HIDE the element as requested.
 *
 * @param string $selector Field name or key.
 * @param mixed  $post_id  Post ID or 'option'.
 * @param mixed  $default  Fallback value if field was never configured.
 * @return mixed
 */
function lx_get_field($selector, $post_id = 'option', $default = '') {
    $opt_key = ($post_id === 'option') ? 'options_' . $selector : $selector;
    $ref_key = ($post_id === 'option') ? '_options_' . $selector : '_' . $selector;

    $has_opt = (get_option($ref_key, '__UNSET__') !== '__UNSET__') || (get_option($opt_key, '__UNSET__') !== '__UNSET__');

    if (function_exists('get_field')) {
        $value = get_field($selector, $post_id);
        if ($value !== null && $value !== false) {
            if (is_string($value)) {
                return trim($value);
            }
            if (is_array($value)) {
                return $value;
            }
            return $value;
        }

        // If get_field returned null or false, but the option was managed in ACF:
        // This means the user emptied or cleared the field in ACF.
        if ($has_opt) {
            return is_array($default) ? array() : '';
        }
    }

    if ($has_opt) {
        $raw_val = get_option($opt_key, '__UNSET__');
        if ($raw_val === '__UNSET__' || $raw_val === false || $raw_val === null || $raw_val === '' || $raw_val === 0 || $raw_val === '0') {
            return is_array($default) ? array() : '';
        }
        if (is_string($raw_val)) {
            return trim($raw_val);
        }
        return $raw_val;
    }

    return $default;
}

/**
 * Get ACF image URL or default image
 *
 * If the user explicitly cleared the image in ACF, returns empty string so that
 * the image element can be hidden. If never configured, returns $default_url.
 *
 * @param string $selector    Field name.
 * @param string $default_url Fallback image URL.
 * @param string $size        Image size.
 * @param mixed  $post_id     Post ID or 'option'.
 * @return string
 */
function lx_get_image_url($selector, $default_url = '', $size = 'full', $post_id = 'option') {
    $opt_key = ($post_id === 'option') ? 'options_' . $selector : $selector;
    $ref_key = ($post_id === 'option') ? '_options_' . $selector : '_' . $selector;

    $has_opt = (get_option($ref_key, '__UNSET__') !== '__UNSET__') || (get_option($opt_key, '__UNSET__') !== '__UNSET__');

    if (function_exists('get_field')) {
        $image = get_field($selector, $post_id);
        if (!empty($image)) {
            if (is_array($image) && !empty($image['url'])) {
                return $image['url'];
            }
            if (is_numeric($image)) {
                $url = wp_get_attachment_image_url($image, $size);
                if ($url) {
                    return $url;
                }
            }
            if (is_string($image) && trim($image) !== '') {
                return trim($image);
            }
        }
        // If image is empty and option was managed in ACF, return empty string so it hides
        if ($has_opt) {
            return '';
        }
    }

    if ($has_opt) {
        $raw_val = get_option($opt_key, '');
        if (empty($raw_val)) {
            return '';
        }
        if (is_numeric($raw_val)) {
            $url = wp_get_attachment_image_url($raw_val, $size);
            return $url ?: '';
        }
        if (is_string($raw_val) && trim($raw_val) !== '') {
            return trim($raw_val);
        }
        return '';
    }

    return $default_url;
}

/**
 * Check if a field value has actual visible content
 *
 * @param mixed $value Field value.
 * @return bool
 */
function lx_has_content($value) {
    if ($value === null || $value === false || $value === '') {
        return false;
    }
    if (is_string($value)) {
        $stripped = trim(strip_tags($value, '<img><svg><video><audio><input>'));
        return $stripped !== '';
    }
    if (is_array($value)) {
        return !empty($value);
    }
    if (is_numeric($value)) {
        return true;
    }
    return !empty($value);
}

/**
 * Automatically purge LiteSpeed Cache and object cache whenever ACF is updated
 */
add_action('acf/save_post', function($post_id) {
    if (class_exists('LiteSpeed_Cache_API')) {
        LiteSpeed_Cache_API::purge_all();
    }
    if (function_exists('litespeed_purge_all')) {
        litespeed_purge_all();
    }
    do_action('litespeed_purge_all');
    wp_cache_flush();
}, 50);
