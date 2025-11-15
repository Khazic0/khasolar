<?php
/**
 * The template for displaying search results
 *
 * @package KhaSolar
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">

    <div class="page-header">
        <div class="container">
            <h1 class="page-title">
                <?php
                printf(
                    esc_html__( 'Kết quả tìm kiếm cho: %s', 'khasolar' ),
                    '<span>' . get_search_query() . '</span>'
                );
                ?>
            </h1>
        </div>
    </div>

    <div class="container">
        <?php if ( have_posts() ) : ?>

            <div class="search-results">
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <article class="search-result-item">
                        <h3 class="result-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>

                        <div class="result-meta">
                            <span class="result-type">
                                <?php
                                $post_type = get_post_type();
                                $post_type_obj = get_post_type_object( $post_type );
                                echo esc_html( $post_type_obj->labels->singular_name );
                                ?>
                            </span>
                            <span class="meta-separator">•</span>
                            <span class="result-date"><?php echo get_the_date(); ?></span>
                        </div>

                        <div class="result-excerpt">
                            <?php echo wp_trim_words( get_the_excerpt(), 30 ); ?>
                        </div>

                        <a href="<?php the_permalink(); ?>" class="result-link">
                            <?php _e( 'Xem chi tiết', 'khasolar' ); ?> →
                        </a>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>

            <?php khasolar_pagination(); ?>

        <?php else : ?>

            <div class="no-results">
                <h2><?php _e( 'Không tìm thấy kết quả', 'khasolar' ); ?></h2>
                <p><?php _e( 'Xin lỗi, chúng tôi không tìm thấy kết quả nào phù hợp với từ khóa của bạn. Vui lòng thử lại với từ khóa khác.', 'khasolar' ); ?></p>

                <div class="search-again">
                    <form role="search" method="get" class="search-form-large" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="search" class="search-field" placeholder="<?php _e( 'Tìm kiếm lại...', 'khasolar' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                        <button type="submit" class="btn btn-primary">
                            <?php _e( 'Tìm kiếm', 'khasolar' ); ?>
                        </button>
                    </form>
                </div>
            </div>

        <?php endif; ?>
    </div>

</main><!-- #primary -->

<?php
get_footer();
