<?php
/**
 * Leads System - Form Handling and Database
 *
 * @package KhaSolar
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Create leads database table on theme activation
 */
function khasolar_create_leads_table() {
    global $wpdb;

    $table_name      = $wpdb->prefix . 'khasolar_leads';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        product_id mediumint(9) DEFAULT NULL,
        product_title text DEFAULT NULL,
        name varchar(255) NOT NULL,
        phone varchar(50) NOT NULL,
        location varchar(255) DEFAULT NULL,
        note text DEFAULT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

/**
 * Handle lead form submission
 */
function khasolar_handle_lead_submission() {

    // Check if form is submitted
    if ( ! isset( $_POST['khasolar_lead_submit'] ) ) {
        return;
    }

    // Verify nonce
    if ( ! isset( $_POST['khasolar_lead_nonce'] ) ||
         ! wp_verify_nonce( $_POST['khasolar_lead_nonce'], 'khasolar_submit_lead' ) ) {
        khasolar_set_lead_message( 'error', __( 'Lỗi bảo mật. Vui lòng thử lại.', 'khasolar' ) );
        return;
    }

    // Honeypot check (spam protection)
    if ( ! empty( $_POST['website'] ) ) {
        khasolar_set_lead_message( 'error', __( 'Spam detected.', 'khasolar' ) );
        return;
    }

    // Sanitize and validate form data
    $name     = isset( $_POST['lead_name'] ) ? sanitize_text_field( $_POST['lead_name'] ) : '';
    $phone    = isset( $_POST['lead_phone'] ) ? sanitize_text_field( $_POST['lead_phone'] ) : '';
    $location = isset( $_POST['lead_location'] ) ? sanitize_text_field( $_POST['lead_location'] ) : '';
    $note     = isset( $_POST['lead_note'] ) ? sanitize_textarea_field( $_POST['lead_note'] ) : '';

    $product_id    = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
    $product_title = isset( $_POST['product_title'] ) ? sanitize_text_field( $_POST['product_title'] ) : '';

    // Validate required fields
    if ( empty( $name ) || empty( $phone ) ) {
        khasolar_set_lead_message( 'error', __( 'Vui lòng điền đầy đủ họ tên và số điện thoại.', 'khasolar' ) );
        return;
    }

    // Validate phone number (basic validation for Vietnamese phone numbers)
    if ( ! preg_match( '/^[0-9]{10,11}$/', str_replace( array( ' ', '-', '.', '(' , ')' ), '', $phone ) ) ) {
        khasolar_set_lead_message( 'error', __( 'Số điện thoại không hợp lệ. Vui lòng nhập 10-11 chữ số.', 'khasolar' ) );
        return;
    }

    // Insert into database
    global $wpdb;
    $table_name = $wpdb->prefix . 'khasolar_leads';

    $result = $wpdb->insert(
        $table_name,
        array(
            'product_id'    => $product_id,
            'product_title' => $product_title,
            'name'          => $name,
            'phone'         => $phone,
            'location'      => $location,
            'note'          => $note,
            'created_at'    => current_time( 'mysql' ),
        ),
        array( '%d', '%s', '%s', '%s', '%s', '%s', '%s' )
    );

    if ( $result === false ) {
        khasolar_set_lead_message( 'error', __( 'Có lỗi xảy ra. Vui lòng thử lại sau.', 'khasolar' ) );
        return;
    }

    // Send email notification to admin
    khasolar_send_lead_notification( array(
        'name'          => $name,
        'phone'         => $phone,
        'location'      => $location,
        'note'          => $note,
        'product_id'    => $product_id,
        'product_title' => $product_title,
    ) );

    // Set success message
    khasolar_set_lead_message( 'success', __( 'Cảm ơn bạn! Chúng tôi sẽ liên hệ trong thời gian sớm nhất.', 'khasolar' ) );

    // Clear POST data to prevent resubmission
    if ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
        wp_safe_redirect( get_permalink() . '#lead-form' );
        exit;
    }
}
add_action( 'template_redirect', 'khasolar_handle_lead_submission' );

/**
 * Send email notification when a lead is submitted
 */
