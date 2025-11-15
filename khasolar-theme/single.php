<?php
/**
 * The template for displaying all single posts
 *
 * @package KhaSolar
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">

    <div class="page-header">
        <div class="container">
            <?php khasolar_breadcrumb(); ?>
        </div>
    </div>

    <div class="container">
        <div class="single-post-layout">

            <div class="post-main-content">
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>

                            <div class="entry-meta">
                                <?php khasolar_posted_on(); ?>
                                <span class="meta-separator">•</span>
                                <?php khasolar_posted_by(); ?>
                            </div>
                        </header>

                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-featured-image">
                                <?php the_post_thumbnail( 'full' ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>

                        <footer class="entry-footer">
                            <?php
                            $tags = get_the_tags();
                            if ( $tags ) :
                                ?>
                                <div class="post-tags">
                                    <strong><?php _e( 'Tags:', 'khasolar' ); ?></strong>
                                    <?php
                                    foreach ( $tags as $tag ) {
                                        echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a> ';
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                        </footer>

                    </article>

                    <?php
                endwhile;
                ?>
            </div>

            <aside class="post-sidebar">
                <div class="sidebar-widget">
                    <h3><?php _e( 'Bài viết mới', 'khasolar' ); ?></h3>
                    <?php
                    $recent_posts = new WP_Query( array(
                        'posts_per_page' => 5,
                        'post__not_in'   => array( get_the_ID() ),
                    ) );

                    if ( $recent_posts->have_posts() ) :
                        echo '<ul class="recent-posts-list">';
                        while ( $recent_posts->have_posts() ) :
                            $recent_posts->the_post();
                            ?>
                            <li>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                            </li>
                            <?php
                        endwhile;
                        echo '</ul>';
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </aside>

        </div>
    </div>

</main><!-- #primary -->

<?php
get_footer();
