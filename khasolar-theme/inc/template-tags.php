<?php
/**
 * Template Tags - Helper Functions
 *
 * @package KhaSolar
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Display breadcrumb navigation
 */
function khasolar_breadcrumb() {
    if ( is_front_page() ) {
        return;
    }

    echo '<div class="breadcrumb">';
    echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Trang chủ', 'khasolar' ) . '</a>';
    echo ' <span class="separator">/</span> ';

    if ( is_singular( 'solar_product' ) ) {
        echo '<a href="' . esc_url( get_post_type_archive_link( 'solar_product' ) ) . '">' . __( 'Sản phẩm', 'khasolar' ) . '</a>';
        echo ' <span class="separator">/</span> ';
        echo '<span class="current">' . get_the_title() . '</span>';
    } elseif ( is_post_type_archive( 'solar_product' ) || is_tax( 'solar_category' ) ) {
        echo '<span class="current">' . __( 'Sản phẩm', 'khasolar' ) . '</span>';
    } elseif ( is_singular( 'solar_project' ) ) {
        echo '<a href="' . esc_url( get_post_type_archive_link( 'solar_project' ) ) . '">' . __( 'Dự án', 'khasolar' ) . '</a>';
        echo ' <span class="separator">/</span> ';
        echo '<span class="current">' . get_the_title() . '</span>';
    } elseif ( is_post_type_archive( 'solar_project' ) ) {
        echo '<span class="current">' . __( 'Dự án', 'khasolar' ) . '</span>';
    } elseif ( is_singular( 'post' ) ) {
        echo '<a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">' . __( 'Blog', 'khasolar' ) . '</a>';
        echo ' <span class="separator">/</span> ';
        echo '<span class="current">' . get_the_title() . '</span>';
    } elseif ( is_page() ) {
        echo '<span class="current">' . get_the_title() . '</span>';
    } elseif ( is_search() ) {
        echo '<span class="current">' . __( 'Kết quả tìm kiếm', 'khasolar' ) . '</span>';
    } elseif ( is_404() ) {
        echo '<span class="current">' . __( 'Không tìm thấy', 'khasolar' ) . '</span>';
    } else {
        echo '<span class="current">' . get_the_title() . '</span>';
    }

    echo '</div>';
}

/**
 * Display pagination for archive pages
 */
function khasolar_pagination() {
    if ( is_singular() ) {
        return;
    }

    global $wp_query;

    if ( $wp_query->max_num_pages <= 1 ) {
        return;
    }

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    if ( $paged >= 1 ) {
        $links = array();
    }

    if ( $max > 1 ) {
        echo '<nav class="pagination">';
    }

    // Previous link
    if ( $paged > 1 ) {
        echo '<a href="' . esc_url( get_pagenum_link( $paged - 1 ) ) . '" class="pagination-prev">' . __( '« Trước', 'khasolar' ) . '</a>';
    }

    // Page numbers
    for ( $i = 1; $i <= $max; $i++ ) {
        if ( $i === $paged ) {
            echo '<span class="pagination-current">' . $i . '</span>';
        } else {
            echo '<a href="' . esc_url( get_pagenum_link( $i ) ) . '" class="pagination-number">' . $i . '</a>';
        }
    }

    // Next link
    if ( $paged < $max ) {
        echo '<a href="' . esc_url( get_pagenum_link( $paged + 1 ) ) . '" class="pagination-next">' . __( 'Tiếp »', 'khasolar' ) . '</a>';
    }

    if ( $max > 1 ) {
        echo '</nav>';
    }
}

/**
 * Get product meta value
 */
function khasolar_get_product_meta( $post_id, $key, $default = '' ) {
    $value = get_post_meta( $post_id, '_ks_' . $key, true );
    return ! empty( $value ) ? $value : $default;
}

/**
 * Get project meta value
 */
function khasolar_get_project_meta( $post_id, $key, $default = '' ) {
    $value = get_post_meta( $post_id, '_ks_project_' . $key, true );
    return ! empty( $value ) ? $value : $default;
}

/**
 * Display posted date
 */
function khasolar_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

    $time_string = sprintf(
        $time_string,
        esc_attr( get_the_date( DATE_W3C ) ),
        esc_html( get_the_date() )
    );

    echo '<span class="posted-on">' . $time_string . '</span>';
}

/**
 * Display posted by author
 */
function khasolar_posted_by() {
    echo '<span class="posted-by">' .
        __( 'bởi', 'khasolar' ) . ' ' .
        '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' .
        esc_html( get_the_author() ) .
        '</a></span>';
}

/**
 * Get phone number for display
 */
function khasolar_get_phone() {
    return apply_filters( 'khasolar_phone_number', '0123 456 789' );
}

/**
 * Get email for display
 */
function khasolar_get_email() {
    return apply_filters( 'khasolar_email', 'contact@khasolar.vn' );
}

/**
 * Get address for display
 */
function khasolar_get_address() {
    return apply_filters( 'khasolar_address', 'Hà Nội, Việt Nam' );
}

/**
 * Get working hours
 */
function khasolar_get_working_hours() {
    return apply_filters( 'khasolar_working_hours', 'T2–T7: 8:00–18:00' );
}

/**
 * Display social media links
 */
function khasolar_social_links() {
    $social_links = array(
        'facebook'  => '#',
        'zalo'      => '#',
        'youtube'   => '#',
    );

    $social_links = apply_filters( 'khasolar_social_links', $social_links );

    if ( empty( $social_links ) ) {
        return;
    }

    echo '<div class="social-links">';

    foreach ( $social_links as $network => $url ) {
        if ( ! empty( $url ) && $url !== '#' ) {
            echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener" class="social-link social-' . esc_attr( $network ) . '">';
            echo '<span class="screen-reader-text">' . ucfirst( $network ) . '</span>';
            echo '</a>';
        }
    }

    echo '</div>';
}

/**
 * Truncate text to a certain number of words
 */
function khasolar_truncate_text( $text, $limit = 20, $append = '...' ) {
    $text = wp_strip_all_tags( $text );
    $words = explode( ' ', $text );

    if ( count( $words ) > $limit ) {
        $words = array_slice( $words, 0, $limit );
        $text = implode( ' ', $words ) . $append;
    }

    return $text;
}

/**
 * Get default placeholder image URL
 */
function khasolar_get_placeholder_image() {
    return apply_filters( 'khasolar_placeholder_image', 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400"%3E%3Crect width="400" height="400" fill="%23f5f5f7"/%3E%3Ctext x="50%25" y="50%25" dominant-baseline="middle" text-anchor="middle" font-family="sans-serif" font-size="24" fill="%23999"%3EKha Solar%3C/text%3E%3C/svg%3E' );
}

/**
 * Format Vietnamese currency
 */
function khasolar_format_price( $price ) {
    if ( empty( $price ) || $price <= 0 ) {
        return __( 'Liên hệ', 'khasolar' );
    }
    return number_format( $price, 0, ',', '.' ) . ' ₫';
}
