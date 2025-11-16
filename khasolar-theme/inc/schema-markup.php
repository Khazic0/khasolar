<?php
/**
 * Schema Markup for SEO
 *
 * Adds structured data for better search engine visibility
 *
 * @package KhaSolar
 * @since 1.2.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Output Organization Schema
 */
function khasolar_organization_schema() {
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'Kha Solar',
        'url' => home_url(),
        'logo' => get_template_directory_uri() . '/assets/images/logo.png',
        'description' => __( 'Nhà cung cấp giải pháp năng lượng mặt trời hàng đầu tại Việt Nam', 'khasolar' ),
        'contactPoint' => array(
            '@type' => 'ContactPoint',
            'telephone' => khasolar_get_phone(),
            'contactType' => 'Customer Service',
            'areaServed' => 'VN',
            'availableLanguage' => 'Vietnamese'
        ),
        'sameAs' => array(
            'https://facebook.com/khasolar',
            'https://zalo.me/khasolar',
        )
    );

    return json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
}

/**
 * Output LocalBusiness Schema
 */
function khasolar_local_business_schema() {
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => 'Kha Solar',
        'image' => get_template_directory_uri() . '/assets/images/logo.png',
        'url' => home_url(),
        'telephone' => khasolar_get_phone(),
        'email' => khasolar_get_email(),
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => khasolar_get_address(),
            'addressLocality' => 'Hồ Chí Minh',
            'addressCountry' => 'VN'
        ),
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => '10.762622',
            'longitude' => '106.660172'
        ),
        'openingHoursSpecification' => array(
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => array(
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday'
            ),
            'opens' => '08:00',
            'closes' => '18:00'
        ),
        'priceRange' => '$$'
    );

    return json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
}

/**
 * Output Product Schema for single product pages
 */
function khasolar_product_schema() {
    if ( ! is_singular( 'solar_product' ) ) {
        return '';
    }

    global $post;

    // Get product meta
    $brand = get_post_meta( $post->ID, '_ks_brand', true );
    $model = get_post_meta( $post->ID, '_ks_model', true );
    $power_kw = get_post_meta( $post->ID, '_ks_power_kw', true );
    $price_from = get_post_meta( $post->ID, '_ks_price_from', true );
    $stock_status = get_post_meta( $post->ID, '_ks_stock_status', true );
    $warranty = get_post_meta( $post->ID, '_ks_warranty_years', true );

    // Get categories
    $categories = wp_get_post_terms( $post->ID, 'solar_category', array( 'fields' => 'names' ) );

    // Build schema
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => get_the_title(),
        'description' => wp_strip_all_tags( get_the_excerpt() ),
        'url' => get_permalink(),
        'brand' => array(
            '@type' => 'Brand',
            'name' => $brand ? $brand : 'Kha Solar'
        ),
        'category' => ! empty( $categories ) ? $categories[0] : 'Solar Equipment'
    );

    // Add image if exists
    if ( has_post_thumbnail() ) {
        $schema['image'] = get_the_post_thumbnail_url( $post->ID, 'full' );
    }

    // Add model/SKU
    if ( $model ) {
        $schema['model'] = $model;
        $schema['sku'] = $model;
        $schema['mpn'] = $model;
    }

    // Add offers (price and availability)
    $offers = array(
        '@type' => 'Offer',
        'url' => get_permalink(),
        'priceCurrency' => 'VND',
        'availability' => $stock_status === 'in_stock' ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
        'seller' => array(
            '@type' => 'Organization',
            'name' => 'Kha Solar'
        )
    );

    if ( $price_from ) {
        $offers['price'] = $price_from;
    }

    $schema['offers'] = $offers;

    // Add warranty if exists
    if ( $warranty ) {
        $schema['warranty'] = array(
            '@type' => 'WarrantyPromise',
            'durationOfWarranty' => array(
                '@type' => 'QuantitativeValue',
                'value' => $warranty,
                'unitCode' => 'ANN'
            )
        );
    }

    // Add technical specs
    if ( $power_kw ) {
        $schema['additionalProperty'] = array(
            array(
                '@type' => 'PropertyValue',
                'name' => 'Power Output',
                'value' => $power_kw . ' kW'
            )
        );
    }

    return json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
}

/**
 * Output Breadcrumb Schema
 */
