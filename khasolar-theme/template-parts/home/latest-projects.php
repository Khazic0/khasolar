<?php
/**
 * Template part for displaying latest projects
 *
 * @package KhaSolar
 * @since 1.0.0
 */

// Query latest projects
$args = array(
    'post_type'      => 'solar_project',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$projects_query = new WP_Query( $args );
?>

<section class="latest-projects-section">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title"><?php _e( 'Dự án tiêu biểu', 'khasolar' ); ?></h2>
            <p class="section-subtitle"><?php _e( 'Những công trình đã triển khai thành công', 'khasolar' ); ?></p>
        </div>

        <?php if ( $projects_query->have_posts() ) : ?>
            <div class="project-grid">
                <?php
                while ( $projects_query->have_posts() ) :
                    $projects_query->the_post();
                    get_template_part( 'template-parts/project/card' );
                endwhile;
                wp_reset_postdata();
                ?>
            </div>

            <div class="section-footer text-center">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_project' ) ); ?>" class="btn btn-secondary">
                    <?php _e( 'Xem tất cả dự án', 'khasolar' ); ?>
                </a>
            </div>

        <?php else : ?>
            <div class="no-projects">
                <p><?php _e( 'Hiện chưa có dự án nào.', 'khasolar' ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