function khasolar_send_lead_notification( $data ) {
    $admin_email = get_option( 'admin_email' );
    $site_name   = get_bloginfo( 'name' );

    $subject = sprintf( '[%s] Yêu cầu tư vấn mới từ %s', $site_name, $data['name'] );

    $message = sprintf(
        "Bạn có một yêu cầu tư vấn mới từ website %s\n\n" .
        "Thông tin khách hàng:\n" .
        "- Họ và tên: %s\n" .
        "- Số điện thoại: %s\n" .
        "- Địa điểm: %s\n" .
        "- Ghi chú: %s\n\n" .
        "Sản phẩm quan tâm:\n" .
        "- %s\n" .
        "- Link: %s\n\n" .
        "Thời gian: %s\n\n" .
        "---\n" .
        "Email này được gửi tự động từ %s",
        $site_name,
        $data['name'],
        $data['phone'],
        ! empty( $data['location'] ) ? $data['location'] : 'Không cung cấp',
        ! empty( $data['note'] ) ? $data['note'] : 'Không có',
        $data['product_title'],
        $data['product_id'] ? get_permalink( $data['product_id'] ) : 'N/A',
        current_time( 'd/m/Y H:i:s' ),
        home_url()
    );

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $site_name . ' <noreply@' . parse_url( home_url(), PHP_URL_HOST ) . '>',
    );

    wp_mail( $admin_email, $subject, $message, $headers );
}

/**
 * Set lead form message in session/transient
 */
function khasolar_set_lead_message( $type, $message ) {
    set_transient( 'khasolar_lead_message', array(
        'type'    => $type,
        'message' => $message,
    ), 30 );
}

/**
 * Get and clear lead form message
 */
function khasolar_get_lead_message() {
    $message = get_transient( 'khasolar_lead_message' );

    if ( $message ) {
        delete_transient( 'khasolar_lead_message' );
        return $message;
    }

    return null;
}

/**
 * Admin menu for viewing leads
 */
function khasolar_add_leads_admin_menu() {
    add_menu_page(
        __( 'Yêu cầu tư vấn', 'khasolar' ),
        __( 'Yêu cầu tư vấn', 'khasolar' ),
        'manage_options',
        'khasolar-leads',
        'khasolar_leads_admin_page',
        'dashicons-email',
        25
    );
}
add_action( 'admin_menu', 'khasolar_add_leads_admin_menu' );

/**
 * Export leads to CSV
 */
function khasolar_export_leads_csv() {
    // Check permissions
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'Bạn không có quyền truy cập chức năng này.', 'khasolar' ) );
    }

    // Verify nonce
    if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'export_leads_csv' ) ) {
        wp_die( __( 'Lỗi bảo mật.', 'khasolar' ) );
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'khasolar_leads';

    // Build query with optional date filters
    $where = '1=1';
    if ( ! empty( $_GET['from_date'] ) ) {
        $from_date = sanitize_text_field( $_GET['from_date'] );
        $where .= $wpdb->prepare( " AND DATE(created_at) >= %s", $from_date );
    }
    if ( ! empty( $_GET['to_date'] ) ) {
        $to_date = sanitize_text_field( $_GET['to_date'] );
        $where .= $wpdb->prepare( " AND DATE(created_at) <= %s", $to_date );
    }

    $leads = $wpdb->get_results( "SELECT * FROM $table_name WHERE $where ORDER BY created_at DESC" );

    if ( empty( $leads ) ) {
        wp_die( __( 'Không có dữ liệu để xuất.', 'khasolar' ) );
    }

    // Set headers for CSV download
    header( 'Content-Type: text/csv; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename=khasolar-leads-' . date( 'Y-m-d' ) . '.csv' );
    header( 'Pragma: no-cache' );
    header( 'Expires: 0' );

    // Open output stream
    $output = fopen( 'php://output', 'w' );

    // Add BOM for UTF-8 (helps Excel recognize UTF-8 encoding)
    fprintf( $output, chr(0xEF).chr(0xBB).chr(0xBF) );

    // CSV headers
    fputcsv( $output, array(
        'ID',
        'Họ tên',
        'Số điện thoại',
        'Địa điểm',
        'Sản phẩm',
        'Ghi chú',
        'Thời gian'
    ) );

    // CSV rows
    foreach ( $leads as $lead ) {
        fputcsv( $output, array(
            $lead->id,
            $lead->name,
            $lead->phone,
            $lead->location,
            $lead->product_title,
            $lead->note,
            mysql2date( 'd/m/Y H:i:s', $lead->created_at )
        ) );
    }

    fclose( $output );
    exit;
}

