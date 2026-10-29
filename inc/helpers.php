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
    $has_opt_in_db = (get_option($opt_key, '__NOT_SET__') !== '__NOT_SET__');
    $is_synced = (bool) get_option('lx_tam_goi_content_sync_ver', false);

    if (function_exists('get_field')) {
        $value = get_field($selector, $post_id);
        if ($value !== null && $value !== false) {
            if (is_string($value)) {
                $trimmed = trim($value);
                if ($trimmed !== '') {
                    return $trimmed;
                }
                if ($is_synced || $has_opt_in_db) {
                    return '';
                }
            } elseif (is_array($value)) {
                if (!empty($value)) {
                    return $value;
                }
                if ($is_synced || $has_opt_in_db) {
                    return array();
                }
            } else {
                return $value;
            }
        }

        // If field exists in database option table, but value is empty/false (user cleared it or deleted all repeater rows)
        if ($is_synced && $has_opt_in_db) {
            $raw_val = get_option($opt_key, null);
            if ($raw_val === '0' || $raw_val === 0 || $raw_val === '' || $raw_val === null || $raw_val === false) {
                return '';
            }
            if (is_array($raw_val)) {
                return $raw_val;
            }
            return '';
        }
    }

    if ($is_synced && $has_opt_in_db) {
        $raw_opt = get_option($opt_key, null);
        if ($raw_opt !== null && $raw_opt !== false && $raw_opt !== '' && $raw_opt !== 0 && $raw_opt !== '0') {
            if (is_string($raw_opt)) {
                return trim($raw_opt);
            }
            return $raw_opt;
        }
        return '';
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

    $opt_key = ($post_id === 'option') ? 'options_' . $selector : $selector;
    $has_opt_in_db = (get_option($opt_key, '__NOT_SET__') !== '__NOT_SET__');
    $is_synced = (bool) get_option('lx_tam_goi_content_sync_ver', false);

    if (function_exists('get_field')) {
        $img = get_field($selector, $post_id);
        if ($img !== null && $img !== false && $img !== '' && $img !== 0 && $img !== '0') {
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
        }

        // If site was initialized and user explicitly removed the image in ACF
        if ($is_synced && $has_opt_in_db) {
            $raw_opt = get_option($opt_key, null);
            if (is_numeric($raw_opt) && $raw_opt > 0) {
                $src = wp_get_attachment_image_url($raw_opt, $size);
                if ($src) return $src;
            }
            if (is_string($raw_opt) && trim($raw_opt) !== '' && $raw_opt !== '0') {
                return trim($raw_opt);
            }
            // User cleared image in ACF -> return empty so it hides
            return '';
        }
    }

    if ($is_synced && $has_opt_in_db) {
        $raw_opt = get_option($opt_key, null);
        if (is_numeric($raw_opt) && $raw_opt > 0) {
            $src = wp_get_attachment_image_url($raw_opt, $size);
            if ($src) return $src;
        }
        if (is_string($raw_opt) && trim($raw_opt) !== '' && $raw_opt !== '0') {
            return trim($raw_opt);
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
