<?php
/**
 * Demo Content Seeder
 * Creates sample products, projects, and blog posts
 *
 * @package KhaSolar
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add admin menu for demo content
 */
function khasolar_add_demo_admin_menu() {
    add_menu_page(
        __( 'Kha Solar Demo', 'khasolar' ),
        __( 'Kha Solar Demo', 'khasolar' ),
        'manage_options',
        'khasolar-demo',
        'khasolar_demo_admin_page',
        'dashicons-admin-tools',
        30
    );
}
add_action( 'admin_menu', 'khasolar_add_demo_admin_menu' );

/**
 * Demo admin page
 */
function khasolar_demo_admin_page() {
    // Handle demo content creation
    if ( isset( $_POST['khasolar_create_demo'] ) && check_admin_referer( 'khasolar_demo_action', 'khasolar_demo_nonce' ) ) {
        khasolar_create_demo_content();
        echo '<div class="notice notice-success"><p>' . __( 'Nội dung demo đã được tạo thành công!', 'khasolar' ) . '</p></div>';
    }

    // Handle demo content deletion
    if ( isset( $_POST['khasolar_delete_demo'] ) && check_admin_referer( 'khasolar_demo_delete_action', 'khasolar_demo_delete_nonce' ) ) {
        khasolar_delete_demo_content();
        echo '<div class="notice notice-success"><p>' . __( 'Nội dung demo đã được xóa!', 'khasolar' ) . '</p></div>';
    }

    ?>
    <div class="wrap">
        <h1><?php _e( 'Kha Solar Demo Content', 'khasolar' ); ?></h1>

        <div class="card" style="max-width: 800px;">
            <h2><?php _e( 'Tạo nội dung demo', 'khasolar' ); ?></h2>
            <p><?php _e( 'Tạo dữ liệu mẫu để test theme. Bao gồm:', 'khasolar' ); ?></p>
            <ul style="list-style: disc; padding-left: 20px;">
                <li>10 sản phẩm solar (biến tần, pin, phụ kiện)</li>
                <li>3 dự án đã triển khai</li>
                <li>5 bài viết blog</li>
                <li>Các trang cơ bản (Giới thiệu, Liên hệ, Chính sách...)</li>
                <li>Danh mục sản phẩm</li>
            </ul>

            <form method="post" style="margin-top: 20px;">
                <?php wp_nonce_field( 'khasolar_demo_action', 'khasolar_demo_nonce' ); ?>
                <button type="submit" name="khasolar_create_demo" class="button button-primary button-large">
                    <?php _e( 'Tạo nội dung demo', 'khasolar' ); ?>
                </button>
            </form>
        </div>

        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2><?php _e( 'Xóa nội dung demo', 'khasolar' ); ?></h2>
            <p><?php _e( 'Xóa tất cả nội dung demo đã tạo (sản phẩm, dự án, bài viết).', 'khasolar' ); ?></p>

            <form method="post" style="margin-top: 20px;">
                <?php wp_nonce_field( 'khasolar_demo_delete_action', 'khasolar_demo_delete_nonce' ); ?>
                <button type="submit" name="khasolar_delete_demo" class="button button-large"
                        onclick="return confirm('<?php _e( 'Bạn có chắc muốn xóa tất cả nội dung demo?', 'khasolar' ); ?>');">
                    <?php _e( 'Xóa nội dung demo', 'khasolar' ); ?>
                </button>
            </form>
        </div>
    </div>
    <?php
}

/**
 * Create all demo content
 */
function khasolar_create_demo_content() {
    // Create product categories first
    khasolar_create_demo_categories();

    // Create demo products
    khasolar_create_demo_products();

    // Create demo projects
    khasolar_create_demo_projects();

    // Create demo blog posts
    khasolar_create_demo_posts();

    // Create demo pages
    khasolar_create_demo_pages();

    // Store that demo content was created
    update_option( 'khasolar_demo_created', true );
}

/**
 * Delete all demo content
 */
function khasolar_delete_demo_content() {
    // Delete all solar products
    $products = get_posts( array(
        'post_type'      => 'solar_product',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ) );
    foreach ( $products as $product_id ) {
        wp_delete_post( $product_id, true );
    }

    // Delete all solar projects
    $projects = get_posts( array(
        'post_type'      => 'solar_project',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ) );
    foreach ( $projects as $project_id ) {
        wp_delete_post( $project_id, true );
    }

    // Delete demo option
    delete_option( 'khasolar_demo_created' );
}

