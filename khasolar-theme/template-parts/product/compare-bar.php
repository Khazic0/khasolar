<?php
/**
 * Template part for displaying floating comparison bar
 *
 * @package KhaSolar
 * @since 1.2.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$compared_products = khasolar_get_compared_products();
$count = count( $compared_products );
?>

<div id="khasolar-compare-bar" class="compare-bar <?php echo $count > 0 ? 'has-products' : ''; ?>" data-count="<?php echo esc_attr( $count ); ?>">
    <div class="compare-bar-inner">
        <div class="compare-bar-header">
            <h4 class="compare-bar-title">
                <span class="dashicons dashicons-chart-bar"></span>
                <?php _e( 'So sánh sản phẩm', 'khasolar' ); ?>
                <span class="compare-count">(<span id="compare-count"><?php echo $count; ?></span>/4)</span>
            </h4>
            <button type="button" class="compare-bar-close" aria-label="<?php _e( 'Đóng', 'khasolar' ); ?>">
                <span class="dashicons dashicons-no-alt"></span>
            </button>
        </div>

        <div class="compare-bar-products" id="compare-products-list">
            <?php if ( ! empty( $compared_products ) ) : ?>
                <?php foreach ( $compared_products as $product_id ) : ?>
                    <?php
                    $product = get_post( $product_id );
                    if ( ! $product ) continue;
                    ?>
                    <div class="compare-product-item" data-product-id="<?php echo esc_attr( $product_id ); ?>">
                        <?php if ( has_post_thumbnail( $product_id ) ) : ?>
                            <div class="compare-product-image">
                                <?php echo get_the_post_thumbnail( $product_id, 'product-thumb' ); ?>
                            </div>
                        <?php endif; ?>
                        <div class="compare-product-info">
                            <h5><?php echo esc_html( get_the_title( $product_id ) ); ?></h5>
                        </div>
                        <button type="button" class="compare-product-remove" data-product-id="<?php echo esc_attr( $product_id ); ?>" aria-label="<?php _e( 'Xóa', 'khasolar' ); ?>">
                            <span class="dashicons dashicons-no"></span>
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="compare-empty-message"><?php _e( 'Chưa có sản phẩm nào. Nhấn "So sánh" ở sản phẩm bạn muốn so sánh.', 'khasolar' ); ?></p>
            <?php endif; ?>
        </div>

        <div class="compare-bar-actions">
            <button type="button" id="compare-clear-all" class="button button-secondary">
                <?php _e( 'Xóa tất cả', 'khasolar' ); ?>
            </button>
            <a href="<?php echo esc_url( home_url( '/so-sanh-san-pham/' ) ); ?>" id="compare-view-btn" class="button button-primary">
                <?php _e( 'Xem so sánh', 'khasolar' ); ?>
            </a>
        </div>
    </div>
</div>
