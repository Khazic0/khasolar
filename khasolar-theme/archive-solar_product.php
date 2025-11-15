<?php
/**
 * The template for displaying product archive
 *
 * @package KhaSolar
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main archive-products">

    <div class="page-header">
        <div class="container">
            <?php khasolar_breadcrumb(); ?>

            <h1 class="page-title">
                <?php
                if ( is_tax( 'solar_category' ) ) {
                    single_term_title();
                } else {
                    _e( 'Tất cả sản phẩm', 'khasolar' );
                }
                ?>
            </h1>

            <?php if ( is_tax( 'solar_category' ) && term_description() ) : ?>
                <div class="archive-description">
                    <?php echo term_description(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <div class="archive-layout">

            <!-- Sidebar Filters -->
            <aside class="archive-sidebar">
                <div class="sidebar-widget">
                    <h3 class="widget-title"><?php _e( 'Danh mục', 'khasolar' ); ?></h3>
                    <?php
                    $categories = get_terms( array(
                        'taxonomy'   => 'solar_category',
                        'hide_empty' => false,
                    ) );

                    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
                        ?>
                        <ul class="category-filter">
                            <li class="<?php echo ! is_tax( 'solar_category' ) ? 'active' : ''; ?>">
                                <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_product' ) ); ?>">
                                    <?php _e( 'Tất cả sản phẩm', 'khasolar' ); ?>
                                </a>
                            </li>
                            <?php foreach ( $categories as $category ) : ?>
                                <li class="<?php echo is_tax( 'solar_category', $category->term_id ) ? 'active' : ''; ?>">
                                    <a href="<?php echo esc_url( get_term_link( $category ) ); ?>">
                                        <?php echo esc_html( $category->name ); ?>
                                        <span class="count">(<?php echo $category->count; ?>)</span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="sidebar-widget">
                    <h3 class="widget-title"><?php _e( 'Công suất', 'khasolar' ); ?></h3>
                    <ul class="power-filter">
                        <li><a href="#"><?php _e( 'Dưới 3 kW', 'khasolar' ); ?></a></li>
                        <li><a href="#"><?php _e( '3-6 kW', 'khasolar' ); ?></a></li>
                        <li><a href="#"><?php _e( '6-10 kW', 'khasolar' ); ?></a></li>
                        <li><a href="#"><?php _e( 'Trên 10 kW', 'khasolar' ); ?></a></li>
                    </ul>
                </div>

                <div class="sidebar-widget">
                    <h3 class="widget-title"><?php _e( 'Thương hiệu', 'khasolar' ); ?></h3>
                    <ul class="brand-filter">
                        <li><a href="#">Deye</a></li>
                        <li><a href="#">APESS</a></li>
                        <li><a href="#">LumenTree</a></li>
                        <li><a href="#">Growatt</a></li>
                        <li><a href="#">Sofar</a></li>
                    </ul>
                </div>

                <div class="sidebar-widget widget-cta">
                    <h3><?php _e( 'Cần tư vấn?', 'khasolar' ); ?></h3>
                    <p><?php _e( 'Liên hệ ngay để được hỗ trợ chọn sản phẩm phù hợp', 'khasolar' ); ?></p>
                    <a href="tel:<?php echo esc_attr( str_replace( ' ', '', khasolar_get_phone() ) ); ?>" class="btn btn-primary btn-block">
                        <?php _e( 'Gọi ngay', 'khasolar' ); ?>
                    </a>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="archive-content">
                <?php if ( have_posts() ) : ?>

                    <div class="archive-toolbar">
                        <div class="results-count">
                            <?php
                            global $wp_query;
                            printf(
                                _n(
                                    'Hiển thị %s sản phẩm',
                                    'Hiển thị %s sản phẩm',
                                    $wp_query->found_posts,
                                    'khasolar'
                                ),
                                '<strong>' . number_format_i18n( $wp_query->found_posts ) . '</strong>'
                            );
                            ?>
                        </div>

                        <div class="archive-sorting">
                            <select id="product-sort" onchange="location = this.value;">
                                <option value="<?php echo esc_url( add_query_arg( 'orderby', 'date' ) ); ?>">
                                    <?php _e( 'Mới nhất', 'khasolar' ); ?>
                                </option>
                                <option value="<?php echo esc_url( add_query_arg( 'orderby', 'title' ) ); ?>">
                                    <?php _e( 'Tên A-Z', 'khasolar' ); ?>
                                </option>
                                <option value="<?php echo esc_url( add_query_arg( 'orderby', 'price' ) ); ?>">
                                    <?php _e( 'Giá thấp đến cao', 'khasolar' ); ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="product-grid">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            get_template_part( 'template-parts/product/card' );
                        endwhile;
                        ?>
                    </div>

                    <?php khasolar_pagination(); ?>

                <?php else : ?>

                    <div class="no-results">
                        <h2><?php _e( 'Không tìm thấy sản phẩm nào', 'khasolar' ); ?></h2>
                        <p><?php _e( 'Xin lỗi, chúng tôi không tìm thấy sản phẩm phù hợp. Vui lòng thử tìm kiếm hoặc liên hệ để được tư vấn.', 'khasolar' ); ?></p>
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_product' ) ); ?>" class="btn btn-primary">
                            <?php _e( 'Xem tất cả sản phẩm', 'khasolar' ); ?>
                        </a>
                    </div>

                <?php endif; ?>
            </div>

        </div><!-- .archive-layout -->
    </div><!-- .container -->

</main><!-- #primary -->

<?php
get_footer();
