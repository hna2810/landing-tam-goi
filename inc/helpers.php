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
    if (function_exists('get_field')) {
        $value = get_field($selector, $post_id);
        // Field was found in ACF
        if ($value !== null && $value !== false) {
            // If it's a string that was explicitly cleared (empty string), return empty string (do NOT fall back to default)
            if (is_string($value)) {
                return trim($value);
            }
            // If it's an array/repeater that was cleared, return array
            if (is_array($value)) {
                return $value;
            }
            return $value;
        }
    }

    // Direct WordPress option check as secondary fallback
    $opt_key = ($post_id === 'option') ? 'options_' . $selector : $selector;
    $raw_opt = get_option($opt_key, null);
    if ($raw_opt !== null) {
        if (is_string($raw_opt)) {
            return trim($raw_opt);
        }
        return $raw_opt;
    }

    return $default;
}

/**
 * Get ACF image URL or default image
 *
 * @param string $selector Field name or key.
 * @param string $default  Fallback URL.
 * @param string $size     Image size.
 * @param mixed  $post_id  Post ID or 'option'.
 * @return string
 */
function lx_get_image_url($selector, $default = '', $size = 'full', $post_id = 'option') {
    if ($default === 'option') {
        $post_id = 'option';
        $default = (is_string($size) && $size !== 'full') ? $size : '';
        $size = 'full';
    }

    if (function_exists('get_field')) {
        $img = get_field($selector, $post_id);
        if ($img !== null && $img !== false) {
            if (is_array($img) && !empty($img['url'])) {
                if ($size !== 'full' && !empty($img['sizes'][$size])) {
                    return $img['sizes'][$size];
                }
                return $img['url'];
            }
            if (is_numeric($img) && $img > 0) {
                $src = wp_get_attachment_image_url($img, $size);
                if ($src) {
                    return $src;
                }
            }
            if (is_string($img) && trim($img) !== '') {
                return trim($img);
            }
            // If cleared in ACF, return empty
            return '';
        }
    }

    $opt_key = ($post_id === 'option') ? 'options_' . $selector : $selector;
    $raw_opt = get_option($opt_key, null);
    if ($raw_opt !== null) {
        if (is_string($raw_opt) && trim($raw_opt) !== '') {
            return trim($raw_opt);
        }
        if (is_numeric($raw_opt) && $raw_opt > 0) {
            $src = wp_get_attachment_image_url($raw_opt, $size);
            if ($src) {
                return $src;
            }
        }
        return '';
    }

    return $default;
}

/**
 * Check if a field or array has meaningful content
 *
 * @param mixed $val Value to check.
 * @return bool
 */
function lx_has_content($val) {
    if ($val === null || $val === false) {
        return false;
    }
    if (is_string($val)) {
        return trim($val) !== '';
    }
    if (is_array($val)) {
        return !empty($val);
    }
    return true;
}
