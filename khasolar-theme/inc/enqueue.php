<?php
/**
 * Enqueue Scripts and Styles
 *
 * @package KhaSolar
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue theme styles
 */
function khasolar_enqueue_styles() {

    // Google Fonts - Inter
    wp_enqueue_style(
        'khasolar-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap',
        array(),
        null
    );

    // Main theme stylesheet (required by WordPress)
    wp_enqueue_style(
        'khasolar-style',
        get_stylesheet_uri(),
        array(),
        KHASOLAR_VERSION
    );

    // Main CSS file
    wp_enqueue_style(
        'khasolar-main',
        KHASOLAR_URI . '/assets/css/main.css',
        array( 'khasolar-style' ),
        KHASOLAR_VERSION
    );
}
add_action( 'wp_enqueue_scripts', 'khasolar_enqueue_styles' );

/**
 * Enqueue theme scripts
 */
function khasolar_enqueue_scripts() {

    // Main JavaScript file
    wp_enqueue_script(
        'khasolar-main',
        KHASOLAR_URI . '/assets/js/main.js',
        array( 'jquery' ),
        KHASOLAR_VERSION,
        true
    );

    // Calculator JavaScript
    wp_enqueue_script(
        'khasolar-calculator',
        KHASOLAR_URI . '/assets/js/calculator.js',
        array( 'jquery', 'khasolar-main' ),
        KHASOLAR_VERSION,
        true
    );

    // Product Gallery JavaScript (only on single product pages)
    if ( is_singular( 'solar_product' ) ) {
        wp_enqueue_script(
            'khasolar-product-gallery',
            KHASOLAR_URI . '/assets/js/product-gallery.js',
            array(),
            KHASOLAR_VERSION,
            true
        );
    }

    // Cart JavaScript
    wp_enqueue_script(
        'khasolar-cart',
        KHASOLAR_URI . '/assets/js/cart.js',
        array( 'jquery', 'khasolar-main' ),
        KHASOLAR_VERSION,
        true
    );

    // Localize script for AJAX
    wp_localize_script( 'khasolar-main', 'khasolarData', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'khasolar_nonce' ),
    ) );

    // Comment reply script for threaded comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'khasolar_enqueue_scripts' );

/**
 * Enqueue admin styles and scripts
 */
function khasolar_admin_enqueue_scripts( $hook ) {
    global $post_type;

    // Enqueue media uploader on product edit pages
    if ( ( 'post.php' === $hook || 'post-new.php' === $hook ) && 'solar_product' === $post_type ) {
        wp_enqueue_media();

        // jQuery UI for sortable
        wp_enqueue_script( 'jquery-ui-sortable' );
    }

    // Only on our demo content page
    if ( 'toplevel_page_khasolar-demo' !== $hook ) {
        return;
    }

    // Admin styles
    wp_enqueue_style(
        'khasolar-admin',
        KHASOLAR_URI . '/assets/css/admin.css',
        array(),
        KHASOLAR_VERSION
    );
}
add_action( 'admin_enqueue_scripts', 'khasolar_admin_enqueue_scripts' );

/**
 * Add preconnect for Google Fonts
 */
function khasolar_resource_hints( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin',
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }
    return $urls;
}
add_filter( 'wp_resource_hints', 'khasolar_resource_hints', 10, 2 );
