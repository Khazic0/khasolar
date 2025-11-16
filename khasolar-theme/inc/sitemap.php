<?php
/**
 * XML Sitemap Generator
 *
 * Generates XML sitemap for better SEO
 *
 * @package KhaSolar
 * @since 1.2.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Generate XML Sitemap
 */
function khasolar_generate_sitemap() {
    // Check if this is sitemap request
    if ( ! isset( $_GET['feed'] ) || $_GET['feed'] !== 'sitemap' ) {
        return;
    }

    header( 'Content-Type: application/xml; charset=utf-8' );
    header( 'X-Robots-Tag: noindex, follow', true );

    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    // Homepage
    echo '<url>';
    echo '<loc>' . esc_url( home_url( '/' ) ) . '</loc>';
    echo '<lastmod>' . date( 'c', current_time( 'timestamp' ) ) . '</lastmod>';
    echo '<changefreq>daily</changefreq>';
    echo '<priority>1.0</priority>';
    echo '</url>';

    // Pages
    $pages = get_pages( array(
        'post_status' => 'publish',
        'sort_column' => 'post_modified',
    ) );

    foreach ( $pages as $page ) {
        $priority = $page->post_parent == 0 ? '0.8' : '0.6';

        echo '<url>';
        echo '<loc>' . esc_url( get_permalink( $page->ID ) ) . '</loc>';
        echo '<lastmod>' . date( 'c', strtotime( $page->post_modified ) ) . '</lastmod>';
        echo '<changefreq>monthly</changefreq>';
        echo '<priority>' . $priority . '</priority>';
        echo '</url>';
    }

    // Blog posts
    $posts = get_posts( array(
        'post_type'   => 'post',
        'post_status' => 'publish',
        'numberposts' => 500,
        'orderby'     => 'modified',
        'order'       => 'DESC',
    ) );

    foreach ( $posts as $post ) {
        echo '<url>';
        echo '<loc>' . esc_url( get_permalink( $post->ID ) ) . '</loc>';
        echo '<lastmod>' . date( 'c', strtotime( $post->post_modified ) ) . '</lastmod>';
        echo '<changefreq>weekly</changefreq>';
        echo '<priority>0.6</priority>';
        echo '</url>';
    }

    // Solar Products
    $products = get_posts( array(
        'post_type'   => 'solar_product',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby'     => 'modified',
        'order'       => 'DESC',
    ) );

    foreach ( $products as $product ) {
        echo '<url>';
        echo '<loc>' . esc_url( get_permalink( $product->ID ) ) . '</loc>';
        echo '<lastmod>' . date( 'c', strtotime( $product->post_modified ) ) . '</lastmod>';
        echo '<changefreq>weekly</changefreq>';
        echo '<priority>0.9</priority>';
        echo '</url>';
    }

    // Product categories
    $categories = get_terms( array(
        'taxonomy'   => 'solar_category',
        'hide_empty' => true,
    ) );

    if ( ! is_wp_error( $categories ) ) {
        foreach ( $categories as $category ) {
            echo '<url>';
            echo '<loc>' . esc_url( get_term_link( $category ) ) . '</loc>';
            echo '<changefreq>weekly</changefreq>';
            echo '<priority>0.7</priority>';
            echo '</url>';
        }
    }

    // Solar Projects
    $projects = get_posts( array(
        'post_type'   => 'solar_project',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby'     => 'modified',
        'order'       => 'DESC',
    ) );

    foreach ( $projects as $project ) {
        echo '<url>';
        echo '<loc>' . esc_url( get_permalink( $project->ID ) ) . '</loc>';
        echo '<lastmod>' . date( 'c', strtotime( $project->post_modified ) ) . '</lastmod>';
        echo '<changefreq>monthly</changefreq>';
        echo '<priority>0.7</priority>';
        echo '</url>';
    }

    // Product archive
    $product_archive = get_post_type_archive_link( 'solar_product' );
    if ( $product_archive ) {
        echo '<url>';
        echo '<loc>' . esc_url( $product_archive ) . '</loc>';
        echo '<changefreq>daily</changefreq>';
        echo '<priority>0.9</priority>';
        echo '</url>';
    }

    // Project archive
    $project_archive = get_post_type_archive_link( 'solar_project' );
    if ( $project_archive ) {
        echo '<url>';
        echo '<loc>' . esc_url( $project_archive ) . '</loc>';
        echo '<changefreq>weekly</changefreq>';
        echo '<priority>0.8</priority>';
        echo '</url>';
    }

    echo '</urlset>';
    exit;
}
add_action( 'template_redirect', 'khasolar_generate_sitemap', 1 );

/**
 * Add sitemap to robots.txt
 */
function khasolar_robots_txt( $output ) {
    $output .= "Sitemap: " . home_url( '/?feed=sitemap' ) . "\n";
    return $output;
}
add_filter( 'robots_txt', 'khasolar_robots_txt' );

/**
 * Ping search engines when content updates
 */
function khasolar_ping_search_engines( $post_id ) {
    // Only ping for products and projects
    $post_type = get_post_type( $post_id );
    if ( ! in_array( $post_type, array( 'solar_product', 'solar_project', 'post' ), true ) ) {
        return;
    }

    // Check if published
    if ( get_post_status( $post_id ) !== 'publish' ) {
        return;
    }

    // Ping Google
    $sitemap_url = home_url( '/?feed=sitemap' );
    $ping_url = 'https://www.google.com/ping?sitemap=' . urlencode( $sitemap_url );

    wp_remote_get( $ping_url, array(
        'timeout' => 3,
        'blocking' => false,
    ) );
}
add_action( 'save_post', 'khasolar_ping_search_engines', 10, 1 );
