<?php
/**
 * Product Comparison System
 *
 * Allows users to compare up to 4 products side-by-side
 *
 * @package KhaSolar
 * @since 1.2.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get compared products from cookie
 */
function khasolar_get_compared_products() {
    if ( isset( $_COOKIE['khasolar_compare'] ) ) {
        $product_ids = json_decode( stripslashes( $_COOKIE['khasolar_compare'] ), true );
        if ( is_array( $product_ids ) ) {
            return array_map( 'absint', $product_ids );
        }
    }
    return array();
}

/**
 * AJAX: Add product to comparison
 */
function khasolar_ajax_add_to_compare() {
    check_ajax_referer( 'khasolar_compare_nonce', 'nonce' );

    $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;

    if ( ! $product_id || get_post_type( $product_id ) !== 'solar_product' ) {
        wp_send_json_error( array( 'message' => __( 'Sản phẩm không hợp lệ.', 'khasolar' ) ) );
    }

    $compared = khasolar_get_compared_products();

    // Check if already in comparison
    if ( in_array( $product_id, $compared, true ) ) {
        wp_send_json_error( array( 'message' => __( 'Sản phẩm đã có trong danh sách so sánh.', 'khasolar' ) ) );
    }

    // Limit to 4 products
    if ( count( $compared ) >= 4 ) {
        wp_send_json_error( array( 'message' => __( 'Chỉ có thể so sánh tối đa 4 sản phẩm.', 'khasolar' ) ) );
    }

    $compared[] = $product_id;

    wp_send_json_success( array(
        'count'   => count( $compared ),
        'message' => __( 'Đã thêm vào danh sách so sánh.', 'khasolar' ),
        'product_ids' => $compared
    ) );
}
add_action( 'wp_ajax_khasolar_add_to_compare', 'khasolar_ajax_add_to_compare' );
add_action( 'wp_ajax_nopriv_khasolar_add_to_compare', 'khasolar_ajax_add_to_compare' );

/**
 * AJAX: Remove product from comparison
 */
function khasolar_ajax_remove_from_compare() {
    check_ajax_referer( 'khasolar_compare_nonce', 'nonce' );

    $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;

    if ( ! $product_id ) {
        wp_send_json_error( array( 'message' => __( 'Sản phẩm không hợp lệ.', 'khasolar' ) ) );
    }

    $compared = khasolar_get_compared_products();
    $compared = array_diff( $compared, array( $product_id ) );
    $compared = array_values( $compared ); // Re-index

    wp_send_json_success( array(
        'count'   => count( $compared ),
        'message' => __( 'Đã xóa khỏi danh sách so sánh.', 'khasolar' ),
        'product_ids' => $compared
    ) );
}
add_action( 'wp_ajax_khasolar_remove_from_compare', 'khasolar_ajax_remove_from_compare' );
add_action( 'wp_ajax_nopriv_khasolar_remove_from_compare', 'khasolar_ajax_remove_from_compare' );

/**
 * AJAX: Clear all compared products
 */
function khasolar_ajax_clear_compare() {
    check_ajax_referer( 'khasolar_compare_nonce', 'nonce' );

    wp_send_json_success( array(
        'count'   => 0,
        'message' => __( 'Đã xóa tất cả sản phẩm so sánh.', 'khasolar' ),
        'product_ids' => array()
    ) );
}
add_action( 'wp_ajax_khasolar_clear_compare', 'khasolar_ajax_clear_compare' );
add_action( 'wp_ajax_nopriv_khasolar_clear_compare', 'khasolar_ajax_clear_compare' );

/**
 * AJAX: Get comparison data
 */
function khasolar_ajax_get_compare_data() {
    check_ajax_referer( 'khasolar_compare_nonce', 'nonce' );

    $product_ids = isset( $_POST['product_ids'] ) ? array_map( 'absint', $_POST['product_ids'] ) : array();

    if ( empty( $product_ids ) ) {
        wp_send_json_error( array( 'message' => __( 'Không có sản phẩm nào để so sánh.', 'khasolar' ) ) );
    }

    $products = array();

    foreach ( $product_ids as $product_id ) {
        $product = get_post( $product_id );

        if ( ! $product || $product->post_type !== 'solar_product' ) {
            continue;
        }

        $products[] = array(
            'id'    => $product_id,
            'title' => get_the_title( $product_id ),
            'url'   => get_permalink( $product_id ),
            'image' => get_the_post_thumbnail_url( $product_id, 'product-thumb' ),
        );
    }

    wp_send_json_success( array(
        'products' => $products
    ) );
}
add_action( 'wp_ajax_khasolar_get_compare_data', 'khasolar_ajax_get_compare_data' );
add_action( 'wp_ajax_nopriv_khasolar_get_compare_data', 'khasolar_ajax_get_compare_data' );

/**
 * Enqueue comparison scripts
 */
function khasolar_enqueue_compare_scripts() {
    wp_enqueue_script(
        'khasolar-compare',
        KHASOLAR_URI . '/assets/js/compare.js',
        array( 'jquery' ),
        KHASOLAR_VERSION,
        true
    );

    wp_localize_script( 'khasolar-compare', 'khasolarCompare', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'khasolar_compare_nonce' ),
        'compare_url' => home_url( '/so-sanh-san-pham/' ),
        'strings'  => array(
            'add_to_compare'    => __( 'So sánh', 'khasolar' ),
            'remove_from_compare' => __( 'Bỏ so sánh', 'khasolar' ),
            'max_products'      => __( 'Chỉ có thể so sánh tối đa 4 sản phẩm.', 'khasolar' ),
            'min_products'      => __( 'Vui lòng chọn ít nhất 2 sản phẩm để so sánh.', 'khasolar' ),
            'added'             => __( 'Đã thêm vào danh sách so sánh', 'khasolar' ),
            'removed'           => __( 'Đã xóa khỏi danh sách so sánh', 'khasolar' ),
        )
    ) );
}
add_action( 'wp_enqueue_scripts', 'khasolar_enqueue_compare_scripts' );

/**
 * Output floating compare bar
 */
function khasolar_floating_compare_bar() {
    get_template_part( 'template-parts/product/compare-bar' );
}
add_action( 'wp_footer', 'khasolar_floating_compare_bar' );

/**
 * Check if product is in comparison
 */
function khasolar_is_product_in_compare( $product_id ) {
    $compared = khasolar_get_compared_products();
    return in_array( absint( $product_id ), $compared, true );
}

/**
 * Get product specs for comparison
 */
function khasolar_get_product_specs_array( $product_id ) {
    return array(
        'brand'       => get_post_meta( $product_id, '_ks_brand', true ),
        'model'       => get_post_meta( $product_id, '_ks_model', true ),
        'power_kw'    => get_post_meta( $product_id, '_ks_power_kw', true ),
        'phase'       => get_post_meta( $product_id, '_ks_phase', true ),
        'voltage'     => get_post_meta( $product_id, '_ks_voltage', true ),
        'warranty'    => get_post_meta( $product_id, '_ks_warranty_years', true ),
        'origin'      => get_post_meta( $product_id, '_ks_origin', true ),
        'price_from'  => get_post_meta( $product_id, '_ks_price_from', true ),
        'stock_status' => get_post_meta( $product_id, '_ks_stock_status', true ),
    );
}
