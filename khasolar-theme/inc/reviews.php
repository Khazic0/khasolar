<?php
/**
 * Customer Reviews & Ratings System
 *
 * @package KhaSolar
 * @since 1.2.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Create reviews database table
 */
function khasolar_create_reviews_table() {
    global $wpdb;

    $table_name      = $wpdb->prefix . 'khasolar_reviews';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        product_id mediumint(9) NOT NULL,
        customer_name varchar(255) NOT NULL,
        customer_email varchar(255) NOT NULL,
        rating tinyint(1) NOT NULL,
        review_text text,
        status varchar(20) DEFAULT 'pending',
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id),
        KEY product_id (product_id),
        KEY status (status)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

/**
 * Get product average rating
 */
function khasolar_get_product_rating( $product_id ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'khasolar_reviews';

    $rating = $wpdb->get_var( $wpdb->prepare(
        "SELECT AVG(rating) FROM $table_name WHERE product_id = %d AND status = 'approved'",
        $product_id
    ) );

    return $rating ? round( $rating, 1 ) : 0;
}

/**
 * Get product review count
 */
function khasolar_get_product_review_count( $product_id ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'khasolar_reviews';

    $count = $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE product_id = %d AND status = 'approved'",
        $product_id
    ) );

    return absint( $count );
}

/**
 * Get product reviews
 */
function khasolar_get_product_reviews( $product_id, $limit = 10 ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'khasolar_reviews';

    $reviews = $wpdb->get_results( $wpdb->prepare(
        "SELECT * FROM $table_name WHERE product_id = %d AND status = 'approved' ORDER BY created_at DESC LIMIT %d",
        $product_id,
        $limit
    ) );

    return $reviews;
}

/**
 * Get rating distribution for a product
 */
function khasolar_get_rating_distribution( $product_id ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'khasolar_reviews';

    $distribution = array();
    for ( $i = 5; $i >= 1; $i-- ) {
        $count = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM $table_name WHERE product_id = %d AND rating = %d AND status = 'approved'",
            $product_id,
            $i
        ) );
        $distribution[ $i ] = absint( $count );
    }

    return $distribution;
}

/**
 * Handle review submission
 */
function khasolar_submit_review() {
    // Check if form is submitted
    if ( ! isset( $_POST['khasolar_review_submit'] ) ) {
        return;
    }

    // Verify nonce
    if ( ! isset( $_POST['khasolar_review_nonce'] ) ||
         ! wp_verify_nonce( $_POST['khasolar_review_nonce'], 'khasolar_submit_review' ) ) {
        khasolar_set_review_message( 'error', __( 'Lỗi bảo mật. Vui lòng thử lại.', 'khasolar' ) );
        return;
    }

    // Honeypot check
    if ( ! empty( $_POST['website'] ) ) {
        return;
    }

    // Sanitize and validate
    $product_id     = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
    $customer_name  = isset( $_POST['review_name'] ) ? sanitize_text_field( $_POST['review_name'] ) : '';
    $customer_email = isset( $_POST['review_email'] ) ? sanitize_email( $_POST['review_email'] ) : '';
    $rating         = isset( $_POST['review_rating'] ) ? absint( $_POST['review_rating'] ) : 0;
    $review_text    = isset( $_POST['review_text'] ) ? sanitize_textarea_field( $_POST['review_text'] ) : '';

    // Validate required fields
    if ( ! $product_id || ! $customer_name || ! $customer_email || ! $rating ) {
        khasolar_set_review_message( 'error', __( 'Vui lòng điền đầy đủ thông tin bắt buộc.', 'khasolar' ) );
        return;
    }

    // Validate rating range
    if ( $rating < 1 || $rating > 5 ) {
        khasolar_set_review_message( 'error', __( 'Đánh giá không hợp lệ.', 'khasolar' ) );
        return;
    }

    // Validate email
    if ( ! is_email( $customer_email ) ) {
        khasolar_set_review_message( 'error', __( 'Email không hợp lệ.', 'khasolar' ) );
        return;
    }

    // Check if user already reviewed this product
    global $wpdb;
    $table_name = $wpdb->prefix . 'khasolar_reviews';

    $existing = $wpdb->get_var( $wpdb->prepare(
        "SELECT id FROM $table_name WHERE product_id = %d AND customer_email = %s",
        $product_id,
        $customer_email
    ) );

    if ( $existing ) {
        khasolar_set_review_message( 'error', __( 'Bạn đã đánh giá sản phẩm này rồi.', 'khasolar' ) );
        return;
    }

    // Insert review
    $result = $wpdb->insert(
        $table_name,
        array(
            'product_id'     => $product_id,
            'customer_name'  => $customer_name,
            'customer_email' => $customer_email,
            'rating'         => $rating,
            'review_text'    => $review_text,
            'status'         => 'pending', // Require admin approval
            'created_at'     => current_time( 'mysql' ),
        ),
        array( '%d', '%s', '%s', '%d', '%s', '%s', '%s' )
    );

    if ( $result === false ) {
        khasolar_set_review_message( 'error', __( 'Có lỗi xảy ra. Vui lòng thử lại sau.', 'khasolar' ) );
        return;
    }

    // Send notification to admin
    khasolar_send_review_notification( array(
        'product_id'     => $product_id,
        'customer_name'  => $customer_name,
        'customer_email' => $customer_email,
        'rating'         => $rating,
        'review_text'    => $review_text,
    ) );

    khasolar_set_review_message( 'success', __( 'Cảm ơn đánh giá của bạn! Đánh giá sẽ được hiển thị sau khi được duyệt.', 'khasolar' ) );

    // Redirect to prevent resubmission
    wp_safe_redirect( get_permalink( $product_id ) . '#reviews' );
    exit;
}
add_action( 'template_redirect', 'khasolar_submit_review' );

