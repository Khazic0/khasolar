<?php
/**
 * The template for displaying product archive
 *
 * @package KhaSolar
 * @since 1.2.0
 */

get_header();
?>

<main id="primary" class="site-main archive-products">

    <div class="page-header-enhanced">
        <div class="container">
            <?php khasolar_breadcrumb(); ?>

            <div class="page-header-content">
                <h1 class="page-title-large">
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
                <?php else : ?>
                    <p class="archive-subtitle"><?php _e( 'Biến tần, Pin lưu trữ, Tủ điện chất lượng cao - Chính hãng, Bảo hành dài hạn', 'khasolar' ); ?></p>
                <?php endif; ?>
            </div>

            <!-- Trust Badges -->
            <div class="trust-badges-mini">
                <div class="trust-badge">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                    <span><?php _e( 'Chính hãng 100%', 'khasolar' ); ?></span>
                </div>
                <div class="trust-badge">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span><?php _e( 'Bảo hành dài hạn', 'khasolar' ); ?></span>
                </div>
                <div class="trust-badge">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span><?php _e( 'Giao hàng toàn quốc', 'khasolar' ); ?></span>
                </div>
                <div class="trust-badge">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span><?php _e( 'Hỗ trợ 24/7', 'khasolar' ); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Mobile Filter Toggle -->
        <button class="mobile-filter-toggle" id="mobileFilterToggle">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="4" y1="21" x2="4" y2="14"></line>
                <line x1="4" y1="10" x2="4" y2="3"></line>
                <line x1="12" y1="21" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12" y2="3"></line>
                <line x1="20" y1="21" x2="20" y2="16"></line>
                <line x1="20" y1="12" x2="20" y2="3"></line>
                <line x1="1" y1="14" x2="7" y2="14"></line>
                <line x1="9" y1="8" x2="15" y2="8"></line>
                <line x1="17" y1="16" x2="23" y2="16"></line>
            </svg>
            <?php _e( 'Bộ lọc', 'khasolar' ); ?>
        </button>

        <div class="archive-layout">

            <!-- Sidebar Filters -->
            <aside class="archive-sidebar" id="archiveSidebar">
                <div class="sidebar-header mobile-only">
                    <h3><?php _e( 'Bộ lọc sản phẩm', 'khasolar' ); ?></h3>
                    <button class="sidebar-close" id="sidebarClose">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <div class="sidebar-widget">
                    <h3 class="widget-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <?php _e( 'Danh mục', 'khasolar' ); ?>
                    </h3>
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
                                    <span class="filter-label"><?php _e( 'Tất cả sản phẩm', 'khasolar' ); ?></span>
                                    <span class="filter-count">
                                        <?php
                                        $all_count = wp_count_posts( 'solar_product' );
                                        echo isset( $all_count->publish ) ? '(' . $all_count->publish . ')' : '';
                                        ?>
                                    </span>
                                </a>
                            </li>
                            <?php foreach ( $categories as $category ) : ?>
                                <li class="<?php echo is_tax( 'solar_category', $category->term_id ) ? 'active' : ''; ?>">
                                    <a href="<?php echo esc_url( get_term_link( $category ) ); ?>">
                                        <span class="filter-label"><?php echo esc_html( $category->name ); ?></span>
                                        <span class="filter-count">(<?php echo $category->count; ?>)</span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="sidebar-widget">
                    <h3 class="widget-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                        <?php _e( 'Công suất', 'khasolar' ); ?>
                    </h3>
                    <ul class="power-filter">
                        <li><a href="#"><span class="filter-label"><?php _e( 'Dưới 3 kW', 'khasolar' ); ?></span></a></li>
                        <li><a href="#"><span class="filter-label"><?php _e( '3-6 kW', 'khasolar' ); ?></span></a></li>
                        <li><a href="#"><span class="filter-label"><?php _e( '6-10 kW', 'khasolar' ); ?></span></a></li>
                        <li><a href="#"><span class="filter-label"><?php _e( 'Trên 10 kW', 'khasolar' ); ?></span></a></li>
                    </ul>
                </div>

                <div class="sidebar-widget">
                    <h3 class="widget-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        <?php _e( 'Thương hiệu', 'khasolar' ); ?>
                    </h3>
                    <ul class="brand-filter">
                        <li><a href="#"><span class="filter-label">Deye</span></a></li>
                        <li><a href="#"><span class="filter-label">LumenTree</span></a></li>
                        <li><a href="#"><span class="filter-label">Senergy</span></a></li>
                        <li><a href="#"><span class="filter-label">SUNGO</span></a></li>
                        <li><a href="#"><span class="filter-label">Ecergy</span></a></li>
                    </ul>
                </div>

                <div class="sidebar-widget widget-cta">
                    <div class="cta-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                    </div>
                    <h3><?php _e( 'Cần tư vấn?', 'khasolar' ); ?></h3>
                    <p><?php _e( 'Liên hệ ngay để được hỗ trợ chọn sản phẩm phù hợp nhất', 'khasolar' ); ?></p>
                    <a href="tel:<?php echo esc_attr( str_replace( ' ', '', khasolar_get_phone() ) ); ?>" class="btn btn-primary btn-block">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <?php echo esc_html( khasolar_get_phone() ); ?>
                    </a>
                    <a href="https://zalo.me/<?php echo esc_attr( get_theme_mod( 'khasolar_zalo', '0' ) ); ?>" target="_blank" class="btn btn-secondary-outline btn-block" style="margin-top: 10px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.486 2 2 6.262 2 11.5c0 2.848 1.334 5.408 3.45 7.164L4.5 22l3.856-1.592C9.582 20.794 10.77 21 12 21c5.514 0 10-4.262 10-9.5S17.514 2 12 2z"/>
                        </svg>
                        <?php _e( 'Chat Zalo', 'khasolar' ); ?>
                    </a>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="archive-content">
                <?php if ( have_posts() ) : ?>

                    <div class="archive-toolbar">
                        <div class="toolbar-left">
                            <div class="results-count">
                                <?php
                                global $wp_query;
                                printf(
                                    _n(
                                        '<strong>%s</strong> sản phẩm',
                                        '<strong>%s</strong> sản phẩm',
                                        $wp_query->found_posts,
                                        'khasolar'
                                    ),
                                    number_format_i18n( $wp_query->found_posts )
                                );
                                ?>
                            </div>
                        </div>

                        <div class="toolbar-right">
                            <div class="view-switcher">
                                <button class="view-btn active" data-view="grid" title="<?php _e( 'Xem dạng lưới', 'khasolar' ); ?>">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="14" width="7" height="7"></rect>
                                        <rect x="3" y="14" width="7" height="7"></rect>
                                    </svg>
                                </button>
                                <button class="view-btn" data-view="list" title="<?php _e( 'Xem dạng danh sách', 'khasolar' ); ?>">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="8" y1="6" x2="21" y2="6"></line>
                                        <line x1="8" y1="12" x2="21" y2="12"></line>
                                        <line x1="8" y1="18" x2="21" y2="18"></line>
                                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                    </svg>
                                </button>
                            </div>

                            <div class="archive-sorting">
                                <select id="product-sort" onchange="location = this.value;">
                                    <option value="<?php echo esc_url( remove_query_arg( 'orderby' ) ); ?>">
                                        <?php _e( 'Mặc định', 'khasolar' ); ?>
                                    </option>
                                    <option value="<?php echo esc_url( add_query_arg( 'orderby', 'date' ) ); ?>" <?php selected( isset( $_GET['orderby'] ) && $_GET['orderby'] === 'date' ); ?>>
                                        <?php _e( 'Mới nhất', 'khasolar' ); ?>
                                    </option>
                                    <option value="<?php echo esc_url( add_query_arg( 'orderby', 'title' ) ); ?>" <?php selected( isset( $_GET['orderby'] ) && $_GET['orderby'] === 'title' ); ?>>
                                        <?php _e( 'Tên A-Z', 'khasolar' ); ?>
                                    </option>
                                    <option value="<?php echo esc_url( add_query_arg( 'orderby', 'price' ) ); ?>" <?php selected( isset( $_GET['orderby'] ) && $_GET['orderby'] === 'price' ); ?>>
                                        <?php _e( 'Giá thấp đến cao', 'khasolar' ); ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="product-grid view-grid" id="productGrid">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            get_template_part( 'template-parts/product/card' );
                        endwhile;
                        ?>
                    </div>

                    <?php khasolar_pagination(); ?>

                <?php else : ?>

                    <div class="no-results-enhanced">
                        <div class="no-results-icon">
                            <svg width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        <h2><?php _e( 'Không tìm thấy sản phẩm nào', 'khasolar' ); ?></h2>
                        <p><?php _e( 'Xin lỗi, chúng tôi không tìm thấy sản phẩm phù hợp với bộ lọc của bạn. Vui lòng thử tìm kiếm hoặc liên hệ để được tư vấn.', 'khasolar' ); ?></p>
                        <div class="no-results-actions">
                            <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_product' ) ); ?>" class="btn btn-primary">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                </svg>
                                <?php _e( 'Xem tất cả sản phẩm', 'khasolar' ); ?>
                            </a>
                            <a href="tel:<?php echo esc_attr( str_replace( ' ', '', khasolar_get_phone() ) ); ?>" class="btn btn-secondary-outline">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <?php _e( 'Gọi ngay tư vấn', 'khasolar' ); ?>
                            </a>
                        </div>
                    </div>

                <?php endif; ?>
            </div>

        </div><!-- .archive-layout -->
    </div><!-- .container -->

