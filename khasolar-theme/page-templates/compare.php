<?php
/**
 * Template Name: So sánh sản phẩm
 *
 * Full page template for product comparison
 *
 * @package KhaSolar
 * @since 1.2.0
 */

get_header();

$compared_products = khasolar_get_compared_products();
?>

<div class="page-compare">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title"><?php _e( 'So sánh sản phẩm', 'khasolar' ); ?></h1>
            <?php if ( ! empty( $compared_products ) ) : ?>
                <p class="page-description"><?php _e( 'So sánh chi tiết thông số kỹ thuật giữa các sản phẩm', 'khasolar' ); ?></p>
            <?php endif; ?>
        </header>

        <?php if ( empty( $compared_products ) ) : ?>
            <div class="compare-empty">
                <div class="compare-empty-icon">
                    <span class="dashicons dashicons-chart-bar"></span>
                </div>
                <h2><?php _e( 'Chưa có sản phẩm nào để so sánh', 'khasolar' ); ?></h2>
                <p><?php _e( 'Vui lòng chọn ít nhất 2 sản phẩm để so sánh thông số kỹ thuật.', 'khasolar' ); ?></p>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_product' ) ); ?>" class="button button-primary">
                    <?php _e( 'Xem tất cả sản phẩm', 'khasolar' ); ?>
                </a>
            </div>

        <?php elseif ( count( $compared_products ) < 2 ) : ?>
            <div class="compare-notice">
                <p><?php _e( 'Vui lòng chọn thêm sản phẩm để so sánh (tối thiểu 2 sản phẩm).', 'khasolar' ); ?></p>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_product' ) ); ?>" class="button">
                    <?php _e( 'Thêm sản phẩm', 'khasolar' ); ?>
                </a>
            </div>

        <?php else : ?>
            <div class="comparison-table-wrapper">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th class="spec-label"><?php _e( 'Thông số', 'khasolar' ); ?></th>
                            <?php foreach ( $compared_products as $product_id ) : ?>
                                <?php $product = get_post( $product_id ); ?>
                                <?php if ( ! $product ) continue; ?>
                                <th class="product-col">
                                    <div class="product-header">
                                        <?php if ( has_post_thumbnail( $product_id ) ) : ?>
                                            <div class="product-image">
                                                <a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>">
                                                    <?php echo get_the_post_thumbnail( $product_id, 'product-thumb' ); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <h3 class="product-title">
                                            <a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>">
                                                <?php echo esc_html( get_the_title( $product_id ) ); ?>
                                            </a>
                                        </h3>
                                        <button type="button" class="compare-product-remove-btn" data-product-id="<?php echo esc_attr( $product_id ); ?>">
                                            <span class="dashicons dashicons-no-alt"></span>
                                            <?php _e( 'Xóa', 'khasolar' ); ?>
                                        </button>
                                    </div>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Define comparison rows
                        $comparison_rows = array(
                            'brand'       => __( 'Thương hiệu', 'khasolar' ),
                            'model'       => __( 'Model', 'khasolar' ),
                            'power_kw'    => __( 'Công suất (kW)', 'khasolar' ),
                            'phase'       => __( 'Số pha', 'khasolar' ),
                            'voltage'     => __( 'Điện áp', 'khasolar' ),
                            'warranty'    => __( 'Bảo hành (năm)', 'khasolar' ),
                            'origin'      => __( 'Xuất xứ', 'khasolar' ),
                            'price_from'  => __( 'Giá từ', 'khasolar' ),
                            'stock_status' => __( 'Tình trạng', 'khasolar' ),
                        );

                        // Get all product specs
                        $products_specs = array();
                        foreach ( $compared_products as $product_id ) {
                            $products_specs[ $product_id ] = khasolar_get_product_specs_array( $product_id );
                        }

                        // Output comparison rows
                        foreach ( $comparison_rows as $spec_key => $spec_label ) :
                            // Check if values differ
                            $values = array();
                            foreach ( $compared_products as $product_id ) {
                                $values[] = $products_specs[ $product_id ][ $spec_key ];
                            }
                            $has_difference = count( array_unique( array_filter( $values ) ) ) > 1;
                            ?>
                            <tr class="<?php echo $has_difference ? 'has-difference' : ''; ?>">
                                <td class="spec-label">
                                    <strong><?php echo esc_html( $spec_label ); ?></strong>
                                    <?php if ( $has_difference ) : ?>
                                        <span class="diff-indicator" title="<?php _e( 'Có sự khác biệt', 'khasolar' ); ?>">●</span>
                                    <?php endif; ?>
                                </td>
                                <?php foreach ( $compared_products as $product_id ) : ?>
                                    <td class="product-col">
                                        <?php
                                        $value = $products_specs[ $product_id ][ $spec_key ];

                                        if ( $spec_key === 'price_from' && $value ) {
                                            echo khasolar_get_formatted_price( $value );
                                        } elseif ( $spec_key === 'stock_status' && $value ) {
                                            echo khasolar_get_stock_status_label( $value );
                                        } elseif ( $spec_key === 'warranty' && $value ) {
                                            echo esc_html( $value . ' ' . __( 'năm', 'khasolar' ) );
                                        } elseif ( $spec_key === 'power_kw' && $value ) {
                                            echo esc_html( $value . ' kW' );
                                        } elseif ( $value ) {
                                            echo esc_html( $value );
                                        } else {
                                            echo '<span class="no-data">—</span>';
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>

                        <!-- Description row -->
                        <tr>
                            <td class="spec-label"><strong><?php _e( 'Mô tả', 'khasolar' ); ?></strong></td>
                            <?php foreach ( $compared_products as $product_id ) : ?>
                                <td class="product-col">
                                    <?php
                                    $excerpt = get_the_excerpt( $product_id );
                                    echo $excerpt ? wp_trim_words( $excerpt, 20 ) : '<span class="no-data">—</span>';
                                    ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>

                        <!-- Action buttons -->
                        <tr class="action-row">
                            <td class="spec-label"></td>
                            <?php foreach ( $compared_products as $product_id ) : ?>
                                <td class="product-col">
                                    <a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" class="button button-primary">
                                        <?php _e( 'Xem chi tiết', 'khasolar' ); ?>
                                    </a>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="compare-actions">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_product' ) ); ?>" class="button">
                    <?php _e( 'Thêm sản phẩm khác', 'khasolar' ); ?>
                </a>
                <button type="button" id="compare-print" class="button">
                    <span class="dashicons dashicons-printer"></span>
                    <?php _e( 'In so sánh', 'khasolar' ); ?>
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
