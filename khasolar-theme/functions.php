<?php
/**
 * Kha Solar Theme Functions
 *
 * @package KhaSolar
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define theme constants
 */
define( 'KHASOLAR_VERSION', '1.3.0' );
define( 'KHASOLAR_DIR', get_template_directory() );
define( 'KHASOLAR_URI', get_template_directory_uri() );

/**
 * Increase upload size and image processing limits
 */
@ini_set( 'upload_max_size', '64M' );
@ini_set( 'post_max_size', '64M' );
@ini_set( 'max_execution_time', '300' );
@ini_set( 'memory_limit', '256M' );

/**
 * Filter upload size limit
 */
function khasolar_increase_upload_size( $size ) {
    return 1024 * 1024 * 64; // 64MB
}
add_filter( 'upload_size_limit', 'khasolar_increase_upload_size' );

/**
 * Add custom image sizes for better handling
 */
function khasolar_custom_image_sizes() {
    // Medium-large size for products
    add_image_size( 'product-medium', 800, 800, false );
    // Large size with reasonable dimensions
    add_image_size( 'product-large', 1200, 1200, false );
}
add_action( 'after_setup_theme', 'khasolar_custom_image_sizes' );

/**
 * Increase image processing memory
 */
function khasolar_increase_image_memory( $image ) {
    @ini_set( 'memory_limit', '256M' );
    return $image;
}
add_filter( 'wp_image_editors', 'khasolar_increase_image_memory' );

/**
 * Include theme files
 */
require_once KHASOLAR_DIR . '/inc/setup.php';
require_once KHASOLAR_DIR . '/inc/enqueue.php';
require_once KHASOLAR_DIR . '/inc/cpt-solar-product.php';
require_once KHASOLAR_DIR . '/inc/meta-solar-product.php';
require_once KHASOLAR_DIR . '/inc/cpt-solar-project.php';
require_once KHASOLAR_DIR . '/inc/template-tags.php';
require_once KHASOLAR_DIR . '/inc/leads.php';
require_once KHASOLAR_DIR . '/inc/demo-content.php';
require_once KHASOLAR_DIR . '/inc/import-real-products.php';
require_once KHASOLAR_DIR . '/inc/calculator.php';
require_once KHASOLAR_DIR . '/inc/quick-contact.php';
require_once KHASOLAR_DIR . '/inc/schema-markup.php';
require_once KHASOLAR_DIR . '/inc/product-compare.php';
require_once KHASOLAR_DIR . '/inc/reviews.php';
require_once KHASOLAR_DIR . '/inc/sitemap.php';
require_once KHASOLAR_DIR . '/inc/setup-wizard.php';
require_once KHASOLAR_DIR . '/inc/performance.php';
require_once KHASOLAR_DIR . '/inc/analytics.php';
require_once KHASOLAR_DIR . '/inc/product-gallery.php';
require_once KHASOLAR_DIR . '/inc/cart.php';

/**
 * Theme activation hook
 * Create database tables and flush rewrite rules
 */
function khasolar_activation() {
    // Create database tables
    khasolar_create_leads_table();
    khasolar_create_reviews_table();

    // Flush rewrite rules for custom post types
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'khasolar_activation' );

/**
 * Theme deactivation hook
 */
function khasolar_deactivation() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'khasolar_deactivation' );
