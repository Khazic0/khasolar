<?php
/**
 * The template for displaying single product
 *
 * @package KhaSolar
 * @since 1.2.0
 */

get_header();
?>

<main id="primary" class="site-main single-product-enhanced">

    <?php
    while ( have_posts() ) :
        the_post();

        $product_id    = get_the_ID();
        $brand         = get_post_meta( $product_id, '_ks_brand', true );
        $model         = get_post_meta( $product_id, '_ks_model', true );
        $power_kw      = get_post_meta( $product_id, '_ks_power_kw', true );
        $price_from    = get_post_meta( $product_id, '_ks_price_from', true );
        $stock_status  = get_post_meta( $product_id, '_ks_stock_status', true );
        $stock_status  = ! empty( $stock_status ) ? $stock_status : 'in_stock';
        $warranty      = get_post_meta( $product_id, '_ks_warranty_years', true );
        $origin        = get_post_meta( $product_id, '_ks_origin', true );

        // Get average rating
        $rating = khasolar_get_product_rating( $product_id );
        $review_count = khasolar_get_product_review_count( $product_id );
        ?>

        <div class="product-header-breadcrumb">
            <div class="container">
                <?php khasolar_breadcrumb(); ?>
            </div>
        </div>

        <div class="container">
            <div class="product-main-grid">

                <!-- Product Gallery -->
                <div class="product-gallery-section">
                    <div class="product-main-image-wrapper">
                        <?php if ( $stock_status !== 'in_stock' ) : ?>
                            <div class="product-badge-overlay badge-<?php echo esc_attr( $stock_status ); ?>">
                                <?php echo esc_html( khasolar_get_stock_status_label( $stock_status ) ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="product-main-image">
                                <?php the_post_thumbnail( 'large', array( 'class' => 'zoom-image' ) ); ?>
                            </div>
                        <?php else : ?>
                            <div class="product-main-image product-placeholder">
                                <img src="<?php echo esc_url( khasolar_get_placeholder_image() ); ?>" alt="<?php the_title_attribute(); ?>" class="zoom-image">
                            </div>
                        <?php endif; ?>

                        <div class="image-zoom-hint">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                <line x1="11" y1="8" x2="11" y2="14"></line>
                                <line x1="8" y1="11" x2="14" y2="11"></line>
                            </svg>
                            <?php _e( 'Click để phóng to', 'khasolar' ); ?>
                        </div>
                    </div>

                    <!-- Trust Badges -->
                    <div class="product-trust-features">
                        <div class="trust-feature">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            <span><?php _e( '100% chính hãng', 'khasolar' ); ?></span>
                        </div>
                        <div class="trust-feature">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>
                                <?php
                                if ( $warranty ) {
                                    printf( __( 'Bảo hành %d năm', 'khasolar' ), $warranty );
                                } else {
                                    _e( 'Bảo hành chính hãng', 'khasolar' );
                                }
                                ?>
                            </span>
                        </div>
                        <div class="trust-feature">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            <span><?php _e( 'Giao hàng toàn quốc', 'khasolar' ); ?></span>
                        </div>
                        <div class="trust-feature">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            </svg>
                            <span><?php _e( 'Thi công chuyên nghiệp', 'khasolar' ); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="product-info-enhanced">
                    <!-- Brand Badge -->
                    <?php if ( $brand ) : ?>
                        <div class="product-brand-badge">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            <span><?php echo esc_html( $brand ); ?></span>
                            <?php if ( $origin ) : ?>
                                <span class="origin-flag"><?php echo esc_html( $origin ); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Product Title -->
                    <h1 class="product-title-enhanced"><?php the_title(); ?></h1>

                    <!-- Rating & Reviews -->
                    <?php if ( $rating > 0 || $review_count > 0 ) : ?>
                        <div class="product-rating-section">
                            <?php echo khasolar_display_stars( $rating ); ?>
                            <a href="#reviews" class="review-count-link smooth-scroll">
                                <?php printf( _n( '%d đánh giá', '%d đánh giá', $review_count, 'khasolar' ), $review_count ); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Model Code -->
                    <?php if ( $model ) : ?>
                        <div class="product-model-enhanced">
                            <span class="model-label"><?php _e( 'Mã sản phẩm:', 'khasolar' ); ?></span>
                            <strong class="model-code"><?php echo esc_html( $model ); ?></strong>
                        </div>
                    <?php endif; ?>

                    <!-- Quick Specs -->
                    <div class="product-quick-specs">
                        <?php if ( $power_kw ) : ?>
                            <div class="spec-item highlight-spec">
                                <div class="spec-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                    </svg>
                                </div>
                                <div class="spec-content">
                                    <span class="spec-label"><?php _e( 'Công suất', 'khasolar' ); ?></span>
                                    <strong class="spec-value"><?php echo esc_html( $power_kw ); ?> kW</strong>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="spec-item">
                            <div class="spec-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                </svg>
                            </div>
                            <div class="spec-content">
                                <span class="spec-label"><?php _e( 'Tình trạng', 'khasolar' ); ?></span>
                                <strong class="spec-value status-<?php echo esc_attr( $stock_status ); ?>">
                                    <?php echo esc_html( khasolar_get_stock_status_label( $stock_status ) ); ?>
                                </strong>
                            </div>
                        </div>

                        <?php
                        $categories = get_the_terms( $product_id, 'solar_category' );
                        if ( $categories && ! is_wp_error( $categories ) ) :
                            $category = $categories[0];
                            ?>
                            <div class="spec-item">
                                <div class="spec-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                        <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                    </svg>
                                </div>
                                <div class="spec-content">
                                    <span class="spec-label"><?php _e( 'Danh mục', 'khasolar' ); ?></span>
                                    <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="spec-value category-link">
                                        <?php echo esc_html( $category->name ); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Price Box -->
                    <div class="product-price-enhanced">
                        <?php if ( $price_from && $price_from > 0 ) : ?>
                            <div class="price-group">
                                <span class="price-label"><?php _e( 'Giá từ', 'khasolar' ); ?></span>
                                <div class="price-main"><?php echo khasolar_format_price( $price_from ); ?></div>
                                <span class="price-note"><?php _e( '(Giá có thể thay đổi theo chương trình khuyến mãi)', 'khasolar' ); ?></span>
                            </div>
                        <?php else : ?>
                            <div class="price-contact-box">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <div>
                                    <strong><?php _e( 'Liên hệ để được báo giá tốt nhất', 'khasolar' ); ?></strong>
                                    <p><?php _e( 'Giá ưu đãi dành riêng cho bạn', 'khasolar' ); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Price Benefits -->
                        <div class="price-benefits">
                            <div class="benefit-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <span><?php _e( 'Giá đã bao gồm VAT', 'khasolar' ); ?></span>
                            </div>
                            <div class="benefit-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <span><?php _e( 'Miễn phí vận chuyển nội thành', 'khasolar' ); ?></span>
                            </div>
                            <div class="benefit-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <span><?php _e( 'Hỗ trợ trả góp 0%', 'khasolar' ); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Short Description -->
                    <?php if ( get_the_excerpt() ) : ?>
                        <div class="product-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="product-actions-enhanced">
                        <a href="#lead-form" class="btn btn-primary btn-extra-large smooth-scroll">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            <?php _e( 'Yêu cầu báo giá ngay', 'khasolar' ); ?>
                        </a>

                        <div class="secondary-actions">
                            <a href="tel:<?php echo esc_attr( str_replace( ' ', '', khasolar_get_phone() ) ); ?>" class="btn btn-call">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <span>
                                    <small><?php _e( 'Hotline', 'khasolar' ); ?></small>
                                    <strong><?php echo esc_html( khasolar_get_phone() ); ?></strong>
                                </span>
                            </a>

                            <a href="https://zalo.me/<?php echo esc_attr( get_theme_mod( 'khasolar_zalo', '0' ) ); ?>" target="_blank" class="btn btn-zalo">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.486 2 2 6.262 2 11.5c0 2.848 1.334 5.408 3.45 7.164L4.5 22l3.856-1.592C9.582 20.794 10.77 21 12 21c5.514 0 10-4.262 10-9.5S17.514 2 12 2z"/>
                                </svg>
                                <span><?php _e( 'Chat Zalo', 'khasolar' ); ?></span>
                            </a>
                        </div>
                    </div>

                    <!-- Product Meta Info -->
                    <div class="product-meta-info">
                        <div class="meta-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                            </svg>
                            <span><?php _e( 'SKU:', 'khasolar' ); ?> <strong><?php echo $model ? esc_html( $model ) : $product_id; ?></strong></span>
                        </div>
                        <div class="meta-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            </svg>
                            <?php
                            $categories = get_the_terms( $product_id, 'solar_category' );
                            if ( $categories && ! is_wp_error( $categories ) ) :
                                ?>
                                <span><?php _e( 'Danh mục:', 'khasolar' ); ?>
                                <?php
                                $cat_links = array();
                                foreach ( $categories as $cat ) {
                                    $cat_links[] = '<a href="' . esc_url( get_term_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a>';
                                }
                                echo implode( ', ', $cat_links );
                                ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div><!-- .product-main-grid -->

            <!-- Product Details Tabs -->
            <div class="product-details-tabs">
                <div class="tabs-navigation" id="tabsNav">
                    <button class="tab-btn active" data-tab="description">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <?php _e( 'Mô tả', 'khasolar' ); ?>
                    </button>
                    <button class="tab-btn" data-tab="specifications">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        <?php _e( 'Thông số kỹ thuật', 'khasolar' ); ?>
                    </button>
                    <button class="tab-btn" data-tab="consultation">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        <?php _e( 'Tư vấn', 'khasolar' ); ?>
                    </button>
                    <button class="tab-btn" data-tab="reviews">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                        <?php _e( 'Đánh giá', 'khasolar' ); ?>
                        <?php if ( $review_count > 0 ) : ?>
                            <span class="tab-badge"><?php echo $review_count; ?></span>
                        <?php endif; ?>
                    </button>
                </div>

                <div class="tabs-content">
                    <!-- Description Tab -->
                    <div class="tab-panel active" id="tab-description">
                        <div class="product-content-enhanced">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <!-- Specifications Tab -->
                    <div class="tab-panel" id="tab-specifications">
                        <?php get_template_part( 'template-parts/product/spec-table' ); ?>
                    </div>

                    <!-- Consultation Tab -->
                    <div class="tab-panel" id="tab-consultation">
                        <div class="consultation-enhanced">
                            <div class="consultation-header">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <h3><?php _e( 'Tư vấn hệ thống phù hợp', 'khasolar' ); ?></h3>
                                <p><?php _e( 'Để lựa chọn thiết bị phù hợp nhất với nhu cầu sử dụng và điều kiện lắp đặt', 'khasolar' ); ?></p>
                            </div>

                            <div class="consultation-checklist">
                                <h4><?php _e( 'Các yếu tố cần cân nhắc:', 'khasolar' ); ?></h4>
                                <ul class="checklist-items">
                                    <li>
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        <span><?php _e( 'Diện tích mái nhà/khu vực lắp đặt', 'khasolar' ); ?></span>
                                    </li>
                                    <li>
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        <span><?php _e( 'Công suất tiêu thụ điện hàng ngày', 'khasolar' ); ?></span>
                                    </li>
                                    <li>
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        <span><?php _e( 'Loại hình sử dụng (hòa lưới, hybrid, độc lập)', 'khasolar' ); ?></span>
                                    </li>
                                    <li>
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        <span><?php _e( 'Nhu cầu sử dụng pin lưu trữ', 'khasolar' ); ?></span>
                                    </li>
                                    <li>
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        <span><?php _e( 'Ngân sách đầu tư dự kiến', 'khasolar' ); ?></span>
                                    </li>
                                </ul>
                            </div>

                            <div class="consultation-cta">
                                <h4><?php _e( 'Liên hệ ngay với Kha Solar để được tư vấn miễn phí!', 'khasolar' ); ?></h4>
                                <div class="cta-buttons">
                                    <a href="tel:<?php echo esc_attr( str_replace( ' ', '', khasolar_get_phone() ) ); ?>" class="btn btn-primary">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                        </svg>
                                        <?php _e( 'Gọi ngay tư vấn', 'khasolar' ); ?>
                                    </a>
                                    <a href="#lead-form" class="btn btn-secondary-outline smooth-scroll">
                                        <?php _e( 'Để lại thông tin', 'khasolar' ); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div class="tab-panel" id="tab-reviews">
                        <?php get_template_part( 'template-parts/product/reviews' ); ?>
                    </div>
                </div>
            </div>

            <!-- Lead Form Section -->
            <section class="product-section lead-form-section" id="lead-form">
                <div class="section-header-centered">
                    <h2><?php _e( 'Yêu cầu báo giá & tư vấn', 'khasolar' ); ?></h2>
                    <p><?php _e( 'Để lại thông tin để nhận báo giá chi tiết và tư vấn miễn phí từ chuyên gia', 'khasolar' ); ?></p>
                </div>
                <?php get_template_part( 'template-parts/product/lead-form' ); ?>
            </section>

            <!-- Related Products -->
            <?php
            $categories = get_the_terms( $product_id, 'solar_category' );
            if ( $categories && ! is_wp_error( $categories ) ) :
                $category_ids = wp_list_pluck( $categories, 'term_id' );

                $related_args = array(
                    'post_type'      => 'solar_product',
                    'posts_per_page' => 4,
                    'post__not_in'   => array( $product_id ),
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'solar_category',
                            'field'    => 'term_id',
                            'terms'    => $category_ids,
                        ),
                    ),
                    'orderby'        => 'rand',
                );

                $related_query = new WP_Query( $related_args );

                if ( $related_query->have_posts() ) :
                    ?>
                    <section class="related-products-section">
                        <div class="section-header-with-link">
                            <h2><?php _e( 'Sản phẩm tương tự', 'khasolar' ); ?></h2>
                            <a href="<?php echo esc_url( get_term_link( $categories[0] ) ); ?>" class="view-all-link">
                                <?php _e( 'Xem tất cả', 'khasolar' ); ?>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                        </div>
                        <div class="product-grid">
                            <?php
                            while ( $related_query->have_posts() ) :
                                $related_query->the_post();
                                get_template_part( 'template-parts/product/card' );
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </section>
                    <?php
                endif;
            endif;
            ?>

        </div><!-- .container -->

        <?php
    endwhile;
    ?>