/**
 * Send email notification when review is submitted
 */
function khasolar_send_review_notification( $data ) {
    $admin_email = get_option( 'admin_email' );
    $site_name   = get_bloginfo( 'name' );
    $product     = get_post( $data['product_id'] );

    $subject = sprintf( '[%s] Đánh giá mới - %d sao', $site_name, $data['rating'] );

    $message = sprintf(
        "Bạn có đánh giá mới từ website %s\n\n" .
        "Sản phẩm: %s\n" .
        "Link: %s\n\n" .
        "Khách hàng: %s (%s)\n" .
        "Đánh giá: %d/5 sao\n\n" .
        "Nội dung:\n%s\n\n" .
        "Thời gian: %s\n\n" .
        "Duyệt đánh giá tại: %s\n\n" .
        "---\n" .
        "Email này được gửi tự động từ %s",
        $site_name,
        $product ? $product->post_title : 'N/A',
        get_permalink( $data['product_id'] ),
        $data['customer_name'],
        $data['customer_email'],
        $data['rating'],
        $data['review_text'] ? $data['review_text'] : 'Không có nội dung',
        current_time( 'd/m/Y H:i:s' ),
        admin_url( 'admin.php?page=khasolar-reviews' ),
        home_url()
    );

    wp_mail( $admin_email, $subject, $message );
}

/**
 * Set review message
 */
function khasolar_set_review_message( $type, $message ) {
    set_transient( 'khasolar_review_message', array(
        'type'    => $type,
        'message' => $message,
    ), 30 );
}

/**
 * Get review message
 */
function khasolar_get_review_message() {
    $message = get_transient( 'khasolar_review_message' );

    if ( $message ) {
        delete_transient( 'khasolar_review_message' );
        return $message;
    }

    return null;
}

/**
 * Admin menu for reviews
 */
function khasolar_add_reviews_admin_menu() {
    add_submenu_page(
        'khasolar-leads',
        __( 'Đánh giá sản phẩm', 'khasolar' ),
        __( 'Đánh giá', 'khasolar' ),
        'manage_options',
        'khasolar-reviews',
        'khasolar_reviews_admin_page'
    );
}
add_action( 'admin_menu', 'khasolar_add_reviews_admin_menu' );

/**
 * Admin page for reviews
 */
