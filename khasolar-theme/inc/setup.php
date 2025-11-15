<?php
/**
 * Theme Setup
 * Register theme supports, menus, image sizes, widget areas
 *
 * @package KhaSolar
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features
 */
function khasolar_theme_setup() {

    // Make theme available for translation
    load_theme_textdomain( 'khasolar', KHASOLAR_DIR . '/languages' );

    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support( 'post-thumbnails' );

    // Add custom image sizes
    add_image_size( 'khasolar-product-thumb', 400, 400, true );      // Product grid
    add_image_size( 'khasolar-product-large', 800, 800, true );      // Product single
    add_image_size( 'khasolar-project-thumb', 600, 400, true );      // Project grid
    add_image_size( 'khasolar-hero', 1920, 800, true );              // Hero images
    add_image_size( 'khasolar-blog-thumb', 400, 250, true );         // Blog grid

    // Register navigation menus
    register_nav_menus( array(
        'header_menu' => esc_html__( 'Header Menu', 'khasolar' ),
        'footer_menu' => esc_html__( 'Footer Menu', 'khasolar' ),
    ) );

    // Switch default core markup to output valid HTML5
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add theme support for selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Add support for editor styles
    add_theme_support( 'editor-styles' );

    // Add support for responsive embeds
    add_theme_support( 'responsive-embeds' );

    // Add support for custom background
    add_theme_support( 'custom-background', array(
        'default-color' => 'f5f5f7',
    ) );
}
add_action( 'after_setup_theme', 'khasolar_theme_setup' );

/**
 * Set the content width in pixels
 */
function khasolar_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'khasolar_content_width', 1200 );
}
add_action( 'after_setup_theme', 'khasolar_content_width', 0 );

/**
 * Register widget areas
 */
function khasolar_widgets_init() {

    // Sidebar for product archive
    register_sidebar( array(
        'name'          => esc_html__( 'Product Sidebar', 'khasolar' ),
        'id'            => 'product-sidebar',
        'description'   => esc_html__( 'Add widgets for product archive sidebar filters.', 'khasolar' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    // Footer widget areas (3 columns)
    for ( $i = 1; $i <= 3; $i++ ) {
        register_sidebar( array(
            'name'          => sprintf( esc_html__( 'Footer Column %d', 'khasolar' ), $i ),
            'id'            => 'footer-' . $i,
            'description'   => sprintf( esc_html__( 'Widgets for footer column %d.', 'khasolar' ), $i ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );
    }
}
add_action( 'widgets_init', 'khasolar_widgets_init' );

/**
 * Add body classes for better styling control
 */
function khasolar_body_classes( $classes ) {

    // Add class if we're viewing a single product
    if ( is_singular( 'solar_product' ) ) {
        $classes[] = 'single-solar-product';
    }

    // Add class if we're viewing product archive
    if ( is_post_type_archive( 'solar_product' ) || is_tax( 'solar_category' ) ) {
        $classes[] = 'archive-solar-products';
    }

    // Add class if we're viewing a single project
    if ( is_singular( 'solar_project' ) ) {
        $classes[] = 'single-solar-project';
    }

    // Add class if we're viewing project archive
    if ( is_post_type_archive( 'solar_project' ) ) {
        $classes[] = 'archive-solar-projects';
    }

    // Add class for front page
    if ( is_front_page() ) {
        $classes[] = 'khasolar-homepage';
    }

    return $classes;
}
add_filter( 'body_class', 'khasolar_body_classes' );

/**
 * Add custom excerpt length
 */
function khasolar_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'khasolar_excerpt_length' );

/**
 * Modify excerpt more string
 */
function khasolar_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'khasolar_excerpt_more' );
