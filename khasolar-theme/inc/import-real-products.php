<?php
/**
 * Import Real Products - Kha Solar
 * Thêm sản phẩm thực tế vào website
 *
 * @package KhaSolar
 * @since 1.1.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Real product data from client
 */
function khasolar_get_real_products_data() {
    return array(
        // BIẾN TẦN Category
        array(
            'category' => 'Biến tần Hybrid',
            'title'    => 'Inverter Hybrid Deye 12kW 1 pha',
            'content'  => 'Inverter Hybrid Deye 12kW 1 pha là dòng biến tần Hybrid công suất lớn, phù hợp cho hộ gia đình tiêu thụ điện cao hoặc nhà xưởng nhỏ. Sản phẩm được trang bị công nghệ tiên tiến với hiệu suất cao, độ bền vượt trội.',
            'meta'     => array(
                'brand'          => 'Deye',
                'model'          => 'Deye 12KW 1P',
                'power_kw'       => '12',
                'phase'          => '1 pha',
                'voltage'        => '220V',
                'warranty_years' => '5',
                'origin'         => 'Trung Quốc',
                'price_from'     => '32000000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Công suất ra AC: 12000W\nHiệu suất: 97.6%\nCấp chống nước: IP65\nKích thước: 420x670x233 (mm)\nKhối Lượng: 35.6kg\nKết nối: Wifi, RS485, GPRS\nBảo hành: 5 năm",
            ),
        ),
        array(
            'category' => 'Biến tần Hybrid',
            'title'    => 'Inverter Hybrid Deye 6kW 1 pha',
            'content'  => 'Inverter hybrid Deye 6kW 1 pha là dòng biến tần Hybrid phổ thông với thiết kế nhỏ gọn nhưng mang lại một hiệu năng mạnh mẽ đang được rất nhiều khách hàng trên thế giới tin dùng, đạt các tiêu chuẩn khắt khe của châu Âu. Với vị trí số 1 tại Mỹ và số 2 tại Nam Phi (2020), sản phẩm này là lựa chọn đáng tin cậy cho các hệ thống năng lượng mặt trời.',
            'meta'     => array(
                'brand'          => 'Deye',
                'model'          => 'Deye 6KW 1P',
                'power_kw'       => '6',
                'phase'          => '1 pha',
                'voltage'        => '220V',
                'warranty_years' => '5',
                'origin'         => 'Trung Quốc',
                'price_from'     => '18500000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Công suất ra AC: 6kW\nDòng điện Max PV hoạt động: 18A\nDòng điện Max PV ngắn mạch: 27A\nHiệu suất: 97%\nKhối Lượng: 26.8 Kg\nKết nối: Wifi, RS485, GPRS\nBảo hành: 5 năm",
            ),
        ),
        array(
            'category' => 'Biến tần Hybrid',
            'title'    => 'Inverter Hybrid Deye 8kW 1 pha',
            'content'  => 'Inverter Hybrid Deye 8kW 1 pha là lựa chọn hoàn hảo cho các hộ gia đình có nhu cầu sử dụng điện cao. Sản phẩm có khả năng chuyển đổi công suất PV tối đa 12800W, đảm bảo hiệu quả sử dụng điện mặt trời tối ưu.',
            'meta'     => array(
                'brand'          => 'Deye',
                'model'          => 'Deye 8KW 1P',
                'power_kw'       => '8',
                'phase'          => '1 pha',
                'voltage'        => '220V',
                'warranty_years' => '5',
                'origin'         => 'Trung Quốc',
                'price_from'     => '23000000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Công suất PV lắp đặt tối đa: 16000W\nCông suất PV chuyển đổi tối đa: 12800W\nDòng điện đầu vào tối đa: 26A\nHiệu suất: 97.6%\nCấp chống nước: IP65\nKích thước: 366x589.5x237 (mm)\nKhối Lượng: 26.8kg\nKết nối: Wifi, RS485, GPRS\nBảo hành: 5 năm",
            ),
        ),
        array(
            'category' => 'Biến tần Hybrid',
            'title'    => 'LumenTree 6KW-T (Có song song)',
            'content'  => 'Inverter Hybrid LumenTree 6KW-T là dòng sản phẩm cao cấp với khả năng kết nối song song để nâng công suất hoặc tạo điện 3 pha. Đặc biệt phù hợp cho các trường hợp lắp lẻ tấm pin hoặc 2 mái bị bóng che.',
            'meta'     => array(
                'brand'          => 'LumenTree',
                'model'          => '6KW-T',
                'power_kw'       => '6',
                'phase'          => '1 pha',
                'voltage'        => '220V',
                'warranty_years' => '5',
                'origin'         => 'Trung Quốc',
                'price_from'     => '19500000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Công suất PV max: 8000W\nCông suất đầu ra: 6 KW\nCông suất sạc/xả: 100A/130A\nĐiện áp max PV: 500V\n2 MPPT 15A (tổng 30A)\nPhù hợp lắp dưới 20 tấm pin 550W\nCó thể kết nối song song để nâng công suất\nCó thể tạo điện 3 pha khi kết nối //\nBảo hành: 5 năm",
            ),
        ),
        array(
            'category' => 'Biến tần Hybrid',
            'title'    => 'LumenTree 4KW-H (Không song song)',
            'content'  => 'Inverter Hybrid LumenTree 4KW-H là lựa chọn kinh tế cho hộ gia đình nhỏ. Sản phẩm có công suất 4kW, phù hợp lắp dưới 10 tấm pin 550Wp. Bảo hành 3 năm chính hãng.',
            'meta'     => array(
                'brand'          => 'LumenTree',
                'model'          => '4KW-H',
                'power_kw'       => '4',
                'phase'          => '1 pha',
                'voltage'        => '220V',
                'warranty_years' => '3',
                'origin'         => 'Trung Quốc',
                'price_from'     => '14500000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Công suất PV max: 5000W\nCông suất đầu ra: 4 KW\nCông suất sạc: 60A\nĐiện áp max PV: 500V\nDòng PV max: 15A\nPhù hợp lắp dưới 10 tấm pin 5xxWp\nKhông thể kết nối song song\nBảo hành: 3 năm",
            ),
        ),
        array(
            'category' => 'Biến tần Hybrid',
            'title'    => 'LumenTree 6KW-S (Có song song - Bảo hành 5 năm)',
            'content'  => 'Inverter Hybrid LumenTree 6KW-S phiên bản nâng cấp với bảo hành 5 năm. Có khả năng kết nối song song để mở rộng công suất hoặc tạo điện 3 pha khi cần thiết.',
            'meta'     => array(
                'brand'          => 'LumenTree',
                'model'          => '6KW-S',
                'power_kw'       => '6',
                'phase'          => '1 pha',
                'voltage'        => '220V',
                'warranty_years' => '5',
                'origin'         => 'Trung Quốc',
                'price_from'     => '19500000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Công suất PV max: 8000W\nCông suất đầu ra: 6 KW\nCông suất sạc/xả: 100A/130A\nĐiện áp max PV: 500V\n2 MPPT 15A (tổng 30A)\nPhù hợp lắp dưới 20 tấm pin 550W\nCó thể kết nối song song\nBảo hành: 5 năm",
            ),
        ),
        array(
            'category' => 'Biến tần Hybrid',
            'title'    => 'LumenTree 6KW-H (Không song song - Bảo hành 3 năm)',
            'content'  => 'Inverter Hybrid LumenTree 6KW-H phiên bản tiêu chuẩn với công suất 6kW. Phù hợp cho hộ gia đình không có nhu cầu mở rộng hệ thống.',
            'meta'     => array(
                'brand'          => 'LumenTree',
                'model'          => '6KW-H',
                'power_kw'       => '6',
                'phase'          => '1 pha',
                'voltage'        => '220V',
                'warranty_years' => '3',
                'origin'         => 'Trung Quốc',
                'price_from'     => '17500000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Công suất PV max: 8000W\nCông suất đầu ra: 6 KW\nCông suất sạc/xả: 100A/130A\nĐiện áp max PV: 500V\n2 MPPT 15A (tổng 30A)\nPhù hợp lắp dưới 20 tấm pin 550W\nKhông thể kết nối song song\nBảo hành: 3 năm",
            ),
        ),
        array(
            'category' => 'Biến tần Hybrid',
            'title'    => 'LumenTree 8KW-H (Không song song - Bảo hành 3 năm)',
            'content'  => 'Inverter Hybrid LumenTree 8KW-H công suất cao 8kW, có thể lắp hệ thống PV lên đến 15kWp. Phù hợp cho hộ gia đình có nhu cầu sử dụng điện cao hoặc nhà xưởng nhỏ.',
            'meta'     => array(
                'brand'          => 'LumenTree',
                'model'          => '8KW-H',
                'power_kw'       => '8',
                'phase'          => '1 pha',
                'voltage'        => '220V',
                'warranty_years' => '3',
                'origin'         => 'Trung Quốc',
                'price_from'     => '22000000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Công suất PV max: 10.000W\nCông suất lắp PV: 15kWp\nCông suất đầu ra: 8 KW\nCông suất sạc/xả: 100A/130A\nĐiện áp max PV: 500V\n2 MPPT 23A (tổng 46A)\nPhù hợp lắp dưới 20 tấm pin 700W\nKhông thể kết nối song song\nBảo hành: 3 năm",
            ),
        ),
        array(
            'category' => 'Biến tần Hybrid',
            'title'    => 'Senergy 6kW SE 6K ECO',
            'content'  => 'Inverter Hybrid Senergy 6kW SE 6K ECO là dòng sản phẩm hybrid cao cấp với 2 MPPT độc lập, tương thích với nhiều loại pin lithium 48V. Sản phẩm đạt chuẩn chống nước IP65, có thể lắp đặt ngoài trời.',
            'meta'     => array(
                'brand'          => 'Senergy',
                'model'          => 'SE 6K ECO',
                'power_kw'       => '6',
                'phase'          => '1 pha',
                'voltage'        => '220/230/240V',
                'warranty_years' => '5',
                'origin'         => 'Trung Quốc',
                'price_from'     => '18000000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Công suất AC: 6000W – Dòng ra 26A\nLoại: Hybrid (hòa lưới + lưu trữ)\nTương thích: Pin lithium 48V (Pylontech, Dyness...)\nSố MPPT: 2 MPPT độc lập\nĐiện áp PV tối đa: 500VDC\nDải điện áp MPPT: 125–425VDC\nDòng PV đầu vào tối đa: 2 x 12.5A\nDòng sạc/xả tối đa: 135A\nĐiện áp pin hỗ trợ: 40–60VDC\nChống nước và bụi: Chuẩn IP65\nGiao tiếp: RS485 / CAN / WiFi / USB\nBảo hành: 05 năm",
            ),
        ),
        array(
            'category' => 'Biến tần Hybrid',
            'title'    => 'SUNGO 6.2kW AC 9kW PV HE200-7200-F',
            'content'  => 'Inverter Hybrid SUNGO 6.2kW với công suất AC 6200W và có thể nhận công suất PV lên đến 9000W. Sản phẩm có 2 kênh ngõ ra AC độc lập, hỗ trợ nhiều loại pin lithium và lead-acid.',
            'meta'     => array(
                'brand'          => 'SUNGO',
                'model'          => 'HE200-7200-F',
                'power_kw'       => '6.2',
                'phase'          => '1 pha',
                'voltage'        => '230V',
                'warranty_years' => '2',
                'origin'         => 'Trung Quốc',
                'price_from'     => '16500000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Công suất AC: 6200W – Dòng ra 26A\nLoại: Hybrid (hòa lưới + lưu trữ + độc lập)\nTương thích: Pin Lithium 48V (Ebox, Dyness, Pylontech...)\nSố MPPT: 1 MPPT\nCông suất PV tối đa: 9000W\nDòng PV đầu vào: 27A\nĐiện áp PV tối đa: 500VDC\nDải điện áp MPPT: 60–450VDC\nDòng sạc/xả tối đa: 120A\nĐiện áp pin hỗ trợ: 40–60VDC\nNgõ ra AC: 2 kênh độc lập\nHiệu suất: ≥97%\nChống nước, bụi: IP21\nKích thước: 540 × 420 × 210 mm\nTrọng lượng: 11kg\nBảo hành: 02 năm",
            ),
        ),
        array(
            'category' => 'Biến tần Hybrid',
            'title'    => 'Ecergy 6KW ECO',
            'content'  => 'Inverter Hybrid Ecergy 6KW ECO với 2 MPPT độc lập, tương thích nhiều loại pin. Sản phẩm đạt chuẩn chống nước IP65, có thể lắp ngoài trời. Bảo hành 5 năm 1 đổi 1 phân phối bởi Kha Solar.',
            'meta'     => array(
                'brand'          => 'Ecergy',
                'model'          => '6KW ECO',
                'power_kw'       => '6',
                'phase'          => '1 pha',
                'voltage'        => '220/230/240V',
                'warranty_years' => '5',
                'origin'         => 'Trung Quốc',
                'price_from'     => '17500000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Công suất AC: 6.000W – Dòng ra 26A\nLoại: Hybrid (hòa lưới + lưu trữ)\nTương thích: Pin Lithium / Lead Acid 48V\nCông suất sạc/xả tối đa: 6.600W / 6.600W\nDòng sạc/xả tối đa: 135A / 135A\nĐiện áp pin hỗ trợ: 40–60VDC\nCông suất PV tối đa: 9.000W\nĐiện áp PV tối đa: 500VDC\nSố lượng MPPT: 2 MPPT độc lập\nDải điện áp MPPT: 70–480VDC\nDòng PV đầu vào tối đa: 18A x 2 string (36A tổng)\nCấp chống nước – bụi: IP65\nHiệu suất: ≥97%\nBảo hành: 5 năm 1 đổi 1",
            ),
        ),

        // PIN LƯU TRỮ Category
        array(
            'category' => 'Pin lưu trữ',
            'title'    => 'EBOX 16kWh (314Ah - 51.2V)',
            'content'  => 'Pin lưu trữ EBOX 16kWh với dung lượng 314Ah, điện áp 51.2VDC. Sử dụng cell Cornex loại A chính hãng có giấy xuất xưởng. BMS Paceex 200A hỗ trợ Bluetooth/WiFi và cân bằng chủ động. Tương thích với hầu hết các inverter hybrid trên thị trường.',
            'meta'     => array(
                'brand'          => 'EBOX',
                'model'          => 'EBOX 16kWh',
                'power_kw'       => '16',
                'phase'          => '',
                'voltage'        => '51.2VDC',
                'warranty_years' => '5',
                'origin'         => 'Việt Nam',
                'price_from'     => '68000000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Dung lượng danh định: 314Ah\nĐiện áp danh định: 51.2VDC\nCông suất tổng: 16.000Wh\nDung lượng sử dụng (90% DOD): ~14.400Wh\nĐiện áp sạc: 56.8VDC\nĐiện áp xả: 44.8 – 56.8VDC\nDòng sạc tối đa: 200A\nDòng xả tối đa: 200A\nLoại cell: Cornex loại A – có giấy xuất xưởng\nBMS: Paceex 200A – Bluetooth/WiFi\nTương thích: Deye, LumenTree, Lux, Solix, Ecergy, Senergy, Sungo\nKích thước: 900 × 430 × 228 mm\nKhối lượng: 120kg\nMôi trường hoạt động: –10°C → +50°C\nGiao tiếp: RS485 / CAN / Bluetooth / WiFi\nChứng nhận: CO, CQ, VAT, bảo hiểm cháy nổ PVI\nBảo hành: 05 năm chính hãng",
            ),
        ),

        // TỦ ĐIỆN Category
        array(
            'category' => 'Phụ kiện',
            'title'    => 'Tủ điện đấu sẵn cao cấp màu trắng',
            'content'  => 'Tủ điện đấu sẵn cao cấp màu trắng, thiết kế chuyên nghiệp, đầy đủ các thiết bị bảo vệ cần thiết. Phù hợp cho hệ thống điện mặt trời gia đình.',
            'meta'     => array(
                'brand'          => 'Kha Solar',
                'model'          => 'Cabinet White Premium',
                'power_kw'       => '',
                'phase'          => '',
                'voltage'        => '220V',
                'warranty_years' => '2',
                'origin'         => 'Việt Nam',
                'price_from'     => '3500000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Màu sắc: Trắng cao cấp\nVật liệu: Thép phủ sơn tĩnh điện\nĐầy đủ CB, MCB, SPD\nDây đấu chuẩn\nĐã đấu sẵn, sẵn sàng sử dụng\nPhù hợp: Hệ thống gia đình 6-8kW\nBảo hành: 2 năm",
            ),
        ),
        array(
            'category' => 'Phụ kiện',
            'title'    => 'Tủ điện đấu sẵn cho LumenTree 4KW-H & 6KW-H',
            'content'  => 'Tủ điện đấu sẵn chuyên dụng cho inverter LumenTree 4KW-H và 6KW-H. Đấu nối đúng chuẩn kỹ thuật, đảm bảo an toàn và hiệu quả vận hành.',
            'meta'     => array(
                'brand'          => 'Kha Solar',
                'model'          => 'Cabinet LumenTree',
                'power_kw'       => '',
                'phase'          => '',
                'voltage'        => '220V',
                'warranty_years' => '2',
                'origin'         => 'Việt Nam',
                'price_from'     => '3200000',
                'stock_status'   => 'in_stock',
                'key_specs'      => "Tương thích: LumenTree 4KW-H, 6KW-H\nĐầy đủ thiết bị bảo vệ\nCB, MCB, SPD chính hãng\nDây đấu đúng tiết diện\nĐã test sẵn\nBảo hành: 2 năm",
            ),
        ),
    );
}

