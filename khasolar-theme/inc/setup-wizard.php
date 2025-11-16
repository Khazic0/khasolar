<?php
/**
 * Quick Setup Wizard
 *
 * Helps users quickly setup the theme for production
 *
 * @package KhaSolar
 * @since 1.2.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add setup wizard to admin menu
 */
function khasolar_add_setup_wizard_menu() {
    add_menu_page(
        __( 'Thiết lập nhanh', 'khasolar' ),
        __( '⚡ Thiết lập', 'khasolar' ),
        'manage_options',
        'khasolar-setup',
        'khasolar_setup_wizard_page',
        'dashicons-admin-generic',
        3
    );
}
add_action( 'admin_menu', 'khasolar_add_setup_wizard_menu' );

/**
 * Setup wizard page
 */
function khasolar_setup_wizard_page() {
    // Handle actions
    if ( isset( $_POST['khasolar_setup_action'] ) ) {
        check_admin_referer( 'khasolar_setup_wizard' );

        $action = $_POST['khasolar_setup_action'];

        switch ( $action ) {
            case 'create_comparison_page':
                khasolar_create_comparison_page();
                break;

            case 'create_essential_pages':
                khasolar_create_essential_pages();
                break;

            case 'flush_permalinks':
                flush_rewrite_rules();
                echo '<div class="notice notice-success"><p>' . __( 'Đã làm mới permalinks!', 'khasolar' ) . '</p></div>';
                break;
        }
    }

    // Get setup status
    $status = khasolar_get_setup_status();

    ?>
    <div class="wrap khasolar-setup-wizard">
        <h1>⚡ Thiết Lập Nhanh Kha Solar Theme</h1>
        <p class="description">Hoàn thành các bước sau để website sẵn sàng kinh doanh</p>

        <div class="khasolar-setup-progress">
            <?php
            $total = count( $status );
            $completed = count( array_filter( $status ) );
            $percentage = $total > 0 ? ( $completed / $total ) * 100 : 0;
            ?>
            <div class="progress-bar">
                <div class="progress-fill" style="width: <?php echo esc_attr( $percentage ); ?>%;"></div>
            </div>
            <p class="progress-text"><strong><?php echo $completed; ?></strong> / <?php echo $total; ?> hoàn thành (<?php echo round( $percentage ); ?>%)</p>
        </div>

        <div class="khasolar-setup-steps">

            <!-- Step 1: Permalinks -->
            <div class="setup-step <?php echo $status['permalinks'] ? 'completed' : ''; ?>">
                <div class="step-header">
                    <span class="step-icon"><?php echo $status['permalinks'] ? '✅' : '1'; ?></span>
                    <h2>Permalinks (Đường dẫn URL)</h2>
                </div>
                <div class="step-content">
                    <?php if ( $status['permalinks'] ) : ?>
                        <p class="success">✅ Permalinks đã được cấu hình đúng: <code>/%postname%/</code></p>
                    <?php else : ?>
                        <p class="warning">⚠️ Permalinks chưa đúng. Cần set thành <strong>Post name</strong></p>
                        <p>
                            <a href="<?php echo admin_url( 'options-permalink.php' ); ?>" class="button button-primary">
                                Đi đến Settings → Permalinks
                            </a>
                            hoặc
                            <form method="post" style="display: inline;">
                                <?php wp_nonce_field( 'khasolar_setup_wizard' ); ?>
                                <input type="hidden" name="khasolar_setup_action" value="flush_permalinks">
                                <button type="submit" class="button">Làm mới Permalinks</button>
                            </form>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Step 2: Comparison Page -->
            <div class="setup-step <?php echo $status['comparison_page'] ? 'completed' : ''; ?>">
                <div class="step-header">
                    <span class="step-icon"><?php echo $status['comparison_page'] ? '✅' : '2'; ?></span>
                    <h2>Trang So Sánh Sản Phẩm</h2>
                </div>
                <div class="step-content">
                    <?php if ( $status['comparison_page'] ) : ?>
                        <p class="success">✅ Trang so sánh đã tồn tại</p>
                        <p><a href="<?php echo home_url( '/so-sanh-san-pham/' ); ?>" target="_blank">Xem trang →</a></p>
                    <?php else : ?>
                        <p class="warning">⚠️ Chưa có trang so sánh. Tính năng comparison sẽ không hoạt động!</p>
                        <form method="post">
                            <?php wp_nonce_field( 'khasolar_setup_wizard' ); ?>
                            <input type="hidden" name="khasolar_setup_action" value="create_comparison_page">
                            <button type="submit" class="button button-primary">Tạo Trang So Sánh</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Step 3: Essential Pages -->
            <div class="setup-step <?php echo $status['essential_pages'] ? 'completed' : ''; ?>">
                <div class="step-header">
                    <span class="step-icon"><?php echo $status['essential_pages'] ? '✅' : '3'; ?></span>
                    <h2>Các Trang Cần Thiết</h2>
                </div>
                <div class="step-content">
                    <?php
                    $essential_pages = array(
                        'about' => 'Về chúng tôi',
                        'contact' => 'Liên hệ',
                    );
                    $missing = array();
                    foreach ( $essential_pages as $slug => $title ) {
                        if ( ! get_page_by_path( $slug ) ) {
                            $missing[] = $title;
                        }
                    }
                    ?>
                    <?php if ( empty( $missing ) ) : ?>
                        <p class="success">✅ Các trang cơ bản đã có</p>
                    <?php else : ?>
                        <p class="warning">⚠️ Thiếu trang: <?php echo implode( ', ', $missing ); ?></p>
                        <form method="post">
                            <?php wp_nonce_field( 'khasolar_setup_wizard' ); ?>
                            <input type="hidden" name="khasolar_setup_action" value="create_essential_pages">
                            <button type="submit" class="button button-primary">Tạo Các Trang Cơ Bản</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Step 4: Products -->
            <div class="setup-step <?php echo $status['has_products'] ? 'completed' : ''; ?>">
                <div class="step-header">
                    <span class="step-icon"><?php echo $status['has_products'] ? '✅' : '4'; ?></span>
                    <h2>Sản Phẩm</h2>
                </div>
                <div class="step-content">
                    <?php if ( $status['has_products'] ) : ?>
                        <p class="success">✅ Đã có <?php echo $status['product_count']; ?> sản phẩm</p>
                        <p><a href="<?php echo admin_url( 'edit.php?post_type=solar_product' ); ?>">Quản lý sản phẩm →</a></p>
                    <?php else : ?>
                        <p class="warning">⚠️ Chưa có sản phẩm nào!</p>
                        <p>
                            <a href="<?php echo admin_url( 'admin.php?page=khasolar-import-products' ); ?>" class="button button-primary">
                                Import 14 Sản Phẩm
                            </a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Step 5: Contact Info -->
            <div class="setup-step <?php echo $status['contact_configured'] ? 'completed' : ''; ?>">
                <div class="step-header">
                    <span class="step-icon"><?php echo $status['contact_configured'] ? '✅' : '5'; ?></span>
                    <h2>Thông Tin Liên Hệ</h2>
                </div>
                <div class="step-content">
                    <?php if ( $status['contact_configured'] ) : ?>
                        <p class="success">✅ WhatsApp và Zalo đã cấu hình</p>
                        <ul>
                            <li>WhatsApp: <?php echo get_theme_mod( 'khasolar_whatsapp', '(chưa set)' ); ?></li>
                            <li>Zalo: <?php echo get_theme_mod( 'khasolar_zalo', '(chưa set)' ); ?></li>
                        </ul>
                    <?php else : ?>
                        <p class="warning">⚠️ Chưa cấu hình WhatsApp và Zalo</p>
                    <?php endif; ?>
                    <p>
                        <a href="<?php echo admin_url( 'customize.php?autofocus[section]=khasolar_contact_info' ); ?>" class="button button-primary">
                            Cấu hình liên hệ
                        </a>
                    </p>
                    <p class="description">Lưu ý: Cần sửa số điện thoại, email, địa chỉ trong file <code>/inc/template-tags.php</code></p>
                </div>
            </div>

            <!-- Step 6: Menus -->
            <div class="setup-step <?php echo $status['menus_configured'] ? 'completed' : ''; ?>">
                <div class="step-header">
                    <span class="step-icon"><?php echo $status['menus_configured'] ? '✅' : '6'; ?></span>
                    <h2>Navigation Menus</h2>
                </div>
                <div class="step-content">
                    <?php if ( $status['menus_configured'] ) : ?>
                        <p class="success">✅ Header và Footer menu đã có</p>
                    <?php else : ?>
                        <p class="warning">⚠️ Chưa có menu</p>
                    <?php endif; ?>
                    <p>
                        <a href="<?php echo admin_url( 'nav-menus.php' ); ?>" class="button button-primary">
                            Tạo Menu
                        </a>
                    </p>
                </div>
            </div>

        </div>

        <div class="khasolar-setup-actions">
            <h2>🎯 Các Bước Tiếp Theo</h2>
            <ul class="next-steps">
                <li>📖 <a href="<?php echo get_template_directory_uri(); ?>/../PRODUCTION-GUIDE.md" target="_blank">Đọc hướng dẫn Production đầy đủ</a></li>
                <li>🖼️ Upload hình ảnh cho sản phẩm</li>
                <li>📝 Tạo nội dung cho các trang Về chúng tôi, Liên hệ</li>
                <li>📧 Cấu hình SMTP email (khuyến nghị: WP Mail SMTP plugin)</li>
                <li>🔒 Cài SSL certificate</li>
                <li>⚡ Cài caching plugin (WP Super Cache hoặc WP Rocket)</li>
                <li>🔐 Cài security plugin (Wordfence)</li>
                <li>🔄 Setup backup tự động (UpdraftPlus)</li>
                <li>📊 Setup Google Analytics (optional)</li>
                <li>🚀 Launch!</li>
            </ul>
        </div>

        <div class="khasolar-support-box">
            <h3>📚 Tài Liệu Hỗ Trợ</h3>
            <ul>
                <li><a href="<?php echo home_url( '/?feed=sitemap' ); ?>" target="_blank">XML Sitemap</a> - Submit to Google Search Console</li>
                <li><strong>Email support:</strong> contact@khasolar.vn</li>
                <li><strong>Documentation:</strong> README.md, PRODUCTION-GUIDE.md</li>
            </ul>
        </div>
    </div>

    <style>
        .khasolar-setup-wizard {
            max-width: 900px;
        }

        .khasolar-setup-progress {
            background: #fff;
            padding: 25px;
            margin: 25px 0;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .progress-bar {
            height: 20px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #FF6B35 0%, #004E89 100%);
            transition: width 0.5s ease;
        }

        .progress-text {
            text-align: center;
            margin: 0;
            font-size: 18px;
        }

        .setup-step {
            background: #fff;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-left: 4px solid #ddd;
            transition: all 0.3s;
        }

        .setup-step.completed {
            border-left-color: #1a8917;
            background: #f0f9ff;
        }

        .step-header {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px 25px;
            border-bottom: 1px solid #e9ecef;
        }

        .step-header h2 {
            margin: 0;
            font-size: 18px;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            background: #FF6B35;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }

        .setup-step.completed .step-icon {
            background: #1a8917;
        }

        .step-content {
            padding: 20px 25px;
        }

        .success {
            color: #1a8917;
            font-weight: 600;
        }

        .warning {
            color: #d63638;
            font-weight: 600;
        }

        .khasolar-setup-actions,
        .khasolar-support-box {
            background: #fff;
            padding: 25px;
            margin-top: 25px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .next-steps {
            list-style: none;
            padding: 0;
        }

        .next-steps li {
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .next-steps li:last-child {
            border-bottom: none;
        }
    </style>
    <?php
}

/**
 * Get setup status
 */
function khasolar_get_setup_status() {
    $status = array();

    // Check permalinks
    $permalink_structure = get_option( 'permalink_structure' );
    $status['permalinks'] = ! empty( $permalink_structure ) && $permalink_structure !== '/index.php/%postname%/';

    // Check comparison page
    $comparison_page = get_page_by_path( 'so-sanh-san-pham' );
    $status['comparison_page'] = ! empty( $comparison_page );

    // Check essential pages
    $has_about = get_page_by_path( 'about' ) || get_page_by_path( 've-chung-toi' );
    $has_contact = get_page_by_path( 'contact' ) || get_page_by_path( 'lien-he' );
    $status['essential_pages'] = $has_about && $has_contact;

    // Check products
    $product_count = wp_count_posts( 'solar_product' );
    $status['product_count'] = isset( $product_count->publish ) ? $product_count->publish : 0;
    $status['has_products'] = $status['product_count'] > 0;

    // Check contact info
    $whatsapp = get_theme_mod( 'khasolar_whatsapp' );
    $zalo = get_theme_mod( 'khasolar_zalo' );
    $status['contact_configured'] = ! empty( $whatsapp ) && ! empty( $zalo );

    // Check menus
    $locations = get_nav_menu_locations();
    $status['menus_configured'] = ! empty( $locations['header_menu'] ) || ! empty( $locations['footer_menu'] );

    return $status;
}

/**
 * Create comparison page
 */
function khasolar_create_comparison_page() {
    $page_id = wp_insert_post( array(
        'post_title'   => 'So sánh sản phẩm',
        'post_name'    => 'so-sanh-san-pham',
        'post_content' => '<!-- This page uses the comparison template -->',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'page_template' => 'page-templates/compare.php',
    ) );

    if ( $page_id ) {
        update_post_meta( $page_id, '_wp_page_template', 'page-templates/compare.php' );
        echo '<div class="notice notice-success"><p>✅ Đã tạo trang So sánh sản phẩm!</p></div>';
    } else {
        echo '<div class="notice notice-error"><p>❌ Không thể tạo trang. Vui lòng tạo thủ công.</p></div>';
    }
}

/**
 * Create essential pages
 */
function khasolar_create_essential_pages() {
    $pages = array(
        array(
            'title' => 'Về chúng tôi',
            'slug'  => 've-chung-toi',
            'content' => '<h2>Về Kha Solar</h2><p>Kha Solar là đơn vị hàng đầu cung cấp giải pháp năng lượng mặt trời tại Việt Nam.</p><h3>Vì sao chọn Kha Solar?</h3><ul><li>Sản phẩm chính hãng, bảo hành dài hạn</li><li>Đội ngũ kỹ thuật chuyên nghiệp</li><li>Thi công nhanh chóng, đúng tiến độ</li><li>Hỗ trợ sau bán hàng tận tâm</li><li>Giá cả cạnh tranh nhất thị trường</li></ul>',
        ),
        array(
            'title' => 'Liên hệ',
            'slug'  => 'lien-he',
            'content' => '<h2>Thông tin liên hệ</h2><p><strong>Địa chỉ:</strong> [Cập nhật địa chỉ của bạn]</p><p><strong>Hotline:</strong> [Cập nhật số điện thoại]</p><p><strong>Email:</strong> contact@khasolar.vn</p><p><strong>Giờ làm việc:</strong> 8:00 - 18:00 (Thứ 2 - Thứ 7)</p>',
        ),
    );

    $created = 0;
    foreach ( $pages as $page ) {
        if ( ! get_page_by_path( $page['slug'] ) ) {
            wp_insert_post( array(
                'post_title'   => $page['title'],
                'post_name'    => $page['slug'],
                'post_content' => $page['content'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ) );
            $created++;
        }
    }

    if ( $created > 0 ) {
        echo '<div class="notice notice-success"><p>✅ Đã tạo ' . $created . ' trang!</p></div>';
    } else {
        echo '<div class="notice notice-info"><p>ℹ️ Các trang đã tồn tại.</p></div>';
    }
}
