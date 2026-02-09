<?php
/**
 * Archive Template for Packages
 */
get_header(); ?>

<main class="site-main">

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">All Safari Packages</h1>
            <p class="page-subtitle">Explore our curated safari experiences</p>
        </div>
    </section>

    <!-- Packages Grid -->
    <section class="packages-archive-section">
        <div class="container">

            <div class="packages-grid">
                <?php
                if (have_posts()):
                    while (have_posts()): the_post();
                        $price = get_post_meta(get_the_ID(), '_package_price', true);
                        $old_price = get_post_meta(get_the_ID(), '_package_old_price', true);
                        $duration = get_post_meta(get_the_ID(), '_package_duration', true);
                        $location = get_post_meta(get_the_ID(), '_package_location', true);
                        $discount = get_post_meta(get_the_ID(), '_package_discount', true);
                ?>
                    <div class="package-card">
                        <div class="package-img">
                            <?php if (has_post_thumbnail()): ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large'); ?>
                                </a>
                            <?php else: ?>
                                <a href="<?php the_permalink(); ?>">
                                    <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?w=600&h=400&fit=crop" alt="<?php the_title(); ?>">
                                </a>
                            <?php endif; ?>
                            <?php if ($discount): ?>
                                <span class="package-badge"><?php echo esc_html($discount); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="package-body">
                            <?php if ($location): ?>
                                <span class="package-location">
                                    <i class="fas fa-map-marker-alt"></i> <?php echo esc_html($location); ?>
                                </span>
                            <?php endif; ?>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="package-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></div>
                            <div class="package-meta">
                                <?php if ($duration): ?>
                                    <span class="package-duration">
                                        <i class="far fa-clock"></i> <?php echo esc_html($duration); ?>
                                    </span>
                                <?php endif; ?>
                                <div class="package-price">
                                    <?php if ($old_price): ?>
                                        <span class="price-old">₹<?php echo number_format($old_price); ?></span>
                                    <?php endif; ?>
                                    <?php if ($price): ?>
                                        <span class="price-current">₹<?php echo number_format($price); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn-outline">View Details</a>
                        </div>
                    </div>
                <?php
                    endwhile;
                else:
                ?>
                    <div class="no-packages">
                        <i class="fas fa-inbox" style="font-size: 60px; color: #ccc;"></i>
                        <h3>No packages found</h3>
                        <p>Please create packages from WordPress admin.</p>
                    </div>
                <?php
                endif;
                ?>
            </div>

            <!-- Pagination -->
            <?php
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => '<i class="fas fa-arrow-left"></i> Previous',
                'next_text' => 'Next <i class="fas fa-arrow-right"></i>',
            ));
            ?>

        </div>
    </section>

</main>

<?php get_footer(); ?>