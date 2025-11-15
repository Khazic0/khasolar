<?php
/**
 * Template part for displaying the top bar
 *
 * @package KhaSolar
 * @since 1.0.0
 */
?>

<div class="top-bar">
    <div class="container">
        <div class="top-bar-content">
            <div class="top-bar-left">
                <span class="topbar-item topbar-email">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <a href="mailto:<?php echo esc_attr( khasolar_get_email() ); ?>">
                        <?php echo esc_html( khasolar_get_email() ); ?>
                    </a>
                </span>
            </div>

            <div class="top-bar-center">
                <span class="topbar-item topbar-phone">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <a href="tel:<?php echo esc_attr( str_replace( ' ', '', khasolar_get_phone() ) ); ?>">
                        <?php echo esc_html( khasolar_get_phone() ); ?>
                    </a>
                </span>
            </div>

            <div class="top-bar-right">
                <span class="topbar-item topbar-hours">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <?php echo esc_html( khasolar_get_working_hours() ); ?>
                </span>
            </div>
        </div>
    </div>
</div>
