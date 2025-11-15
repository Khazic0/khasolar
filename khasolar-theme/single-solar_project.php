<?php
/**
 * The template for displaying single project
 *
 * @package KhaSolar
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main single-project">

    <?php
    while ( have_posts() ) :
        the_post();

        $project_id      = get_the_ID();
        $location        = get_post_meta( $project_id, '_ks_project_location', true );
        $capacity        = get_post_meta( $project_id, '_ks_project_capacity_kwp', true );
        $type            = get_post_meta( $project_id, '_ks_project_type', true );
        $inverter        = get_post_meta( $project_id, '_ks_project_inverter', true );
        $battery         = get_post_meta( $project_id, '_ks_project_battery', true );
        $completed_date  = get_post_meta( $project_id, '_ks_project_completed_date', true );
        $key_notes       = get_post_meta( $project_id, '_ks_project_key_notes', true );
        ?>

        <div class="project-header">
            <div class="container">
                <?php khasolar_breadcrumb(); ?>
            </div>
        </div>

        <div class="container">

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="project-header-main">
                    <h1 class="project-title"><?php the_title(); ?></h1>

                    <div class="project-meta-bar">
                        <?php if ( $location ) : ?>
                            <span class="project-meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <?php echo esc_html( $location ); ?>
                            </span>
                        <?php endif; ?>

                        <?php if ( $capacity ) : ?>
                            <span class="project-meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                </svg>
                                <strong><?php echo esc_html( $capacity ); ?> kWp</strong>
                            </span>
                        <?php endif; ?>

                        <?php if ( $type ) : ?>
                            <span class="project-meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <?php echo esc_html( $type ); ?>
                            </span>
                        <?php endif; ?>

                        <?php if ( $completed_date ) : ?>
                            <span class="project-meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <?php echo esc_html( mysql2date( 'd/m/Y', $completed_date ) ); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="project-featured-image">
                        <?php the_post_thumbnail( 'full' ); ?>
                    </div>
                <?php endif; ?>

                <div class="project-content-layout">

                    <div class="project-main-content">
                        <div class="project-description">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <aside class="project-sidebar">

                        <div class="project-info-box">
                            <h3><?php _e( 'Thông tin dự án', 'khasolar' ); ?></h3>

                            <table class="project-info-table">
                                <tbody>
                                    <?php if ( $location ) : ?>
                                        <tr>
                                            <th><?php _e( 'Địa điểm', 'khasolar' ); ?></th>
                                            <td><?php echo esc_html( $location ); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ( $capacity ) : ?>
                                        <tr>
                                            <th><?php _e( 'Công suất', 'khasolar' ); ?></th>
                                            <td><strong><?php echo esc_html( $capacity ); ?> kWp</strong></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ( $type ) : ?>
                                        <tr>
                                            <th><?php _e( 'Loại dự án', 'khasolar' ); ?></th>
                                            <td><?php echo esc_html( $type ); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ( $inverter ) : ?>
                                        <tr>
                                            <th><?php _e( 'Biến tần', 'khasolar' ); ?></th>
                                            <td><?php echo esc_html( $inverter ); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ( $battery ) : ?>
                                        <tr>
                                            <th><?php _e( 'Pin lưu trữ', 'khasolar' ); ?></th>
                                            <td><?php echo esc_html( $battery ); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ( $completed_date ) : ?>
                                        <tr>
                                            <th><?php _e( 'Hoàn thành', 'khasolar' ); ?></th>
                                            <td><?php echo esc_html( mysql2date( 'd/m/Y', $completed_date ) ); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ( $key_notes ) : ?>
                            <div class="project-notes-box">
                                <h3><?php _e( 'Ghi chú', 'khasolar' ); ?></h3>
                                <div class="notes-content">
                                    <?php echo wpautop( esc_html( $key_notes ) ); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="project-cta-box">
                            <h3><?php _e( 'Quan tâm đến giải pháp này?', 'khasolar' ); ?></h3>
                            <p><?php _e( 'Liên hệ với chúng tôi để được tư vấn chi tiết', 'khasolar' ); ?></p>
                            <a href="<?php echo esc_url( home_url( '/lien-he' ) ); ?>" class="btn btn-primary btn-block">
                                <?php _e( 'Nhận tư vấn', 'khasolar' ); ?>
                            </a>
                        </div>

                    </aside>

                </div><!-- .project-content-layout -->

            </article>

            <!-- Related Projects -->
            <?php
            $related_args = array(
                'post_type'      => 'solar_project',
                'posts_per_page' => 3,
                'post__not_in'   => array( $project_id ),
                'orderby'        => 'rand',
            );

            $related_query = new WP_Query( $related_args );

            if ( $related_query->have_posts() ) :
                ?>
                <section class="related-projects">
                    <h2><?php _e( 'Dự án khác', 'khasolar' ); ?></h2>
                    <div class="project-grid">
                        <?php
                        while ( $related_query->have_posts() ) :
                            $related_query->the_post();
                            get_template_part( 'template-parts/project/card' );
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </section>
                <?php
            endif;
            ?>

        </div><!-- .container -->

        <?php
    endwhile;
    ?>

</main><!-- #primary -->

<?php
get_footer();
