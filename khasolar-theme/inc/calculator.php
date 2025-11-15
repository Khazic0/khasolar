<?php
/**
 * Solar ROI Calculator
 * Tính toán tiết kiệm điện và thời gian hoàn vốn
 *
 * @package KhaSolar
 * @since 1.1.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Calculate solar savings
 *
 * @param float $monthly_bill Hóa đơn điện hàng tháng (VNĐ)
 * @param float $system_size Công suất hệ thống (kWp)
 * @param float $system_cost Chi phí hệ thống (VNĐ) - optional
 * @return array Calculation results
 */
function khasolar_calculate_savings( $monthly_bill, $system_size, $system_cost = 0 ) {

    // Constants for Vietnam
    $avg_electricity_price = 2500; // VNĐ/kWh (average)
    $sun_hours_per_day = 4.5; // Average sun hours in Vietnam
    $system_efficiency = 0.85; // 85% efficiency
    $electricity_price_increase = 0.08; // 8% increase per year

    // Calculate monthly consumption (kWh)
    $monthly_consumption = $monthly_bill / $avg_electricity_price;

    // Calculate system production
    $daily_production = $system_size * $sun_hours_per_day * $system_efficiency; // kWh/day
    $monthly_production = $daily_production * 30; // kWh/month
    $yearly_production = $daily_production * 365; // kWh/year

    // Calculate savings
    $monthly_savings = min( $monthly_production, $monthly_consumption ) * $avg_electricity_price;
    $yearly_savings = $monthly_savings * 12;

    // Estimate system cost if not provided
    if ( $system_cost <= 0 ) {
        // Average cost: 13,000,000 VNĐ/kWp for complete system
        $system_cost = $system_size * 13000000;
    }

    // Calculate payback period (simple calculation)
    $payback_years = $system_cost / $yearly_savings;

    // Calculate 20-year savings (accounting for electricity price increase)
    $total_20year_savings = 0;
    for ( $year = 1; $year <= 20; $year++ ) {
        $yearly_price = $avg_electricity_price * pow( 1 + $electricity_price_increase, $year - 1 );
        $total_20year_savings += min( $yearly_production, $monthly_consumption * 12 ) * $yearly_price;
    }

    $net_profit_20years = $total_20year_savings - $system_cost;

    return array(
        'monthly_consumption'   => round( $monthly_consumption, 1 ),
        'monthly_production'    => round( $monthly_production, 1 ),
        'yearly_production'     => round( $yearly_production, 1 ),
        'monthly_savings'       => round( $monthly_savings, -3 ), // Round to thousands
        'yearly_savings'        => round( $yearly_savings, -3 ),
        'system_cost'           => round( $system_cost, -3 ),
        'payback_years'         => round( $payback_years, 1 ),
        'payback_months'        => round( $payback_years * 12, 0 ),
        'total_20year_savings'  => round( $total_20year_savings, -3 ),
        'net_profit_20years'    => round( $net_profit_20years, -3 ),
        'co2_reduction_yearly'  => round( $yearly_production * 0.5, 1 ), // 0.5 kg CO2/kWh
    );
}

/**
 * Handle calculator form submission via AJAX
 */
function khasolar_ajax_calculate() {

    // Check nonce
    check_ajax_referer( 'khasolar_calculator_nonce', 'nonce' );

    // Get and validate inputs
    $monthly_bill = isset( $_POST['monthly_bill'] ) ? floatval( $_POST['monthly_bill'] ) : 0;
    $system_size = isset( $_POST['system_size'] ) ? floatval( $_POST['system_size'] ) : 0;
    $system_cost = isset( $_POST['system_cost'] ) ? floatval( $_POST['system_cost'] ) : 0;

    // Validate
    if ( $monthly_bill <= 0 || $system_size <= 0 ) {
        wp_send_json_error( array(
            'message' => __( 'Vui lòng nhập đầy đủ thông tin hợp lệ.', 'khasolar' ),
        ) );
    }

    // Calculate
    $results = khasolar_calculate_savings( $monthly_bill, $system_size, $system_cost );

    // Optional: Save calculation to leads table for follow-up
    if ( isset( $_POST['save_calculation'] ) && $_POST['save_calculation'] === 'true' ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'khasolar_leads';

        $name = isset( $_POST['customer_name'] ) ? sanitize_text_field( $_POST['customer_name'] ) : '';
        $phone = isset( $_POST['customer_phone'] ) ? sanitize_text_field( $_POST['customer_phone'] ) : '';

        if ( ! empty( $name ) && ! empty( $phone ) ) {
            $note = sprintf(
                "Tính toán ROI: Hóa đơn %s VNĐ/tháng, Hệ thống %s kWp, Tiết kiệm %s VNĐ/năm, Hoàn vốn %s năm",
                number_format( $monthly_bill, 0, ',', '.' ),
                $system_size,
                number_format( $results['yearly_savings'], 0, ',', '.' ),
                $results['payback_years']
            );

            $wpdb->insert(
                $table_name,
                array(
                    'product_id'    => 0,
                    'product_title' => 'ROI Calculator',
                    'name'          => $name,
                    'phone'         => $phone,
                    'location'      => '',
                    'note'          => $note,
                    'created_at'    => current_time( 'mysql' ),
                ),
                array( '%d', '%s', '%s', '%s', '%s', '%s', '%s' )
            );
        }
    }

    wp_send_json_success( $results );
}
add_action( 'wp_ajax_khasolar_calculate', 'khasolar_ajax_calculate' );
add_action( 'wp_ajax_nopriv_khasolar_calculate', 'khasolar_ajax_calculate' );

/**
 * Shortcode for calculator
 * Usage: [khasolar_calculator]
 */
function khasolar_calculator_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'title' => __( 'Tính toán tiết kiệm với điện mặt trời', 'khasolar' ),
        'show_contact_form' => 'false',
    ), $atts );

    ob_start();
    include get_template_directory() . '/template-parts/calculator/form.php';
    return ob_get_clean();
}
add_shortcode( 'khasolar_calculator', 'khasolar_calculator_shortcode' );
