<?php
/**
 * Single Package Template
 */
get_header(); ?>

<main class="site-main">

    <?php while (have_posts()): the_post(); ?>

    <!-- Package Header -->
    <section class="package-header">
        <?php if (has_post_thumbnail()): ?>
            <div class="package-header-bg" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>')"></div>
            <div class="package-header-overlay"></div>
        <?php endif; ?>

        <div class="package-header-content">
            <div class="container">
                <?php
                $location = get_post_meta(get_the_ID(), '_package_location', true);
                if ($location):
                ?>
                    <span class="package-location-badge">
                        <i class="fas fa-map-marker-alt"></i> <?php echo esc_html($location); ?>
                    </span>
                <?php endif; ?>

                <h1 class="package-title"><?php the_title(); ?></h1>

                <div class="package-header-meta">
                    <?php
                    $duration = get_post_meta(get_the_ID(), '_package_duration', true);
                    $price = get_post_meta(get_the_ID(), '_package_price', true);
                    ?>

                    <?php if ($duration): ?>
                        <span class="package-meta-item">
                            <i class="far fa-clock"></i> <?php echo esc_html($duration); ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($price): ?>
                        <span class="package-meta-item">
                            <i class="fas fa-tag"></i> Starting from ₹<?php echo number_format($price); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Package Content -->
    <section class="package-content-section">
        <div class="container">
            <div class="package-layout">

                <!-- Main Content -->
                <div class="package-main">
                    <div class="package-description">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Sidebar -->
                <aside class="package-sidebar">
                    <div class="package-booking-card">
                        <h3>Package Details</h3>

                        <?php
                        $price = get_post_meta(get_the_ID(), '_package_price', true);
                        $old_price = get_post_meta(get_the_ID(), '_package_old_price', true);
                        $duration = get_post_meta(get_the_ID(), '_package_duration', true);
                        $location = get_post_meta(get_the_ID(), '_package_location', true);
                        $discount = get_post_meta(get_the_ID(), '_package_discount', true);
                        ?>

                        <div class="booking-price">
                            <?php if ($old_price): ?>
                                <span class="price-old">₹<?php echo number_format($old_price); ?></span>
                            <?php endif; ?>
                            <?php if ($price): ?>
                                <span class="price-current">₹<?php echo number_format($price); ?></span>
                            <?php endif; ?>
                            <?php if ($discount): ?>
                                <span class="price-discount"><?php echo esc_html($discount); ?></span>
                            <?php endif; ?>
                        </div>

                        <ul class="booking-details">
                            <?php if ($duration): ?>
                                <li>
                                    <i class="far fa-clock"></i>
                                    <span>Duration:</span>
                                    <strong><?php echo esc_html($duration); ?></strong>
                                </li>
                            <?php endif; ?>

                            <?php if ($location): ?>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>Location:</span>
                                    <strong><?php echo esc_html($location); ?></strong>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary btn-block">Book Now</a>
                        <a href="tel:<?php echo esc_attr(get_theme_mod('contact_phone', '+91 12345 67890')); ?>" class="btn-outline btn-block">
                            <i class="fas fa-phone-alt"></i> Call Us
                        </a>
                    </div>
                </aside>

            </div>
        </div>
    </section>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>