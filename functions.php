<?php
/**
 * Theme functions and definitions
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('LX_THEME_VERSION')) {
    define('LX_THEME_VERSION', '1.6.0');
}
if (!defined('LX_THEME_DIR')) {
    define('LX_THEME_DIR', get_template_directory());
}
if (!defined('LX_THEME_URI')) {
    define('LX_THEME_URI', get_template_directory_uri());
}

/**
 * Theme setup
 */
function lx_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
}
add_action('after_setup_theme', 'lx_theme_setup');

/**
 * Purge cache helper
 */
add_action('init', function() {
    if (isset($_GET['purge_cache']) || isset($_GET['lx_force_sync'])) {
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
    }
}, 30);

/**
 * Load modules from inc/
 */
require_once LX_THEME_DIR . '/inc/index.php';