/**
 * Create product categories
 */
function khasolar_create_demo_categories() {
    $categories = array(
        'Biến tần Hybrid'  => 'Biến tần lai ghép - tích hợp hòa lưới và lưu trữ pin',
        'Biến tần On-grid' => 'Biến tần hòa lưới - kết nối trực tiếp với lưới điện',
        'Pin lưu trữ'      => 'Pin lithium lưu trữ năng lượng',
        'Phụ kiện'         => 'Cáp, connector, công tắc, thiết bị giám sát',
        'Combo tiết kiệm'  => 'Bộ combo sản phẩm giá ưu đãi',
    );

    foreach ( $categories as $name => $description ) {
        if ( ! term_exists( $name, 'solar_category' ) ) {
            wp_insert_term( $name, 'solar_category', array(
                'description' => $description,
            ) );
        }
    }
}

/**
 * Create demo products
 */
function khasolar_create_demo_products() {
    $products = array(
        array(
            'title'     => 'Biến tần Deye SUN-6K-SG04LP1-EU-SM2 6kW',
            'content'   => 'Biến tần hybrid 1 pha 6kW của Deye, hỗ trợ pin lưu trữ, hiệu suất cao, bảo vệ toàn diện. Phù hợp cho hộ gia đình sử dụng điện trung bình.',
            'category'  => 'Biến tần Hybrid',
            'meta'      => array(
                'brand'          => 'Deye',
                'model'          => 'SUN-6K-SG04LP1-EU-SM2',
                'power_kw'       => '6',
                'phase'          => '1 pha',
                'voltage'        => '220V',
                'warranty_years' => '5',
                'origin'         => 'Trung Quốc',
                'price_from'     => '18500000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Công suất AC danh định: 6000W\nĐiện áp vào DC: 180~550V\nHiệu suất tối đa: 97.8%\nBảo vệ chống sét DC&AC\nKết nối WiFi/LAN\nHỗ trợ sạc từ lưới và solar\nChế độ backup tự động",
            ),
        ),
        array(
            'title'     => 'Pin APESS ES-BOX42 5.2kWh',
            'content'   => 'Pin lưu trữ lithium 5.2kWh của APESS, dễ lắp đặt, tuổi thọ cao, an toàn tuyệt đối. Mở rộng được đến 10 module.',
            'category'  => 'Pin lưu trữ',
            'meta'      => array(
                'brand'          => 'APESS',
                'model'          => 'ES-BOX42',
                'power_kw'       => '5.2',
                'phase'          => '',
                'voltage'        => '51.2V',
                'warranty_years' => '10',
                'origin'         => 'Trung Quốc',
                'price_from'     => '22000000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Dung lượng: 5.2kWh\nĐiện áp: 51.2V\nDòng sạc/xả tối đa: 100A\nTuổi thọ: >6000 chu kỳ\nLắp đặt trong nhà\nĐộ an toàn cao IP65\nBMS thông minh",
            ),
        ),
        array(
            'title'     => 'Biến tần Growatt SPH 8000TL BL-UP 8kW',
            'content'   => 'Biến tần Hybrid 1 pha công suất 8kW, hỗ trợ pin lithium, chế độ backup UPS, phù hợp nhà ở lớn.',
            'category'  => 'Biến tần Hybrid',
            'meta'      => array(
                'brand'          => 'Growatt',
                'model'          => 'SPH 8000TL BL-UP',
                'power_kw'       => '8',
                'phase'          => '1 pha',
                'voltage'        => '220V',
                'warranty_years' => '5',
                'origin'         => 'Trung Quốc',
                'price_from'     => '23000000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Công suất AC: 8000W\nHiệu suất tối đa: 98%\nChế độ UPS tích hợp\nHỗ trợ pin cao điện áp\nCổng kết nối đa dạng\nỨng dụng giám sát thông minh",
            ),
        ),
        array(
            'title'     => 'Biến tần Sofar 5kW On-Grid',
            'content'   => 'Biến tần hòa lưới 1 pha 5kW của Sofar, nhỏ gọn, hiệu suất cao, giá thành tốt. Dành cho hệ thống không dùng pin.',
            'category'  => 'Biến tần On-grid',
            'meta'      => array(
                'brand'          => 'Sofar',
                'model'          => '5KTL-G3',
                'power_kw'       => '5',
                'phase'          => '1 pha',
                'voltage'        => '220V',
                'warranty_years' => '5',
                'origin'         => 'Trung Quốc',
                'price_from'     => '12000000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Công suất AC: 5000W\nHiệu suất: 97.6%\nKhởi động điện áp thấp\nNhỏ gọn, dễ lắp đặt\nBảo vệ chống đảo điện\nKết nối WiFi",
            ),
        ),
        array(
            'title'     => 'Pin LumenTree 10kWh',
            'content'   => 'Pin lưu trữ công suất lớn 10kWh, phù hợp cho nhà xưởng, trang trại. Mở rộng lên 50kWh.',
            'category'  => 'Pin lưu trữ',
            'meta'      => array(
                'brand'          => 'LumenTree',
                'model'          => 'LT-10K',
                'power_kw'       => '10',
                'phase'          => '',
                'voltage'        => '51.2V',
                'warranty_years' => '10',
                'origin'         => 'Trung Quốc',
                'price_from'     => '42000000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Dung lượng: 10kWh\nĐiện áp: 51.2V\nDòng xả liên tục: 100A\nTuổi thọ: 6000+ chu kỳ\nBMS thông minh\nMở rộng được",
            ),
        ),
        array(
            'title'     => 'Biến tần 3 pha Deye 12kW',
            'content'   => 'Biến tần Hybrid 3 pha 12kW cho nhà xưởng, trang trại. Hỗ trợ pin, backup mạnh mẽ.',
            'category'  => 'Biến tần Hybrid',
            'meta'      => array(
                'brand'          => 'Deye',
                'model'          => 'SUN-12K-SG04LP3',
                'power_kw'       => '12',
                'phase'          => '3 pha',
                'voltage'        => '380V',
                'warranty_years' => '5',
                'origin'         => 'Trung Quốc',
                'price_from'     => '32000000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Công suất AC: 12kW\nĐiện áp 3 pha 380V\nHỗ trợ pin cao điện áp\nChế độ backup tự động\nHiệu suất: 97.8%\nKết nối WiFi/LAN",
            ),
        ),
        array(
            'title'     => 'Combo Deye 6kW + Pin 5.2kWh',
            'content'   => 'Bộ combo tiết kiệm bao gồm biến tần Deye 6kW + Pin APESS 5.2kWh, sẵn sàng lắp đặt.',
            'category'  => 'Combo tiết kiệm',
            'meta'      => array(
                'brand'          => 'Deye + APESS',
                'model'          => 'Combo 6K',
                'power_kw'       => '6',
                'phase'          => '1 pha',
                'voltage'        => '220V',
                'warranty_years' => '5',
                'origin'         => 'Trung Quốc',
                'price_from'     => '38000000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Biến tần Deye 6kW\nPin APESS 5.2kWh\nCáp kết nối\nHướng dẫn lắp đặt\nBảo hành 5 năm",
            ),
        ),
        array(
            'title'     => 'Cáp Solar 4mm² DC',
            'content'   => 'Cáp DC chuyên dụng cho hệ thống điện mặt trời, chịu nhiệt, chống UV. Cuộn 100m.',
            'category'  => 'Phụ kiện',
            'meta'      => array(
                'brand'          => 'Standard',
                'model'          => 'DC-4MM-100M',
                'power_kw'       => '',
                'phase'          => '',
                'voltage'        => '',
                'warranty_years' => '2',
                'origin'         => 'Việt Nam',
                'price_from'     => '1800000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Tiết diện: 4mm²\nChiều dài: 100m\nChịu nhiệt đến 120°C\nChống UV\nĐạt chuẩn TÜV",
            ),
        ),
        array(
            'title'     => 'Connector MC4',
            'content'   => 'Đầu nối MC4 chuẩn châu Âu, chất lượng cao, độ kín IP67. Bộ 10 cặp.',
            'category'  => 'Phụ kiện',
            'meta'      => array(
                'brand'          => 'MC4',
                'model'          => 'MC4-CONNECTOR',
                'power_kw'       => '',
                'phase'          => '',
                'voltage'        => '',
                'warranty_years' => '2',
                'origin'         => 'Trung Quốc',
                'price_from'     => '350000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Chuẩn MC4\nĐộ kín IP67\nChịu dòng 30A\nChịu nhiệt tốt\nBộ 10 cặp đực cái",
            ),
        ),
        array(
            'title'     => 'Công tắc DC 1000V 32A',
            'content'   => 'Công tắc ngắt mạch DC chuyên dụng, bảo vệ hệ thống an toàn, dễ lắp đặt.',
            'category'  => 'Phụ kiện',
            'meta'      => array(
                'brand'          => 'ABB',
                'model'          => 'DC-1000V-32A',
                'power_kw'       => '',
                'phase'          => '',
                'voltage'        => '1000V DC',
                'warranty_years' => '3',
                'origin'         => 'Thái Lan',
                'price_from'     => '1200000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Điện áp: 1000V DC\nDòng điện: 32A\nBảo vệ quá tải\nDễ lắp đặt\nĐạt chuẩn IEC",
            ),
        ),
    );

    foreach ( $products as $product_data ) {
        // Check if product already exists
        $existing = get_page_by_title( $product_data['title'], OBJECT, 'solar_product' );
        if ( $existing ) {
            continue;
        }

        // Insert product
        $product_id = wp_insert_post( array(
            'post_title'   => $product_data['title'],
            'post_content' => $product_data['content'],
            'post_status'  => 'publish',
            'post_type'    => 'solar_product',
            'post_excerpt' => wp_trim_words( $product_data['content'], 20 ),
        ) );

        if ( $product_id && ! is_wp_error( $product_id ) ) {
            // Set category
            $term = get_term_by( 'name', $product_data['category'], 'solar_category' );
            if ( $term ) {
                wp_set_object_terms( $product_id, $term->term_id, 'solar_category' );
            }

            // Set meta
            foreach ( $product_data['meta'] as $key => $value ) {
                if ( ! empty( $value ) ) {
                    update_post_meta( $product_id, '_ks_' . $key, $value );
                }
            }
        }
    }
}

