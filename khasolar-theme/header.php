<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php _e( 'Chuyển đến nội dung', 'khasolar' ); ?></a>

    <header id="masthead" class="site-header">
        <?php get_template_part( 'template-parts/header/topbar' ); ?>
        <?php get_template_part( 'template-parts/header/navbar' ); ?>
    </header>

    <div id="content" class="site-content">
