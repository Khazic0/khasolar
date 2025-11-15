<?php
/**
 * The template for displaying single product
 *
 * @package KhaSolar
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main single-product">

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
        ?>

        <div class="product-header">
            <div class="container">
                <?php khasolar_breadcrumb(); ?>
            </div>
        </div>

        <div class="container">
            <div class="product-main">

                <!-- Product Image -->
                <div class="product-image-section">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="product-main-image">
                            <?php the_post_thumbnail( 'khasolar-product-large' ); ?>
                        </div>
                    <?php else : ?>
                        <div class="product-main-image product-placeholder">
                            <img src="<?php echo esc_url( khasolar_get_placeholder_image() ); ?>" alt="<?php the_title_attribute(); ?>">
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Product Info -->
                <div class="product-info-section">
                    <?php if ( $brand ) : ?>
                        <div class="product-brand-label">
                            <span><?php echo esc_html( $brand ); ?></span>
                        </div>
                    <?php endif; ?>

                    <h1 class="product-title"><?php the_title(); ?></h1>

                    <?php if ( $model ) : ?>
                        <div class="product-model-code">
                            <?php _e( 'Mã:', 'khasolar' ); ?> <strong><?php echo esc_html( $model ); ?></strong>
                        </div>
                    <?php endif; ?>

                    <div class="product-quick-info">
                        <?php if ( $power_kw ) : ?>
                            <div class="quick-info-item">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                </svg>
                                <span><?php _e( 'Công suất:', 'khasolar' ); ?> <strong><?php echo esc_html( $power_kw ); ?> kW</strong></span>
                            </div>
                        <?php endif; ?>

                        <div class="quick-info-item quick-info-stock <?php echo esc_attr( khasolar_get_stock_status_class( $stock_status ) ); ?>">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                            </svg>
                            <span><?php echo esc_html( khasolar_get_stock_status_label( $stock_status ) ); ?></span>
                        </div>

                        <?php
                        $categories = get_the_terms( $product_id, 'solar_category' );
                        if ( $categories && ! is_wp_error( $categories ) ) :
                            $category = $categories[0];
                            ?>
                            <div class="quick-info-item">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                </svg>
                                <a href="<?php echo esc_url( get_term_link( $category ) ); ?>">
                                    <?php echo esc_html( $category->name ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="product-price-box">
                        <?php if ( $price_from && $price_from > 0 ) : ?>
                            <div class="price-label"><?php _e( 'Giá từ:', 'khasolar' ); ?></div>
                            <div class="price-value"><?php echo khasolar_format_price( $price_from ); ?></div>
                            <div class="price-note"><?php _e( '(Giá có thể thay đổi theo thời điểm)', 'khasolar' ); ?></div>
                        <?php else : ?>
                            <div class="price-contact-big">
                                <?php _e( 'Liên hệ để được báo giá tốt nhất', 'khasolar' ); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="product-summary">
                        <?php the_excerpt(); ?>
                    </div>

                    <div class="product-actions">
                        <a href="#lead-form" class="btn btn-primary btn-large smooth-scroll">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <?php _e( 'Nhận tư vấn & báo giá', 'khasolar' ); ?>
                        </a>

                        <a href="tel:<?php echo esc_attr( str_replace( ' ', '', khasolar_get_phone() ) ); ?>" class="btn btn-secondary-outline btn-large">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <?php _e( 'Gọi ngay:', 'khasolar' ); ?> <?php echo esc_html( khasolar_get_phone() ); ?>
                        </a>
                    </div>
                </div>

            </div><!-- .product-main -->

            <!-- Product Details Tabs/Sections -->
            <div class="product-details">

                <!-- Description -->
                <section class="product-section product-description">
                    <h2><?php _e( 'Mô tả sản phẩm', 'khasolar' ); ?></h2>
                    <div class="product-content">
                        <?php the_content(); ?>
                    </div>
                </section>

                <!-- Specifications -->
                <section class="product-section product-specifications">
                    <?php get_template_part( 'template-parts/product/spec-table' ); ?>
                </section>

                <!-- Consultation Section -->
                <section class="product-section product-consultation">
                    <h2><?php _e( 'Tư vấn hệ thống phù hợp', 'khasolar' ); ?></h2>
                    <div class="consultation-content">
                        <p><?php _e( 'Để lựa chọn thiết bị phù hợp nhất với nhu cầu sử dụng và điều kiện lắp đặt, bạn cần cân nhắc nhiều yếu tố:', 'khasolar' ); ?></p>
                        <ul>
                            <li><?php _e( 'Diện tích mái nhà/khu vực lắp đặt', 'khasolar' ); ?></li>
                            <li><?php _e( 'Công suất tiêu thụ điện hàng ngày', 'khasolar' ); ?></li>
                            <li><?php _e( 'Loại hình sử dụng (hòa lưới, hybrid, độc lập)', 'khasolar' ); ?></li>
                            <li><?php _e( 'Nhu cầu sử dụng pin lưu trữ', 'khasolar' ); ?></li>
                        </ul>
                        <p><strong><?php _e( 'Liên hệ ngay với Kha Solar để được tư vấn miễn phí!', 'khasolar' ); ?></strong></p>
                    </div>
                </section>

                <!-- Lead Form -->
                <section class="product-section">
                    <?php get_template_part( 'template-parts/product/lead-form' ); ?>
                </section>

            </div><!-- .product-details -->

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
                );

                $related_query = new WP_Query( $related_args );

                if ( $related_query->have_posts() ) :
                    ?>
                    <section class="related-products">
                        <h2><?php _e( 'Sản phẩm tương tự', 'khasolar' ); ?></h2>
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

<?php
get_footer();