/**
 * Create demo projects
 */
function khasolar_create_demo_projects() {
    $projects = array(
        array(
            'title'   => 'Hệ thống 10kWp hòa lưới - Nhà ở Hà Nội',
            'content' => 'Dự án lắp đặt hệ thống điện mặt trời hòa lưới công suất 10kWp cho hộ gia đình tại Hà Nội. Hệ thống giúp tiết kiệm 80% hóa đơn điện hàng tháng.',
            'meta'    => array(
                'location'        => 'Hà Nội',
                'capacity_kwp'    => '10',
                'type'            => 'Dân dụng',
                'inverter'        => 'Sofar 10kW On-grid',
                'battery'         => '',
                'completed_date'  => '2024-01-15',
                'key_notes'       => 'Hệ thống hoạt động ổn định, sản lượng đạt 95% công suất thiết kế. Khách hàng rất hài lòng.',
            ),
        ),
        array(
            'title'   => 'Hệ thống Hybrid 20kWp + Pin - Nhà xưởng Bình Dương',
            'content' => 'Lắp đặt hệ thống hybrid 20kWp kết hợp pin lưu trữ 20kWh cho nhà xưởng may mặc tại Bình Dương. Đảm bảo nguồn điện liên tục khi lưới mất điện.',
            'meta'    => array(
                'location'        => 'Bình Dương',
                'capacity_kwp'    => '20',
                'type'            => 'Nhà xưởng',
                'inverter'        => 'Deye 20kW 3 pha',
                'battery'         => 'LumenTree 20kWh',
                'completed_date'  => '2023-11-20',
                'key_notes'       => 'Hệ thống backup tự động khi mất điện lưới. Tiết kiệm chi phí vận hành nhà máy đáng kể.',
            ),
        ),
        array(
            'title'   => 'Hệ thống 15kWp cho trang trại - Đồng Nai',
            'content' => 'Dự án cung cấp điện cho hệ thống tưới tự động và camera giám sát trang trại rau sạch 2 hecta tại Đồng Nai.',
            'meta'    => array(
                'location'        => 'Đồng Nai',
                'capacity_kwp'    => '15',
                'type'            => 'Nông nghiệp',
                'inverter'        => 'Growatt 15kW',
                'battery'         => 'APESS 10kWh',
                'completed_date'  => '2023-09-10',
                'key_notes'       => 'Hệ thống hoạt động độc lập, phục vụ tưới tự động và camera 24/7. Hiệu quả cao.',
            ),
        ),
    );

    foreach ( $projects as $project_data ) {
        $existing = get_page_by_title( $project_data['title'], OBJECT, 'solar_project' );
        if ( $existing ) {
            continue;
        }

        $project_id = wp_insert_post( array(
            'post_title'   => $project_data['title'],
            'post_content' => $project_data['content'],
            'post_status'  => 'publish',
            'post_type'    => 'solar_project',
            'post_excerpt' => wp_trim_words( $project_data['content'], 15 ),
        ) );

        if ( $project_id && ! is_wp_error( $project_id ) ) {
            foreach ( $project_data['meta'] as $key => $value ) {
                if ( ! empty( $value ) ) {
                    update_post_meta( $project_id, '_ks_project_' . $key, $value );
                }
            }
        }
    }
}

