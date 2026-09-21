<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Add submenu for logs
add_action( 'admin_menu', function() {
    add_submenu_page(
        'options-general.php',
        __( 'Access Log', 'site-lock-under-ombygning' ),
        __( 'Access Log', 'site-lock-under-ombygning' ),
        'manage_options',
        'sluo-logs',
        'sluo_render_logs_page'
    );
} );

// Render logs page
function sluo_render_logs_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'Du har ikke tilladelse til at få adgang til denne side.', 'site-lock-under-ombygning' ) );
    }

    // Handle clear logs
    if ( isset( $_POST['sluo_clear_logs'] ) && check_admin_referer( 'sluo_clear_logs_nonce', 'sluo_nonce' ) ) {
        if ( sluo_clear_access_log() ) {
            echo '<div class="notice notice-success"><p>' . esc_html( __( 'Access log blevet slettet.', 'site-lock-under-ombygning' ) ) . '</p></div>';
        }
    }

    // Handle download
    if ( isset( $_GET['sluo_download_log'] ) && check_admin_referer( 'sluo_download_log' ) ) {
        $csv_content = sluo_export_log_csv();
        
        if ( ! empty( $csv_content ) ) {
            header( 'Content-Type: text/csv; charset=utf-8' );
            header( 'Content-Disposition: attachment; filename="site-lock-log-' . date( 'Y-m-d' ) . '.csv"' );
            echo $csv_content;
            exit;
        }
    }

    $stats = sluo_get_stats();
    $log_entries = sluo_get_access_log( 100 );
    
    ?>
    <div class="wrap">
        <h1><?php _e( 'Site Lock - Access Log', 'site-lock-under-ombygning' ); ?></h1>
        
        <!-- Statistik -->
        <div class="sluo-stats">
            <div class="stat-box">
                <div class="stat-number"><?php echo intval( $stats['total_attempts'] ); ?></div>
                <div class="stat-label"><?php _e( 'I alt adgangsforsøg', 'site-lock-under-ombygning' ); ?></div>
            </div>
            <div class="stat-box success">
                <div class="stat-number"><?php echo intval( $stats['successful_attempts'] ); ?></div>
                <div class="stat-label"><?php _e( 'Vellykkede forsøg', 'site-lock-under-ombygning' ); ?></div>
            </div>
            <div class="stat-box error">
                <div class="stat-number"><?php echo intval( $stats['failed_attempts'] ); ?></div>
                <div class="stat-label"><?php _e( 'Mislykkede forsøg', 'site-lock-under-ombygning' ); ?></div>
            </div>
        </div>
        
        <!-- Handlinger -->
        <div class="sluo-actions" style="margin: 20px 0; padding: 20px; background: #f5f5f5; border-radius: 4px;">
            <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'page' => 'sluo-logs', 'sluo_download_log' => '1' ), admin_url( 'admin.php' ) ), 'sluo_download_log' ) ); ?>" class="button button-primary">
                <?php _e( 'Download CSV', 'site-lock-under-ombygning' ); ?>
            </a>
            
            <form method="post" style="display: inline;">
                <?php wp_nonce_field( 'sluo_clear_logs_nonce', 'sluo_nonce' ); ?>
                <button type="submit" name="sluo_clear_logs" class="button button-secondary" onclick="return confirm('<?php esc_attr_e( 'Er du sikker? Dette kan ikke fortrydes.', 'site-lock-under-ombygning' ); ?>');">
                    <?php _e( 'Slet Log', 'site-lock-under-ombygning' ); ?>
                </button>
            </form>
        </div>
        
        <!-- Log Tabel -->
        <div class="sluo-log-table">
            <h2><?php _e( 'Seneste adgangsforsøg', 'site-lock-under-ombygning' ); ?></h2>
            
            <?php if ( empty( $log_entries ) ) : ?>
                <p><?php _e( 'Der er ingen log-indgange endnu.', 'site-lock-under-ombygning' ); ?></p>
            <?php else : ?>
                <table class="widefat fixed">
                    <thead>
                        <tr>
                            <th class="col-time"><?php _e( 'Tidspunkt', 'site-lock-under-ombygning' ); ?></th>
                            <th class="col-status"><?php _e( 'Status', 'site-lock-under-ombygning' ); ?></th>
                            <th class="col-code"><?php _e( 'Kode', 'site-lock-under-ombygning' ); ?></th>
                            <th class="col-ip"><?php _e( 'IP-Adresse', 'site-lock-under-ombygning' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $log_entries as $entry ) : ?>
                            <?php
                            // Parse log entry
                            preg_match( '/\[(.*?)\].*?Status: (\w+) \| Code: (.*?) \| IP: ([\d\.]+)/', $entry, $matches );
                            
                            if ( ! empty( $matches ) ) {
                                $timestamp = $matches[1] ?? '';
                                $status = $matches[2] ?? '';
                                $code = $matches[3] ?? '';
                                $ip = $matches[4] ?? '';
                                
                                $status_class = $status === 'success' ? 'status-success' : 'status-error';
                                $status_label = $status === 'success' ? __( 'Vellykket', 'site-lock-under-ombygning' ) : __( 'Mislykket', 'site-lock-under-ombygning' );
                            ?>
                                <tr>
                                    <td class="col-time"><?php echo esc_html( $timestamp ); ?></td>
                                    <td class="col-status"><span class="status-badge <?php echo esc_attr( $status_class ); ?>"><?php echo esc_html( $status_label ); ?></span></td>
                                    <td class="col-code"><code><?php echo esc_html( $code ); ?></code></td>
                                    <td class="col-ip"><code><?php echo esc_html( $ip ); ?></code></td>
                                </tr>
                            <?php } ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <style>
        .sluo-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        
        .stat-box {
            background: white;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-left: 4px solid #0073aa;
        }
        
        .stat-box.success {
            border-left-color: #28a745;
        }
        
        .stat-box.error {
            border-left-color: #dc3545;
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #0073aa;
            margin-bottom: 10px;
        }
        
        .stat-box.success .stat-number {
            color: #28a745;
        }
        
        .stat-box.error .stat-number {
            color: #dc3545;
        }
        
        .stat-label {
            font-size: 14px;
            color: #666;
        }
        
        .sluo-log-table {
            background: white;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .sluo-log-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .sluo-log-table thead {
            background: #f5f5f5;
        }
        
        .sluo-log-table th {
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            font-weight: 600;
        }
        
        .sluo-log-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        
        .sluo-log-table tbody tr:hover {
            background: #f9f9f9;
        }
        
        .col-time {
            width: 25%;
        }
        
        .col-status {
            width: 15%;
        }
        
        .col-code {
            width: 30%;
        }
        
        .col-ip {
            width: 30%;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-success {
            background: #d4edda;
            color: #155724;
        }
        
        .status-error {
            background: #f8d7da;
            color: #721c24;
        }
        
        code {
            background: #f5f5f5;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        
        .sluo-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
    </style>
    <?php
}