/**
 * Admin page to display leads
 */
function khasolar_leads_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'khasolar_leads';

    // Handle CSV export
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'export_csv' ) {
        khasolar_export_leads_csv();
        exit;
    }

    // Handle delete action
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'delete' && isset( $_GET['lead_id'] ) ) {
        check_admin_referer( 'delete_lead_' . $_GET['lead_id'] );
        $wpdb->delete( $table_name, array( 'id' => absint( $_GET['lead_id'] ) ), array( '%d' ) );
        echo '<div class="notice notice-success"><p>' . __( 'Đã xóa yêu cầu.', 'khasolar' ) . '</p></div>';
    }

    // Get filter parameters
    $from_date = isset( $_GET['from_date'] ) ? sanitize_text_field( $_GET['from_date'] ) : '';
    $to_date   = isset( $_GET['to_date'] ) ? sanitize_text_field( $_GET['to_date'] ) : '';

    // Build query with filters
    $where = '1=1';
    if ( ! empty( $from_date ) ) {
        $where .= $wpdb->prepare( " AND DATE(created_at) >= %s", $from_date );
    }
    if ( ! empty( $to_date ) ) {
        $where .= $wpdb->prepare( " AND DATE(created_at) <= %s", $to_date );
    }

    // Get all leads
    $leads = $wpdb->get_results( "SELECT * FROM $table_name WHERE $where ORDER BY created_at DESC" );

    // Get statistics
    $total_leads = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
    $today_leads = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE DATE(created_at) = CURDATE()" );
    $week_leads  = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)" );
    $month_leads = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE created_at > DATE_SUB(NOW(), INTERVAL 30 DAY)" );

    ?>
    <div class="wrap">
        <h1><?php _e( 'Yêu cầu tư vấn', 'khasolar' ); ?></h1>

        <!-- Statistics Cards -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin: 20px 0;">
            <div style="background: #fff; padding: 20px; border-left: 4px solid #FF6B35; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #666; font-size: 14px;"><?php _e( 'Tổng số leads', 'khasolar' ); ?></h3>
                <p style="margin: 0; font-size: 32px; font-weight: bold; color: #FF6B35;"><?php echo number_format( $total_leads ); ?></p>
            </div>
            <div style="background: #fff; padding: 20px; border-left: 4px solid #004E89; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #666; font-size: 14px;"><?php _e( 'Hôm nay', 'khasolar' ); ?></h3>
                <p style="margin: 0; font-size: 32px; font-weight: bold; color: #004E89;"><?php echo number_format( $today_leads ); ?></p>
            </div>
            <div style="background: #fff; padding: 20px; border-left: 4px solid #1a8917; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #666; font-size: 14px;"><?php _e( '7 ngày qua', 'khasolar' ); ?></h3>
                <p style="margin: 0; font-size: 32px; font-weight: bold; color: #1a8917;"><?php echo number_format( $week_leads ); ?></p>
            </div>
            <div style="background: #fff; padding: 20px; border-left: 4px solid #d63638; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px; color: #666; font-size: 14px;"><?php _e( '30 ngày qua', 'khasolar' ); ?></h3>
                <p style="margin: 0; font-size: 32px; font-weight: bold; color: #d63638;"><?php echo number_format( $month_leads ); ?></p>
            </div>
        </div>

        <!-- Filter and Export Bar -->
        <div style="background: #fff; padding: 15px; margin: 20px 0; border: 1px solid #ccc;">
            <form method="get" action="" style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                <input type="hidden" name="page" value="khasolar-leads" />

                <label style="display: flex; align-items: center; gap: 8px;">
                    <strong><?php _e( 'Từ ngày:', 'khasolar' ); ?></strong>
                    <input type="date" name="from_date" value="<?php echo esc_attr( $from_date ); ?>" />
                </label>

                <label style="display: flex; align-items: center; gap: 8px;">
                    <strong><?php _e( 'Đến ngày:', 'khasolar' ); ?></strong>
                    <input type="date" name="to_date" value="<?php echo esc_attr( $to_date ); ?>" />
                </label>

                <button type="submit" class="button"><?php _e( 'Lọc', 'khasolar' ); ?></button>

                <?php if ( ! empty( $from_date ) || ! empty( $to_date ) ) : ?>
                    <a href="<?php echo esc_url( admin_url( 'admin.php?page=khasolar-leads' ) ); ?>" class="button">
                        <?php _e( 'Xóa bộ lọc', 'khasolar' ); ?>
                    </a>
                <?php endif; ?>

                <div style="margin-left: auto;">
                    <?php
                    $export_url = wp_nonce_url(
                        add_query_arg(
                            array(
                                'page' => 'khasolar-leads',
                                'action' => 'export_csv',
                                'from_date' => $from_date,
                                'to_date' => $to_date,
                            ),
                            admin_url( 'admin.php' )
                        ),
                        'export_leads_csv'
                    );
                    ?>
                    <a href="<?php echo esc_url( $export_url ); ?>" class="button button-primary">
                        <span class="dashicons dashicons-download" style="vertical-align: middle;"></span>
                        <?php _e( 'Xuất CSV', 'khasolar' ); ?>
                    </a>
                </div>
            </form>
        </div>

        <?php if ( ! empty( $from_date ) || ! empty( $to_date ) ) : ?>
            <div class="notice notice-info">
                <p>
                    <?php
                    printf(
                        __( 'Đang hiển thị %d leads', 'khasolar' ),
                        count( $leads )
                    );
                    if ( $from_date && $to_date ) {
                        printf( ' ' . __( 'từ %s đến %s', 'khasolar' ), $from_date, $to_date );
                    } elseif ( $from_date ) {
                        printf( ' ' . __( 'từ %s', 'khasolar' ), $from_date );
                    } elseif ( $to_date ) {
                        printf( ' ' . __( 'đến %s', 'khasolar' ), $to_date );
                    }
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if ( empty( $leads ) ) : ?>
            <p><?php _e( 'Chưa có yêu cầu tư vấn nào.', 'khasolar' ); ?></p>
        <?php else : ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th style="width: 50px;"><?php _e( 'ID', 'khasolar' ); ?></th>
                        <th><?php _e( 'Họ tên', 'khasolar' ); ?></th>
                        <th><?php _e( 'Số điện thoại', 'khasolar' ); ?></th>
                        <th><?php _e( 'Địa điểm', 'khasolar' ); ?></th>
                        <th><?php _e( 'Sản phẩm', 'khasolar' ); ?></th>
                        <th><?php _e( 'Ghi chú', 'khasolar' ); ?></th>
                        <th><?php _e( 'Thời gian', 'khasolar' ); ?></th>
                        <th><?php _e( 'Hành động', 'khasolar' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $leads as $lead ) : ?>
                        <tr>
                            <td><?php echo esc_html( $lead->id ); ?></td>
                            <td><strong><?php echo esc_html( $lead->name ); ?></strong></td>
                            <td><a href="tel:<?php echo esc_attr( $lead->phone ); ?>"><?php echo esc_html( $lead->phone ); ?></a></td>
                            <td><?php echo esc_html( $lead->location ); ?></td>
                            <td>
                                <?php if ( $lead->product_id && get_post( $lead->product_id ) ) : ?>
                                    <a href="<?php echo esc_url( get_permalink( $lead->product_id ) ); ?>" target="_blank">
                                        <?php echo esc_html( $lead->product_title ); ?>
                                    </a>
                                <?php else : ?>
                                    <?php echo esc_html( $lead->product_title ); ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo esc_html( wp_trim_words( $lead->note, 10 ) ); ?></td>
                            <td><?php echo esc_html( mysql2date( 'd/m/Y H:i', $lead->created_at ) ); ?></td>
                            <td>
                                <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=khasolar-leads&action=delete&lead_id=' . $lead->id ), 'delete_lead_' . $lead->id ) ); ?>"
                                   class="button button-small"
                                   onclick="return confirm('<?php _e( 'Bạn có chắc muốn xóa?', 'khasolar' ); ?>');">
                                    <?php _e( 'Xóa', 'khasolar' ); ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Add leads count to admin menu
 */
function khasolar_add_leads_count_bubble() {
    global $menu, $wpdb;

    $table_name = $wpdb->prefix . 'khasolar_leads';
    $count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)" );

    if ( $count > 0 ) {
        foreach ( $menu as $key => $value ) {
            if ( $menu[ $key ][2] === 'khasolar-leads' ) {
                $menu[ $key ][0] .= ' <span class="awaiting-mod">' . $count . '</span>';
                break;
            }
        }
    }
}
add_action( 'admin_menu', 'khasolar_add_leads_count_bubble', 999 );