/**
 * Create demo blog posts
 */
function khasolar_create_demo_posts() {
    $posts = array(
        array(
            'title'   => 'Hướng dẫn chọn biến tần phù hợp với công suất sử dụng',
            'content' => 'Việc chọn biến tần phù hợp là yếu tố quan trọng quyết định hiệu quả của hệ thống điện mặt trời. Bài viết này sẽ hướng dẫn bạn cách tính toán và lựa chọn công suất biến tần dựa trên nhu cầu sử dụng điện hàng ngày.',
        ),
        array(
            'title'   => 'Vì sao nên sử dụng pin lưu trữ cho hệ thống điện mặt trời gia đình',
            'content' => 'Pin lưu trữ giúp tối ưu hóa sử dụng điện mặt trời, đảm bảo nguồn điện liên tục khi mất lưới. Tìm hiểu về lợi ích và cách lựa chọn dung lượng pin phù hợp.',
        ),
        array(
            'title'   => '3 sai lầm phổ biến khi tự lắp đặt hệ thống điện mặt trời',
            'content' => 'Nhiều người muốn tự lắp đặt để tiết kiệm chi phí nhưng thường mắc những sai lầm nguy hiểm. Bài viết chỉ ra 3 sai lầm thường gặp và cách khắc phục.',
        ),
        array(
            'title'   => 'So sánh chi tiết các dòng biến tần hybrid phổ biến hiện nay',
            'content' => 'Phân tích ưu nhược điểm của các thương hiệu biến tần hybrid như Deye, Growatt, Sofar. Giúp bạn đưa ra lựa chọn đúng đắn cho hệ thống của mình.',
        ),
        array(
            'title'   => 'Checklist kiểm tra trước khi vận hành hệ thống điện mặt trời',
            'content' => 'Danh sách kiểm tra đầy đủ các bước cần thiết trước khi khởi động hệ thống điện mặt trời lần đầu. Đảm bảo an toàn và hiệu quả tối ưu.',
        ),
    );

    foreach ( $posts as $post_data ) {
        $existing = get_page_by_title( $post_data['title'], OBJECT, 'post' );
        if ( $existing ) {
            continue;
        }

        wp_insert_post( array(
            'post_title'   => $post_data['title'],
            'post_content' => $post_data['content'],
            'post_status'  => 'publish',
            'post_type'    => 'post',
            'post_excerpt' => wp_trim_words( $post_data['content'], 20 ),
        ) );
    }
}

