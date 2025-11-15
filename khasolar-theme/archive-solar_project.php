<?php
/**
 * The template for displaying project archive
 *
 * @package KhaSolar
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main archive-projects">

    <div class="page-header">
        <div class="container">
            <?php khasolar_breadcrumb(); ?>

            <h1 class="page-title"><?php _e( 'Dự án tiêu biểu', 'khasolar' ); ?></h1>
            <p class="page-subtitle">
                <?php _e( 'Những công trình điện mặt trời đã triển khai thành công bởi Kha Solar', 'khasolar' ); ?>
            </p>
        </div>
    </div>

    <div class="container">
        <?php if ( have_posts() ) : ?>

            <div class="archive-toolbar">
                <div class="results-count">
                    <?php
                    global $wp_query;
                    printf(
                        _n(
                            'Hiển thị %s dự án',
                            'Hiển thị %s dự án',
                            $wp_query->found_posts,
                            'khasolar'
                        ),
                        '<strong>' . number_format_i18n( $wp_query->found_posts ) . '</strong>'
                    );
                    ?>
                </div>
            </div>

            <div class="project-grid">
                <?php
                while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/project/card' );
                endwhile;
                ?>
            </div>

            <?php khasolar_pagination(); ?>

        <?php else : ?>

            <div class="no-results">
                <h2><?php _e( 'Không tìm thấy dự án nào', 'khasolar' ); ?></h2>
                <p><?php _e( 'Hiện tại chưa có dự án nào được đăng tải.', 'khasolar' ); ?></p>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                    <?php _e( 'Về trang chủ', 'khasolar' ); ?>
                </a>
            </div>

        <?php endif; ?>
    </div><!-- .container -->

</main><!-- #primary -->

<?php
get_footer();
