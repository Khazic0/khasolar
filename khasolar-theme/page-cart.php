<?php
/**
 * Template Name: Giỏ Hàng
 * Template for shopping cart page
 *
 * @package KhaSolar
 * @since 1.3.0
 */

get_header();

$cart_items = khasolar_get_cart_items();
$cart_count = khasolar_get_cart_count();
?>

<main class="site-main cart-page">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <?php _e( 'Giỏ hàng của bạn', 'khasolar' ); ?>
            </h1>
            <?php if ( ! empty( $cart_items ) ) : ?>
                <p class="cart-count-text"><?php printf( _n( '%d sản phẩm', '%d sản phẩm', $cart_count, 'khasolar' ), $cart_count ); ?></p>
            <?php endif; ?>
        </div>

        <?php if ( empty( $cart_items ) ) : ?>
            <div class="cart-empty">
                <div class="empty-cart-icon">
                    <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </div>
                <h2><?php _e( 'Giỏ hàng trống', 'khasolar' ); ?></h2>
                <p><?php _e( 'Bạn chưa có sản phẩm nào trong giỏ hàng.', 'khasolar' ); ?></p>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_product' ) ); ?>" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    <?php _e( 'Tiếp tục mua sắm', 'khasolar' ); ?>
                </a>
            </div>
        <?php else : ?>
            <div class="cart-content">
                <div class="cart-items-section">
                    <div class="cart-table-header">
                        <h2><?php _e( 'Sản phẩm', 'khasolar' ); ?></h2>
                        <button type="button" class="clear-cart-btn btn-text">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                            <?php _e( 'Xóa tất cả', 'khasolar' ); ?>
                        </button>
                    </div>

                    <div class="cart-items">
                        <?php foreach ( $cart_items as $item ) : ?>
                            <div class="cart-item" data-product-id="<?php echo esc_attr( $item['product_id'] ); ?>">
                                <div class="cart-item-image">
                                    <?php if ( $item['thumbnail'] ) : ?>
                                        <img src="<?php echo esc_url( $item['thumbnail'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
                                    <?php else : ?>
                                        <img src="<?php echo esc_url( khasolar_get_placeholder_image() ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
                                    <?php endif; ?>
                                </div>

                                <div class="cart-item-details">
                                    <h3 class="cart-item-title">
                                        <a href="<?php echo esc_url( $item['permalink'] ); ?>">
                                            <?php echo esc_html( $item['title'] ); ?>
                                        </a>
                                    </h3>

                                    <?php if ( $item['brand'] ) : ?>
                                        <div class="cart-item-brand">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                                <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                            </svg>
                                            <?php echo esc_html( $item['brand'] ); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( $item['power_kw'] ) : ?>
                                        <div class="cart-item-power">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                            </svg>
                                            <?php echo esc_html( $item['power_kw'] ); ?> kW
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="cart-item-quantity">
                                    <label><?php _e( 'Số lượng:', 'khasolar' ); ?></label>
                                    <div class="quantity-input">
                                        <button type="button" class="qty-btn qty-btn-minus">−</button>
                                        <input type="number" class="cart-quantity-input" value="<?php echo esc_attr( $item['quantity'] ); ?>" min="1" data-product-id="<?php echo esc_attr( $item['product_id'] ); ?>">
                                        <button type="button" class="qty-btn qty-btn-plus">+</button>
                                    </div>
                                </div>

                                <div class="cart-item-price">
                                    <?php if ( $item['price'] && $item['price'] > 0 ) : ?>
                                        <span class="price-label"><?php _e( 'Giá:', 'khasolar' ); ?></span>
                                        <span class="price-value"><?php echo khasolar_format_price( $item['price'] ); ?></span>
                                    <?php else : ?>
                                        <span class="price-contact"><?php _e( 'Liên hệ', 'khasolar' ); ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="cart-item-actions">
                                    <button type="button" class="remove-from-cart" data-product-id="<?php echo esc_attr( $item['product_id'] ); ?>" title="<?php _e( 'Xóa', 'khasolar' ); ?>">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="cart-sidebar">
                    <div class="cart-summary">
                        <h3><?php _e( 'Thông tin đơn hàng', 'khasolar' ); ?></h3>

                        <div class="cart-summary-item">
                            <span><?php _e( 'Tổng số lượng:', 'khasolar' ); ?></span>
                            <strong><?php echo $cart_count; ?> <?php _e( 'sản phẩm', 'khasolar' ); ?></strong>
                        </div>

                        <div class="cart-note">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <p><?php _e( 'Vui lòng liên hệ để được báo giá chính xác và tư vấn chi tiết.', 'khasolar' ); ?></p>
                        </div>

                        <div class="cart-actions">
                            <a href="<?php echo esc_url( khasolar_get_cart_zalo_link() ); ?>" class="btn btn-primary btn-block" target="_blank" rel="noopener">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <?php _e( 'Gửi yêu cầu qua Zalo', 'khasolar' ); ?>
                            </a>

                            <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_product' ) ); ?>" class="btn btn-secondary btn-block">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="15 18 9 12 15 6"></polyline>
                                </svg>
                                <?php _e( 'Tiếp tục mua sắm', 'khasolar' ); ?>
                            </a>
                        </div>
                    </div>

                    <div class="cart-help">
                        <h4><?php _e( 'Cần hỗ trợ?', 'khasolar' ); ?></h4>
                        <p><?php _e( 'Đội ngũ chuyên gia của chúng tôi sẵn sàng tư vấn và hỗ trợ bạn.', 'khasolar' ); ?></p>
                        <div class="contact-info">
                            <?php
                            $phone = get_theme_mod( 'khasolar_phone', '0987654321' );
                            $email = get_theme_mod( 'khasolar_email', 'info@khasolar.vn' );
                            ?>
                            <?php if ( $phone ) : ?>
                                <a href="tel:<?php echo esc_attr( $phone ); ?>" class="contact-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                    <?php echo esc_html( $phone ); ?>
                                </a>
                            <?php endif; ?>

                            <?php if ( $email ) : ?>
                                <a href="mailto:<?php echo esc_attr( $email ); ?>" class="contact-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                    <?php echo esc_html( $email ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
