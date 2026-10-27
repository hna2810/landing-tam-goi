<?php
/**
 * Load all theme modules from inc/
 *
 * @package LXLanding
 */

if (!defined('ABSPATH')) {
    exit;
}

$modules = array(
    'helpers.php',
    'cleanup.php',
    'assets.php',
    'ajax-order.php',
    'acf-options.php',
);

foreach ($modules as $file) {
    $path = LX_THEME_DIR . '/inc/' . $file;
    if (file_exists($path)) {
        require_once $path;
    }
}