/**
 * Import real products to WordPress
 */
function khasolar_import_real_products() {
    $products = khasolar_get_real_products_data();
    $imported_count = 0;

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
            if ( ! $term ) {
                // Create category if not exists
                $term_data = wp_insert_term( $product_data['category'], 'solar_category' );
                if ( ! is_wp_error( $term_data ) ) {
                    $term = get_term( $term_data['term_id'], 'solar_category' );
                }
            }

            if ( $term ) {
                wp_set_object_terms( $product_id, $term->term_id, 'solar_category' );
            }

            // Set meta
            foreach ( $product_data['meta'] as $key => $value ) {
                if ( ! empty( $value ) || $value === '0' ) {
                    update_post_meta( $product_id, '_ks_' . $key, $value );
                }
            }

            $imported_count++;
        }
    }

    return $imported_count;
}

/**
 * Add admin menu for importing real products
 */
function khasolar_add_import_menu() {
    add_submenu_page(
        'khasolar-demo',
        __( 'Import Sản phẩm', 'khasolar' ),
        __( 'Import Sản phẩm', 'khasolar' ),
        'manage_options',
        'khasolar-import',
        'khasolar_import_page'
    );
}
add_action( 'admin_menu', 'khasolar_add_import_menu' );

/**
 * Import page
 */
