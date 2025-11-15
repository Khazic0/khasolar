<?php
/**
 * The template for displaying the homepage
 *
 * @package KhaSolar
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main homepage">

    <?php
    // Hero Section
    get_template_part( 'template-parts/home/hero' );

    // Product Categories
    get_template_part( 'template-parts/home/categories' );

    // Trust Badges
    get_template_part( 'template-parts/home/trust-badges' );

    // Featured Products
    get_template_part( 'template-parts/home/featured-products' );

    // Latest Projects
    get_template_part( 'template-parts/home/latest-projects' );

    // Latest Blog Posts
    get_template_part( 'template-parts/home/latest-posts' );
    ?>

</main><!-- #primary -->

<?php
get_footer();
