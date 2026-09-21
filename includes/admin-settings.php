<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Add admin menu
add_action( 'admin_menu', function() {
    add_options_page(
        __( 'Site Lock - Under Ombygning', 'site-lock-under-ombygning' ),
        __( 'Under Ombygning', 'site-lock-under-ombygning' ),
        'manage_options',
        'sluo-settings',
        'sluo_render_settings_page'
    );
} );

// Register settings
add_action( 'admin_init', function() {
    register_setting( 'sluo_settings_group', 'sluo_enabled' );
    register_setting( 'sluo_settings_group', 'sluo_title' );
    register_setting( 'sluo_settings_group', 'sluo_message' );
    register_setting( 'sluo_settings_group', 'sluo_access_code' );
    register_setting( 'sluo_settings_group', 'sluo_logo_id' );
    register_setting( 'sluo_settings_group', 'sluo_background_color' );
    register_setting( 'sluo_settings_group', 'sluo_text_color' );
    register_setting( 'sluo_settings_group', 'sluo_button_color' );
    register_setting( 'sluo_settings_group', 'sluo_show_admin_bar' );
    register_setting( 'sluo_settings_group', 'sluo_log_attempts' );
    register_setting( 'sluo_settings_group', 'sluo_allow_subscribers' );
    register_setting( 'sluo_settings_group', 'sluo_email_notifications' );
    register_setting( 'sluo_settings_group', 'sluo_social_facebook' );
    register_setting( 'sluo_settings_group', 'sluo_social_twitter' );
    register_setting( 'sluo_settings_group', 'sluo_social_instagram' );
} );

