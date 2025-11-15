<?php
/**
 * The template for displaying all pages
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
            <h1 class="page-title"><?php the_title(); ?></h1>
        </div>
    </div>

    <div class="container">
        <div class="page-content">
            <?php
            while ( have_posts() ) :
                the_post();
                ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="page-featured-image">
                            <?php the_post_thumbnail( 'full' ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>

                <?php
            endwhile;
            ?>
        </div>
    </div>

</main><!-- #primary -->

<?php
get_footer();