function khasolar_reviews_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'khasolar_reviews';

    // Handle approve action
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'approve' && isset( $_GET['review_id'] ) ) {
        check_admin_referer( 'approve_review_' . $_GET['review_id'] );
        $wpdb->update( $table_name, array( 'status' => 'approved' ), array( 'id' => absint( $_GET['review_id'] ) ), array( '%s' ), array( '%d' ) );
        echo '<div class="notice notice-success"><p>' . __( 'Đã duyệt đánh giá.', 'khasolar' ) . '</p></div>';
    }

    // Handle reject action
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'reject' && isset( $_GET['review_id'] ) ) {
        check_admin_referer( 'reject_review_' . $_GET['review_id'] );
        $wpdb->update( $table_name, array( 'status' => 'rejected' ), array( 'id' => absint( $_GET['review_id'] ) ), array( '%s' ), array( '%d' ) );
        echo '<div class="notice notice-success"><p>' . __( 'Đã từ chối đánh giá.', 'khasolar' ) . '</p></div>';
    }

    // Handle delete action
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'delete' && isset( $_GET['review_id'] ) ) {
        check_admin_referer( 'delete_review_' . $_GET['review_id'] );
        $wpdb->delete( $table_name, array( 'id' => absint( $_GET['review_id'] ) ), array( '%d' ) );
        echo '<div class="notice notice-success"><p>' . __( 'Đã xóa đánh giá.', 'khasolar' ) . '</p></div>';
    }

    // Get filter
    $status = isset( $_GET['review_status'] ) ? sanitize_text_field( $_GET['review_status'] ) : 'all';

    // Build query
    $where = '';
    if ( $status !== 'all' ) {
        $where = $wpdb->prepare( "WHERE status = %s", $status );
    }

    // Get reviews
    $reviews = $wpdb->get_results( "SELECT * FROM $table_name $where ORDER BY created_at DESC" );

    // Get counts
    $pending_count  = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'pending'" );
    $approved_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'approved'" );
    $rejected_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'rejected'" );
    $total_count    = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );

    ?>
    <div class="wrap">
        <h1><?php _e( 'Đánh giá sản phẩm', 'khasolar' ); ?></h1>

        <!-- Filter tabs -->
        <ul class="subsubsub">
            <li><a href="?page=khasolar-reviews&review_status=all" <?php echo $status === 'all' ? 'class="current"' : ''; ?>><?php printf( __( 'Tất cả (%d)', 'khasolar' ), $total_count ); ?></a> |</li>
            <li><a href="?page=khasolar-reviews&review_status=pending" <?php echo $status === 'pending' ? 'class="current"' : ''; ?>><?php printf( __( 'Chờ duyệt (%d)', 'khasolar' ), $pending_count ); ?></a> |</li>
            <li><a href="?page=khasolar-reviews&review_status=approved" <?php echo $status === 'approved' ? 'class="current"' : ''; ?>><?php printf( __( 'Đã duyệt (%d)', 'khasolar' ), $approved_count ); ?></a> |</li>
            <li><a href="?page=khasolar-reviews&review_status=rejected" <?php echo $status === 'rejected' ? 'class="current"' : ''; ?>><?php printf( __( 'Đã từ chối (%d)', 'khasolar' ), $rejected_count ); ?></a></li>
        </ul>

        <?php if ( empty( $reviews ) ) : ?>
            <p><?php _e( 'Chưa có đánh giá nào.', 'khasolar' ); ?></p>
        <?php else : ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th style="width: 50px;"><?php _e( 'ID', 'khasolar' ); ?></th>
                        <th><?php _e( 'Sản phẩm', 'khasolar' ); ?></th>
                        <th><?php _e( 'Khách hàng', 'khasolar' ); ?></th>
                        <th style="width: 100px;"><?php _e( 'Đánh giá', 'khasolar' ); ?></th>
                        <th><?php _e( 'Nội dung', 'khasolar' ); ?></th>
                        <th style="width: 100px;"><?php _e( 'Trạng thái', 'khasolar' ); ?></th>
                        <th style="width: 150px;"><?php _e( 'Thời gian', 'khasolar' ); ?></th>
                        <th style="width: 150px;"><?php _e( 'Hành động', 'khasolar' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $reviews as $review ) : ?>
                        <?php $product = get_post( $review->product_id ); ?>
                        <tr>
                            <td><?php echo esc_html( $review->id ); ?></td>
                            <td>
                                <?php if ( $product ) : ?>
                                    <a href="<?php echo esc_url( get_permalink( $review->product_id ) ); ?>" target="_blank">
                                        <?php echo esc_html( $product->post_title ); ?>
                                    </a>
                                <?php else : ?>
                                    <em><?php _e( 'Sản phẩm đã xóa', 'khasolar' ); ?></em>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo esc_html( $review->customer_name ); ?></strong><br>
                                <a href="mailto:<?php echo esc_attr( $review->customer_email ); ?>"><?php echo esc_html( $review->customer_email ); ?></a>
                            </td>
                            <td>
                                <span class="rating-stars">
                                    <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                                        <span class="star <?php echo $i <= $review->rating ? 'filled' : ''; ?>">★</span>
                                    <?php endfor; ?>
                                </span>
                            </td>
                            <td><?php echo esc_html( wp_trim_words( $review->review_text, 15 ) ); ?></td>
                            <td>
                                <?php
                                $status_labels = array(
                                    'pending'  => '<span style="color: #d63638;">Chờ duyệt</span>',
                                    'approved' => '<span style="color: #1a8917;">Đã duyệt</span>',
                                    'rejected' => '<span style="color: #999;">Đã từ chối</span>',
                                );
                                echo isset( $status_labels[ $review->status ] ) ? $status_labels[ $review->status ] : $review->status;
                                ?>
                            </td>
                            <td><?php echo esc_html( mysql2date( 'd/m/Y H:i', $review->created_at ) ); ?></td>
                            <td>
                                <?php if ( $review->status === 'pending' ) : ?>
                                    <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=khasolar-reviews&action=approve&review_id=' . $review->id ), 'approve_review_' . $review->id ) ); ?>" class="button button-small button-primary">
                                        <?php _e( 'Duyệt', 'khasolar' ); ?>
                                    </a>
                                    <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=khasolar-reviews&action=reject&review_id=' . $review->id ), 'reject_review_' . $review->id ) ); ?>" class="button button-small">
                                        <?php _e( 'Từ chối', 'khasolar' ); ?>
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=khasolar-reviews&action=delete&review_id=' . $review->id ), 'delete_review_' . $review->id ) ); ?>" class="button button-small" onclick="return confirm('<?php _e( 'Bạn có chắc muốn xóa?', 'khasolar' ); ?>');">
                                    <?php _e( 'Xóa', 'khasolar' ); ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <style>
        .rating-stars { font-size: 18px; }
        .rating-stars .star { color: #ddd; }
        .rating-stars .star.filled { color: #FFB800; }
    </style>
    <?php
}

/**
 * Display star rating HTML
 */
function khasolar_display_stars( $rating, $show_number = true ) {
    $rating = floatval( $rating );
    $full_stars = floor( $rating );
    $half_star = ( $rating - $full_stars ) >= 0.5 ? 1 : 0;
    $empty_stars = 5 - $full_stars - $half_star;

    $html = '<div class="khasolar-rating">';
    $html .= '<div class="rating-stars">';

    // Full stars
    for ( $i = 0; $i < $full_stars; $i++ ) {
        $html .= '<span class="star full">★</span>';
    }

    // Half star
    if ( $half_star ) {
        $html .= '<span class="star half">★</span>';
    }

    // Empty stars
    for ( $i = 0; $i < $empty_stars; $i++ ) {
        $html .= '<span class="star empty">★</span>';
    }

    $html .= '</div>';

    if ( $show_number ) {
        $html .= '<span class="rating-number">' . number_format( $rating, 1 ) . '</span>';
    }

    $html .= '</div>';

    return $html;
}

/**
 * Add review count to admin menu
 */
function khasolar_add_review_count_bubble() {
    global $submenu, $wpdb;

    $table_name = $wpdb->prefix . 'khasolar_reviews';
    $count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'pending'" );

    if ( $count > 0 && isset( $submenu['khasolar-leads'] ) ) {
        foreach ( $submenu['khasolar-leads'] as $key => $value ) {
            if ( $value[2] === 'khasolar-reviews' ) {
                $submenu['khasolar-leads'][ $key ][0] .= ' <span class="awaiting-mod">' . $count . '</span>';
                break;
            }
        }
    }
}
add_action( 'admin_menu', 'khasolar_add_review_count_bubble', 999 );
