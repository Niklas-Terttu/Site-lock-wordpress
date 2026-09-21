<?php
/**
 * Plugin Name: Site Lock - Under Ombygning
 * Plugin URI: https://example.com
 * Description: Profesionelt "Under ombygning" plugin til WordPress med tilpasset tekst, adgangskode og admin bypass.
 * Version: 1.0.0
 * Author: Cronovelo
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: site-lock-under-ombygning
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants
define( 'SLUO_VERSION', '1.0.0' );
define( 'SLUO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SLUO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'SLUO_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

// Load text domain for translations
add_action( 'plugins_loaded', function() {
    load_plugin_textdomain( 'site-lock-under-ombygning', false, dirname( SLUO_PLUGIN_BASENAME ) . '/languages' );
} );

// Include required files
require_once SLUO_PLUGIN_DIR . 'includes/functions.php';
require_once SLUO_PLUGIN_DIR . 'includes/admin-settings.php';
require_once SLUO_PLUGIN_DIR . 'includes/admin-logs.php';
require_once SLUO_PLUGIN_DIR . 'includes/frontend.php';

// Activation hook
register_activation_hook( __FILE__, 'sluo_activate' );

function sluo_activate() {
    // Set default options
    if ( ! get_option( 'sluo_enabled' ) ) {
        add_option( 'sluo_enabled', false );
    }
    if ( ! get_option( 'sluo_title' ) ) {
        add_option( 'sluo_title', 'Under ombygning' );
    }
    if ( ! get_option( 'sluo_message' ) ) {
        add_option( 'sluo_message', 'Vi er i gang med at opgradere vores hjemmeside. Vi vender tilbage snart!' );
    }
    if ( ! get_option( 'sluo_access_code' ) ) {
        add_option( 'sluo_access_code', '' );
    }
    if ( ! get_option( 'sluo_show_admin_bar' ) ) {
        add_option( 'sluo_show_admin_bar', true );
    }
    if ( ! get_option( 'sluo_log_attempts' ) ) {
        add_option( 'sluo_log_attempts', true );
    }
    if ( ! get_option( 'sluo_allow_subscribers' ) ) {
        add_option( 'sluo_allow_subscribers', false );
    }
}

// Deactivation hook
register_deactivation_hook( __FILE__, 'sluo_deactivate' );

function sluo_deactivate() {
    // Clean up session when deactivating
    delete_transient( 'sluo_access_granted_' . get_current_user_id() );
}
