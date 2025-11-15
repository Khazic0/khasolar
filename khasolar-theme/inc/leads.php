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
 * Admin page to display leads
 */
function khasolar_leads_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'khasolar_leads';

    // Handle delete action
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'delete' && isset( $_GET['lead_id'] ) ) {
        check_admin_referer( 'delete_lead_' . $_GET['lead_id'] );
        $wpdb->delete( $table_name, array( 'id' => absint( $_GET['lead_id'] ) ), array( '%d' ) );
        echo '<div class="notice notice-success"><p>' . __( 'Đã xóa yêu cầu.', 'khasolar' ) . '</p></div>';
    }

    // Get all leads
    $leads = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY created_at DESC" );

    ?>
    <div class="wrap">
        <h1><?php _e( 'Yêu cầu tư vấn', 'khasolar' ); ?></h1>

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