function khasolar_breadcrumb_schema() {
    if ( is_front_page() ) {
        return '';
    }

    $items = array();
    $position = 1;

    // Home
    $items[] = array(
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => __( 'Trang chủ', 'khasolar' ),
        'item' => home_url()
    );

    // Add breadcrumb items based on page type
    if ( is_post_type_archive( 'solar_product' ) ) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => __( 'Sản phẩm', 'khasolar' ),
            'item' => get_post_type_archive_link( 'solar_product' )
        );
    } elseif ( is_post_type_archive( 'solar_project' ) ) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => __( 'Dự án', 'khasolar' ),
            'item' => get_post_type_archive_link( 'solar_project' )
        );
    } elseif ( is_singular( 'solar_product' ) ) {
        // Product archive
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => __( 'Sản phẩm', 'khasolar' ),
            'item' => get_post_type_archive_link( 'solar_product' )
        );

        // Current product
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink()
        );
    } elseif ( is_singular( 'solar_project' ) ) {
        // Project archive
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => __( 'Dự án', 'khasolar' ),
            'item' => get_post_type_archive_link( 'solar_project' )
        );

        // Current project
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink()
        );
    } elseif ( is_single() ) {
        // Blog
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => __( 'Blog', 'khasolar' ),
            'item' => get_permalink( get_option( 'page_for_posts' ) )
        );

        // Current post
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink()
        );
    } elseif ( is_page() ) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink()
        );
    }

    if ( empty( $items ) ) {
        return '';
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items
    );

    return json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
}

/**
 * Output all schema markup in head
 */
function khasolar_output_schema_markup() {
    $schemas = array();

    // Always output organization schema
    $schemas[] = khasolar_organization_schema();

    // Output local business on homepage
    if ( is_front_page() ) {
        $schemas[] = khasolar_local_business_schema();
    }

    // Output product schema on product pages
    if ( is_singular( 'solar_product' ) ) {
        $schemas[] = khasolar_product_schema();
    }

    // Output breadcrumb schema
    $breadcrumb = khasolar_breadcrumb_schema();
    if ( $breadcrumb ) {
        $schemas[] = $breadcrumb;
    }

    // Output all schemas
    foreach ( $schemas as $schema ) {
        if ( ! empty( $schema ) ) {
            echo '<script type="application/ld+json">' . $schema . '</script>' . "\n";
        }
    }
}
add_action( 'wp_head', 'khasolar_output_schema_markup' );

/**
 * Add Open Graph meta tags
 */
function khasolar_open_graph_meta() {
    // Title
    if ( is_singular() ) {
        $title = get_the_title();
    } elseif ( is_post_type_archive( 'solar_product' ) ) {
        $title = __( 'Sản phẩm năng lượng mặt trời', 'khasolar' );
    } elseif ( is_post_type_archive( 'solar_project' ) ) {
        $title = __( 'Dự án đã thực hiện', 'khasolar' );
    } else {
        $title = get_bloginfo( 'name' );
    }

    echo '<meta property="og:title" content="' . esc_attr( $title ) . '" />' . "\n";
    echo '<meta property="og:type" content="' . ( is_singular() ? 'article' : 'website' ) . '" />' . "\n";
    echo '<meta property="og:url" content="' . esc_url( get_permalink() ) . '" />' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . "\n";

    // Description
    if ( is_singular() ) {
        $description = wp_strip_all_tags( get_the_excerpt() );
    } else {
        $description = get_bloginfo( 'description' );
    }
    echo '<meta property="og:description" content="' . esc_attr( $description ) . '" />' . "\n";

    // Image
    if ( is_singular() && has_post_thumbnail() ) {
        echo '<meta property="og:image" content="' . esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ) . '" />' . "\n";
    } else {
        echo '<meta property="og:image" content="' . esc_url( get_template_directory_uri() . '/assets/images/logo.png' ) . '" />' . "\n";
    }

    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '" />' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '" />' . "\n";
}
add_action( 'wp_head', 'khasolar_open_graph_meta' );

/**
 * Add meta description tag
 */
function khasolar_meta_description() {
    if ( is_singular() ) {
        $description = wp_strip_all_tags( get_the_excerpt() );
        if ( empty( $description ) ) {
            $description = wp_trim_words( get_the_content(), 20, '...' );
        }
    } elseif ( is_post_type_archive( 'solar_product' ) ) {
        $description = __( 'Khám phá các sản phẩm năng lượng mặt trời chất lượng cao: biến tần, pin lưu trữ, tủ điện. Giải pháp năng lượng xanh cho gia đình và doanh nghiệp.', 'khasolar' );
    } elseif ( is_post_type_archive( 'solar_project' ) ) {
        $description = __( 'Xem các dự án năng lượng mặt trời đã thực hiện bởi Kha Solar. Hệ thống điện mặt trời hòa lưới và độc lập chất lượng cao.', 'khasolar' );
    } else {
        $description = get_bloginfo( 'description' );
    }

    if ( ! empty( $description ) ) {
        echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $description ) ) . '" />' . "\n";
    }
}
add_action( 'wp_head', 'khasolar_meta_description' );
