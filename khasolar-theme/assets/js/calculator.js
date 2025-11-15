/**
 * Solar ROI Calculator JavaScript
 * Version: 1.1.0
 */

(function($) {
    'use strict';

    /**
     * Calculator Handler
     */
    const KhaSolarCalculator = {

        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            const self = this;

            // Form submission
            $('#khasolar-calculator-form').on('submit', function(e) {
                e.preventDefault();
                self.calculate();
            });

            // Recalculate button
            $(document).on('click', '#btn-recalculate', function() {
                self.resetCalculator();
            });

            // Get quote button
            $(document).on('click', '#btn-get-quote', function() {
                self.showContactForm();
            });

            // Quote form submission
            $(document).on('submit', '#calculator-quote-form', function(e) {
                e.preventDefault();
                self.submitQuote();
            });

            // Auto-format number inputs
            $('input[type="number"]').on('blur', function() {
                const value = $(this).val();
                if (value) {
                    $(this).val(parseFloat(value));
                }
            });
        },

        calculate: function() {
            const self = this;
            const form = $('#khasolar-calculator-form');
            const monthlyBill = parseFloat($('#calc_monthly_bill').val());
            const systemSize = parseFloat($('#calc_system_size').val());
            const systemCost = parseFloat($('#calc_system_cost').val()) || 0;

            // Validation
            if (!monthlyBill || !systemSize) {
                alert('Vui lòng nhập đầy đủ thông tin!');
                return;
            }

            if (monthlyBill < 100000) {
                alert('Hóa đơn điện quá thấp. Vui lòng nhập lại!');
                return;
            }

            if (systemSize < 1 || systemSize > 100) {
                alert('Công suất hệ thống không hợp lệ!');
                return;
            }

            // Show loading
            $('.calculator-loading').show();
            form.hide();

            // AJAX call
            $.ajax({
                url: khasolarData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'khasolar_calculate',
                    nonce: $('#calculator_nonce').val(),
                    monthly_bill: monthlyBill,
                    system_size: systemSize,
                    system_cost: systemCost
                },
                success: function(response) {
                    $('.calculator-loading').hide();

                    if (response.success) {
                        self.displayResults(response.data);
                    } else {
                        alert(response.data.message || 'Có lỗi xảy ra. Vui lòng thử lại!');
                        form.show();
                    }
                },
                error: function() {
                    $('.calculator-loading').hide();
                    alert('Lỗi kết nối. Vui lòng thử lại!');
                    form.show();
                }
            });
        },

        displayResults: function(data) {
            // Format numbers
            const formatMoney = function(value) {
                return new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND',
                    minimumFractionDigits: 0
                }).format(value);
            };

            const formatNumber = function(value, decimals = 0) {
                return new Intl.NumberFormat('vi-VN', {
                    minimumFractionDigits: decimals,
                    maximumFractionDigits: decimals
                }).format(value);
            };

            // Update result values
            $('#result-yearly-savings').text(formatMoney(data.yearly_savings));
            $('#result-monthly-savings').text(formatMoney(data.monthly_savings));
            $('#result-system-cost').text(formatMoney(data.system_cost));

            // Payback period
            const years = Math.floor(data.payback_years);
            const months = data.payback_months % 12;
            let paybackText = '';
            if (years > 0) {
                paybackText = years + ' năm';
                if (months > 0) {
                    paybackText += ' ' + months + ' tháng';
                }
            } else {
                paybackText = months + ' tháng';
            }
            $('#result-payback').text(paybackText);

            // Production
            $('#result-production').html(formatNumber(data.yearly_production, 1) + ' <small>kWh</small>');

            // 20-year profit
            $('#result-profit').text(formatMoney(data.net_profit_20years));

            // Environmental benefits
            $('#result-co2').text(formatNumber(data.co2_reduction_yearly, 1));

            // Trees equivalent (1 tree absorbs ~20kg CO2/year)
            const trees = Math.round(data.co2_reduction_yearly / 20);
            $('#result-trees').text(trees);

            // Show results
            $('#calculator-results').slideDown(400);

            // Scroll to results
            $('html, body').animate({
                scrollTop: $('#calculator-results').offset().top - 100
            }, 500);
        },

        resetCalculator: function() {
            $('#calculator-results').slideUp(300);
            $('#khasolar-calculator-form').slideDown(400);
            $('#calculator-contact-form').hide();

            // Scroll back to form
            $('html, body').animate({
                scrollTop: $('#khasolar-calculator-form').offset().top - 100
            }, 500);
        },

        showContactForm: function() {
            $('#calculator-contact-form').slideDown(400);

            // Scroll to contact form
            $('html, body').animate({
                scrollTop: $('#calculator-contact-form').offset().top - 100
            }, 500);
        },

        submitQuote: function() {
            const name = $('input[name="customer_name"]').val();
            const phone = $('input[name="customer_phone"]').val();
            const monthlyBill = $('#calc_monthly_bill').val();
            const systemSize = $('#calc_system_size').val();
            const systemCost = $('#calc_system_cost').val() || 0;

            if (!name || !phone) {
                alert('Vui lòng điền đầy đủ thông tin!');
                return;
            }

            // Show loading
            $('.calculator-loading').show();

            // Submit via AJAX
            $.ajax({
                url: khasolarData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'khasolar_calculate',
                    nonce: $('#calculator_nonce').val(),
                    monthly_bill: monthlyBill,
                    system_size: systemSize,
                    system_cost: systemCost,
                    save_calculation: 'true',
                    customer_name: name,
                    customer_phone: phone
                },
                success: function(response) {
                    $('.calculator-loading').hide();

                    if (response.success) {
                        alert('Cảm ơn bạn! Chúng tôi sẽ liên hệ trong thời gian sớm nhất.');
                        $('#calculator-contact-form').slideUp();
                        $('#calculator-quote-form')[0].reset();
                    } else {
                        alert('Có lỗi xảy ra. Vui lòng thử lại!');
                    }
                },
                error: function() {
                    $('.calculator-loading').hide();
                    alert('Lỗi kết nối. Vui lòng thử lại!');
                }
            });
        }
    };

    /**
     * Initialize on document ready
     */
    $(document).ready(function() {
        if ($('#khasolar-calculator-form').length) {
            KhaSolarCalculator.init();
        }
    });

})(jQuery);
