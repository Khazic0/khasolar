/**
 * Kha Solar Theme - Main JavaScript
 * Version: 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Scroll to top button
     */
    function initScrollToTop() {
        const scrollButton = $('#scroll-to-top');

        if (scrollButton.length) {
            // Show/hide button based on scroll position
            $(window).on('scroll', function() {
                if ($(this).scrollTop() > 300) {
                    scrollButton.addClass('visible');
                } else {
                    scrollButton.removeClass('visible');
                }
            });

            // Smooth scroll to top on click
            scrollButton.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, 600);
            });
        }
    }

    /**
     * Smooth scroll for anchor links
     */
    function initSmoothScroll() {
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            const target = $(this.hash);

            if (target.length) {
                e.preventDefault();

                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 600);
            }
        });
    }

    /**
     * Mobile menu toggle
     */
    function initMobileMenu() {
        const menuToggle = $('.mobile-menu-toggle');
        const navigation = $('.main-navigation');

        menuToggle.on('click', function() {
            $(this).toggleClass('active');
            navigation.toggleClass('active');

            // Toggle aria-expanded
            const expanded = $(this).attr('aria-expanded') === 'true';
            $(this).attr('aria-expanded', !expanded);
        });

        // Close menu on window resize if desktop
        $(window).on('resize', function() {
            if ($(window).width() > 992) {
                navigation.removeClass('active');
                menuToggle.removeClass('active').attr('aria-expanded', 'false');
            }
        });
    }

    /**
     * Search toggle
     */
    function initSearchToggle() {
        const searchToggle = $('.search-toggle');
        const searchForm = $('.header-search-form');

        searchToggle.on('click', function() {
            searchForm.slideToggle(300);

            // Focus search field when opened
            if (searchForm.is(':visible')) {
                searchForm.find('.search-field').focus();
            }
        });

        // Close search on click outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-toggle, .header-search-form').length) {
                searchForm.slideUp(300);
            }
        });
    }

    /**
     * Sticky header on scroll
     */
    function initStickyHeader() {
        const header = $('.main-header');
        const headerOffset = header.offset().top;

        $(window).on('scroll', function() {
            if ($(this).scrollTop() > headerOffset) {
                header.addClass('sticky');
            } else {
                header.removeClass('sticky');
            }
        });
    }

    /**
     * Form validation enhancement
     */
    function initFormValidation() {
        // Add visual feedback for form fields
        $('input, textarea, select').on('blur', function() {
            if ($(this).val() !== '') {
                $(this).addClass('filled');
            } else {
                $(this).removeClass('filled');
            }
        });

        // Check if already filled on page load
        $('input, textarea, select').each(function() {
            if ($(this).val() !== '') {
                $(this).addClass('filled');
            }
        });
    }

    /**
     * Lazy load images (simple implementation)
     */
    function initLazyLoad() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img.lazy').forEach(function(img) {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Add animation on scroll (fade in elements)
     */
    function initScrollAnimations() {
        if ('IntersectionObserver' in window) {
            const animateObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            // Observe elements that should animate
            document.querySelectorAll('.product-card, .project-card, .blog-card, .category-card').forEach(function(el) {
                animateObserver.observe(el);
            });
        }
    }

    /**
     * Product archive filters (basic toggle)
     */
    function initProductFilters() {
        $('.filter-toggle').on('click', function() {
            $(this).next('.filter-content').slideToggle();
            $(this).toggleClass('active');
        });
    }

    /**
     * Star rating display (if needed)
     */
    function initRatings() {
        $('.rating').each(function() {
            const rating = $(this).data('rating');
            const stars = $(this).find('.star');

            stars.each(function(index) {
                if (index < rating) {
                    $(this).addClass('filled');
                }
            });
        });
    }

    /**
     * Initialize all functions
     */
    function init() {
        initScrollToTop();
        initSmoothScroll();
        initMobileMenu();
        initSearchToggle();
        initStickyHeader();
        initFormValidation();
        initLazyLoad();
        initScrollAnimations();
        initProductFilters();
        initRatings();

        // Log initialization (remove in production)
        console.log('Kha Solar Theme JavaScript initialized');
    }

    /**
     * Document ready
     */
    $(document).ready(function() {
        init();
    });

    /**
     * Window load
     */
    $(window).on('load', function() {
        // Remove preloader if exists
        $('.preloader').fadeOut();
    });

})(jQuery);
