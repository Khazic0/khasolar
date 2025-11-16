/**
 * Kha Solar Product Gallery
 * WooCommerce-style product gallery with lightbox
 *
 * @package Kha Solar
 * @version 1.2.0
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProductGallery);
    } else {
        initProductGallery();
    }

    function initProductGallery() {
        const gallery = document.querySelector('.khasolar-product-gallery');
        if (!gallery) return;

        const mainImage = gallery.querySelector('.main-product-image');
        const thumbnails = gallery.querySelectorAll('.thumbnail-item');
        const thumbnailsTrack = gallery.querySelector('.thumbnails-track');
        const prevBtn = gallery.querySelector('.thumbnail-nav.prev');
        const nextBtn = gallery.querySelector('.thumbnail-nav.next');
        const lightboxTrigger = gallery.querySelector('.gallery-lightbox-trigger');

        // Lightbox elements
        const lightbox = document.getElementById('product-lightbox');
        if (!lightbox) return;

        const lightboxImage = lightbox.querySelector('.lightbox-image');
        const lightboxClose = lightbox.querySelector('.lightbox-close');
        const lightboxOverlay = lightbox.querySelector('.lightbox-overlay');
        const lightboxPrev = lightbox.querySelector('.lightbox-prev');
        const lightboxNext = lightbox.querySelector('.lightbox-next');
        const currentCounter = lightbox.querySelector('.current-image');
        const totalCounter = lightbox.querySelector('.total-images');

        let currentIndex = 0;
        const totalImages = thumbnails.length;
        let isLightboxOpen = false;

        // Thumbnail navigation
        if (thumbnails.length > 0) {
            updateThumbnailNavigation();

            // Click thumbnail to change main image
            thumbnails.forEach((thumbnail, index) => {
                thumbnail.addEventListener('click', () => {
                    setActiveImage(index);
                });
            });

            // Prev/Next buttons for thumbnails
            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    scrollThumbnails('prev');
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    scrollThumbnails('next');
                });
            }

            // Update navigation on scroll
            if (thumbnailsTrack) {
                thumbnailsTrack.addEventListener('scroll', () => {
                    updateThumbnailNavigation();
                }, { passive: true });
            }
        }

        // Open lightbox
        if (lightboxTrigger) {
            lightboxTrigger.addEventListener('click', () => {
                openLightbox(currentIndex);
            });
        }

        // Click main image to open lightbox
        if (mainImage) {
            mainImage.addEventListener('click', () => {
                openLightbox(currentIndex);
            });
            mainImage.style.cursor = 'pointer';
        }

        // Close lightbox
        if (lightboxClose) {
            lightboxClose.addEventListener('click', closeLightbox);
        }

        if (lightboxOverlay) {
            lightboxOverlay.addEventListener('click', closeLightbox);
        }

        // Lightbox navigation
        if (lightboxPrev) {
            lightboxPrev.addEventListener('click', () => {
                navigateLightbox('prev');
            });
        }

        if (lightboxNext) {
            lightboxNext.addEventListener('click', () => {
                navigateLightbox('next');
            });
        }

        // Keyboard navigation
        document.addEventListener('keydown', handleKeyboard);

        // Touch/swipe support for lightbox
        let touchStartX = 0;
        let touchEndX = 0;

        if (lightbox) {
            lightbox.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            lightbox.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            }, { passive: true });
        }

        function setActiveImage(index) {
            if (index < 0 || index >= totalImages) return;

            currentIndex = index;

            // Update main image
            const thumbnail = thumbnails[index];
            const largeUrl = thumbnail.dataset.large;
            const fullUrl = thumbnail.dataset.full;

            if (mainImage && largeUrl) {
                // Fade effect
                mainImage.style.opacity = '0';
                setTimeout(() => {
                    mainImage.src = largeUrl;
                    mainImage.dataset.large = fullUrl;
                    mainImage.style.opacity = '1';
                }, 150);
            }

            // Update active thumbnail
            thumbnails.forEach(t => t.classList.remove('active'));
            thumbnail.classList.add('active');

            // Scroll thumbnail into view if needed
            scrollThumbnailIntoView(index);
        }

        function scrollThumbnails(direction) {
            if (!thumbnailsTrack) return;

            const scrollAmount = 120; // Width of one thumbnail + gap
            const currentScroll = thumbnailsTrack.scrollLeft;

            if (direction === 'prev') {
                thumbnailsTrack.scrollLeft = currentScroll - scrollAmount;
            } else {
                thumbnailsTrack.scrollLeft = currentScroll + scrollAmount;
            }

            setTimeout(updateThumbnailNavigation, 100);
        }

        function scrollThumbnailIntoView(index) {
            if (!thumbnailsTrack || !thumbnails[index]) return;

            const thumbnail = thumbnails[index];
            const trackRect = thumbnailsTrack.getBoundingClientRect();
            const thumbRect = thumbnail.getBoundingClientRect();

            // Check if thumbnail is outside visible area
            if (thumbRect.left < trackRect.left || thumbRect.right > trackRect.right) {
                thumbnail.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            }

            setTimeout(updateThumbnailNavigation, 100);
        }

        function updateThumbnailNavigation() {
            if (!thumbnailsTrack || !prevBtn || !nextBtn) return;

            const isAtStart = thumbnailsTrack.scrollLeft <= 0;
            const isAtEnd = thumbnailsTrack.scrollLeft >= (thumbnailsTrack.scrollWidth - thumbnailsTrack.clientWidth - 5);

            prevBtn.disabled = isAtStart;
            nextBtn.disabled = isAtEnd;

            // Update scroll indicators
            const container = thumbnailsTrack.closest('.thumbnails-container');
            if (container) {
                if (isAtStart) {
                    container.classList.remove('scrolled');
                } else {
                    container.classList.add('scrolled');
                }

                if (isAtEnd) {
                    container.classList.add('scrolled-end');
                } else {
                    container.classList.remove('scrolled-end');
                }
            }
        }

        function openLightbox(index) {
            if (!lightbox || !thumbnails[index]) return;

            currentIndex = index;
            isLightboxOpen = true;

            const fullUrl = thumbnails[index].dataset.full;
            lightboxImage.src = fullUrl;

            if (currentCounter) currentCounter.textContent = index + 1;
            if (totalCounter) totalCounter.textContent = totalImages;

            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';

            updateLightboxButtons();
        }

        function closeLightbox() {
            if (!lightbox) return;

            isLightboxOpen = false;
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }

        function navigateLightbox(direction) {
            if (!isLightboxOpen) return;

            let newIndex = currentIndex;

            if (direction === 'prev') {
                newIndex = currentIndex > 0 ? currentIndex - 1 : totalImages - 1;
            } else {
                newIndex = currentIndex < totalImages - 1 ? currentIndex + 1 : 0;
            }

            currentIndex = newIndex;

            const fullUrl = thumbnails[newIndex].dataset.full;
            lightboxImage.src = fullUrl;

            if (currentCounter) currentCounter.textContent = newIndex + 1;

            // Also update main gallery
            setActiveImage(newIndex);

            updateLightboxButtons();
        }

        function updateLightboxButtons() {
            // Enable/disable buttons based on position
            if (lightboxPrev) {
                lightboxPrev.style.opacity = currentIndex === 0 ? '0.3' : '1';
            }
            if (lightboxNext) {
                lightboxNext.style.opacity = currentIndex === totalImages - 1 ? '0.3' : '1';
            }
        }

        function handleKeyboard(e) {
            if (!isLightboxOpen) return;

            switch(e.key) {
                case 'Escape':
                    closeLightbox();
                    break;
                case 'ArrowLeft':
                    navigateLightbox('prev');
                    break;
                case 'ArrowRight':
                    navigateLightbox('next');
                    break;
            }
        }

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) < swipeThreshold) return;

            if (diff > 0) {
                // Swipe left - next image
                navigateLightbox('next');
            } else {
                // Swipe right - prev image
                navigateLightbox('prev');
            }
        }

        // Image zoom on hover (optional enhancement)
        if (mainImage) {
            let isZoomed = false;

            mainImage.addEventListener('mouseenter', () => {
                if (isLightboxOpen) return;
                mainImage.style.transition = 'transform 0.3s ease';
            });

            mainImage.addEventListener('mousemove', (e) => {
                if (isLightboxOpen) return;

                const rect = mainImage.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;

                mainImage.style.transformOrigin = `${x}% ${y}%`;

                if (!isZoomed) {
                    mainImage.style.transform = 'scale(1.5)';
                    isZoomed = true;
                }
            });

            mainImage.addEventListener('mouseleave', () => {
                mainImage.style.transform = 'scale(1)';
                mainImage.style.transformOrigin = 'center';
                isZoomed = false;
            });
        }
    }

    // Lazy load images in gallery
    function lazyLoadGalleryImages() {
        const galleryImages = document.querySelectorAll('.khasolar-product-gallery img[data-src]');

        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        observer.unobserve(img);
                    }
                });
            });

            galleryImages.forEach(img => imageObserver.observe(img));
        } else {
            // Fallback for browsers without IntersectionObserver
            galleryImages.forEach(img => {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
            });
        }
    }

    lazyLoadGalleryImages();
})();
