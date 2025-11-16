/**
 * Kha Solar Cart Functionality
 *
 * @package Kha Solar
 * @version 1.3.0
 */

(function($) {
    'use strict';

    // Cart object
    const KhaSolarCart = {
        init: function() {
            this.bindEvents();
            this.updateCartCount();
        },

        bindEvents: function() {
            // Add to cart button
            $(document).on('click', '.add-to-cart-btn', this.addToCart.bind(this));

            // Remove from cart
            $(document).on('click', '.remove-from-cart', this.removeFromCart.bind(this));

            // Update quantity
            $(document).on('change', '.cart-quantity-input', this.updateQuantity.bind(this));

            // Clear cart
            $(document).on('click', '.clear-cart-btn', this.clearCart.bind(this));

            // Quantity increment/decrement
            $(document).on('click', '.qty-btn-minus', this.decrementQuantity.bind(this));
            $(document).on('click', '.qty-btn-plus', this.incrementQuantity.bind(this));
        },

        addToCart: function(e) {
            e.preventDefault();

            const $button = $(e.currentTarget);
            const productId = $button.data('product-id');
            const quantity = $button.data('quantity') || 1;

            // Disable button
            $button.prop('disabled', true).addClass('loading');

            $.ajax({
                url: khasolarData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'khasolar_add_to_cart',
                    nonce: khasolarData.nonce,
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        // Update cart count
                        KhaSolarCart.updateCartCount(response.data.cart_count);

                        // Show success message
                        KhaSolarCart.showNotification(response.data.message, 'success');

                        // Add animation to button
                        $button.addClass('added');
                        setTimeout(function() {
                            $button.removeClass('added');
                        }, 2000);
                    } else {
                        KhaSolarCart.showNotification(response.data.message, 'error');
                    }
                },
                error: function() {
                    KhaSolarCart.showNotification('Có lỗi xảy ra. Vui lòng thử lại.', 'error');
                },
                complete: function() {
                    $button.prop('disabled', false).removeClass('loading');
                }
            });
        },

        removeFromCart: function(e) {
            e.preventDefault();

            if (!confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                return;
            }

            const $button = $(e.currentTarget);
            const productId = $button.data('product-id');
            const $row = $button.closest('.cart-item');

            $.ajax({
                url: khasolarData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'khasolar_remove_from_cart',
                    nonce: khasolarData.nonce,
                    product_id: productId
                },
                success: function(response) {
                    if (response.success) {
                        // Remove row with animation
                        $row.fadeOut(300, function() {
                            $(this).remove();

                            // Check if cart is empty
                            if ($('.cart-item').length === 0) {
                                location.reload();
                            }
                        });

                        // Update cart count
                        KhaSolarCart.updateCartCount(response.data.cart_count);

                        KhaSolarCart.showNotification(response.data.message, 'success');
                    } else {
                        KhaSolarCart.showNotification(response.data.message, 'error');
                    }
                },
                error: function() {
                    KhaSolarCart.showNotification('Có lỗi xảy ra. Vui lòng thử lại.', 'error');
                }
            });
        },

        updateQuantity: function(e) {
            const $input = $(e.currentTarget);
            const productId = $input.data('product-id');
            const quantity = parseInt($input.val()) || 1;

            // Ensure minimum quantity is 1
            if (quantity < 1) {
                $input.val(1);
                return;
            }

            $.ajax({
                url: khasolarData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'khasolar_update_cart_quantity',
                    nonce: khasolarData.nonce,
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        // Update cart count
                        KhaSolarCart.updateCartCount(response.data.cart_count);

                        // Reload to update totals (simple approach)
                        location.reload();
                    } else {
                        KhaSolarCart.showNotification(response.data.message, 'error');
                    }
                },
                error: function() {
                    KhaSolarCart.showNotification('Có lỗi xảy ra. Vui lòng thử lại.', 'error');
                }
            });
        },

        clearCart: function(e) {
            e.preventDefault();

            if (!confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')) {
                return;
            }

            $.ajax({
                url: khasolarData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'khasolar_clear_cart',
                    nonce: khasolarData.nonce
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function() {
                    KhaSolarCart.showNotification('Có lỗi xảy ra. Vui lòng thử lại.', 'error');
                }
            });
        },

        decrementQuantity: function(e) {
            e.preventDefault();
            const $button = $(e.currentTarget);
            const $input = $button.siblings('.cart-quantity-input');
            const currentValue = parseInt($input.val()) || 1;

            if (currentValue > 1) {
                $input.val(currentValue - 1).trigger('change');
            }
        },

        incrementQuantity: function(e) {
            e.preventDefault();
            const $button = $(e.currentTarget);
            const $input = $button.siblings('.cart-quantity-input');
            const currentValue = parseInt($input.val()) || 1;

            $input.val(currentValue + 1).trigger('change');
        },

        updateCartCount: function(count) {
            const $cartCount = $('.cart-count');

            if (typeof count === 'undefined') {
                // Get count from server if not provided
                return;
            }

            $cartCount.text(count);

            if (count > 0) {
                $cartCount.addClass('has-items');
            } else {
                $cartCount.removeClass('has-items');
            }
        },

        showNotification: function(message, type) {
            // Remove existing notifications
            $('.cart-notification').remove();

            // Create notification element
            const $notification = $('<div class="cart-notification ' + type + '">' + message + '</div>');

            // Append to body
            $('body').append($notification);

            // Trigger animation
            setTimeout(function() {
                $notification.addClass('show');
            }, 10);

            // Auto hide after 3 seconds
            setTimeout(function() {
                $notification.removeClass('show');
                setTimeout(function() {
                    $notification.remove();
                }, 300);
            }, 3000);
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        KhaSolarCart.init();
    });

})(jQuery);
