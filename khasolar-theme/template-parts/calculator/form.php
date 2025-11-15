<?php
/**
 * ROI Calculator Form Template
 *
 * @package KhaSolar
 * @since 1.1.0
 */

$title = isset( $atts['title'] ) ? $atts['title'] : __( 'Tính toán tiết kiệm với điện mặt trời', 'khasolar' );
$show_contact = isset( $atts['show_contact_form'] ) ? $atts['show_contact_form'] === 'true' : false;
?>

<div class="khasolar-calculator-widget">
    <div class="calculator-header">
        <h3 class="calculator-title"><?php echo esc_html( $title ); ?></h3>
        <p class="calculator-subtitle">
            <?php _e( 'Xem ngay bạn có thể tiết kiệm bao nhiêu tiền điện mỗi năm', 'khasolar' ); ?>
        </p>
    </div>

    <form id="khasolar-calculator-form" class="calculator-form">
        <?php wp_nonce_field( 'khasolar_calculator_nonce', 'calculator_nonce' ); ?>

        <div class="calculator-inputs">
            <div class="calc-field">
                <label for="calc_monthly_bill">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                    <?php _e( 'Hóa đơn điện hàng tháng', 'khasolar' ); ?>
                </label>
                <div class="calc-input-group">
                    <input
                        type="number"
                        id="calc_monthly_bill"
                        name="monthly_bill"
                        placeholder="2000000"
                        min="100000"
                        max="50000000"
                        step="100000"
                        required
                    >
                    <span class="calc-unit">VNĐ</span>
                </div>
                <small class="calc-hint"><?php _e( 'Ví dụ: 2,000,000 VNĐ', 'khasolar' ); ?></small>
            </div>

            <div class="calc-field">
                <label for="calc_system_size">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                    <?php _e( 'Công suất hệ thống dự kiến', 'khasolar' ); ?>
                </label>
                <div class="calc-input-group">
                    <input
                        type="number"
                        id="calc_system_size"
                        name="system_size"
                        placeholder="6"
                        min="1"
                        max="100"
                        step="0.5"
                        required
                    >
                    <span class="calc-unit">kWp</span>
                </div>
                <small class="calc-hint"><?php _e( 'Ví dụ: 6 kWp cho hộ gia đình', 'khasolar' ); ?></small>
            </div>

            <div class="calc-field calc-field-optional">
                <label for="calc_system_cost">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                    <?php _e( 'Chi phí đầu tư (tùy chọn)', 'khasolar' ); ?>
                </label>
                <div class="calc-input-group">
                    <input
                        type="number"
                        id="calc_system_cost"
                        name="system_cost"
                        placeholder="78000000"
                        min="0"
                        step="1000000"
                    >
                    <span class="calc-unit">VNĐ</span>
                </div>
                <small class="calc-hint"><?php _e( 'Để trống để tự động ước tính', 'khasolar' ); ?></small>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-large btn-block calculator-submit">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            <?php _e( 'Tính toán ngay', 'khasolar' ); ?>
        </button>
    </form>

    <!-- Results Section (Hidden by default) -->
    <div id="calculator-results" class="calculator-results" style="display: none;">
        <div class="results-header">
            <h4><?php _e( 'Kết quả tính toán', 'khasolar' ); ?></h4>
        </div>

        <div class="results-grid">
            <div class="result-card result-highlight">
                <div class="result-icon">💰</div>
                <div class="result-label"><?php _e( 'Tiết kiệm mỗi năm', 'khasolar' ); ?></div>
                <div class="result-value" id="result-yearly-savings">-</div>
            </div>

            <div class="result-card result-highlight">
                <div class="result-icon">⏱️</div>
                <div class="result-label"><?php _e( 'Thời gian hoàn vốn', 'khasolar' ); ?></div>
                <div class="result-value" id="result-payback">-</div>
            </div>

            <div class="result-card">
                <div class="result-label"><?php _e( 'Tiết kiệm mỗi tháng', 'khasolar' ); ?></div>
                <div class="result-value" id="result-monthly-savings">-</div>
            </div>

            <div class="result-card">
                <div class="result-label"><?php _e( 'Chi phí đầu tư', 'khasolar' ); ?></div>
                <div class="result-value" id="result-system-cost">-</div>
            </div>

            <div class="result-card">
                <div class="result-label"><?php _e( 'Sản lượng điện/năm', 'khasolar' ); ?></div>
                <div class="result-value" id="result-production">-</div>
            </div>

            <div class="result-card">
                <div class="result-label"><?php _e( 'Lợi nhuận sau 20 năm', 'khasolar' ); ?></div>
                <div class="result-value" id="result-profit">-</div>
            </div>
        </div>

        <div class="results-benefits">
            <h5><?php _e( 'Lợi ích môi trường', 'khasolar' ); ?></h5>
            <div class="benefit-item">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 3h18v18H3zM12 8v8m-4-4h8"></path>
                </svg>
                <span><?php _e( 'Giảm', 'khasolar' ); ?> <strong id="result-co2">-</strong> kg CO2/năm</span>
            </div>
            <div class="benefit-item">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2v20M2 12h20"></path>
                </svg>
                <span><?php _e( 'Tương đương trồng', 'khasolar' ); ?> <strong id="result-trees">-</strong> <?php _e( 'cây xanh', 'khasolar' ); ?></span>
            </div>
        </div>

        <div class="results-actions">
            <button type="button" class="btn btn-primary" id="btn-get-quote">
                <?php _e( 'Nhận báo giá chi tiết', 'khasolar' ); ?>
            </button>
            <button type="button" class="btn btn-secondary-outline" id="btn-recalculate">
                <?php _e( 'Tính toán lại', 'khasolar' ); ?>
            </button>
        </div>
    </div>

    <!-- Contact Form (Shown when clicking "Get Quote") -->
    <div id="calculator-contact-form" class="calculator-contact-form" style="display: none;">
        <h4><?php _e( 'Nhận báo giá chi tiết', 'khasolar' ); ?></h4>
        <p><?php _e( 'Để lại thông tin, chúng tôi sẽ gửi báo giá chi tiết và tư vấn miễn phí', 'khasolar' ); ?></p>

        <form id="calculator-quote-form">
            <div class="form-row">
                <div class="form-field">
                    <input type="text" name="customer_name" placeholder="<?php _e( 'Họ và tên *', 'khasolar' ); ?>" required>
                </div>
                <div class="form-field">
                    <input type="tel" name="customer_phone" placeholder="<?php _e( 'Số điện thoại *', 'khasolar' ); ?>" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">
                <?php _e( 'Gửi yêu cầu báo giá', 'khasolar' ); ?>
            </button>
        </form>
    </div>

    <!-- Loading State -->
    <div class="calculator-loading" style="display: none;">
        <div class="loading-spinner"></div>
        <p><?php _e( 'Đang tính toán...', 'khasolar' ); ?></p>
    </div>
</div>
