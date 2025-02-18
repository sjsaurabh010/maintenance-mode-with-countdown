<?php
/**
 * Plugin Name: Maintenance Mode with Countdown Timer
 * Description: A simple maintenance mode plugin with a countdown timer.
 * Version:     1.0
 * License:     GPL2
 */

// Prevent direct access to the plugin files
if (!defined('ABSPATH')) {
    exit;
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';

// Activation hook
register_activation_hook(__FILE__, 'mmwc_activate_plugin');

// Deactivation hook
register_deactivation_hook(__FILE__, 'mmwc_deactivate_plugin');

// Uninstall hook
register_uninstall_hook(__FILE__, 'mmwc_uninstall_plugin');

// Load scripts and styles
function mmwc_enqueue_assets() {
    wp_enqueue_style('mmwc-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('mmwc-countdown', plugin_dir_url(__FILE__) . 'assets/js/countdown.js', array('jquery'), null, true);
    wp_localize_script('mmwc-countdown', 'mmwcCountdown', array(
        'countdown_date' => get_option('mmwc_end_time')
    ));
}
add_action('wp_enqueue_scripts', 'mmwc_enqueue_assets');

// Display Maintenance Mode
function mmwc_display_maintenance_page() {
    if (get_option('mmwc_maintenance_mode') === 'on') {
        include plugin_dir_path(__FILE__) . 'assets/images/maintenance-image.jpg';
        echo '<div id="maintenance-message">We are currently under maintenance. Please check back soon.</div>';
        echo '<div id="countdown-timer"></div>';
        exit;
    }
}
add_action('template_redirect', 'mmwc_display_maintenance_page');
