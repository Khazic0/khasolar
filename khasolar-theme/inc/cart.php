<?php
/**
 * Shopping Cart Functionality
 *
 * @package KhaSolar
 * @since 1.3.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Initialize cart session
 */
function khasolar_init_cart() {
    if ( ! session_id() && ! headers_sent() ) {
        session_start();
    }

    if ( ! isset( $_SESSION['khasolar_cart'] ) ) {
        $_SESSION['khasolar_cart'] = array();
    }
}
add_action( 'init', 'khasolar_init_cart' );

/**
 * Get cart contents
 */
function khasolar_get_cart() {
    if ( ! isset( $_SESSION['khasolar_cart'] ) ) {
        return array();
    }
    return $_SESSION['khasolar_cart'];
}

/**
 * Get cart count
 */
function khasolar_get_cart_count() {
    $cart = khasolar_get_cart();
    $count = 0;

    foreach ( $cart as $item ) {
        $count += isset( $item['quantity'] ) ? intval( $item['quantity'] ) : 1;
    }

    return $count;
}

/**
 * Add product to cart
 */
function khasolar_add_to_cart( $product_id, $quantity = 1 ) {
    // Validate product
    if ( ! $product_id || get_post_type( $product_id ) !== 'solar_product' ) {
        return false;
    }

    $cart = khasolar_get_cart();

    // Check if product already in cart
    if ( isset( $cart[ $product_id ] ) ) {
        $cart[ $product_id ]['quantity'] += $quantity;
    } else {
        $cart[ $product_id ] = array(
            'product_id' => $product_id,
            'quantity'   => $quantity,
            'added_time' => time(),
        );
    }

    $_SESSION['khasolar_cart'] = $cart;
    return true;
}

/**
 * Remove product from cart
 */
function khasolar_remove_from_cart( $product_id ) {
    $cart = khasolar_get_cart();

    if ( isset( $cart[ $product_id ] ) ) {
        unset( $cart[ $product_id ] );
        $_SESSION['khasolar_cart'] = $cart;
        return true;
    }

    return false;
}

/**
 * Update cart item quantity
 */
function khasolar_update_cart_quantity( $product_id, $quantity ) {
    $cart = khasolar_get_cart();

    if ( isset( $cart[ $product_id ] ) ) {
        if ( $quantity <= 0 ) {
            unset( $cart[ $product_id ] );
        } else {
            $cart[ $product_id ]['quantity'] = $quantity;
        }
        $_SESSION['khasolar_cart'] = $cart;
        return true;
    }

    return false;
}

/**
 * Clear cart
 */
function khasolar_clear_cart() {
    $_SESSION['khasolar_cart'] = array();
}

/**
 * Get cart items with product details
 */
function khasolar_get_cart_items() {
    $cart = khasolar_get_cart();
    $items = array();

    foreach ( $cart as $product_id => $cart_item ) {
        $product = get_post( $product_id );

        if ( ! $product || $product->post_status !== 'publish' ) {
            continue;
        }

        $brand    = get_post_meta( $product_id, '_ks_brand', true );
        $model    = get_post_meta( $product_id, '_ks_model', true );
        $power_kw = get_post_meta( $product_id, '_ks_power_kw', true );
        $price    = get_post_meta( $product_id, '_ks_price_from', true );

        $items[ $product_id ] = array(
            'product_id' => $product_id,
            'title'      => $product->post_title,
            'brand'      => $brand,
            'model'      => $model,
            'power_kw'   => $power_kw,
            'price'      => $price,
            'quantity'   => $cart_item['quantity'],
            'permalink'  => get_permalink( $product_id ),
            'thumbnail'  => get_the_post_thumbnail_url( $product_id, 'thumbnail' ),
        );
    }

    return $items;
}

/**
 * AJAX: Add to cart
 */
function khasolar_ajax_add_to_cart() {
    check_ajax_referer( 'khasolar_nonce', 'nonce' );

    $product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;
    $quantity   = isset( $_POST['quantity'] ) ? intval( $_POST['quantity'] ) : 1;

    if ( ! $product_id ) {
        wp_send_json_error( array( 'message' => __( 'Sản phẩm không hợp lệ', 'khasolar' ) ) );
    }

    if ( khasolar_add_to_cart( $product_id, $quantity ) ) {
        $cart_count = khasolar_get_cart_count();

        wp_send_json_success( array(
            'message'    => __( 'Đã thêm vào giỏ hàng', 'khasolar' ),
            'cart_count' => $cart_count,
        ) );
    } else {
        wp_send_json_error( array( 'message' => __( 'Không thể thêm vào giỏ hàng', 'khasolar' ) ) );
    }
}
add_action( 'wp_ajax_khasolar_add_to_cart', 'khasolar_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_khasolar_add_to_cart', 'khasolar_ajax_add_to_cart' );

/**
 * AJAX: Remove from cart
 */
function khasolar_ajax_remove_from_cart() {
    check_ajax_referer( 'khasolar_nonce', 'nonce' );

    $product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;

    if ( ! $product_id ) {
        wp_send_json_error( array( 'message' => __( 'Sản phẩm không hợp lệ', 'khasolar' ) ) );
    }

    if ( khasolar_remove_from_cart( $product_id ) ) {
        $cart_count = khasolar_get_cart_count();

        wp_send_json_success( array(
            'message'    => __( 'Đã xóa khỏi giỏ hàng', 'khasolar' ),
            'cart_count' => $cart_count,
        ) );
    } else {
        wp_send_json_error( array( 'message' => __( 'Không thể xóa khỏi giỏ hàng', 'khasolar' ) ) );
    }
}
add_action( 'wp_ajax_khasolar_remove_from_cart', 'khasolar_ajax_remove_from_cart' );
add_action( 'wp_ajax_nopriv_khasolar_remove_from_cart', 'khasolar_ajax_remove_from_cart' );

