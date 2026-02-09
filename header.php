<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <?php tadoba_social_links(); ?>
                <a href="tel:<?php echo esc_attr(get_theme_mod('contact_phone', '+91 12345 67890')); ?>" class="header-contact">
                    <i class="fas fa-phone-alt"></i> <?php echo esc_html(get_theme_mod('contact_phone', '+91 12345 67890')); ?>
                </a>
            </div>

            <div class="header-center">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                        <span class="logo-text"><?php bloginfo('name'); ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <div class="header-right">
                <a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email', 'info@tadoba.com')); ?>" class="header-contact">
                    <i class="fas fa-envelope"></i> <?php echo esc_html(get_theme_mod('contact_email', 'info@tadoba.com')); ?>
                </a>
                <button class="mobile-menu-toggle" id="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="header-divider"></div>

    <div class="header-bottom">
        <div class="container">
            <nav class="main-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'nav-menu',
                    'fallback_cb' => function() {
                        echo '<ul class="nav-menu">';
                        echo '<li class="current-menu-item"><a href="' . home_url('/') . '">Home</a></li>';
                        echo '<li><a href="' . home_url('/about') . '">About Us</a></li>';
                        echo '<li><a href="' . home_url('/packages') . '">Packages</a></li>';
                        echo '<li><a href="' . home_url('/resorts') . '">Resorts</a></li>';
                        echo '<li><a href="' . home_url('/contact') . '">Contact</a></li>';
                        echo '</ul>';
                    }
                ));
                ?>
            </nav>
            <div class="header-btn">
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary-small">Book Now</a>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Menu -->
<div class="mobile-menu-overlay" id="mobile-menu">
    <div class="mobile-menu-inner">
        <button class="mobile-menu-close" id="mobile-menu-close">
            <i class="fas fa-times"></i>
        </button>
        <nav class="mobile-nav">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'mobile-nav-menu',
                'fallback_cb' => function() {
                    echo '<ul class="mobile-nav-menu">';
                    echo '<li><a href="' . home_url('/') . '">Home</a></li>';
                    echo '<li><a href="' . home_url('/about') . '">About Us</a></li>';
                    echo '<li><a href="' . home_url('/packages') . '">Packages</a></li>';
                    echo '<li><a href="' . home_url('/resorts') . '">Resorts</a></li>';
                    echo '<li><a href="' . home_url('/contact') . '">Contact</a></li>';
                    echo '</ul>';
                }
            ));
            ?>
        </nav>
        <div class="mobile-menu-footer">
            <?php tadoba_social_links(); ?>
        </div>
    </div>
</div>