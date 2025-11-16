<?php
/**
 * Template part for displaying a product card
 *
 * @package KhaSolar
 * @since 1.0.0
 */

$product_id    = get_the_ID();
$brand         = get_post_meta( $product_id, '_ks_brand', true );
$model         = get_post_meta( $product_id, '_ks_model', true );
$power_kw      = get_post_meta( $product_id, '_ks_power_kw', true );
$price_from    = get_post_meta( $product_id, '_ks_price_from', true );
$stock_status  = get_post_meta( $product_id, '_ks_stock_status', true );
$stock_status  = ! empty( $stock_status ) ? $stock_status : 'in_stock';
?>

<div class="product-card">
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="product-card-image">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'khasolar-product-thumb' ); ?>
            </a>

            <?php if ( $stock_status !== 'in_stock' ) : ?>
                <span class="product-badge badge-<?php echo esc_attr( $stock_status ); ?>">
                    <?php echo esc_html( khasolar_get_stock_status_label( $stock_status ) ); ?>
                </span>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <div class="product-card-image product-card-placeholder">
            <a href="<?php the_permalink(); ?>">
                <img src="<?php echo esc_url( khasolar_get_placeholder_image() ); ?>" alt="<?php the_title_attribute(); ?>">
            </a>
        </div>
    <?php endif; ?>

    <div class="product-card-content">
        <?php if ( $brand ) : ?>
            <div class="product-brand"><?php echo esc_html( $brand ); ?></div>
        <?php endif; ?>

        <h3 class="product-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <?php if ( $model ) : ?>
            <div class="product-model"><?php echo esc_html( $model ); ?></div>
        <?php endif; ?>

        <div class="product-card-meta">
            <?php if ( $power_kw ) : ?>
                <span class="product-power">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                    <?php echo esc_html( $power_kw ); ?> kW
                </span>
            <?php endif; ?>

            <?php
            $categories = get_the_terms( $product_id, 'solar_category' );
            if ( $categories && ! is_wp_error( $categories ) ) :
                $category = $categories[0];
                ?>
                <span class="product-category">
                    <a href="<?php echo esc_url( get_term_link( $category ) ); ?>">
                        <?php echo esc_html( $category->name ); ?>
                    </a>
                </span>
            <?php endif; ?>
        </div>

        <div class="product-card-footer">
            <div class="product-price">
                <?php if ( $price_from && $price_from > 0 ) : ?>
                    <span class="price-label"><?php _e( 'Giá từ:', 'khasolar' ); ?></span>
                    <span class="price-value"><?php echo khasolar_format_price( $price_from ); ?></span>
                <?php else : ?>
                    <span class="price-contact"><?php _e( 'Liên hệ', 'khasolar' ); ?></span>
                <?php endif; ?>
            </div>

            <div class="product-card-actions">
                <button type="button" class="add-to-compare <?php echo khasolar_is_product_in_compare( $product_id ) ? 'is-comparing' : ''; ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>">
                    <span class="dashicons dashicons-chart-bar"></span>
                    <span class="compare-text">
                        <?php echo khasolar_is_product_in_compare( $product_id ) ? __( 'Bỏ so sánh', 'khasolar' ) : __( 'So sánh', 'khasolar' ); ?>
                    </span>
                </button>
                <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-small">
                    <?php _e( 'Xem chi tiết', 'khasolar' ); ?>
                </a>
            </div>
        </div>
    </div>
</div>
