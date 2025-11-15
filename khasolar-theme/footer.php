    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="footer-main">
            <div class="container">
                <div class="footer-columns">

                    <!-- Column 1: About -->
                    <div class="footer-column footer-about">
                        <?php if ( has_custom_logo() ) : ?>
                            <div class="footer-logo">
                                <?php the_custom_logo(); ?>
                            </div>
                        <?php else : ?>
                            <h3 class="footer-brand"><?php bloginfo( 'name' ); ?></h3>
                        <?php endif; ?>
                        <p class="footer-description">
                            <?php
                            $description = get_bloginfo( 'description' );
                            if ( $description ) {
                                echo esc_html( $description );
                            } else {
                                _e( 'Giải pháp năng lượng mặt trời hàng đầu - Thiết bị chính hãng, tư vấn chuyên nghiệp, bảo hành dài hạn.', 'khasolar' );
                            }
                            ?>
                        </p>
                        <?php khasolar_social_links(); ?>
                    </div>

                    <!-- Column 2: Quick Links -->
                    <div class="footer-column footer-menu">
                        <h4 class="footer-title"><?php _e( 'Về Kha Solar', 'khasolar' ); ?></h4>
                        <?php
                        if ( has_nav_menu( 'footer_menu' ) ) {
                            wp_nav_menu( array(
                                'theme_location' => 'footer_menu',
                                'menu_class'     => 'footer-nav',
                                'container'      => 'nav',
                                'depth'          => 1,
                            ) );
                        } else {
                            ?>
                            <nav>
                                <ul class="footer-nav">
                                    <li><a href="<?php echo esc_url( home_url( '/gioi-thieu' ) ); ?>"><?php _e( 'Giới thiệu', 'khasolar' ); ?></a></li>
                                    <li><a href="<?php echo esc_url( get_post_type_archive_link( 'solar_project' ) ); ?>"><?php _e( 'Dự án', 'khasolar' ); ?></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/chinh-sach-bao-hanh' ) ); ?>"><?php _e( 'Chính sách bảo hành', 'khasolar' ); ?></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/chinh-sach-van-chuyen' ) ); ?>"><?php _e( 'Vận chuyển & Lắp đặt', 'khasolar' ); ?></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/lien-he' ) ); ?>"><?php _e( 'Liên hệ', 'khasolar' ); ?></a></li>
                                </ul>
                            </nav>
                            <?php
                        }
                        ?>
                    </div>

                    <!-- Column 3: Contact Info -->
                    <div class="footer-column footer-contact">
                        <h4 class="footer-title"><?php _e( 'Liên hệ', 'khasolar' ); ?></h4>
                        <ul class="contact-info">
                            <li class="contact-phone">
                                <strong><?php _e( 'Hotline:', 'khasolar' ); ?></strong>
                                <a href="tel:<?php echo esc_attr( str_replace( ' ', '', khasolar_get_phone() ) ); ?>">
                                    <?php echo esc_html( khasolar_get_phone() ); ?>
                                </a>
                            </li>
                            <li class="contact-email">
                                <strong><?php _e( 'Email:', 'khasolar' ); ?></strong>
                                <a href="mailto:<?php echo esc_attr( khasolar_get_email() ); ?>">
                                    <?php echo esc_html( khasolar_get_email() ); ?>
                                </a>
                            </li>
                            <li class="contact-address">
                                <strong><?php _e( 'Địa chỉ:', 'khasolar' ); ?></strong>
                                <?php echo esc_html( khasolar_get_address() ); ?>
                            </li>
                            <li class="contact-hours">
                                <strong><?php _e( 'Giờ làm việc:', 'khasolar' ); ?></strong>
                                <?php echo esc_html( khasolar_get_working_hours() ); ?>
                            </li>
                        </ul>
                    </div>

                </div><!-- .footer-columns -->
            </div><!-- .container -->
        </div><!-- .footer-main -->

        <div class="footer-bottom">
            <div class="container">
                <div class="footer-copyright">
                    <p>
                        &copy; <?php echo date( 'Y' ); ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <?php bloginfo( 'name' ); ?>
                        </a>.
                        <?php _e( 'Tất cả quyền được bảo lưu.', 'khasolar' ); ?>
                    </p>
                </div>
            </div>
        </div><!-- .footer-bottom -->
    </footer><!-- #colophon -->

    <button id="scroll-to-top" class="scroll-to-top" aria-label="<?php _e( 'Lên đầu trang', 'khasolar' ); ?>">
        <span class="arrow-up">↑</span>
    </button>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