</main><!-- #primary -->

<!-- Sticky Add to Cart Bar (appears on scroll) -->
<div class="sticky-cart-bar" id="stickyCartBar">
    <div class="container">
        <div class="sticky-bar-content">
            <div class="sticky-product-info">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="sticky-thumb">
                        <?php the_post_thumbnail( 'thumbnail' ); ?>
                    </div>
                <?php endif; ?>
                <div class="sticky-details">
                    <h4><?php the_title(); ?></h4>
                    <?php if ( $price_from ) : ?>
                        <span class="sticky-price"><?php echo khasolar_format_price( $price_from ); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="sticky-actions">
                <a href="#lead-form" class="btn btn-primary smooth-scroll">
                    <?php _e( 'Yêu cầu báo giá', 'khasolar' ); ?>
                </a>
                <a href="tel:<?php echo esc_attr( str_replace( ' ', '', khasolar_get_phone() ) ); ?>" class="btn btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <?php _e( 'Gọi ngay', 'khasolar' ); ?>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Tabs functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.tab-panel');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');

            // Remove active class from all
            tabBtns.forEach(b => b.classList.remove('active'));
            tabPanels.forEach(p => p.classList.remove('active'));

            // Add active to clicked
            this.classList.add('active');
            document.getElementById('tab-' + tabId).classList.add('active');
        });
    });

    // Sticky cart bar
    const stickyBar = document.getElementById('stickyCartBar');
    const productMain = document.querySelector('.product-main-grid');

    if (stickyBar && productMain) {
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    stickyBar.classList.remove('is-visible');
                } else {
                    stickyBar.classList.add('is-visible');
                }
            },
            { threshold: 0.1 }
        );

        observer.observe(productMain);
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('.smooth-scroll').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });
});
</script>

<?php
get_footer();
