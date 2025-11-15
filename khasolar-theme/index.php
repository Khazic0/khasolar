<?php
/**
 * The main template file
 * This is the fallback template for displaying all content
 *
 * @package KhaSolar
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">

    <div class="page-header">
        <div class="container">
            <h1 class="page-title"><?php _e( 'Blog', 'khasolar' ); ?></h1>
        </div>
    </div>

    <div class="container">
        <?php if ( have_posts() ) : ?>

            <div class="blog-grid">
                <?php
                while ( have_posts() ) :
                    the_post();
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
                ?>
            </div>

            <?php khasolar_pagination(); ?>

        <?php else : ?>

            <div class="no-results">
                <h2><?php _e( 'Chưa có bài viết nào', 'khasolar' ); ?></h2>
                <p><?php _e( 'Hãy quay lại sau để xem nội dung mới.', 'khasolar' ); ?></p>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                    <?php _e( 'Về trang chủ', 'khasolar' ); ?>
                </a>
            </div>

        <?php endif; ?>
    </div>

</main><!-- #primary -->

<?php
get_footer();
