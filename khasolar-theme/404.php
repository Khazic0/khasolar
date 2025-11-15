<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package KhaSolar
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">

    <div class="container">
        <div class="error-404-content">

            <div class="error-404-header">
                <h1 class="error-404-title">404</h1>
                <h2 class="error-404-subtitle"><?php _e( 'Oops! Trang không tồn tại', 'khasolar' ); ?></h2>
                <p><?php _e( 'Xin lỗi, trang bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.', 'khasolar' ); ?></p>
            </div>

            <div class="error-404-search">
                <h3><?php _e( 'Thử tìm kiếm:', 'khasolar' ); ?></h3>
                <form role="search" method="get" class="search-form-large" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="search" class="search-field" placeholder="<?php _e( 'Tìm kiếm...', 'khasolar' ); ?>" name="s" />
                    <button type="submit" class="btn btn-primary">
                        <?php _e( 'Tìm kiếm', 'khasolar' ); ?>
                    </button>
                </form>
            </div>

            <div class="error-404-links">
                <h3><?php _e( 'Hoặc quay về:', 'khasolar' ); ?></h3>
                <div class="quick-links">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-secondary">
                        <?php _e( 'Trang chủ', 'khasolar' ); ?>
                    </a>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_product' ) ); ?>" class="btn btn-secondary">
                        <?php _e( 'Sản phẩm', 'khasolar' ); ?>
                    </a>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_project' ) ); ?>" class="btn btn-secondary">
                        <?php _e( 'Dự án', 'khasolar' ); ?>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/lien-he' ) ); ?>" class="btn btn-secondary">
                        <?php _e( 'Liên hệ', 'khasolar' ); ?>
                    </a>
                </div>
            </div>

        </div>
    </div>

</main><!-- #primary -->

<?php
get_footer();
