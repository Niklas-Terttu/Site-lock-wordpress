<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get plugin option with default value
 */
function sluo_get_option( $option, $default = false ) {
    return get_option( 'sluo_' . $option, $default );
}

/**
 * Update plugin option
 */
function sluo_update_option( $option, $value ) {
    return update_option( 'sluo_' . $option, $value );
}

/**
 * Check if site lock is enabled
 */
function sluo_is_enabled() {
    return (bool) sluo_get_option( 'enabled', false );
}

/**
 * Check if current user should bypass the lock
 */
function sluo_should_bypass() {
    // Admin users always bypass
    if ( current_user_can( 'manage_options' ) ) {
        return true;
    }
    
    // Subscribers can bypass if enabled
    if ( sluo_get_option( 'allow_subscribers', false ) && current_user_can( 'read' ) ) {
        return true;
    }
    
    return false;
}

/**
 * Sanitize and validate access code
 */
function sluo_sanitize_access_code( $code ) {
    return sanitize_text_field( $code );
}

/**
 * Get access log entries
 */
function sluo_get_access_log( $limit = 50 ) {
    $log_file = SLUO_PLUGIN_DIR . 'logs/access-log.txt';
    
    if ( ! file_exists( $log_file ) ) {
        return array();
    }
    
    $lines = file( $log_file, FILE_IGNORE_NEW_LINES );
    $lines = array_reverse( $lines );
    
    return array_slice( $lines, 0, $limit );
}

/**
 * Clear access log
 */
function sluo_clear_access_log() {
    $log_file = SLUO_PLUGIN_DIR . 'logs/access-log.txt';
    
    if ( file_exists( $log_file ) ) {
        unlink( $log_file );
        return true;
    }
    
    return false;
}

/**
 * Get site lock statistics
 */
function sluo_get_stats() {
    $log_entries = sluo_get_access_log( 999999 );
    
    $stats = array(
        'total_attempts' => count( $log_entries ),
        'successful_attempts' => 0,
        'failed_attempts' => 0,
    );
    
    foreach ( $log_entries as $entry ) {
        if ( strpos( $entry, 'Status: success' ) !== false ) {
            $stats['successful_attempts']++;
        } elseif ( strpos( $entry, 'Status: failed' ) !== false ) {
            $stats['failed_attempts']++;
        }
    }
    
    return $stats;
}

/**
 * Export access log as CSV
 */
function sluo_export_log_csv() {
    $log_entries = sluo_get_access_log( 999999 );
    
    if ( empty( $log_entries ) ) {
        return '';
    }
    
    $csv = "Tidspunkt,Status,IP Adresse\n";
    
    foreach ( $log_entries as $entry ) {
        // Parse log entry
        preg_match( '/\[(.*?)\].*?Status: (\w+).*?IP: ([\d\.]+)/', $entry, $matches );
        
        if ( ! empty( $matches ) ) {
            $timestamp = $matches[1] ?? '';
            $status = $matches[2] ?? '';
            $ip = $matches[3] ?? '';
            
            $csv .= sprintf( '"%s","%s","%s"' . "\n", $timestamp, $status, $ip );
        }
    }
    
    return $csv;
}

/**
 * Check if plugin has required capabilities
 */
function sluo_check_requirements() {
    if ( version_compare( get_bloginfo( 'version' ), '5.0', '<' ) ) {
        return false;
    }
    
    return true;
}

/**
 * Get all plugin settings as array
 */
function sluo_get_all_settings() {
    return array(
        'enabled' => sluo_get_option( 'enabled', false ),
        'title' => sluo_get_option( 'title', __( 'Under ombygning', 'site-lock-under-ombygning' ) ),
        'message' => sluo_get_option( 'message', __( 'Vi er i gang med at opgradere vores hjemmeside. Vi vender tilbage snart!', 'site-lock-under-ombygning' ) ),
        'access_code' => sluo_get_option( 'access_code', '' ),
        'logo_id' => sluo_get_option( 'logo_id', '' ),
        'background_color' => sluo_get_option( 'background_color', '#ffffff' ),
        'text_color' => sluo_get_option( 'text_color', '#333333' ),
        'button_color' => sluo_get_option( 'button_color', '#0073aa' ),
        'allow_subscribers' => sluo_get_option( 'allow_subscribers', false ),
        'show_admin_bar' => sluo_get_option( 'show_admin_bar', true ),
        'log_attempts' => sluo_get_option( 'log_attempts', true ),
        'email_notifications' => sluo_get_option( 'email_notifications', false ),
        'social_facebook' => sluo_get_option( 'social_facebook', '' ),
        'social_twitter' => sluo_get_option( 'social_twitter', '' ),
        'social_instagram' => sluo_get_option( 'social_instagram', '' ),
    );
}
