<?php
/**
 * Performance Optimizations
 *
 * @package KhaSolar
 * @since 1.2.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Lazy load images
 */
function khasolar_lazy_load_images( $content ) {
    if ( is_feed() || is_admin() ) {
        return $content;
    }

    // Add loading="lazy" to images
    $content = preg_replace( '/<img(.*?)src=/i', '<img$1loading="lazy" src=', $content );

    return $content;
}
add_filter( 'the_content', 'khasolar_lazy_load_images' );
add_filter( 'post_thumbnail_html', 'khasolar_lazy_load_images' );

/**
 * Defer JavaScript loading
 */
function khasolar_defer_scripts( $tag, $handle ) {
    // Don't defer jQuery (required by many plugins)
    if ( $handle === 'jquery' || $handle === 'jquery-core' ) {
        return $tag;
    }

    // Don't defer admin scripts
    if ( is_admin() ) {
        return $tag;
    }

    // Defer our theme scripts
    if ( strpos( $handle, 'khasolar' ) !== false ) {
        return str_replace( ' src', ' defer src', $tag );
    }

    return $tag;
}
add_filter( 'script_loader_tag', 'khasolar_defer_scripts', 10, 2 );

/**
 * Remove query strings from static resources
 */
function khasolar_remove_query_strings( $src ) {
    if ( strpos( $src, '?ver=' ) ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}
add_filter( 'style_loader_src', 'khasolar_remove_query_strings', 10, 1 );
add_filter( 'script_loader_src', 'khasolar_remove_query_strings', 10, 1 );

/**
 * Disable emoji scripts
 */
function khasolar_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'khasolar_disable_emojis' );

/**
 * Remove unnecessary WordPress features
 */
function khasolar_cleanup_wp_head() {
    // Remove WordPress version
    remove_action( 'wp_head', 'wp_generator' );

    // Remove RSD link
    remove_action( 'wp_head', 'rsd_link' );

    // Remove Windows Live Writer manifest link
    remove_action( 'wp_head', 'wlwmanifest_link' );

    // Remove shortlink
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );

    // Remove REST API link
    remove_action( 'wp_head', 'rest_output_link_wp_head' );

    // Remove oEmbed discovery links
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

    // Remove rel links
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
}
add_action( 'init', 'khasolar_cleanup_wp_head' );

/**
 * Limit post revisions
 */
if ( ! defined( 'WP_POST_REVISIONS' ) ) {
    define( 'WP_POST_REVISIONS', 3 );
}

/**
 * Optimize database queries
 */
function khasolar_optimize_queries( $query ) {
    if ( ! is_admin() && $query->is_main_query() ) {
        // Don't retrieve post meta if not needed
        if ( is_archive() ) {
            $query->set( 'update_post_meta_cache', false );
            $query->set( 'update_post_term_cache', false );
        }
    }
}
add_action( 'pre_get_posts', 'khasolar_optimize_queries' );

/**
 * Add preconnect for external resources
 */
function khasolar_resource_hints( $urls, $relation_type ) {
    if ( $relation_type === 'preconnect' ) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin',
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );

        // Add Google Analytics if configured
        if ( defined( 'KHASOLAR_GA_ID' ) && KHASOLAR_GA_ID ) {
            $urls[] = array(
                'href' => 'https://www.google-analytics.com',
                'crossorigin',
            );
        }
    }

    return $urls;
}
add_filter( 'wp_resource_hints', 'khasolar_resource_hints', 10, 2 );

/**
 * Enable GZIP compression
 */
function khasolar_enable_gzip() {
    if ( ! is_admin() && ! ini_get( 'zlib.output_compression' ) ) {
        if ( extension_loaded( 'zlib' ) ) {
            ob_start( 'ob_gzhandler' );
        }
    }
}
add_action( 'init', 'khasolar_enable_gzip' );

/**
 * Add browser caching headers
 */
function khasolar_add_cache_headers() {
    if ( ! is_admin() ) {
        header( 'Cache-Control: public, max-age=31536000' );
    }
}
add_action( 'send_headers', 'khasolar_add_cache_headers' );

/**
 * Optimize images on upload (if GD library is available)
 */
function khasolar_optimize_image( $file ) {
    if ( ! function_exists( 'wp_get_image_editor' ) ) {
        return $file;
    }

    $editor = wp_get_image_editor( $file );

    if ( ! is_wp_error( $editor ) ) {
        $editor->set_quality( 85 );
        $editor->save( $file );
    }

    return $file;
}
add_filter( 'wp_handle_upload', 'khasolar_optimize_image' );
