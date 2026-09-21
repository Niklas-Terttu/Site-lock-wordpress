<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Hook into template_redirect to intercept requests
add_action( 'template_redirect', function() {
    // Check if site lock is enabled
    if ( ! get_option( 'sluo_enabled' ) ) {
        return;
    }
    
    // Check if user is admin
    if ( current_user_can( 'manage_options' ) ) {
        return;
    }
    
    // Check if user is subscriber and allowed
    if ( get_option( 'sluo_allow_subscribers' ) && current_user_can( 'read' ) ) {
        return;
    }
    
    // Check if user has access via code
    if ( sluo_user_has_access() ) {
        return;
    }
    
    // Show the under construction page
    sluo_display_construction_page();
    exit;
} );

// Enqueue styles and scripts for construction page
add_action( 'wp_head', function() {
    if ( ! get_option( 'sluo_enabled' ) ) {
        return;
    }
    
    if ( current_user_can( 'manage_options' ) ) {
        return;
    }
    
    if ( get_option( 'sluo_allow_subscribers' ) && current_user_can( 'read' ) ) {
        return;
    }
    
    if ( sluo_user_has_access() ) {
        return;
    }
    
    // Add custom styling
    $bg_color = get_option( 'sluo_background_color' ) ?: '#ffffff';
    $text_color = get_option( 'sluo_text_color' ) ?: '#333333';
    $button_color = get_option( 'sluo_button_color' ) ?: '#0073aa';
    
    ?>
    <style>
        body {
            background-color: <?php echo esc_attr( $bg_color ); ?> !important;
            color: <?php echo esc_attr( $text_color ); ?> !important;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        #wp-admin-bar-root-visit, #wp-admin-bar-site-name, #wpadminbar {
            display: none !important;
        }
        
        .sluo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .sluo-content {
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        
        .sluo-logo {
            margin-bottom: 40px;
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .sluo-logo img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        
        .sluo-title {
            font-size: 48px;
            font-weight: 600;
            margin: 0 0 20px 0;
            color: <?php echo esc_attr( $text_color ); ?>;
        }
        
        .sluo-message {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 40px;
            color: <?php echo esc_attr( $text_color ); ?>;
        }
        
        .sluo-message p:last-child {
            margin-bottom: 0;
        }
        
        .sluo-code-form {
            margin-bottom: 30px;
        }
        
        .sluo-form-group {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .sluo-form-group input {
            flex: 1;
            min-width: 200px;
            padding: 12px 20px;
            border: 2px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .sluo-form-group input:focus {
            outline: none;
            border-color: <?php echo esc_attr( $button_color ); ?>;
        }
        
        .sluo-form-group button {
            padding: 12px 30px;
            background-color: <?php echo esc_attr( $button_color ); ?>;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.3s;
            white-space: nowrap;
        }
        
        .sluo-form-group button:hover {
            opacity: 0.9;
        }
        
        .sluo-form-group button:active {
            opacity: 0.8;
        }
        
        .sluo-error {
            color: #dc3545;
            font-weight: 600;
            margin-bottom: 15px;
            padding: 12px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
        }
        
        .sluo-success {
            color: #155724;
            font-weight: 600;
            margin-bottom: 15px;
            padding: 12px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
        }
        
        .sluo-info-text {
            font-size: 14px;
            color: rgba(0, 0, 0, 0.6);
            margin-bottom: 30px;
        }
        
        .sluo-social {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }
        
        .sluo-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background-color: <?php echo esc_attr( $button_color ); ?>;
            color: white;
            border-radius: 50%;
            text-decoration: none;
            font-size: 24px;
            transition: opacity 0.3s;
        }
        
        .sluo-social a:hover {
            opacity: 0.8;
        }
        
        .sluo-footer {
            margin-top: 60px;
            font-size: 14px;
            opacity: 0.7;
        }
        
        @media (max-width: 600px) {
            .sluo-title {
                font-size: 32px;
            }
            
            .sluo-message {
                font-size: 16px;
            }
            
            .sluo-form-group {
                flex-direction: column;
            }
            
            .sluo-form-group input,
            .sluo-form-group button {
                width: 100%;
            }
        }
    </style>
    <?php
}, 999 );

// Display the construction page
function sluo_display_construction_page() {
    $title = get_option( 'sluo_title' ) ?: 'Under ombygning';
    $message = get_option( 'sluo_message' ) ?: 'Vi er i gang med at opgradere vores hjemmeside. Vi vender tilbage snart!';
    $logo_id = get_option( 'sluo_logo_id' );
    $access_code = get_option( 'sluo_access_code' );
    
    $error_message = '';
    $success_message = '';
    
    // Check for form submission
    if ( isset( $_POST['sluo_access_code_submit'] ) && ! empty( $_POST['sluo_access_code'] ) ) {
        // Verify nonce
        if ( ! isset( $_POST['sluo_nonce'] ) || ! wp_verify_nonce( $_POST['sluo_nonce'], 'sluo_access_code' ) ) {
            $error_message = __( 'Sikkerhedskontrol mislykkedes. Prøv igen.', 'site-lock-under-ombygning' );
        } elseif ( empty( $access_code ) ) {
            $error_message = __( 'Der er ikke indstillet nogen adgangskode.', 'site-lock-under-ombygning' );
        } elseif ( $_POST['sluo_access_code'] !== $access_code ) {
            $error_message = __( 'Forkert adgangskode. Prøv igen.', 'site-lock-under-ombygning' );
            
            // Log failed attempt
            if ( get_option( 'sluo_log_attempts' ) ) {
                sluo_log_attempt( 'failed', sanitize_text_field( $_POST['sluo_access_code'] ) );
            }
        } else {
            // Correct code entered
            $success_message = __( 'Adgangskode accepteret! Du omdirigeres...', 'site-lock-under-ombygning' );
            sluo_grant_access();
            
            // Log successful attempt
            if ( get_option( 'sluo_log_attempts' ) ) {
                sluo_log_attempt( 'success', sanitize_text_field( $_POST['sluo_access_code'] ) );
            }
            
            // Send notification email
            if ( get_option( 'sluo_email_notifications' ) ) {
                sluo_send_notification_email();
            }
            
            // Redirect after a short delay
            header( 'Refresh: 2; url=' . esc_url( home_url() ) );
        }
    }
    
    // Get social media links
    $social_facebook = get_option( 'sluo_social_facebook' );
    $social_twitter = get_option( 'sluo_social_twitter' );
    $social_instagram = get_option( 'sluo_social_instagram' );
    
    ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo esc_html( $title ); ?> - <?php bloginfo( 'name' ); ?></title>
        <?php wp_head(); ?>
        <meta name="robots" content="noindex, follow">
    </head>
    <body <?php body_class(); ?>>
        <div class="sluo-container">
            <div class="sluo-content">
                <?php if ( ! empty( $logo_id ) ) : ?>
                    <div class="sluo-logo">
                        <?php echo wp_get_attachment_image( $logo_id, 'medium' ); ?>
                    </div>
                <?php endif; ?>
                
                <h1 class="sluo-title"><?php echo esc_html( $title ); ?></h1>
                
                <div class="sluo-message">
                    <?php echo wp_kses_post( $message ); ?>
                </div>
                
                <?php if ( ! empty( $access_code ) ) : ?>
                    <div class="sluo-code-form">
                        <?php if ( ! empty( $error_message ) ) : ?>
                            <div class="sluo-error">
                                <?php echo esc_html( $error_message ); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ( ! empty( $success_message ) ) : ?>
                            <div class="sluo-success">
                                <?php echo esc_html( $success_message ); ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <?php wp_nonce_field( 'sluo_access_code', 'sluo_nonce' ); ?>
                            <div class="sluo-form-group">
                                <input type="text" name="sluo_access_code" placeholder="<?php esc_attr_e( 'Indtast adgangskode', 'site-lock-under-ombygning' ); ?>" required>
                                <button type="submit" name="sluo_access_code_submit" value="1">
                                    <?php _e( 'Få Adgang', 'site-lock-under-ombygning' ); ?>
                                </button>
                            </div>
                        </form>
                        <p class="sluo-info-text">
                            <?php _e( 'Har du adgangskode? Indtast den ovenfor for at se hele webstedet.', 'site-lock-under-ombygning' ); ?>
                        </p>
                    </div>
                <?php endif; ?>
                
                <?php if ( $social_facebook || $social_twitter || $social_instagram ) : ?>
                    <div class="sluo-social">
                        <?php if ( ! empty( $social_facebook ) ) : ?>
                            <a href="<?php echo esc_url( $social_facebook ); ?>" target="_blank" rel="noopener noreferrer" title="Facebook">
                                f
                            </a>
                        <?php endif; ?>
                        <?php if ( ! empty( $social_twitter ) ) : ?>
                            <a href="<?php echo esc_url( $social_twitter ); ?>" target="_blank" rel="noopener noreferrer" title="Twitter">
                                𝕏
                            </a>
                        <?php endif; ?>
                        <?php if ( ! empty( $social_instagram ) ) : ?>
                            <a href="<?php echo esc_url( $social_instagram ); ?>" target="_blank" rel="noopener noreferrer" title="Instagram">
                                📷
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <div class="sluo-footer">
                    &copy; <?php echo esc_html( date( 'Y' ) . ' ' . get_bloginfo( 'name' ) ); ?>
                </div>
            </div>
        </div>
        <?php wp_footer(); ?>
    </body>
    </html>
    <?php
}

// Check if user has access via code
function sluo_user_has_access() {
    if ( empty( get_option( 'sluo_access_code' ) ) ) {
        return false;
    }
    
    return isset( $_COOKIE['sluo_access_granted'] ) && $_COOKIE['sluo_access_granted'] === 'true';
}

// Grant access by setting cookie
function sluo_grant_access() {
    $cookie_time = time() + ( 7 * 24 * 60 * 60 ); // 7 days
    setcookie( 'sluo_access_granted', 'true', $cookie_time, COOKIEPATH, COOKIE_DOMAIN );
}

// Log access attempts
function sluo_log_attempt( $status, $code ) {
    $log_file = SLUO_PLUGIN_DIR . 'logs/access-log.txt';
    
    // Create logs directory if it doesn't exist
    if ( ! is_dir( dirname( $log_file ) ) ) {
        wp_mkdir_p( dirname( $log_file ) );
    }
    
    $log_entry = sprintf(
        "[%s] Status: %s | Code: %s | IP: %s | User Agent: %s\n",
        date( 'Y-m-d H:i:s' ),
        $status,
        $code,
        $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
        $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
    );
    
    file_put_contents( $log_file, $log_entry, FILE_APPEND );
}

// Send notification email
function sluo_send_notification_email() {
    $admin_email = get_option( 'admin_email' );
    $subject = sprintf( __( '[%s] Adgangskode brugt på "Under Ombygning" siden', 'site-lock-under-ombygning' ), get_bloginfo( 'name' ) );
    
    $message = sprintf(
        __( "Hej,\n\nNogen har netop brugt adgangskoden til at få adgang til dit websted, der er under ombygning.\n\nTidspunkt: %s\nIP Adresse: %s\n\nMvh,\nSite Lock Plugin", 'site-lock-under-ombygning' ),
        date( 'Y-m-d H:i:s' ),
        $_SERVER['REMOTE_ADDR'] ?? 'Unknown'
    );
    
    wp_mail( $admin_email, $subject, $message );
}
