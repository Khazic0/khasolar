<?php
/**
 * Register Solar Project Custom Post Type and Meta
 *
 * @package KhaSolar
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Solar Project Custom Post Type
 */
function khasolar_register_project_cpt() {

    $labels = array(
        'name'                  => _x( 'Dự án Kha Solar', 'Post Type General Name', 'khasolar' ),
        'singular_name'         => _x( 'Dự án', 'Post Type Singular Name', 'khasolar' ),
        'menu_name'             => __( 'Dự án Solar', 'khasolar' ),
        'name_admin_bar'        => __( 'Dự án', 'khasolar' ),
        'archives'              => __( 'Kho dự án', 'khasolar' ),
        'attributes'            => __( 'Thuộc tính dự án', 'khasolar' ),
        'parent_item_colon'     => __( 'Dự án cha:', 'khasolar' ),
        'all_items'             => __( 'Tất cả dự án', 'khasolar' ),
        'add_new_item'          => __( 'Thêm dự án mới', 'khasolar' ),
        'add_new'               => __( 'Thêm mới', 'khasolar' ),
        'new_item'              => __( 'Dự án mới', 'khasolar' ),
        'edit_item'             => __( 'Sửa dự án', 'khasolar' ),
        'update_item'           => __( 'Cập nhật dự án', 'khasolar' ),
        'view_item'             => __( 'Xem dự án', 'khasolar' ),
        'view_items'            => __( 'Xem dự án', 'khasolar' ),
        'search_items'          => __( 'Tìm dự án', 'khasolar' ),
        'not_found'             => __( 'Không tìm thấy', 'khasolar' ),
        'not_found_in_trash'    => __( 'Không tìm thấy trong thùng rác', 'khasolar' ),
        'featured_image'        => __( 'Hình ảnh dự án', 'khasolar' ),
        'set_featured_image'    => __( 'Đặt hình ảnh dự án', 'khasolar' ),
        'remove_featured_image' => __( 'Xóa hình ảnh dự án', 'khasolar' ),
        'use_featured_image'    => __( 'Sử dụng làm hình ảnh dự án', 'khasolar' ),
        'insert_into_item'      => __( 'Chèn vào dự án', 'khasolar' ),
        'uploaded_to_this_item' => __( 'Đã tải lên dự án này', 'khasolar' ),
        'items_list'            => __( 'Danh sách dự án', 'khasolar' ),
        'items_list_navigation' => __( 'Điều hướng danh sách', 'khasolar' ),
        'filter_items_list'     => __( 'Lọc danh sách', 'khasolar' ),
    );

    $args = array(
        'label'                 => __( 'Dự án Solar', 'khasolar' ),
        'description'           => __( 'Dự án điện mặt trời đã triển khai', 'khasolar' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-admin-multisite',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'rewrite'               => array( 'slug' => 'du-an' ),
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type( 'solar_project', $args );
}
add_action( 'init', 'khasolar_register_project_cpt', 0 );

/**
 * Add meta boxes for solar_project
 */
function khasolar_add_project_meta_boxes() {
    add_meta_box(
        'khasolar_project_details',
        __( 'Thông tin dự án', 'khasolar' ),
        'khasolar_project_details_callback',
        'solar_project',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'khasolar_add_project_meta_boxes' );

/**
 * Project Details Meta Box Callback
 */
function khasolar_project_details_callback( $post ) {
    // Add nonce for security
    wp_nonce_field( 'khasolar_save_project_meta', 'khasolar_project_meta_nonce' );

    // Get current values
    $location       = get_post_meta( $post->ID, '_ks_project_location', true );
    $capacity       = get_post_meta( $post->ID, '_ks_project_capacity_kwp', true );
    $type           = get_post_meta( $post->ID, '_ks_project_type', true );
    $inverter       = get_post_meta( $post->ID, '_ks_project_inverter', true );
    $battery        = get_post_meta( $post->ID, '_ks_project_battery', true );
    $completed_date = get_post_meta( $post->ID, '_ks_project_completed_date', true );
    $key_notes      = get_post_meta( $post->ID, '_ks_project_key_notes', true );
    ?>

    <style>
        .khasolar-meta-field { margin-bottom: 15px; }
        .khasolar-meta-field label { display: block; font-weight: 600; margin-bottom: 5px; }
        .khasolar-meta-field input[type="text"],
        .khasolar-meta-field input[type="number"],
        .khasolar-meta-field input[type="date"],
        .khasolar-meta-field select,
        .khasolar-meta-field textarea { width: 100%; max-width: 600px; padding: 8px; }
        .khasolar-meta-row { display: flex; gap: 20px; flex-wrap: wrap; }
        .khasolar-meta-row .khasolar-meta-field { flex: 1; min-width: 250px; }
    </style>

    <div class="khasolar-meta-row">
        <div class="khasolar-meta-field">
            <label for="ks_project_location"><?php _e( 'Địa điểm', 'khasolar' ); ?></label>
            <input type="text" id="ks_project_location" name="ks_project_location" value="<?php echo esc_attr( $location ); ?>" placeholder="VD: Hà Nội, TP. HCM...">
        </div>

        <div class="khasolar-meta-field">
            <label for="ks_project_capacity_kwp"><?php _e( 'Công suất (kWp)', 'khasolar' ); ?></label>
            <input type="number" id="ks_project_capacity_kwp" name="ks_project_capacity_kwp" value="<?php echo esc_attr( $capacity ); ?>" step="0.1" placeholder="VD: 10">
        </div>
    </div>

    <div class="khasolar-meta-row">
        <div class="khasolar-meta-field">
            <label for="ks_project_type"><?php _e( 'Loại dự án', 'khasolar' ); ?></label>
            <select id="ks_project_type" name="ks_project_type">
                <option value=""><?php _e( '-- Chọn loại --', 'khasolar' ); ?></option>
                <option value="Dân dụng" <?php selected( $type, 'Dân dụng' ); ?>><?php _e( 'Dân dụng', 'khasolar' ); ?></option>
                <option value="Thương mại" <?php selected( $type, 'Thương mại' ); ?>><?php _e( 'Thương mại', 'khasolar' ); ?></option>
                <option value="Nông nghiệp" <?php selected( $type, 'Nông nghiệp' ); ?>><?php _e( 'Nông nghiệp', 'khasolar' ); ?></option>
                <option value="Nhà xưởng" <?php selected( $type, 'Nhà xưởng' ); ?>><?php _e( 'Nhà xưởng', 'khasolar' ); ?></option>
                <option value="Khác" <?php selected( $type, 'Khác' ); ?>><?php _e( 'Khác', 'khasolar' ); ?></option>
            </select>
        </div>

        <div class="khasolar-meta-field">
            <label for="ks_project_completed_date"><?php _e( 'Ngày hoàn thành', 'khasolar' ); ?></label>
            <input type="date" id="ks_project_completed_date" name="ks_project_completed_date" value="<?php echo esc_attr( $completed_date ); ?>">
        </div>
    </div>

    <div class="khasolar-meta-row">
        <div class="khasolar-meta-field">
            <label for="ks_project_inverter"><?php _e( 'Biến tần sử dụng', 'khasolar' ); ?></label>
            <input type="text" id="ks_project_inverter" name="ks_project_inverter" value="<?php echo esc_attr( $inverter ); ?>" placeholder="VD: Deye SUN-6K-SG04LP1">
        </div>

        <div class="khasolar-meta-field">
            <label for="ks_project_battery"><?php _e( 'Pin lưu trữ', 'khasolar' ); ?></label>
            <input type="text" id="ks_project_battery" name="ks_project_battery" value="<?php echo esc_attr( $battery ); ?>" placeholder="VD: APESS ES-BOX42 5.2kWh">
        </div>
    </div>

    <div class="khasolar-meta-field">
        <label for="ks_project_key_notes"><?php _e( 'Ghi chú nổi bật', 'khasolar' ); ?></label>
        <textarea id="ks_project_key_notes" name="ks_project_key_notes" rows="5" placeholder="<?php _e( 'Các thông tin đặc biệt về dự án...', 'khasolar' ); ?>"><?php echo esc_textarea( $key_notes ); ?></textarea>
        <p class="description"><?php _e( 'Nhập các ghi chú, điểm đặc biệt hoặc thông tin khác về dự án.', 'khasolar' ); ?></p>
    </div>

    <?php
}

/**
 * Save project meta data
 */
function khasolar_save_project_meta( $post_id ) {

    // Check if nonce is set
    if ( ! isset( $_POST['khasolar_project_meta_nonce'] ) ) {
        return;
    }

    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['khasolar_project_meta_nonce'], 'khasolar_save_project_meta' ) ) {
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
        '_ks_project_location'      => 'sanitize_text_field',
        '_ks_project_capacity_kwp'  => 'floatval',
        '_ks_project_type'          => 'sanitize_text_field',
        '_ks_project_inverter'      => 'sanitize_text_field',
        '_ks_project_battery'       => 'sanitize_text_field',
        '_ks_project_completed_date'=> 'sanitize_text_field',
        '_ks_project_key_notes'     => 'sanitize_textarea_field',
    );

    foreach ( $fields as $meta_key => $sanitize_callback ) {
        $form_key = str_replace( '_ks_project_', 'ks_project_', $meta_key );

        if ( isset( $_POST[ $form_key ] ) ) {
            $value = call_user_func( $sanitize_callback, $_POST[ $form_key ] );
            update_post_meta( $post_id, $meta_key, $value );
        } else {
            delete_post_meta( $post_id, $meta_key );
        }
    }
}
add_action( 'save_post_solar_project', 'khasolar_save_project_meta' );