/**
 * AJAX: Update cart quantity
 */
function khasolar_ajax_update_cart_quantity() {
    check_ajax_referer( 'khasolar_nonce', 'nonce' );

    $product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;
    $quantity   = isset( $_POST['quantity'] ) ? intval( $_POST['quantity'] ) : 0;

    if ( ! $product_id ) {
        wp_send_json_error( array( 'message' => __( 'Sản phẩm không hợp lệ', 'khasolar' ) ) );
    }

    if ( khasolar_update_cart_quantity( $product_id, $quantity ) ) {
        $cart_count = khasolar_get_cart_count();

        wp_send_json_success( array(
            'message'    => __( 'Đã cập nhật giỏ hàng', 'khasolar' ),
            'cart_count' => $cart_count,
        ) );
    } else {
        wp_send_json_error( array( 'message' => __( 'Không thể cập nhật giỏ hàng', 'khasolar' ) ) );
    }
}
add_action( 'wp_ajax_khasolar_update_cart_quantity', 'khasolar_ajax_update_cart_quantity' );
add_action( 'wp_ajax_nopriv_khasolar_update_cart_quantity', 'khasolar_ajax_update_cart_quantity' );

/**
 * AJAX: Clear cart
 */
function khasolar_ajax_clear_cart() {
    check_ajax_referer( 'khasolar_nonce', 'nonce' );

    khasolar_clear_cart();

    wp_send_json_success( array(
        'message'    => __( 'Đã xóa toàn bộ giỏ hàng', 'khasolar' ),
        'cart_count' => 0,
    ) );
}
add_action( 'wp_ajax_khasolar_clear_cart', 'khasolar_ajax_clear_cart' );
add_action( 'wp_ajax_nopriv_khasolar_clear_cart', 'khasolar_ajax_clear_cart' );

/**
 * Generate Zalo message for product
 */
function khasolar_get_zalo_message( $product_id ) {
    $product  = get_post( $product_id );
    $brand    = get_post_meta( $product_id, '_ks_brand', true );
    $model    = get_post_meta( $product_id, '_ks_model', true );
    $power_kw = get_post_meta( $product_id, '_ks_power_kw', true );
    $price    = get_post_meta( $product_id, '_ks_price_from', true );

    $message = "Xin chào! Tôi muốn mua sản phẩm:\n\n";
    $message .= "📦 " . $product->post_title . "\n";

    if ( $brand ) {
        $message .= "🏢 Thương hiệu: " . $brand . "\n";
    }

    if ( $model ) {
        $message .= "📋 Model: " . $model . "\n";
    }

    if ( $power_kw ) {
        $message .= "⚡ Công suất: " . $power_kw . " kW\n";
    }

    if ( $price && $price > 0 ) {
        $message .= "💰 Giá: " . khasolar_format_price( $price ) . "\n";
    }

    $message .= "\n🔗 " . get_permalink( $product_id );

    return urlencode( $message );
}

/**
 * Generate Zalo link for single product
 */
function khasolar_get_zalo_buy_link( $product_id ) {
    $zalo_number = get_theme_mod( 'khasolar_zalo_number', '0987654321' );
    $zalo_number = preg_replace( '/[^0-9]/', '', $zalo_number );

    // Convert to international format
    if ( substr( $zalo_number, 0, 1 ) === '0' ) {
        $zalo_number = '84' . substr( $zalo_number, 1 );
    }

    $message = khasolar_get_zalo_message( $product_id );

    return "https://zalo.me/" . $zalo_number . "?text=" . $message;
}

/**
 * Generate Zalo message for cart
 */
function khasolar_get_cart_zalo_message() {
    $cart_items = khasolar_get_cart_items();

    if ( empty( $cart_items ) ) {
        return '';
    }

    $message = "Xin chào! Tôi muốn đặt hàng:\n\n";

    $index = 1;
    foreach ( $cart_items as $item ) {
        $message .= $index . ". " . $item['title'];

        if ( $item['brand'] ) {
            $message .= " (" . $item['brand'] . ")";
        }

        $message .= "\n   Số lượng: " . $item['quantity'];

        if ( $item['power_kw'] ) {
            $message .= " | Công suất: " . $item['power_kw'] . " kW";
        }

        $message .= "\n\n";
        $index++;
    }

    $message .= "Vui lòng báo giá và tư vấn cho tôi. Cảm ơn!";

    return urlencode( $message );
}

/**
 * Generate Zalo link for cart
 */
function khasolar_get_cart_zalo_link() {
    $zalo_number = get_theme_mod( 'khasolar_zalo_number', '0987654321' );
    $zalo_number = preg_replace( '/[^0-9]/', '', $zalo_number );

    // Convert to international format
    if ( substr( $zalo_number, 0, 1 ) === '0' ) {
        $zalo_number = '84' . substr( $zalo_number, 1 );
    }

    $message = khasolar_get_cart_zalo_message();

    return "https://zalo.me/" . $zalo_number . "?text=" . $message;
}
