<?php
/**
 * Template part for displaying a project card
 *
 * @package KhaSolar
 * @since 1.0.0
 */

$project_id = get_the_ID();
$location   = get_post_meta( $project_id, '_ks_project_location', true );
$capacity   = get_post_meta( $project_id, '_ks_project_capacity_kwp', true );
$type       = get_post_meta( $project_id, '_ks_project_type', true );
?>

<div class="project-card">
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="project-card-image">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'khasolar-project-thumb' ); ?>
            </a>
            <?php if ( $type ) : ?>
                <span class="project-type-badge"><?php echo esc_html( $type ); ?></span>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <div class="project-card-image project-card-placeholder">
            <a href="<?php the_permalink(); ?>">
                <img src="<?php echo esc_url( khasolar_get_placeholder_image() ); ?>" alt="<?php the_title_attribute(); ?>">
            </a>
        </div>
    <?php endif; ?>

    <div class="project-card-content">
        <h3 class="project-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <div class="project-card-meta">
            <?php if ( $location ) : ?>
                <div class="project-meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <span><?php echo esc_html( $location ); ?></span>
                </div>
            <?php endif; ?>

            <?php if ( $capacity ) : ?>
                <div class="project-meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                    <span><?php echo esc_html( $capacity ); ?> kWp</span>
                </div>
            <?php endif; ?>
        </div>

        <?php if ( has_excerpt() ) : ?>
            <div class="project-card-excerpt">
                <?php echo wp_trim_words( get_the_excerpt(), 15 ); ?>
            </div>
        <?php endif; ?>

        <a href="<?php the_permalink(); ?>" class="project-view-link">
            <?php _e( 'Xem chi tiết', 'khasolar' ); ?> →
        </a>
    </div>
</div>
