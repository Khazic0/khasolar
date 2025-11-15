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
define( 'KHASOLAR_VERSION', '1.0.0' );
define( 'KHASOLAR_DIR', get_template_directory() );
define( 'KHASOLAR_URI', get_template_directory_uri() );

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

/**
 * Theme activation hook
 * Create database tables and flush rewrite rules
 */
function khasolar_activation() {
    // Create leads database table
    khasolar_create_leads_table();

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
