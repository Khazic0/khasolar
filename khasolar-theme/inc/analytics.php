<?php
/**
 * Analytics Integration
 *
 * Google Analytics and other tracking codes
 *
 * @package KhaSolar
 * @since 1.2.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add Google Analytics tracking code
 *
 * To enable, add to wp-config.php:
 * define('KHASOLAR_GA_ID', 'G-XXXXXXXXXX');
 */
function khasolar_google_analytics() {
    // Skip if admin or no GA ID defined
    if ( is_admin() || ! defined( 'KHASOLAR_GA_ID' ) || empty( KHASOLAR_GA_ID ) ) {
        return;
    }

    $ga_id = KHASOLAR_GA_ID;
    ?>
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga_id ); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo esc_js( $ga_id ); ?>', {
            'anonymize_ip': true,
            'cookie_flags': 'SameSite=None;Secure'
        });

        // Track lead form submissions
        document.addEventListener('DOMContentLoaded', function() {
            // Track lead form
            var leadForms = document.querySelectorAll('form[action*="lead"]');
            leadForms.forEach(function(form) {
                form.addEventListener('submit', function() {
                    gtag('event', 'generate_lead', {
                        'event_category': 'Lead',
                        'event_label': 'Product Inquiry'
                    });
                });
            });

            // Track calculator usage
            var calculatorBtn = document.querySelector('#calculate-savings');
            if (calculatorBtn) {
                calculatorBtn.addEventListener('click', function() {
                    gtag('event', 'calculator_use', {
                        'event_category': 'Engagement',
                        'event_label': 'ROI Calculator'
                    });
                });
            }

            // Track comparison usage
            document.addEventListener('click', function(e) {
                if (e.target.closest('.add-to-compare')) {
                    gtag('event', 'add_to_comparison', {
                        'event_category': 'Product',
                        'event_label': 'Product Comparison'
                    });
                }
            });

            // Track WhatsApp/Zalo clicks
            var contactBtns = document.querySelectorAll('.whatsapp-btn, .zalo-btn, .phone-btn');
            contactBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var channel = 'Unknown';
                    if (btn.classList.contains('whatsapp-btn')) channel = 'WhatsApp';
                    if (btn.classList.contains('zalo-btn')) channel = 'Zalo';
                    if (btn.classList.contains('phone-btn')) channel = 'Phone';

                    gtag('event', 'contact_click', {
                        'event_category': 'Contact',
                        'event_label': channel
                    });
                });
            });

            // Track review submissions
            var reviewForms = document.querySelectorAll('form.review-form');
            reviewForms.forEach(function(form) {
                form.addEventListener('submit', function() {
                    gtag('event', 'submit_review', {
                        'event_category': 'Engagement',
                        'event_label': 'Product Review'
                    });
                });
            });
        });
    </script>
    <?php
}
add_action( 'wp_head', 'khasolar_google_analytics', 10 );

/**
 * Add Google Tag Manager (optional)
 *
 * To enable, add to wp-config.php:
 * define('KHASOLAR_GTM_ID', 'GTM-XXXXXXX');
 */
function khasolar_google_tag_manager() {
    if ( is_admin() || ! defined( 'KHASOLAR_GTM_ID' ) || empty( KHASOLAR_GTM_ID ) ) {
        return;
    }

    $gtm_id = KHASOLAR_GTM_ID;
    ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','<?php echo esc_js( $gtm_id ); ?>');</script>
    <!-- End Google Tag Manager -->
    <?php
}
add_action( 'wp_head', 'khasolar_google_tag_manager', 5 );

/**
 * Add GTM noscript (in body)
 */
function khasolar_gtm_noscript() {
    if ( is_admin() || ! defined( 'KHASOLAR_GTM_ID' ) || empty( KHASOLAR_GTM_ID ) ) {
        return;
    }

    $gtm_id = KHASOLAR_GTM_ID;
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr( $gtm_id ); ?>"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}
add_action( 'wp_body_open', 'khasolar_gtm_noscript' );

/**
 * Add Facebook Pixel (optional)
 *
 * To enable, add to wp-config.php:
 * define('KHASOLAR_FB_PIXEL_ID', 'XXXXXXXXXXXXXXXX');
 */
function khasolar_facebook_pixel() {
    if ( is_admin() || ! defined( 'KHASOLAR_FB_PIXEL_ID' ) || empty( KHASOLAR_FB_PIXEL_ID ) ) {
        return;
    }

    $pixel_id = KHASOLAR_FB_PIXEL_ID;
    ?>
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '<?php echo esc_js( $pixel_id ); ?>');
    fbq('track', 'PageView');

    // Track leads
    document.addEventListener('DOMContentLoaded', function() {
        var leadForms = document.querySelectorAll('form[action*="lead"]');
        leadForms.forEach(function(form) {
            form.addEventListener('submit', function() {
                fbq('track', 'Lead');
            });
        });
    });
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
             src="https://www.facebook.com/tr?id=<?php echo esc_attr( $pixel_id ); ?>&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
    <?php
}
add_action( 'wp_head', 'khasolar_facebook_pixel', 10 );

/**
 * Track ecommerce events (for future WooCommerce integration)
 */
function khasolar_track_product_view() {
    if ( ! is_singular( 'solar_product' ) ) {
        return;
    }

    if ( ! defined( 'KHASOLAR_GA_ID' ) || empty( KHASOLAR_GA_ID ) ) {
        return;
    }

    global $post;
    $product_id = $post->ID;
    $product_name = get_the_title();
    $category = '';
    $price = get_post_meta( $product_id, '_ks_price_from', true );

    $categories = get_the_terms( $product_id, 'solar_category' );
    if ( $categories && ! is_wp_error( $categories ) ) {
        $category = $categories[0]->name;
    }

    ?>
    <script>
    gtag('event', 'view_item', {
        'items': [{
            'id': '<?php echo esc_js( $product_id ); ?>',
            'name': '<?php echo esc_js( $product_name ); ?>',
            'category': '<?php echo esc_js( $category ); ?>',
            <?php if ( $price ) : ?>
            'price': <?php echo esc_js( $price ); ?>,
            <?php endif; ?>
        }]
    });
    </script>
    <?php
}
add_action( 'wp_footer', 'khasolar_track_product_view' );

/**
 * Admin notice to add analytics
 */
function khasolar_analytics_admin_notice() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( defined( 'KHASOLAR_GA_ID' ) && KHASOLAR_GA_ID ) {
        return;
    }

    $screen = get_current_screen();
    if ( $screen->id !== 'dashboard' ) {
        return;
    }

    ?>
    <div class="notice notice-info is-dismissible">
        <p>
            <strong>Kha Solar Theme:</strong>
            Bạn chưa cấu hình Google Analytics.
            Thêm vào <code>wp-config.php</code>:
            <code>define('KHASOLAR_GA_ID', 'G-XXXXXXXXXX');</code>
        </p>
    </div>
    <?php
}
add_action( 'admin_notices', 'khasolar_analytics_admin_notice' );
