<?php
/**
 * Solar Product Meta Boxes
 *
 * @package KhaSolar
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add meta boxes for solar_product
 */
function khasolar_add_product_meta_boxes() {
    add_meta_box(
        'khasolar_product_details',
        __( 'Thông tin sản phẩm', 'khasolar' ),
        'khasolar_product_details_callback',
        'solar_product',
        'normal',
        'high'
    );

    add_meta_box(
        'khasolar_product_specs',
        __( 'Thông số kỹ thuật', 'khasolar' ),
        'khasolar_product_specs_callback',
        'solar_product',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'khasolar_add_product_meta_boxes' );

/**
 * Product Details Meta Box Callback
 */
function khasolar_product_details_callback( $post ) {
    // Add nonce for security
    wp_nonce_field( 'khasolar_save_product_meta', 'khasolar_product_meta_nonce' );

    // Get current values
    $brand         = get_post_meta( $post->ID, '_ks_brand', true );
    $model         = get_post_meta( $post->ID, '_ks_model', true );
    $power_kw      = get_post_meta( $post->ID, '_ks_power_kw', true );
    $phase         = get_post_meta( $post->ID, '_ks_phase', true );
    $voltage       = get_post_meta( $post->ID, '_ks_voltage', true );
    $warranty      = get_post_meta( $post->ID, '_ks_warranty_years', true );
    $origin        = get_post_meta( $post->ID, '_ks_origin', true );
    $price_from    = get_post_meta( $post->ID, '_ks_price_from', true ); // Backward compatibility
    $regular_price = get_post_meta( $post->ID, '_ks_regular_price', true );
    $sale_price    = get_post_meta( $post->ID, '_ks_sale_price', true );
    $stock_status  = get_post_meta( $post->ID, '_ks_stock_status', true );

    // If regular price not set but price_from is, use price_from as regular price
    if ( empty( $regular_price ) && ! empty( $price_from ) ) {
        $regular_price = $price_from;
    }
    ?>

    <style>
        .khasolar-meta-field { margin-bottom: 15px; }
        .khasolar-meta-field label { display: block; font-weight: 600; margin-bottom: 5px; }
        .khasolar-meta-field input[type="text"],
        .khasolar-meta-field input[type="number"],
        .khasolar-meta-field select { width: 100%; max-width: 400px; padding: 8px; }
        .khasolar-meta-row { display: flex; gap: 20px; flex-wrap: wrap; }
        .khasolar-meta-row .khasolar-meta-field { flex: 1; min-width: 250px; }
    </style>

    <div class="khasolar-meta-row">
        <div class="khasolar-meta-field">
            <label for="ks_brand"><?php _e( 'Thương hiệu', 'khasolar' ); ?></label>
            <input type="text" id="ks_brand" name="ks_brand" value="<?php echo esc_attr( $brand ); ?>" placeholder="VD: Deye, APESS, LumenTree...">
        </div>

        <div class="khasolar-meta-field">
            <label for="ks_model"><?php _e( 'Model', 'khasolar' ); ?></label>
            <input type="text" id="ks_model" name="ks_model" value="<?php echo esc_attr( $model ); ?>" placeholder="VD: SUN-6K-SG04LP1-EU-SM2">
        </div>
    </div>

    <div class="khasolar-meta-row">
        <div class="khasolar-meta-field">
            <label for="ks_power_kw"><?php _e( 'Công suất (kW / kWp)', 'khasolar' ); ?></label>
            <input type="number" id="ks_power_kw" name="ks_power_kw" value="<?php echo esc_attr( $power_kw ); ?>" step="0.1" placeholder="VD: 6">
        </div>

        <div class="khasolar-meta-field">
            <label for="ks_phase"><?php _e( 'Pha', 'khasolar' ); ?></label>
            <select id="ks_phase" name="ks_phase">
                <option value=""><?php _e( '-- Chọn --', 'khasolar' ); ?></option>
                <option value="1 pha" <?php selected( $phase, '1 pha' ); ?>><?php _e( '1 pha', 'khasolar' ); ?></option>
                <option value="3 pha" <?php selected( $phase, '3 pha' ); ?>><?php _e( '3 pha', 'khasolar' ); ?></option>
            </select>
        </div>
    </div>

    <div class="khasolar-meta-row">
        <div class="khasolar-meta-field">
            <label for="ks_voltage"><?php _e( 'Điện áp', 'khasolar' ); ?></label>
            <input type="text" id="ks_voltage" name="ks_voltage" value="<?php echo esc_attr( $voltage ); ?>" placeholder="VD: 220V / 380V">
        </div>

        <div class="khasolar-meta-field">
            <label for="ks_warranty_years"><?php _e( 'Bảo hành (năm)', 'khasolar' ); ?></label>
            <input type="number" id="ks_warranty_years" name="ks_warranty_years" value="<?php echo esc_attr( $warranty ); ?>" min="0" placeholder="VD: 5">
        </div>
    </div>

    <div class="khasolar-meta-row">
        <div class="khasolar-meta-field">
            <label for="ks_origin"><?php _e( 'Xuất xứ', 'khasolar' ); ?></label>
            <input type="text" id="ks_origin" name="ks_origin" value="<?php echo esc_attr( $origin ); ?>" placeholder="VD: Trung Quốc, Đức, Việt Nam...">
        </div>

        <div class="khasolar-meta-field">
            <label for="ks_stock_status"><?php _e( 'Tình trạng kho', 'khasolar' ); ?></label>
            <select id="ks_stock_status" name="ks_stock_status">
                <option value="in_stock" <?php selected( $stock_status, 'in_stock' ); ?>><?php _e( 'Còn hàng', 'khasolar' ); ?></option>
                <option value="low_stock" <?php selected( $stock_status, 'low_stock' ); ?>><?php _e( 'Sắp hết', 'khasolar' ); ?></option>
                <option value="out_of_stock" <?php selected( $stock_status, 'out_of_stock' ); ?>><?php _e( 'Hết hàng', 'khasolar' ); ?></option>
                <option value="pre_order" <?php selected( $stock_status, 'pre_order' ); ?>><?php _e( 'Đặt trước', 'khasolar' ); ?></option>
            </select>
        </div>
    </div>

    <div class="khasolar-meta-row">
        <div class="khasolar-meta-field">
            <label for="ks_regular_price"><?php _e( 'Giá gốc (VNĐ)', 'khasolar' ); ?></label>
            <input type="number" id="ks_regular_price" name="ks_regular_price" value="<?php echo esc_attr( $regular_price ); ?>" min="0" placeholder="VD: 20000000">
            <p class="description"><?php _e( 'Giá niêm yết chính thức của sản phẩm', 'khasolar' ); ?></p>
        </div>

        <div class="khasolar-meta-field">
            <label for="ks_sale_price"><?php _e( 'Giá khuyến mãi (VNĐ)', 'khasolar' ); ?></label>
            <input type="number" id="ks_sale_price" name="ks_sale_price" value="<?php echo esc_attr( $sale_price ); ?>" min="0" placeholder="VD: 15000000">
            <p class="description"><?php _e( 'Để trống nếu không có khuyến mãi. Giá khuyến mãi phải nhỏ hơn giá gốc.', 'khasolar' ); ?></p>
        </div>
    </div>

    <?php
}

/**
 * Product Specs Meta Box Callback
 */
function khasolar_product_specs_callback( $post ) {
    $key_specs = get_post_meta( $post->ID, '_ks_key_specs', true );
    ?>

    <div class="khasolar-meta-field">
        <label for="ks_key_specs"><?php _e( 'Thông số kỹ thuật nổi bật (mỗi dòng 1 thông số)', 'khasolar' ); ?></label>
        <textarea id="ks_key_specs" name="ks_key_specs" rows="10" style="width: 100%;" placeholder="<?php _e( 'VD:\nCông suất AC danh định: 6000W\nĐiện áp vào DC: 180~550V\nHiệu suất tối đa: 97.8%\nBảo vệ chống sét DC&AC\nKết nối WiFi/LAN', 'khasolar' ); ?>"><?php echo esc_textarea( $key_specs ); ?></textarea>
        <p class="description"><?php _e( 'Nhập mỗi dòng một thông số kỹ thuật. Các thông số này sẽ hiển thị dưới dạng bảng trong trang chi tiết sản phẩm.', 'khasolar' ); ?></p>
    </div>

    <?php
}

/**
 * Save product meta data
 */
function khasolar_save_product_meta( $post_id ) {

    // Check if nonce is set
    if ( ! isset( $_POST['khasolar_product_meta_nonce'] ) ) {
        return;
    }

    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['khasolar_product_meta_nonce'], 'khasolar_save_product_meta' ) ) {
        return;
    }

    // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Sanitize and save fields
    $fields = array(
        '_ks_brand'           => 'sanitize_text_field',
        '_ks_model'           => 'sanitize_text_field',
        '_ks_power_kw'        => 'floatval',
        '_ks_phase'           => 'sanitize_text_field',
        '_ks_voltage'         => 'sanitize_text_field',
        '_ks_warranty_years'  => 'absint',
        '_ks_origin'          => 'sanitize_text_field',
        '_ks_price_from'      => 'absint',
        '_ks_regular_price'   => 'absint',
        '_ks_sale_price'      => 'absint',
        '_ks_stock_status'    => 'sanitize_text_field',
        '_ks_key_specs'       => 'sanitize_textarea_field',
    );

    // Sync price_from with regular_price for backward compatibility
    if ( isset( $_POST['ks_regular_price'] ) ) {
        $regular_price = absint( $_POST['ks_regular_price'] );
        update_post_meta( $post_id, '_ks_price_from', $regular_price );
    }

    foreach ( $fields as $meta_key => $sanitize_callback ) {
        $form_key = str_replace( '_ks_', 'ks_', $meta_key );

        if ( isset( $_POST[ $form_key ] ) ) {
            $value = call_user_func( $sanitize_callback, $_POST[ $form_key ] );
            update_post_meta( $post_id, $meta_key, $value );
        } else {
            delete_post_meta( $post_id, $meta_key );
        }
    }
}
add_action( 'save_post_solar_product', 'khasolar_save_product_meta' );

