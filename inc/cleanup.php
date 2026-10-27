<?php
/**
 * Clean up WordPress defaults for maximum performance
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

// Remove emojis
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

// Remove WP generator and RSD/wlwmanifest
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

// Remove global SVG filters from block themes if present
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
