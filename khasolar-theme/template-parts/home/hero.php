<?php
/**
 * Template part for displaying the hero section
 *
 * @package KhaSolar
 * @since 1.0.0
 */
?>

<section class="site-hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">
                <?php _e( 'Giải pháp điện mặt trời cho công trình của bạn', 'khasolar' ); ?>
            </h1>
            <p class="hero-subtitle">
                <?php _e( 'Thiết bị chính hãng - Tư vấn chuyên nghiệp - Bảo hành dài hạn - Hỗ trợ kỹ thuật toàn quốc', 'khasolar' ); ?>
            </p>

            <div class="hero-buttons">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'solar_product' ) ); ?>" class="btn btn-primary btn-large">
                    <?php _e( 'Xem danh mục sản phẩm', 'khasolar' ); ?>
                </a>
                <a href="<?php echo esc_url( home_url( '/lien-he' ) ); ?>" class="btn btn-secondary-outline btn-large">
                    <?php _e( 'Nhận tư vấn miễn phí', 'khasolar' ); ?>
                </a>
            </div>

            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number">10+</div>
                    <div class="stat-label"><?php _e( 'Năm kinh nghiệm', 'khasolar' ); ?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label"><?php _e( 'Công trình hoàn thành', 'khasolar' ); ?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">40+</div>
                    <div class="stat-label"><?php _e( 'Tỉnh thành triển khai', 'khasolar' ); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>