// Render settings page
function sluo_render_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'Du har ikke tilladelse til at få adgang til denne side.', 'site-lock-under-ombygning' ) );
    }

    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        
        <form action="options.php" method="post" class="sluo-settings-form">
            <?php settings_fields( 'sluo_settings_group' ); ?>
            
            <div class="sluo-tabs">
                <button type="button" class="tab-button active" data-tab="general">
                    <?php _e( 'Generelt', 'site-lock-under-ombygning' ); ?>
                </button>
                <button type="button" class="tab-button" data-tab="appearance">
                    <?php _e( 'Udseende', 'site-lock-under-ombygning' ); ?>
                </button>
                <button type="button" class="tab-button" data-tab="advanced">
                    <?php _e( 'Avanceret', 'site-lock-under-ombygning' ); ?>
                </button>
            </div>

            <!-- TAB: Generelt -->
            <div id="general" class="tab-content active">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="sluo_enabled">
                                <?php _e( 'Aktiver "Under Ombygning"', 'site-lock-under-ombygning' ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="checkbox" id="sluo_enabled" name="sluo_enabled" value="1" 
                                <?php checked( get_option( 'sluo_enabled' ), 1 ); ?> />
                            <p class="description">
                                <?php _e( 'Aktivér eller deaktivér siden "Under Ombygning". Admins kan altid se hele siden.', 'site-lock-under-ombygning' ); ?>
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="sluo_title">
                                <?php _e( 'Overskrift', 'site-lock-under-ombygning' ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="text" id="sluo_title" name="sluo_title" 
                                value="<?php echo esc_attr( get_option( 'sluo_title' ) ); ?>" 
                                class="regular-text" />
                            <p class="description">
                                <?php _e( 'Hovedoverskriften som besøgende vil se.', 'site-lock-under-ombygning' ); ?>
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="sluo_message">
                                <?php _e( 'Besked', 'site-lock-under-ombygning' ); ?>
                            </label>
                        </th>
                        <td>
                            <?php 
                            wp_editor( 
                                get_option( 'sluo_message' ), 
                                'sluo_message',
                                array(
                                    'textarea_rows' => 5,
                                    'media_buttons' => false,
                                    'teeny' => true,
                                )
                            );
                            ?>
                            <p class="description">
                                <?php _e( 'Tilpassede meddelelse for besøgende (understøtter HTML).', 'site-lock-under-ombygning' ); ?>
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="sluo_access_code">
                                <?php _e( 'Adgangskode', 'site-lock-under-ombygning' ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="text" id="sluo_access_code" name="sluo_access_code" 
                                value="<?php echo esc_attr( get_option( 'sluo_access_code' ) ); ?>" 
                                class="regular-text" placeholder="f.eks. hemlig123" />
                            <p class="description">
                                <?php _e( 'Besøgende kan indtaste denne kode for at se hele siden. Lad være tom for at deaktivere.', 'site-lock-under-ombygning' ); ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- TAB: Udseende -->
            <div id="appearance" class="tab-content">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="sluo_logo">
                                <?php _e( 'Logo/Billede', 'site-lock-under-ombygning' ); ?>
                            </label>
                        </th>
                        <td>
                            <div id="sluo-logo-preview" style="margin-bottom: 10px;">
                                <?php
                                $logo_id = get_option( 'sluo_logo_id' );
                                if ( $logo_id ) {
                                    echo wp_get_attachment_image( $logo_id, 'medium' );
                                }
                                ?>
                            </div>
                            <input type="hidden" id="sluo_logo_id" name="sluo_logo_id" 
                                value="<?php echo esc_attr( $logo_id ); ?>" />
                            <button type="button" class="button" id="sluo-upload-logo">
                                <?php _e( 'Upload Logo', 'site-lock-under-ombygning' ); ?>
                            </button>
                            <button type="button" class="button" id="sluo-remove-logo">
                                <?php _e( 'Fjern Logo', 'site-lock-under-ombygning' ); ?>
                            </button>
                            <p class="description">
                                <?php _e( 'Upload et logo eller banner for siden.', 'site-lock-under-ombygning' ); ?>
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="sluo_background_color">
                                <?php _e( 'Baggrundsfarve', 'site-lock-under-ombygning' ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="color" id="sluo_background_color" name="sluo_background_color" 
                                value="<?php echo esc_attr( get_option( 'sluo_background_color' ) ?: '#ffffff' ); ?>" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="sluo_text_color">
                                <?php _e( 'Tekstfarve', 'site-lock-under-ombygning' ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="color" id="sluo_text_color" name="sluo_text_color" 
                                value="<?php echo esc_attr( get_option( 'sluo_text_color' ) ?: '#333333' ); ?>" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="sluo_button_color">
                                <?php _e( 'Knap farve', 'site-lock-under-ombygning' ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="color" id="sluo_button_color" name="sluo_button_color" 
                                value="<?php echo esc_attr( get_option( 'sluo_button_color' ) ?: '#0073aa' ); ?>" />
                        </td>
                    </tr>
                </table>
            </div>

            <!-- TAB: Avanceret -->
            <div id="advanced" class="tab-content">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="sluo_allow_subscribers">
                                <?php _e( 'Tillad abonnenter', 'site-lock-under-ombygning' ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="checkbox" id="sluo_allow_subscribers" name="sluo_allow_subscribers" value="1" 
                                <?php checked( get_option( 'sluo_allow_subscribers' ), 1 ); ?> />
                            <p class="description">
                                <?php _e( 'Tillad brugere med "abonnent" rolle at se hele siden.', 'site-lock-under-ombygning' ); ?>
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="sluo_show_admin_bar">
                                <?php _e( 'Vis admin bar', 'site-lock-under-ombygning' ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="checkbox" id="sluo_show_admin_bar" name="sluo_show_admin_bar" value="1" 
                                <?php checked( get_option( 'sluo_show_admin_bar' ), 1 ); ?> />
                            <p class="description">
                                <?php _e( 'Vis WordPress admin bar for admin brugere på "Under Ombygning" siden.', 'site-lock-under-ombygning' ); ?>
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="sluo_log_attempts">
                                <?php _e( 'Log adgangs-forsøg', 'site-lock-under-ombygning' ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="checkbox" id="sluo_log_attempts" name="sluo_log_attempts" value="1" 
                                <?php checked( get_option( 'sluo_log_attempts' ), 1 ); ?> />
                            <p class="description">
                                <?php _e( 'Log hver gang nogen forsøger at bruge adgangskoden.', 'site-lock-under-ombygning' ); ?>
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="sluo_email_notifications">
                                <?php _e( 'Email notifikationer', 'site-lock-under-ombygning' ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="checkbox" id="sluo_email_notifications" name="sluo_email_notifications" value="1" 
                                <?php checked( get_option( 'sluo_email_notifications' ), 1 ); ?> />
                            <p class="description">
                                <?php _e( 'Modtag email når nogen bruger adgangskoden med succes.', 'site-lock-under-ombygning' ); ?>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row" style="vertical-align: top;">
                            <label><?php _e( 'Sociale medier', 'site-lock-under-ombygning' ); ?></label>
                        </th>
                        <td>
                            <p>
                                <label for="sluo_social_facebook">
                                    <?php _e( 'Facebook URL:', 'site-lock-under-ombygning' ); ?>
                                </label>
                                <input type="url" id="sluo_social_facebook" name="sluo_social_facebook" 
                                    value="<?php echo esc_attr( get_option( 'sluo_social_facebook' ) ); ?>" 
                                    class="regular-text" placeholder="https://facebook.com/..." />
                            </p>
                            <p>
                                <label for="sluo_social_twitter">
                                    <?php _e( 'Twitter URL:', 'site-lock-under-ombygning' ); ?>
                                </label>
                                <input type="url" id="sluo_social_twitter" name="sluo_social_twitter" 
                                    value="<?php echo esc_attr( get_option( 'sluo_social_twitter' ) ); ?>" 
                                    class="regular-text" placeholder="https://twitter.com/..." />
                            </p>
                            <p>
                                <label for="sluo_social_instagram">
                                    <?php _e( 'Instagram URL:', 'site-lock-under-ombygning' ); ?>
                                </label>
                                <input type="url" id="sluo_social_instagram" name="sluo_social_instagram" 
                                    value="<?php echo esc_attr( get_option( 'sluo_social_instagram' ) ); ?>" 
                                    class="regular-text" placeholder="https://instagram.com/..." />
                            </p>
                        </td>
                    </tr>
                </table>
            </div>

            <?php submit_button(); ?>
        </form>

        <div class="sluo-info" style="margin-top: 30px; padding: 20px; background: #f5f5f5; border-left: 4px solid #0073aa;">
            <h3><?php _e( 'Hjælp', 'site-lock-under-ombygning' ); ?></h3>
            <p>
                <?php _e( 'Dette plugin viser en "Under Ombygning" side for alle besøgende, mens du arbejder på dit websted.', 'site-lock-under-ombygning' ); ?>
            </p>
            <ul style="margin-left: 20px;">
                <li><?php _e( '<strong>Admins</strong> kan altid se hele webstedet normalt', 'site-lock-under-ombygning' ); ?></li>
                <li><?php _e( '<strong>Adgangskode:</strong> Besøgende kan indtaste en kode for at se hele webstedet', 'site-lock-under-ombygning' ); ?></li>
                <li><?php _e( '<strong>Abonnenter:</strong> Hvis aktiveret, kan abonnenter se hele webstedet', 'site-lock-under-ombygning' ); ?></li>
            </ul>
        </div>
    </div>

    <style>
        .sluo-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        
        .tab-button {
            background: none;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .tab-button.active {
            border-bottom-color: #0073aa;
            color: #0073aa;
            font-weight: bold;
        }
        
        .tab-button:hover {
            color: #0073aa;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .sluo-settings-form {
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab functionality
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tab = this.getAttribute('data-tab');
                
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));
                
                this.classList.add('active');
                document.getElementById(tab).classList.add('active');
            });
        });
        
        // Logo upload
        const uploadLogoBtn = document.getElementById('sluo-upload-logo');
        const logoIdInput = document.getElementById('sluo_logo_id');
        const logoPreview = document.getElementById('sluo-logo-preview');
        const removeLogoBtn = document.getElementById('sluo-remove-logo');
        
        if (uploadLogoBtn) {
            uploadLogoBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                const mediaUploader = wp.media({
                    title: '<?php _e( "Vælg Logo", "site-lock-under-ombygning" ); ?>',
                    button: {
                        text: '<?php _e( "Brug Dette Billede", "site-lock-under-ombygning" ); ?>'
                    },
                    multiple: false
                }).on('select', function() {
                    const attachment = mediaUploader.state().get('selection').first().toJSON();
                    logoIdInput.value = attachment.id;
                    
                    const img = document.createElement('img');
                    img.src = attachment.url;
                    img.style.maxWidth = '300px';
                    img.style.maxHeight = '200px';
                    
                    logoPreview.innerHTML = '';
                    logoPreview.appendChild(img);
                }).open();
            });
        }
        
        if (removeLogoBtn) {
            removeLogoBtn.addEventListener('click', function(e) {
                e.preventDefault();
                logoIdInput.value = '';
                logoPreview.innerHTML = '';
            });
        }
    });
    </script>
    <?php
}