/**
 * Get formatted price
 */
function khasolar_get_formatted_price( $price ) {
    if ( empty( $price ) ) {
        return '';
    }
    return number_format( $price, 0, ',', '.' ) . ' ₫';
}

/**
 * Get stock status label
 */
function khasolar_get_stock_status_label( $status ) {
    $labels = array(
        'in_stock'      => __( 'Còn hàng', 'khasolar' ),
        'low_stock'     => __( 'Sắp hết', 'khasolar' ),
        'out_of_stock'  => __( 'Hết hàng', 'khasolar' ),
        'pre_order'     => __( 'Đặt trước', 'khasolar' ),
    );

    return isset( $labels[ $status ] ) ? $labels[ $status ] : $labels['in_stock'];
}

/**
 * Get product price data (regular price, sale price, discount %)
 */
function khasolar_get_product_price_data( $product_id ) {
    $regular_price = get_post_meta( $product_id, '_ks_regular_price', true );
    $sale_price    = get_post_meta( $product_id, '_ks_sale_price', true );

    // Backward compatibility: use price_from if regular_price not set
    if ( empty( $regular_price ) ) {
        $regular_price = get_post_meta( $product_id, '_ks_price_from', true );
    }

    $data = array(
        'regular_price' => $regular_price,
        'sale_price'    => $sale_price,
        'has_sale'      => false,
        'discount_percent' => 0,
        'final_price'   => $regular_price,
    );

    // Check if there's a valid sale
    if ( ! empty( $sale_price ) && ! empty( $regular_price ) && $sale_price < $regular_price ) {
        $data['has_sale'] = true;
        $data['discount_percent'] = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
        $data['final_price'] = $sale_price;
    }

    return $data;
}