</main><!-- #primary -->

<script>
// Mobile filter toggle
document.addEventListener('DOMContentLoaded', function() {
    const filterToggle = document.getElementById('mobileFilterToggle');
    const sidebar = document.getElementById('archiveSidebar');
    const sidebarClose = document.getElementById('sidebarClose');

    if (filterToggle && sidebar) {
        filterToggle.addEventListener('click', function() {
            sidebar.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        });
    }

    if (sidebarClose && sidebar) {
        sidebarClose.addEventListener('click', function() {
            sidebar.classList.remove('is-open');
            document.body.style.overflow = '';
        });
    }

    // View switcher
    const viewBtns = document.querySelectorAll('.view-btn');
    const productGrid = document.getElementById('productGrid');

    viewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const view = this.getAttribute('data-view');

            viewBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            if (view === 'list') {
                productGrid.classList.remove('view-grid');
                productGrid.classList.add('view-list');
            } else {
                productGrid.classList.remove('view-list');
                productGrid.classList.add('view-grid');
            }

            // Save preference
            localStorage.setItem('productView', view);
        });
    });

    // Load saved view preference
    const savedView = localStorage.getItem('productView');
    if (savedView === 'list') {
        document.querySelector('.view-btn[data-view="list"]').click();
    }
});
</script>

<?php
get_footer();
