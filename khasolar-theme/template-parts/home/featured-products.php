<?php
/**
 * Template part for displaying featured products
 *
 * @package KhaSolar
 * @since 1.0.0
 */

// Query featured products
$args = array(
    'post_type'      => 'solar_product',
    'posts_per_page' => 8,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$products_query = new WP_Query( $args );
?>

<section class="featured-products-section">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title"><?php _e( 'Sản phẩm nổi bật', 'khasolar' ); ?></h2>
            <p class="section-subtitle"><?php _e( 'Những sản phẩm được tin dùng nhất bởi khách hàng', 'khasolar' ); ?></p>
        </div>

        <?php if ( $products_query->have_posts() ) : ?>
            <div class="product-grid">
                <?php
                while ( $products_query->have_posts() ) :
                    $products_query->the_post();
                    get_template_part( 'template-parts/product/card' );
                endwhile;
                wp_reset_postdata();
                ?>
            </div>

            <div class="section-footer text-center">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_product' ) ); ?>" class="btn btn-secondary">
                    <?php _e( 'Xem tất cả sản phẩm', 'khasolar' ); ?>
                </a>
            </div>

        <?php else : ?>
            <div class="no-products">
                <p><?php _e( 'Hiện chưa có sản phẩm nào.', 'khasolar' ); ?></p>
                <a href="<?php echo admin_url( 'admin.php?page=khasolar-demo' ); ?>" class="btn btn-primary">
                    <?php _e( 'Tạo dữ liệu demo', 'khasolar' ); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
