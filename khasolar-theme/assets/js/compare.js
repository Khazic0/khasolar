/**
 * Product Comparison JavaScript
 *
 * @package KhaSolar
 * @since 1.2.0
 */

(function($) {
    'use strict';

    // Cookie management
    const CompareCookie = {
        name: 'khasolar_compare',
        expireDays: 30,

        get: function() {
            const value = '; ' + document.cookie;
            const parts = value.split('; ' + this.name + '=');
            if (parts.length === 2) {
                try {
                    return JSON.parse(decodeURIComponent(parts.pop().split(';').shift()));
                } catch(e) {
                    return [];
                }
            }
            return [];
        },

        set: function(productIds) {
            const expires = new Date();
            expires.setTime(expires.getTime() + (this.expireDays * 24 * 60 * 60 * 1000));
            document.cookie = this.name + '=' + encodeURIComponent(JSON.stringify(productIds)) +
                            ';expires=' + expires.toUTCString() + ';path=/';
        },

        clear: function() {
            document.cookie = this.name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';
        }
    };

    // Comparison functionality
    const CompareProducts = {
        init: function() {
            this.bindEvents();
            this.updateCompareBar();
            this.updateCompareButtons();
        },

        bindEvents: function() {
            const self = this;

            // Add to compare buttons
            $(document).on('click', '.add-to-compare', function(e) {
                e.preventDefault();
                const productId = $(this).data('product-id');
                self.addProduct(productId, $(this));
            });

            // Remove from compare
            $(document).on('click', '.compare-product-remove, .compare-product-remove-btn', function(e) {
                e.preventDefault();
                const productId = $(this).data('product-id');
                self.removeProduct(productId);
            });

            // Clear all
            $(document).on('click', '#compare-clear-all', function(e) {
                e.preventDefault();
                self.clearAll();
            });

            // Close compare bar
            $(document).on('click', '.compare-bar-close', function(e) {
                e.preventDefault();
                $('#khasolar-compare-bar').removeClass('is-visible');
            });

            // View comparison
            $(document).on('click', '#compare-view-btn', function(e) {
                const productIds = CompareCookie.get();
                if (productIds.length < 2) {
                    e.preventDefault();
                    alert(khasolarCompare.strings.min_products);
                }
            });

            // Print comparison
            $(document).on('click', '#compare-print', function(e) {
                e.preventDefault();
                window.print();
            });
        },

        addProduct: function(productId, $button) {
            let productIds = CompareCookie.get();

            // Check if already added
            if (productIds.includes(productId)) {
                this.showNotice(khasolarCompare.strings.added, 'info');
                return;
            }

            // Check max limit
            if (productIds.length >= 4) {
                this.showNotice(khasolarCompare.strings.max_products, 'error');
                return;
            }

            // Add to array
            productIds.push(productId);
            CompareCookie.set(productIds);

            // Update UI
            this.updateCompareBar();
            this.updateCompareButtons();
            this.showNotice(khasolarCompare.strings.added, 'success');

            // Show compare bar
            $('#khasolar-compare-bar').addClass('is-visible has-products');
        },

        removeProduct: function(productId) {
            let productIds = CompareCookie.get();
            productIds = productIds.filter(id => id !== productId);
            CompareCookie.set(productIds);

            // Update UI
            this.updateCompareBar();
            this.updateCompareButtons();
            this.showNotice(khasolarCompare.strings.removed, 'info');

            // Hide bar if empty
            if (productIds.length === 0) {
                $('#khasolar-compare-bar').removeClass('is-visible has-products');

                // Reload page if on compare page
                if (window.location.href.includes('so-sanh-san-pham')) {
                    window.location.reload();
                }
            } else if (window.location.href.includes('so-sanh-san-pham') && productIds.length < 2) {
                // Reload if less than 2 products on compare page
                window.location.reload();
            }
        },

        clearAll: function() {
            if (confirm('Bạn có chắc muốn xóa tất cả sản phẩm khỏi danh sách so sánh?')) {
                CompareCookie.clear();
                this.updateCompareBar();
                this.updateCompareButtons();
                $('#khasolar-compare-bar').removeClass('is-visible has-products');

                // Reload page if on compare page
                if (window.location.href.includes('so-sanh-san-pham')) {
                    window.location.reload();
                }
            }
        },

        updateCompareBar: function() {
            const productIds = CompareCookie.get();
            const $compareBar = $('#khasolar-compare-bar');
            const $productsList = $('#compare-products-list');

            // Update count
            $('#compare-count').text(productIds.length);
            $compareBar.attr('data-count', productIds.length);

            // If no products, show empty message
            if (productIds.length === 0) {
                $productsList.html('<p class="compare-empty-message">' +
                    'Chưa có sản phẩm nào. Nhấn "So sánh" ở sản phẩm bạn muốn so sánh.' +
                    '</p>');
                $compareBar.removeClass('has-products');
                return;
            }

            $compareBar.addClass('has-products');

            // Fetch product data via AJAX
            $.ajax({
                url: khasolarCompare.ajax_url,
                type: 'POST',
                data: {
                    action: 'khasolar_get_compare_data',
                    nonce: khasolarCompare.nonce,
                    product_ids: productIds
                },
                success: function(response) {
                    if (response.success && response.data.products) {
                        let html = '';
                        response.data.products.forEach(function(product) {
                            html += '<div class="compare-product-item" data-product-id="' + product.id + '">';
                            if (product.image) {
                                html += '<div class="compare-product-image">';
                                html += '<img src="' + product.image + '" alt="' + product.title + '">';
                                html += '</div>';
                            }
                            html += '<div class="compare-product-info">';
                            html += '<h5>' + product.title + '</h5>';
                            html += '</div>';
                            html += '<button type="button" class="compare-product-remove" data-product-id="' + product.id + '">';
                            html += '<span class="dashicons dashicons-no"></span>';
                            html += '</button>';
                            html += '</div>';
                        });
                        $productsList.html(html);
                    }
                }
            });
        },

        updateCompareButtons: function() {
            const productIds = CompareCookie.get();

            $('.add-to-compare').each(function() {
                const $btn = $(this);
                const productId = $btn.data('product-id');

                if (productIds.includes(productId)) {
                    $btn.addClass('is-comparing');
                    $btn.find('.compare-text').text(khasolarCompare.strings.remove_from_compare);
                } else {
                    $btn.removeClass('is-comparing');
                    $btn.find('.compare-text').text(khasolarCompare.strings.add_to_compare);
                }
            });
        },

        showNotice: function(message, type) {
            // Create notice element
            const $notice = $('<div class="compare-notice-popup ' + type + '">' + message + '</div>');

            // Append to body
            $('body').append($notice);

            // Show with animation
            setTimeout(function() {
                $notice.addClass('show');
            }, 100);

            // Hide after 3 seconds
            setTimeout(function() {
                $notice.removeClass('show');
                setTimeout(function() {
                    $notice.remove();
                }, 300);
            }, 3000);
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        CompareProducts.init();

        // Show compare bar if has products
        const productIds = CompareCookie.get();
        if (productIds.length > 0) {
            setTimeout(function() {
                $('#khasolar-compare-bar').addClass('is-visible');
            }, 1000);
        }
    });

})(jQuery);
