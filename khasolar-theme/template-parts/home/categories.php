<?php
/**
 * Template part for displaying product categories
 *
 * @package KhaSolar
 * @since 1.0.0
 */

// Get product categories
$categories = get_terms( array(
    'taxonomy'   => 'solar_category',
    'hide_empty' => false,
) );
?>

<section class="category-section">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title"><?php _e( 'Danh mục sản phẩm', 'khasolar' ); ?></h2>
            <p class="section-subtitle"><?php _e( 'Khám phá các dòng sản phẩm năng lượng mặt trời chất lượng cao', 'khasolar' ); ?></p>
        </div>

        <div class="category-grid">
            <?php
            if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
                foreach ( $categories as $category ) :
                    $term_link = get_term_link( $category );
                    $count = $category->count;
                    ?>
                    <div class="category-card">
                        <a href="<?php echo esc_url( $term_link ); ?>" class="category-link">
                            <div class="category-icon">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                </svg>
                            </div>
                            <h3 class="category-name"><?php echo esc_html( $category->name ); ?></h3>
                            <p class="category-count"><?php echo sprintf( _n( '%s sản phẩm', '%s sản phẩm', $count, 'khasolar' ), $count ); ?></p>
                            <span class="category-arrow">→</span>
                        </a>
                    </div>
                    <?php
                endforeach;
            else :
                // Fallback demo categories if none exist
                $demo_categories = array(
                    array( 'name' => 'Biến tần Hybrid', 'count' => 15 ),
                    array( 'name' => 'Biến tần On-grid', 'count' => 12 ),
                    array( 'name' => 'Pin lưu trữ', 'count' => 20 ),
                    array( 'name' => 'Phụ kiện', 'count' => 8 ),
                    array( 'name' => 'Combo tiết kiệm', 'count' => 6 ),
                    array( 'name' => 'Tấm pin mặt trời', 'count' => 10 ),
                );

                foreach ( $demo_categories as $demo_cat ) :
                    ?>
                    <div class="category-card">
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_product' ) ); ?>" class="category-link">
                            <div class="category-icon">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                </svg>
                            </div>
                            <h3 class="category-name"><?php echo esc_html( $demo_cat['name'] ); ?></h3>
                            <p class="category-count"><?php echo sprintf( _n( '%s sản phẩm', '%s sản phẩm', $demo_cat['count'], 'khasolar' ), $demo_cat['count'] ); ?></p>
                            <span class="category-arrow">→</span>
                        </a>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
