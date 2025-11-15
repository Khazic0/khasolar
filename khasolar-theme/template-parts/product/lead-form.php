<?php
/**
 * Template part for displaying lead/quote request form
 *
 * @package KhaSolar
 * @since 1.0.0
 */

$product_id    = get_the_ID();
$product_title = get_the_title();

// Get and display any form messages
$form_message = khasolar_get_lead_message();
?>

<div id="lead-form" class="product-lead-form">
    <div class="lead-form-header">
        <h3><?php _e( 'Nhận tư vấn & báo giá', 'khasolar' ); ?></h3>
        <p><?php _e( 'Để lại thông tin, chúng tôi sẽ liên hệ tư vấn giải pháp phù hợp nhất cho bạn', 'khasolar' ); ?></p>
    </div>

    <?php if ( $form_message ) : ?>
        <div class="form-message <?php echo esc_attr( $form_message['type'] === 'success' ? 'message-success' : 'message-error' ); ?>">
            <?php echo esc_html( $form_message['message'] ); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?php echo esc_url( get_permalink() ); ?>#lead-form" class="lead-form">
        <?php wp_nonce_field( 'khasolar_submit_lead', 'khasolar_lead_nonce' ); ?>

        <input type="hidden" name="product_id" value="<?php echo esc_attr( $product_id ); ?>">
        <input type="hidden" name="product_title" value="<?php echo esc_attr( $product_title ); ?>">

        <!-- Honeypot field for spam protection -->
        <div class="form-honeypot" style="position: absolute; left: -9999px;">
            <label for="website"><?php _e( 'Website (leave blank)', 'khasolar' ); ?></label>
            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="lead_name">
                    <?php _e( 'Họ và tên', 'khasolar' ); ?> <span class="required">*</span>
                </label>
                <input
                    type="text"
                    id="lead_name"
                    name="lead_name"
                    required
                    placeholder="<?php _e( 'Nhập họ và tên của bạn', 'khasolar' ); ?>"
                    value="<?php echo isset( $_POST['lead_name'] ) ? esc_attr( $_POST['lead_name'] ) : ''; ?>"
                >
            </div>

            <div class="form-field">
                <label for="lead_phone">
                    <?php _e( 'Số điện thoại', 'khasolar' ); ?> <span class="required">*</span>
                </label>
                <input
                    type="tel"
                    id="lead_phone"
                    name="lead_phone"
                    required
                    placeholder="<?php _e( '0912 345 678', 'khasolar' ); ?>"
                    value="<?php echo isset( $_POST['lead_phone'] ) ? esc_attr( $_POST['lead_phone'] ) : ''; ?>"
                >
            </div>
        </div>

        <div class="form-field">
            <label for="lead_location">
                <?php _e( 'Tỉnh/Thành phố', 'khasolar' ); ?>
            </label>
            <input
                type="text"
                id="lead_location"
                name="lead_location"
                placeholder="<?php _e( 'Vd: Hà Nội, TP. HCM...', 'khasolar' ); ?>"
                value="<?php echo isset( $_POST['lead_location'] ) ? esc_attr( $_POST['lead_location'] ) : ''; ?>"
            >
        </div>

        <div class="form-field">
            <label for="lead_note">
                <?php _e( 'Ghi chú', 'khasolar' ); ?>
            </label>
            <textarea
                id="lead_note"
                name="lead_note"
                rows="4"
                placeholder="<?php _e( 'Nhu cầu sử dụng, diện tích, công suất hiện tại...', 'khasolar' ); ?>"
            ><?php echo isset( $_POST['lead_note'] ) ? esc_textarea( $_POST['lead_note'] ) : ''; ?></textarea>
        </div>

        <div class="form-field">
            <button type="submit" name="khasolar_lead_submit" class="btn btn-primary btn-large btn-block">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 2L11 13"></path>
                    <path d="M22 2L15 22L11 13L2 9L22 2Z"></path>
                </svg>
                <?php _e( 'Gửi yêu cầu tư vấn', 'khasolar' ); ?>
            </button>
        </div>

        <p class="form-note">
            <small>
                <?php _e( 'Thông tin của bạn sẽ được bảo mật tuyệt đối theo chính sách bảo mật của chúng tôi.', 'khasolar' ); ?>
            </small>
        </p>
    </form>
</div>
