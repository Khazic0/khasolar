<?php
/**
 * The template for displaying archive pages
 *
 * @package KhaSolar
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">

    <div class="page-header">
        <div class="container">
            <?php khasolar_breadcrumb(); ?>
            <h1 class="page-title">
                <?php
                the_archive_title();
                ?>
            </h1>
            <?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
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
                <h2><?php _e( 'Không tìm thấy kết quả', 'khasolar' ); ?></h2>
                <p><?php _e( 'Xin lỗi, chúng tôi không tìm thấy nội dung nào.', 'khasolar' ); ?></p>
            </div>

        <?php endif; ?>
    </div>

</main><!-- #primary -->

<?php
get_footer();
