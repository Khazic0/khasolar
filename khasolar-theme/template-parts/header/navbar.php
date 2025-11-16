<?php
/**
 * Template part for displaying the main navigation
 *
 * @package KhaSolar
 * @since 1.0.0
 */
?>

<div class="main-header">
    <div class="container">
        <div class="header-content">

            <!-- Logo -->
            <div class="site-branding">
                <?php
                if ( has_custom_logo() ) {
                    the_custom_logo();
                } else {
                    ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home">
                        <span class="site-title"><?php bloginfo( 'name' ); ?></span>
                    </a>
                    <?php
                }
                ?>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" aria-label="<?php _e( 'Menu', 'khasolar' ); ?>" aria-expanded="false">
                <span class="menu-icon"></span>
                <span class="menu-icon"></span>
                <span class="menu-icon"></span>
            </button>

            <!-- Primary Navigation -->
            <nav class="main-navigation">
                <?php
                if ( has_nav_menu( 'header_menu' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'header_menu',
                        'menu_class'     => 'primary-menu',
                        'container'      => false,
                        'depth'          => 2,
                    ) );
                } else {
                    ?>
                    <ul class="primary-menu">
                        <li class="<?php echo is_front_page() ? 'current-menu-item' : ''; ?>">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'Trang chủ', 'khasolar' ); ?></a>
                        </li>
                        <li class="<?php echo is_post_type_archive( 'solar_product' ) || is_singular( 'solar_product' ) ? 'current-menu-item' : ''; ?>">
                            <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_product' ) ); ?>"><?php _e( 'Sản phẩm', 'khasolar' ); ?></a>
                        </li>
                        <li class="<?php echo is_post_type_archive( 'solar_project' ) || is_singular( 'solar_project' ) ? 'current-menu-item' : ''; ?>">
                            <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_project' ) ); ?>"><?php _e( 'Dự án', 'khasolar' ); ?></a>
                        </li>
                        <li class="<?php echo is_home() || is_singular( 'post' ) ? 'current-menu-item' : ''; ?>">
                            <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php _e( 'Blog', 'khasolar' ); ?></a>
                        </li>
                        <li class="<?php echo is_page( 'gioi-thieu' ) ? 'current-menu-item' : ''; ?>">
                            <a href="<?php echo esc_url( home_url( '/gioi-thieu' ) ); ?>"><?php _e( 'Giới thiệu', 'khasolar' ); ?></a>
                        </li>
                        <li class="<?php echo is_page( 'lien-he' ) ? 'current-menu-item' : ''; ?>">
                            <a href="<?php echo esc_url( home_url( '/lien-he' ) ); ?>"><?php _e( 'Liên hệ', 'khasolar' ); ?></a>
                        </li>
                    </ul>
                    <?php
                }
                ?>
            </nav>

            <!-- Header Actions -->
            <div class="header-actions">
                <a href="tel:<?php echo esc_attr( str_replace( ' ', '', khasolar_get_phone() ) ); ?>" class="btn btn-hotline">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <span><?php _e( 'Hotline', 'khasolar' ); ?></span>
                </a>

                <?php
                // Get cart page - assumes you'll create a page with slug 'gio-hang'
                $cart_page_url = home_url( '/gio-hang/' );
                $cart_count = khasolar_get_cart_count();
                ?>
                <a href="<?php echo esc_url( $cart_page_url ); ?>" class="cart-icon" aria-label="<?php _e( 'Giỏ hàng', 'khasolar' ); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="cart-count <?php echo $cart_count > 0 ? 'has-items' : ''; ?>"><?php echo $cart_count; ?></span>
                </a>

                <button class="search-toggle" aria-label="<?php _e( 'Tìm kiếm', 'khasolar' ); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </button>
            </div>

        </div><!-- .header-content -->

        <!-- Search Form (Hidden by default) -->
        <div class="header-search-form" style="display: none;">
            <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input type="search" class="search-field" placeholder="<?php _e( 'Tìm kiếm sản phẩm...', 'khasolar' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                <button type="submit" class="search-submit">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </button>
            </form>
        </div>

    </div><!-- .container -->
</div><!-- .main-header -->
