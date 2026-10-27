<?php
/**
 * Enqueue Theme Scripts and Styles
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue frontend scripts and styles
 */
function lx_enqueue_scripts() {
    // Google Fonts: Playfair Display & Be Vietnam Pro
    wp_enqueue_style(
        'lx-google-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,500;1,600&family=Be+Vietnam+Pro:wght@300;400;500;600;700;800&display=swap',
        array(),
        null
    );

    // Theme Main CSS
    wp_enqueue_style(
        'lx-main-style',
        LX_THEME_URI . '/assets/css/main.css',
        array(),
        LX_THEME_VERSION
    );

    // Theme Main JS
    wp_enqueue_script(
        'lx-main-script',
        LX_THEME_URI . '/assets/js/main.js',
        array(),
        LX_THEME_VERSION,
        true
    );

    // Localize script with AJAX URL and nonce
    wp_localize_script(
        'lx-main-script',
        'lx_landing_vars',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('lx_landing_order_nonce'),
            'theme_uri' => LX_THEME_URI,
        )
    );
}
add_action('wp_enqueue_scripts', 'lx_enqueue_scripts');
