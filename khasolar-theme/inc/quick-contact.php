<?php
/**
 * WhatsApp & Zalo Quick Contact
 *
 * @package KhaSolar
 * @since 1.1.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add floating contact buttons
 */
function khasolar_floating_contact_buttons() {
    ?>
    <div class="floating-contact-buttons">
        <?php
        // WhatsApp
        $whatsapp_number = get_theme_mod( 'khasolar_whatsapp', '84123456789' ); // Format: 84 + phone without 0
        $whatsapp_message = urlencode( __( 'Xin chào! Tôi muốn tư vấn về sản phẩm năng lượng mặt trời.', 'khasolar' ) );
        ?>
        <a href="https://wa.me/<?php echo esc_attr( $whatsapp_number ); ?>?text=<?php echo $whatsapp_message; ?>"
           class="contact-btn whatsapp-btn"
           target="_blank"
           rel="noopener"
           aria-label="<?php _e( 'Chat qua WhatsApp', 'khasolar' ); ?>">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.304-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
            <span class="contact-label"><?php _e( 'WhatsApp', 'khasolar' ); ?></span>
        </a>

        <?php
        // Zalo
        $zalo_number = get_theme_mod( 'khasolar_zalo', '0123456789' );
        ?>
        <a href="https://zalo.me/<?php echo esc_attr( $zalo_number ); ?>"
           class="contact-btn zalo-btn"
           target="_blank"
           rel="noopener"
           aria-label="<?php _e( 'Chat qua Zalo', 'khasolar' ); ?>">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0C5.373 0 0 4.975 0 11.111c0 3.497 1.745 6.616 4.472 8.652V24l4.086-2.242c1.09.301 2.246.464 3.442.464 6.627 0 12-4.974 12-11.111C24 4.975 18.627 0 12 0zm.84 14.967l-3.056-3.259-5.963 3.259 6.559-6.963 3.13 3.259 5.889-3.259-6.559 6.963z"/>
            </svg>
            <span class="contact-label"><?php _e( 'Zalo', 'khasolar' ); ?></span>
        </a>

        <?php
        // Hotline
        $hotline = str_replace( ' ', '', khasolar_get_phone() );
        ?>
        <a href="tel:<?php echo esc_attr( $hotline ); ?>"
           class="contact-btn phone-btn"
           aria-label="<?php _e( 'Gọi điện', 'khasolar' ); ?>">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
            </svg>
            <span class="contact-label"><?php _e( 'Hotline', 'khasolar' ); ?></span>
        </a>
    </div>
    <?php
}
add_action( 'wp_footer', 'khasolar_floating_contact_buttons' );

/**
 * Add Customizer settings for contact numbers
 */
function khasolar_customize_register_contact( $wp_customize ) {

    // Add Section
    $wp_customize->add_section( 'khasolar_contact_settings', array(
        'title'    => __( 'Thông tin liên hệ', 'khasolar' ),
        'priority' => 30,
    ) );

    // WhatsApp Number
    $wp_customize->add_setting( 'khasolar_whatsapp', array(
        'default'           => '84123456789',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'khasolar_whatsapp', array(
        'label'       => __( 'Số WhatsApp', 'khasolar' ),
        'description' => __( 'Định dạng: 84 + số điện thoại (không có số 0 đầu). VD: 84987654321', 'khasolar' ),
        'section'     => 'khasolar_contact_settings',
        'type'        => 'text',
    ) );

    // Zalo Number
    $wp_customize->add_setting( 'khasolar_zalo', array(
        'default'           => '0123456789',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'khasolar_zalo', array(
        'label'       => __( 'Số Zalo', 'khasolar' ),
        'description' => __( 'Số điện thoại Zalo của bạn', 'khasolar' ),
        'section'     => 'khasolar_contact_settings',
        'type'        => 'text',
    ) );
}
add_action( 'customize_register', 'khasolar_customize_register_contact' );
