<?php
/**
 * Product Gallery Management
 * Similar to WooCommerce product gallery
 *
 * @package Kha Solar
 * @version 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add Product Gallery Meta Box
 */
function khasolar_add_product_gallery_meta_box() {
    add_meta_box(
        'khasolar_product_gallery',
        'Thư viện ảnh sản phẩm',
        'khasolar_product_gallery_callback',
        'solar_product',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'khasolar_add_product_gallery_meta_box' );

/**
 * Product Gallery Meta Box Callback
 */
function khasolar_product_gallery_callback( $post ) {
    wp_nonce_field( 'khasolar_product_gallery_nonce', 'khasolar_product_gallery_nonce' );

    $gallery_images = get_post_meta( $post->ID, '_product_gallery_images', true );
    $gallery_ids = ! empty( $gallery_images ) ? explode( ',', $gallery_images ) : array();
    ?>

    <div class="khasolar-gallery-manager">
        <div class="gallery-instructions">
            <p><strong>Hướng dẫn:</strong></p>
            <ul>
                <li>Ảnh đại diện sản phẩm được đặt trong "Ảnh đại diện" bên phải</li>
                <li>Thêm nhiều ảnh sản phẩm vào gallery này để hiển thị dạng slider</li>
                <li>Kéo thả để sắp xếp thứ tự ảnh</li>
                <li>Gallery sẽ hiển thị giống WooCommerce với thumbnails và lightbox</li>
            </ul>
        </div>

        <div class="gallery-images-container">
            <ul class="gallery-images" id="gallery-images-list">
                <?php
                if ( ! empty( $gallery_ids ) ) {
                    foreach ( $gallery_ids as $image_id ) {
                        if ( wp_attachment_is_image( $image_id ) ) {
                            $image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
                            ?>
                            <li class="gallery-image" data-attachment-id="<?php echo esc_attr( $image_id ); ?>">
                                <img src="<?php echo esc_url( $image[0] ); ?>" alt="" />
                                <button type="button" class="remove-image" title="Xóa ảnh">×</button>
                                <div class="drag-handle" title="Kéo để sắp xếp">⋮⋮</div>
                            </li>
                            <?php
                        }
                    }
                }
                ?>
            </ul>

            <div class="add-gallery-images">
                <button type="button" class="button button-primary" id="add-gallery-images">
                    <span class="dashicons dashicons-images-alt2"></span>
                    Thêm ảnh vào gallery
                </button>
                <p class="description">Khuyến nghị: Tải lên ít nhất 3-5 ảnh sản phẩm từ nhiều góc độ khác nhau</p>
            </div>
        </div>

        <input type="hidden" name="product_gallery_images" id="product_gallery_images" value="<?php echo esc_attr( $gallery_images ); ?>" />
    </div>

    <style>
        .khasolar-gallery-manager {
            padding: 10px 0;
        }

        .gallery-instructions {
            background: #f0f6fc;
            border-left: 4px solid #0073aa;
            padding: 15px;
            margin-bottom: 20px;
        }

        .gallery-instructions ul {
            margin: 10px 0 0 20px;
        }

        .gallery-instructions li {
            margin: 5px 0;
            color: #555;
        }

        .gallery-images-container {
            background: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .gallery-images {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 15px;
            list-style: none;
            margin: 0 0 20px 0;
            padding: 0;
            min-height: 120px;
        }

        .gallery-image {
            position: relative;
            border: 2px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            cursor: move;
            transition: all 0.3s;
            background: #f9f9f9;
            aspect-ratio: 1;
        }

        .gallery-image:hover {
            border-color: #0073aa;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .gallery-image.ui-sortable-helper {
            opacity: 0.8;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .gallery-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .gallery-image .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(220, 53, 69, 0.9);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            font-size: 18px;
            line-height: 1;
            opacity: 0;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-image:hover .remove-image {
            opacity: 1;
        }

        .gallery-image .remove-image:hover {
            background: #dc3545;
            transform: scale(1.1);
        }

        .gallery-image .drag-handle {
            position: absolute;
            top: 5px;
            left: 5px;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
            opacity: 0;
            transition: all 0.3s;
            pointer-events: none;
        }

        .gallery-image:hover .drag-handle {
            opacity: 1;
        }

        .add-gallery-images {
            text-align: center;
            padding: 20px;
            border: 2px dashed #ddd;
            border-radius: 4px;
            background: #fafafa;
        }

        .add-gallery-images .button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            padding: 8px 20px;
        }

        .add-gallery-images .description {
            margin-top: 10px;
            color: #666;
        }
    </style>

    <script>
    jQuery(document).ready(function($) {
        // Make gallery sortable
        $('#gallery-images-list').sortable({
            items: 'li',
            cursor: 'move',
            scrollSensitivity: 40,
            forcePlaceholderSize: true,
            forceHelperSize: false,
            helper: 'clone',
            opacity: 0.65,
            placeholder: 'gallery-sortable-placeholder',
            start: function(event, ui) {
                ui.item.css('background-color', '#f6f6f6');
            },
            stop: function(event, ui) {
                ui.item.removeAttr('style');
            },
            update: function() {
                updateGalleryInput();
            }
        });

        // Add images to gallery
        $('#add-gallery-images').on('click', function(e) {
            e.preventDefault();

            var galleryFrame;

            if (galleryFrame) {
                galleryFrame.open();
                return;
            }

            galleryFrame = wp.media({
                title: 'Chọn ảnh cho gallery sản phẩm',
                button: {
                    text: 'Thêm vào gallery'
                },
                multiple: true
            });

            galleryFrame.on('select', function() {
                var selection = galleryFrame.state().get('selection');

                selection.map(function(attachment) {
                    attachment = attachment.toJSON();

                    if (attachment.type === 'image') {
                        var imageHtml = '<li class="gallery-image" data-attachment-id="' + attachment.id + '">' +
                            '<img src="' + attachment.sizes.thumbnail.url + '" alt="" />' +
                            '<button type="button" class="remove-image" title="Xóa ảnh">×</button>' +
                            '<div class="drag-handle" title="Kéo để sắp xếp">⋮⋮</div>' +
                            '</li>';

                        $('#gallery-images-list').append(imageHtml);
                    }
                });

                updateGalleryInput();
            });

            galleryFrame.open();
        });

        // Remove image from gallery
        $(document).on('click', '.gallery-image .remove-image', function(e) {
            e.preventDefault();

            if (confirm('Bạn có chắc muốn xóa ảnh này khỏi gallery?')) {
                $(this).closest('.gallery-image').fadeOut(300, function() {
                    $(this).remove();
                    updateGalleryInput();
                });
            }
        });

        // Update hidden input with gallery IDs
        function updateGalleryInput() {
            var galleryIds = [];

            $('#gallery-images-list .gallery-image').each(function() {
                galleryIds.push($(this).data('attachment-id'));
            });

            $('#product_gallery_images').val(galleryIds.join(','));
        }
    });
    </script>
    <?php
}

/**
 * Save Product Gallery
 */
function khasolar_save_product_gallery( $post_id ) {
    // Check nonce
    if ( ! isset( $_POST['khasolar_product_gallery_nonce'] ) ||
         ! wp_verify_nonce( $_POST['khasolar_product_gallery_nonce'], 'khasolar_product_gallery_nonce' ) ) {
        return;
    }

    // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save gallery images
    if ( isset( $_POST['product_gallery_images'] ) ) {
        $gallery_images = sanitize_text_field( $_POST['product_gallery_images'] );
        update_post_meta( $post_id, '_product_gallery_images', $gallery_images );

        // Auto-set featured image from first gallery image if no featured image exists
        if ( ! has_post_thumbnail( $post_id ) && ! empty( $gallery_images ) ) {
            $image_ids = explode( ',', $gallery_images );
            $first_image_id = isset( $image_ids[0] ) ? intval( $image_ids[0] ) : 0;

            if ( $first_image_id > 0 ) {
                set_post_thumbnail( $post_id, $first_image_id );
            }
        }
    } else {
        delete_post_meta( $post_id, '_product_gallery_images' );
    }
}
add_action( 'save_post_solar_product', 'khasolar_save_product_gallery' );

/**
 * Get Product Gallery Images
 *
 * @param int $product_id Product ID
 * @return array Array of image IDs
 */
function khasolar_get_product_gallery_images( $product_id ) {
    $gallery_images = get_post_meta( $product_id, '_product_gallery_images', true );

    if ( empty( $gallery_images ) ) {
        return array();
    }

    $image_ids = explode( ',', $gallery_images );
    $image_ids = array_filter( $image_ids );

    return $image_ids;
}

/**
 * Display Product Gallery (for frontend)
 *
 * @param int $product_id Product ID
 */
function khasolar_display_product_gallery( $product_id ) {
    $gallery_ids = khasolar_get_product_gallery_images( $product_id );
    $main_image_id = get_post_thumbnail_id( $product_id );

    // Combine main image with gallery
    $all_images = array();
    if ( $main_image_id ) {
        $all_images[] = $main_image_id;
    }
    $all_images = array_merge( $all_images, $gallery_ids );
    $all_images = array_unique( $all_images );

    if ( empty( $all_images ) ) {
        // No images, show placeholder
        ?>
        <div class="product-gallery-placeholder">
            <svg width="200" height="200" viewBox="0 0 200 200" fill="none">
                <rect width="200" height="200" fill="#f0f0f0"/>
                <path d="M100 70L120 90L140 70L160 90L160 130L40 130L40 90L60 70L80 90L100 70Z" fill="#d0d0d0"/>
                <circle cx="70" cy="95" r="8" fill="#b0b0b0"/>
            </svg>
            <p>Chưa có hình ảnh</p>
        </div>
        <?php
        return;
    }

    ?>
    <div class="khasolar-product-gallery">
        <!-- Main Image -->
        <div class="gallery-main-image">
            <?php
            $first_image = $all_images[0];
            $image_url = wp_get_attachment_image_url( $first_image, 'large' );
            $image_full = wp_get_attachment_image_url( $first_image, 'full' );
            ?>
            <div class="main-image-wrapper" data-image-id="<?php echo esc_attr( $first_image ); ?>">
                <img src="<?php echo esc_url( $image_url ); ?>"
                     alt="<?php echo esc_attr( get_the_title() ); ?>"
                     class="main-product-image"
                     data-large="<?php echo esc_url( $image_full ); ?>" />

                <button class="gallery-lightbox-trigger" title="Click để phóng to">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="M21 21l-4.35-4.35"/>
                        <line x1="11" y1="8" x2="11" y2="14"/>
                        <line x1="8" y1="11" x2="14" y2="11"/>
                    </svg>
                </button>
            </div>
        </div>

        <?php if ( count( $all_images ) > 1 ) : ?>
        <!-- Thumbnail Gallery -->
        <div class="gallery-thumbnails">
            <button class="thumbnail-nav prev" disabled>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </button>

            <div class="thumbnails-container">
                <div class="thumbnails-track">
                    <?php foreach ( $all_images as $index => $image_id ) :
                        $thumb_url = wp_get_attachment_image_url( $image_id, 'thumbnail' );
                        $large_url = wp_get_attachment_image_url( $image_id, 'large' );
                        $full_url = wp_get_attachment_image_url( $image_id, 'full' );
                        ?>
                        <div class="thumbnail-item<?php echo $index === 0 ? ' active' : ''; ?>"
                             data-image-id="<?php echo esc_attr( $image_id ); ?>"
                             data-large="<?php echo esc_url( $large_url ); ?>"
                             data-full="<?php echo esc_url( $full_url ); ?>">
                            <img src="<?php echo esc_url( $thumb_url ); ?>" alt="" />
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <button class="thumbnail-nav next">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </button>
        </div>
        <?php endif; ?>
    </div>

    <!-- Lightbox Modal -->
    <div class="khasolar-lightbox" id="product-lightbox">
        <div class="lightbox-overlay"></div>
        <div class="lightbox-container">
            <button class="lightbox-close">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>

            <button class="lightbox-nav lightbox-prev">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </button>

            <div class="lightbox-image-container">
                <img src="" alt="" class="lightbox-image" />
                <div class="lightbox-counter">
                    <span class="current-image">1</span> / <span class="total-images"><?php echo count( $all_images ); ?></span>
                </div>
            </div>

            <button class="lightbox-nav lightbox-next">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </button>
        </div>
    </div>
    <?php
}