/**
 * Create demo pages
 */
function khasolar_create_demo_pages() {
    $pages = array(
        'Giới thiệu'              => 'Kha Solar là đơn vị cung cấp giải pháp năng lượng mặt trời hàng đầu tại Việt Nam với hơn 10 năm kinh nghiệm.',
        'Liên hệ'                 => 'Liên hệ với chúng tôi để được tư vấn miễn phí về giải pháp điện mặt trời phù hợp.',
        'Chính sách bảo hành'     => 'Tất cả sản phẩm đều được bảo hành chính hãng từ 5-25 năm tùy loại sản phẩm.',
        'Chính sách vận chuyển'   => 'Chúng tôi cung cấp dịch vụ vận chuyển và lắp đặt tận nơi trên toàn quốc.',
        'Chính sách đổi trả'      => 'Sản phẩm lỗi do nhà sản xuất được đổi trả trong vòng 30 ngày.',
        'Chính sách bảo mật'      => 'Thông tin khách hàng được bảo mật tuyệt đối theo quy định pháp luật.',
    );

    foreach ( $pages as $title => $content ) {
        $existing = get_page_by_title( $title );
        if ( $existing ) {
            continue;
        }

        wp_insert_post( array(
            'post_title'   => $title,
            'post_content' => $content,
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ) );
    }
}
