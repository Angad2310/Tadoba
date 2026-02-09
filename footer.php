
<footer class="site-footer">
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <?php if (is_active_sidebar('footer-1')): ?>
                        <?php dynamic_sidebar('footer-1'); ?>
                    <?php else: ?>
                        <h3>About Us</h3>
                        <p><?php bloginfo('description'); ?></p>
                        <?php tadoba_social_links(); ?>
                    <?php endif; ?>
                </div>

                <div class="footer-col">
                    <?php if (is_active_sidebar('footer-2')): ?>
                        <?php dynamic_sidebar('footer-2'); ?>
                    <?php else: ?>
                        <h3>Quick Links</h3>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'container' => false,
                            'menu_class' => 'footer-menu',
                            'fallback_cb' => function() {
                                echo '<ul class="footer-menu">';
                                echo '<li><a href="' . home_url('/') . '">Home</a></li>';
                                echo '<li><a href="' . home_url('/about') . '">About</a></li>';
                                echo '<li><a href="' . home_url('/packages') . '">Packages</a></li>';
                                echo '<li><a href="' . home_url('/contact') . '">Contact</a></li>';
                                echo '</ul>';
                            }
                        ));
                        ?>
                    <?php endif; ?>
                </div>

                <div class="footer-col">
                    <?php if (is_active_sidebar('footer-3')): ?>
                        <?php dynamic_sidebar('footer-3'); ?>
                    <?php else: ?>
                        <h3>Contact Us</h3>
                        <ul class="footer-contact">
                            <li>
                                <i class="fas fa-phone-alt"></i>
                                <a href="tel:<?php echo esc_attr(get_theme_mod('contact_phone', '+91 12345 67890')); ?>">
                                    <?php echo esc_html(get_theme_mod('contact_phone', '+91 12345 67890')); ?>
                                </a>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email', 'info@tadoba.com')); ?>">
                                    <?php echo esc_html(get_theme_mod('contact_email', 'info@tadoba.com')); ?>
                                </a>
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Tadoba Andhari Tiger Reserve, Maharashtra</span>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>