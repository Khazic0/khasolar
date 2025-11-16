<?php
/**
 * Template part for displaying product reviews
 *
 * @package KhaSolar
 * @since 1.2.0
 */

$product_id = get_the_ID();
$rating = khasolar_get_product_rating( $product_id );
$review_count = khasolar_get_product_review_count( $product_id );
$reviews = khasolar_get_product_reviews( $product_id, 20 );
$distribution = khasolar_get_rating_distribution( $product_id );

// Get review message if any
$review_message = khasolar_get_review_message();
?>

<div id="reviews" class="product-reviews-section">
    <h2 class="section-title"><?php _e( 'Đánh giá sản phẩm', 'khasolar' ); ?></h2>

    <?php if ( $review_message ) : ?>
        <div class="review-message <?php echo esc_attr( $review_message['type'] ); ?>">
            <?php echo esc_html( $review_message['message'] ); ?>
        </div>
    <?php endif; ?>

    <div class="reviews-container">
        <!-- Rating Summary -->
        <div class="rating-summary">
            <div class="overall-rating">
                <div class="rating-number-large"><?php echo number_format( $rating, 1 ); ?></div>
                <div class="rating-stars-large">
                    <?php echo khasolar_display_stars( $rating, false ); ?>
                </div>
                <div class="rating-count">
                    <?php printf( _n( '%d đánh giá', '%d đánh giá', $review_count, 'khasolar' ), $review_count ); ?>
                </div>
            </div>

            <?php if ( $review_count > 0 ) : ?>
                <div class="rating-distribution">
                    <?php foreach ( $distribution as $stars => $count ) : ?>
                        <?php
                        $percentage = $review_count > 0 ? ( $count / $review_count ) * 100 : 0;
                        ?>
                        <div class="rating-bar">
                            <span class="stars-label"><?php echo $stars; ?> <span class="star">★</span></span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo esc_attr( $percentage ); ?>%;"></div>
                            </div>
                            <span class="count-label"><?php echo $count; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Review Form -->
        <div class="review-form-container">
            <h3><?php _e( 'Viết đánh giá của bạn', 'khasolar' ); ?></h3>

            <form method="post" action="" class="review-form">
                <?php wp_nonce_field( 'khasolar_submit_review', 'khasolar_review_nonce' ); ?>
                <input type="hidden" name="product_id" value="<?php echo esc_attr( $product_id ); ?>">

                <!-- Honeypot -->
                <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">

                <div class="form-row">
                    <label for="review_rating" class="required"><?php _e( 'Đánh giá của bạn', 'khasolar' ); ?></label>
                    <div class="star-rating-input">
                        <input type="radio" name="review_rating" id="star5" value="5" required>
                        <label for="star5" class="star">★</label>
                        <input type="radio" name="review_rating" id="star4" value="4">
                        <label for="star4" class="star">★</label>
                        <input type="radio" name="review_rating" id="star3" value="3">
                        <label for="star3" class="star">★</label>
                        <input type="radio" name="review_rating" id="star2" value="2">
                        <label for="star2" class="star">★</label>
                        <input type="radio" name="review_rating" id="star1" value="1">
                        <label for="star1" class="star">★</label>
                    </div>
                </div>

                <div class="form-row">
                    <label for="review_name" class="required"><?php _e( 'Họ và tên', 'khasolar' ); ?></label>
                    <input type="text" name="review_name" id="review_name" required>
                </div>

                <div class="form-row">
                    <label for="review_email" class="required"><?php _e( 'Email', 'khasolar' ); ?></label>
                    <input type="email" name="review_email" id="review_email" required>
                </div>

                <div class="form-row">
                    <label for="review_text"><?php _e( 'Nội dung đánh giá', 'khasolar' ); ?></label>
                    <textarea name="review_text" id="review_text" rows="5" placeholder="<?php _e( 'Chia sẻ trải nghiệm của bạn về sản phẩm này...', 'khasolar' ); ?>"></textarea>
                </div>

                <div class="form-row">
                    <button type="submit" name="khasolar_review_submit" class="btn btn-primary">
                        <?php _e( 'Gửi đánh giá', 'khasolar' ); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reviews List -->
    <?php if ( ! empty( $reviews ) ) : ?>
        <div class="reviews-list">
            <h3><?php _e( 'Đánh giá từ khách hàng', 'khasolar' ); ?></h3>

            <?php foreach ( $reviews as $review ) : ?>
                <div class="review-item">
                    <div class="review-header">
                        <div class="reviewer-info">
                            <div class="reviewer-avatar">
                                <?php echo substr( $review->customer_name, 0, 1 ); ?>
                            </div>
                            <div class="reviewer-details">
                                <strong class="reviewer-name"><?php echo esc_html( $review->customer_name ); ?></strong>
                                <div class="review-meta">
                                    <?php echo khasolar_display_stars( $review->rating, false ); ?>
                                    <span class="review-date"><?php echo human_time_diff( strtotime( $review->created_at ), current_time( 'timestamp' ) ) . ' ' . __( 'trước', 'khasolar' ); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ( $review->review_text ) : ?>
                        <div class="review-content">
                            <?php echo nl2br( esc_html( $review->review_text ) ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
