<?php
/**
 * Template part for displaying product specifications table
 *
 * @package KhaSolar
 * @since 1.0.0
 */

$product_id     = get_the_ID();
$brand          = get_post_meta( $product_id, '_ks_brand', true );
$model          = get_post_meta( $product_id, '_ks_model', true );
$power_kw       = get_post_meta( $product_id, '_ks_power_kw', true );
$phase          = get_post_meta( $product_id, '_ks_phase', true );
$voltage        = get_post_meta( $product_id, '_ks_voltage', true );
$warranty_years = get_post_meta( $product_id, '_ks_warranty_years', true );
$origin         = get_post_meta( $product_id, '_ks_origin', true );
$key_specs      = get_post_meta( $product_id, '_ks_key_specs', true );
?>

<div class="product-specs-table">
    <h3 class="specs-title"><?php _e( 'Thông số kỹ thuật', 'khasolar' ); ?></h3>

    <table class="specs-table">
        <tbody>
            <?php if ( $brand ) : ?>
                <tr>
                    <th><?php _e( 'Thương hiệu', 'khasolar' ); ?></th>
                    <td><?php echo esc_html( $brand ); ?></td>
                </tr>
            <?php endif; ?>

            <?php if ( $model ) : ?>
                <tr>
                    <th><?php _e( 'Model', 'khasolar' ); ?></th>
                    <td><?php echo esc_html( $model ); ?></td>
                </tr>
            <?php endif; ?>

            <?php if ( $power_kw ) : ?>
                <tr>
                    <th><?php _e( 'Công suất', 'khasolar' ); ?></th>
                    <td><strong><?php echo esc_html( $power_kw ); ?> kW</strong></td>
                </tr>
            <?php endif; ?>

            <?php if ( $phase ) : ?>
                <tr>
                    <th><?php _e( 'Pha', 'khasolar' ); ?></th>
                    <td><?php echo esc_html( $phase ); ?></td>
                </tr>
            <?php endif; ?>

            <?php if ( $voltage ) : ?>
                <tr>
                    <th><?php _e( 'Điện áp', 'khasolar' ); ?></th>
                    <td><?php echo esc_html( $voltage ); ?></td>
                </tr>
            <?php endif; ?>

            <?php if ( $origin ) : ?>
                <tr>
                    <th><?php _e( 'Xuất xứ', 'khasolar' ); ?></th>
                    <td><?php echo esc_html( $origin ); ?></td>
                </tr>
            <?php endif; ?>

            <?php if ( $warranty_years ) : ?>
                <tr>
                    <th><?php _e( 'Bảo hành', 'khasolar' ); ?></th>
                    <td><strong><?php echo esc_html( $warranty_years ); ?> năm</strong></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if ( $key_specs ) : ?>
        <div class="key-specs">
            <h4><?php _e( 'Đặc điểm nổi bật', 'khasolar' ); ?></h4>
            <ul class="specs-list">
                <?php
                $specs_lines = explode( "\n", $key_specs );
                foreach ( $specs_lines as $spec ) {
                    $spec = trim( $spec );
                    if ( ! empty( $spec ) ) {
                        echo '<li>' . esc_html( $spec ) . '</li>';
                    }
                }
                ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
