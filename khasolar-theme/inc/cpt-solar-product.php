<?php
/**
 * Register Solar Product Custom Post Type and Taxonomy
 *
 * @package KhaSolar
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Solar Product Custom Post Type
 */
function khasolar_register_product_cpt() {

    $labels = array(
        'name'                  => _x( 'Sản phẩm Kha Solar', 'Post Type General Name', 'khasolar' ),
        'singular_name'         => _x( 'Sản phẩm', 'Post Type Singular Name', 'khasolar' ),
        'menu_name'             => __( 'Sản phẩm Solar', 'khasolar' ),
        'name_admin_bar'        => __( 'Sản phẩm', 'khasolar' ),
        'archives'              => __( 'Kho sản phẩm', 'khasolar' ),
        'attributes'            => __( 'Thuộc tính sản phẩm', 'khasolar' ),
        'parent_item_colon'     => __( 'Sản phẩm cha:', 'khasolar' ),
        'all_items'             => __( 'Tất cả sản phẩm', 'khasolar' ),
        'add_new_item'          => __( 'Thêm sản phẩm mới', 'khasolar' ),
        'add_new'               => __( 'Thêm mới', 'khasolar' ),
        'new_item'              => __( 'Sản phẩm mới', 'khasolar' ),
        'edit_item'             => __( 'Sửa sản phẩm', 'khasolar' ),
        'update_item'           => __( 'Cập nhật sản phẩm', 'khasolar' ),
        'view_item'             => __( 'Xem sản phẩm', 'khasolar' ),
        'view_items'            => __( 'Xem sản phẩm', 'khasolar' ),
        'search_items'          => __( 'Tìm sản phẩm', 'khasolar' ),
        'not_found'             => __( 'Không tìm thấy', 'khasolar' ),
        'not_found_in_trash'    => __( 'Không tìm thấy trong thùng rác', 'khasolar' ),
        'featured_image'        => __( 'Hình ảnh sản phẩm', 'khasolar' ),
        'set_featured_image'    => __( 'Đặt hình ảnh sản phẩm', 'khasolar' ),
        'remove_featured_image' => __( 'Xóa hình ảnh sản phẩm', 'khasolar' ),
        'use_featured_image'    => __( 'Sử dụng làm hình ảnh sản phẩm', 'khasolar' ),
        'insert_into_item'      => __( 'Chèn vào sản phẩm', 'khasolar' ),
        'uploaded_to_this_item' => __( 'Đã tải lên sản phẩm này', 'khasolar' ),
        'items_list'            => __( 'Danh sách sản phẩm', 'khasolar' ),
        'items_list_navigation' => __( 'Điều hướng danh sách', 'khasolar' ),
        'filter_items_list'     => __( 'Lọc danh sách', 'khasolar' ),
    );

    $args = array(
        'label'                 => __( 'Sản phẩm Solar', 'khasolar' ),
        'description'           => __( 'Sản phẩm năng lượng mặt trời: biến tần, pin, phụ kiện', 'khasolar' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
        'taxonomies'            => array( 'solar_category' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-lightbulb',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'rewrite'               => array( 'slug' => 'san-pham' ),
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type( 'solar_product', $args );
}
add_action( 'init', 'khasolar_register_product_cpt', 0 );

/**
 * Register Solar Category Taxonomy
 */
function khasolar_register_product_taxonomy() {

    $labels = array(
        'name'                       => _x( 'Danh mục sản phẩm', 'Taxonomy General Name', 'khasolar' ),
        'singular_name'              => _x( 'Danh mục', 'Taxonomy Singular Name', 'khasolar' ),
        'menu_name'                  => __( 'Danh mục', 'khasolar' ),
        'all_items'                  => __( 'Tất cả danh mục', 'khasolar' ),
        'parent_item'                => __( 'Danh mục cha', 'khasolar' ),
        'parent_item_colon'          => __( 'Danh mục cha:', 'khasolar' ),
        'new_item_name'              => __( 'Tên danh mục mới', 'khasolar' ),
        'add_new_item'               => __( 'Thêm danh mục mới', 'khasolar' ),
        'edit_item'                  => __( 'Sửa danh mục', 'khasolar' ),
        'update_item'                => __( 'Cập nhật danh mục', 'khasolar' ),
        'view_item'                  => __( 'Xem danh mục', 'khasolar' ),
        'separate_items_with_commas' => __( 'Phân cách bằng dấu phẩy', 'khasolar' ),
        'add_or_remove_items'        => __( 'Thêm hoặc xóa danh mục', 'khasolar' ),
        'choose_from_most_used'      => __( 'Chọn từ danh mục thường dùng', 'khasolar' ),
        'popular_items'              => __( 'Danh mục phổ biến', 'khasolar' ),
        'search_items'               => __( 'Tìm danh mục', 'khasolar' ),
        'not_found'                  => __( 'Không tìm thấy', 'khasolar' ),
        'no_terms'                   => __( 'Chưa có danh mục', 'khasolar' ),
        'items_list'                 => __( 'Danh sách danh mục', 'khasolar' ),
        'items_list_navigation'      => __( 'Điều hướng danh mục', 'khasolar' ),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'rewrite'                    => array( 'slug' => 'danh-muc-solar' ),
        'show_in_rest'               => true,
    );

    register_taxonomy( 'solar_category', array( 'solar_product' ), $args );
}
add_action( 'init', 'khasolar_register_product_taxonomy', 0 );

/**
 * Update messages for solar_product post type
 */
function khasolar_product_updated_messages( $messages ) {
    $post             = get_post();
    $post_type        = get_post_type( $post );
    $post_type_object = get_post_type_object( $post_type );

    $messages['solar_product'] = array(
        0  => '', // Unused. Messages start at index 1.
        1  => __( 'Sản phẩm đã được cập nhật.', 'khasolar' ),
        2  => __( 'Trường tùy chỉnh đã được cập nhật.', 'khasolar' ),
        3  => __( 'Trường tùy chỉnh đã bị xóa.', 'khasolar' ),
        4  => __( 'Sản phẩm đã được cập nhật.', 'khasolar' ),
        5  => isset( $_GET['revision'] ) ? sprintf( __( 'Sản phẩm đã được khôi phục từ bản sửa đổi %s', 'khasolar' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6  => __( 'Sản phẩm đã được xuất bản.', 'khasolar' ),
        7  => __( 'Sản phẩm đã được lưu.', 'khasolar' ),
        8  => __( 'Sản phẩm đã được gửi.', 'khasolar' ),
        9  => sprintf(
            __( 'Sản phẩm đã được lên lịch cho: <strong>%1$s</strong>.', 'khasolar' ),
            date_i18n( __( 'M j, Y @ G:i', 'khasolar' ), strtotime( $post->post_date ) )
        ),
        10 => __( 'Bản nháp sản phẩm đã được cập nhật.', 'khasolar' ),
    );

    if ( $post_type_object->publicly_queryable && 'solar_product' === $post_type ) {
        $permalink = get_permalink( $post->ID );

        $view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'Xem sản phẩm', 'khasolar' ) );
        $messages[ $post_type ][1] .= $view_link;
        $messages[ $post_type ][6] .= $view_link;
        $messages[ $post_type ][9] .= $view_link;

        $preview_permalink = add_query_arg( 'preview', 'true', $permalink );
        $preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Xem trước sản phẩm', 'khasolar' ) );
        $messages[ $post_type ][8]  .= $preview_link;
        $messages[ $post_type ][10] .= $preview_link;
    }

    return $messages;
}
add_filter( 'post_updated_messages', 'khasolar_product_updated_messages' );
