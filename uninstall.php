<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Delete all plugin options
delete_option( 'sluo_enabled' );
delete_option( 'sluo_title' );
delete_option( 'sluo_message' );
delete_option( 'sluo_access_code' );
delete_option( 'sluo_logo_id' );
delete_option( 'sluo_background_color' );
delete_option( 'sluo_text_color' );
delete_option( 'sluo_button_color' );
delete_option( 'sluo_show_admin_bar' );
delete_option( 'sluo_log_attempts' );
delete_option( 'sluo_allow_subscribers' );
delete_option( 'sluo_email_notifications' );
delete_option( 'sluo_social_facebook' );
delete_option( 'sluo_social_twitter' );
delete_option( 'sluo_social_instagram' );

// Delete log files
$log_dir = dirname( __FILE__ ) . '/logs';
if ( is_dir( $log_dir ) ) {
    $files = glob( $log_dir . '/*' );
    foreach ( $files as $file ) {
        if ( is_file( $file ) ) {
            unlink( $file );
        }
    }
    rmdir( $log_dir );
}