/**
 * Display product price HTML
 */
function khasolar_display_product_price( $product_id ) {
    $price_data = khasolar_get_product_price_data( $product_id );

    if ( empty( $price_data['regular_price'] ) ) {
        echo '<span class="price-contact">' . __( 'Liên hệ', 'khasolar' ) . '</span>';
        return;
    }

    if ( $price_data['has_sale'] ) {
        echo '<div class="product-price-wrapper">';
        echo '<span class="price-regular">' . khasolar_format_price( $price_data['regular_price'] ) . '</span>';
        echo '<span class="price-sale">' . khasolar_format_price( $price_data['sale_price'] ) . '</span>';
        if ( $price_data['discount_percent'] > 0 ) {
            echo '<span class="price-discount">-' . $price_data['discount_percent'] . '%</span>';
        }
        echo '</div>';
    } else {
        echo '<span class="price-value">' . khasolar_format_price( $price_data['regular_price'] ) . '</span>';
    }
}

/**
 * Get stock status class for styling
 */
function khasolar_get_stock_status_class( $status ) {
    $classes = array(
        'in_stock'      => 'stock-available',
        'low_stock'     => 'stock-low',
        'out_of_stock'  => 'stock-out',
        'pre_order'     => 'stock-preorder',
    );

    return isset( $classes[ $status ] ) ? $classes[ $status ] : $classes['in_stock'];
}