function khasolar_import_page() {
    // Handle import
    if ( isset( $_POST['khasolar_import_products'] ) && check_admin_referer( 'khasolar_import_action', 'khasolar_import_nonce' ) ) {
        $count = khasolar_import_real_products();
        echo '<div class="notice notice-success"><p>' . sprintf( __( 'Đã import thành công %d sản phẩm!', 'khasolar' ), $count ) . '</p></div>';
    }

    $products = khasolar_get_real_products_data();
    ?>
    <div class="wrap">
        <h1><?php _e( 'Import Sản phẩm Thực Tế', 'khasolar' ); ?></h1>

        <div class="card" style="max-width: 900px;">
            <h2><?php _e( 'Danh sách sản phẩm sẽ được import', 'khasolar' ); ?></h2>

            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th><?php _e( 'Tên sản phẩm', 'khasolar' ); ?></th>
                        <th><?php _e( 'Danh mục', 'khasolar' ); ?></th>
                        <th><?php _e( 'Thương hiệu', 'khasolar' ); ?></th>
                        <th><?php _e( 'Công suất', 'khasolar' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $products as $index => $product ) : ?>
                        <tr>
                            <td><?php echo ($index + 1); ?></td>
                            <td><strong><?php echo esc_html( $product['title'] ); ?></strong></td>
                            <td><?php echo esc_html( $product['category'] ); ?></td>
                            <td><?php echo esc_html( $product['meta']['brand'] ); ?></td>
                            <td><?php echo esc_html( $product['meta']['power_kw'] ); ?> <?php echo $product['meta']['power_kw'] ? 'kW' : ''; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p><strong><?php _e( 'Tổng số:', 'khasolar' ); ?></strong> <?php echo count( $products ); ?> <?php _e( 'sản phẩm', 'khasolar' ); ?></p>

            <form method="post" style="margin-top: 20px;">
                <?php wp_nonce_field( 'khasolar_import_action', 'khasolar_import_nonce' ); ?>
                <button type="submit" name="khasolar_import_products" class="button button-primary button-large">
                    <?php _e( 'Import tất cả sản phẩm', 'khasolar' ); ?>
                </button>
            </form>

            <p class="description" style="margin-top: 15px;">
                <?php _e( 'Lưu ý: Các sản phẩm đã tồn tại sẽ không bị import lại (kiểm tra theo tên sản phẩm).', 'khasolar' ); ?>
            </p>
        </div>
    </div>
    <?php
}
