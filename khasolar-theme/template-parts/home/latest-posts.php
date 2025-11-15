<?php
/**
 * Template part for displaying latest blog posts
 *
 * @package KhaSolar
 * @since 1.0.0
 */

// Query latest posts
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$posts_query = new WP_Query( $args );
?>

<section class="latest-posts-section">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title"><?php _e( 'Kiến thức & Kinh nghiệm', 'khasolar' ); ?></h2>
            <p class="section-subtitle"><?php _e( 'Cập nhật thông tin và hướng dẫn về năng lượng mặt trời', 'khasolar' ); ?></p>
        </div>

        <?php if ( $posts_query->have_posts() ) : ?>
            <div class="blog-grid">
                <?php
                while ( $posts_query->have_posts() ) :
                    $posts_query->the_post();
                    ?>
                    <article class="blog-card">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="blog-card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'khasolar-blog-thumb' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="blog-card-content">
                            <div class="blog-card-meta">
                                <span class="blog-date"><?php echo get_the_date(); ?></span>
                                <?php
                                $categories = get_the_category();
                                if ( ! empty( $categories ) ) :
                                    ?>
                                    <span class="blog-category">
                                        <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>">
                                            <?php echo esc_html( $categories[0]->name ); ?>
                                        </a>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <h3 class="blog-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="blog-card-excerpt">
                                <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="blog-read-more">
                                <?php _e( 'Đọc thêm', 'khasolar' ); ?> →
                            </a>
                        </div>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>

            <div class="section-footer text-center">
                <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="btn btn-secondary">
                    <?php _e( 'Xem tất cả bài viết', 'khasolar' ); ?>
                </a>
            </div>

        <?php else : ?>
            <div class="no-posts">
                <p><?php _e( 'Hiện chưa có bài viết nào.', 'khasolar' ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
