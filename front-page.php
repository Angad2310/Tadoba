<?php
/**
 * Template Name: Homepage
 * The homepage template
 */
get_header(); ?>

<main class="site-main">

    <!-- HERO SECTION -->
    <section class="hero-section">
        <?php
        $hero_img = get_theme_mod('hero_image');
        if (!$hero_img) {
            $hero_img = 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1920&h=1080&fit=crop';
        }
        ?>
        <div class="hero-bg" style="background-image: url('<?php echo esc_url($hero_img); ?>')"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="container">
                <p class="hero-subtitle"><?php echo esc_html(get_theme_mod('hero_subtitle', 'EMBARK ON YOUR NEXT ADVENTURE')); ?></p>
                <h1 class="hero-title"><?php echo esc_html(get_theme_mod('hero_title', 'Discover the Wild Like Never Before')); ?></h1>
                <p class="hero-text"><?php echo esc_html(get_theme_mod('hero_description', 'Experience breathtaking safaris, hidden trails, and jungle adventures.')); ?></p>
                <a href="<?php echo esc_url(home_url('/packages')); ?>" class="btn-primary">Explore Packages</a>
            </div>
        </div>
    </section>

    <!-- WELCOME SECTION -->
    <section class="welcome-section">
        <div class="container">
            <div class="welcome-grid">
                <div class="welcome-content">
                    <span class="section-badge">WELCOME TO TADOBA</span>
                    <h2>Experience Wildlife Like Never Before</h2>
                    <p>Nestled in the heart of Maharashtra, Tadoba Andhari Tiger Reserve is one of India's premier wildlife destinations. Our resort offers you the perfect gateway to explore this magnificent wilderness.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check-circle"></i> Prime location near Moharli Gate</li>
                        <li><i class="fas fa-check-circle"></i> Expert naturalists & safari guides</li>
                        <li><i class="fas fa-check-circle"></i> Luxury accommodations with jungle views</li>
                        <li><i class="fas fa-check-circle"></i> Authentic local & continental cuisine</li>
                        <li><i class="fas fa-check-circle"></i> Eco-friendly & sustainable practices</li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/about')); ?>" class="btn-secondary">Learn More</a>
                </div>
                <div class="welcome-image">
                    <img src="https://images.unsplash.com/photo-1549366021-9f761d450615?w=800&h=600&fit=crop" alt="About Tadoba">
                </div>
            </div>
        </div>
    </section>

    <!-- PACKAGES SECTION -->
    <section class="packages-section">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-badge">OUR PACKAGES</span>
                <h2>Safari Packages & Tours</h2>
                <p>Choose from our curated safari experiences designed for adventure seekers</p>
            </div>

            <div class="packages-grid">
                <?php
                $packages = new WP_Query(array(
                    'post_type' => 'package',
                    'posts_per_page' => 6,
                ));

                if ($packages->have_posts()):
                    while ($packages->have_posts()): $packages->the_post();
                        $price = get_post_meta(get_the_ID(), '_package_price', true);
                        $old_price = get_post_meta(get_the_ID(), '_package_old_price', true);
                        $duration = get_post_meta(get_the_ID(), '_package_duration', true);
                        $location = get_post_meta(get_the_ID(), '_package_location', true);
                        $discount = get_post_meta(get_the_ID(), '_package_discount', true);
                ?>
                    <div class="package-card">
                        <div class="package-img">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('large'); ?>
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?w=600&h=400&fit=crop" alt="<?php the_title(); ?>">
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
                    wp_reset_postdata();
                else:
                    // Sample packages if none exist
                    $samples = array(
                        array('title' => 'Tiger Trail Safari', 'location' => 'Moharli Zone', 'duration' => '3 Days / 2 Nights', 'price' => '12999', 'old_price' => '15999', 'discount' => '20% OFF'),
                        array('title' => 'Jungle Discovery', 'location' => 'Kolara Zone', 'duration' => '2 Days / 1 Night', 'price' => '8499', 'old_price' => '10499', 'discount' => '15% OFF'),
                        array('title' => 'Weekend Wildlife Escape', 'location' => 'Tadoba Zone', 'duration' => '2 Days / 1 Night', 'price' => '9999', 'old_price' => '', 'discount' => ''),
                    );

                    foreach ($samples as $pkg):
                ?>
                    <div class="package-card">
                        <div class="package-img">
                            <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?w=600&h=400&fit=crop" alt="<?php echo esc_attr($pkg['title']); ?>">
                            <?php if ($pkg['discount']): ?>
                                <span class="package-badge"><?php echo esc_html($pkg['discount']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="package-body">
                            <span class="package-location">
                                <i class="fas fa-map-marker-alt"></i> <?php echo esc_html($pkg['location']); ?>
                            </span>
                            <h3><?php echo esc_html($pkg['title']); ?></h3>
                            <div class="package-excerpt">Experience the thrill of wildlife safari in pristine jungle surroundings.</div>
                            <div class="package-meta">
                                <span class="package-duration">
                                    <i class="far fa-clock"></i> <?php echo esc_html($pkg['duration']); ?>
                                </span>
                                <div class="package-price">
                                    <?php if ($pkg['old_price']): ?>
                                        <span class="price-old">₹<?php echo number_format($pkg['old_price']); ?></span>
                                    <?php endif; ?>
                                    <span class="price-current">₹<?php echo number_format($pkg['price']); ?></span>
                                </div>
                            </div>
                            <a href="#" class="btn-outline">View Details</a>
                        </div>
                    </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>

            <div class="text-center" style="margin-top: 40px;">
                <a href="<?php echo esc_url(home_url('/packages')); ?>" class="btn-primary">View All Packages</a>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="features-section">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-badge">WHY CHOOSE US</span>
                <h2>Resort Amenities & Facilities</h2>
            </div>

            <div class="features-grid">
                <div class="feature-box">
                    <div class="feature-icon"><i class="fas fa-wifi"></i></div>
                    <h4>High-Speed WiFi</h4>
                    <p>Stay connected throughout the property</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon"><i class="fas fa-swimming-pool"></i></div>
                    <h4>Swimming Pool</h4>
                    <p>Relax in our jungle-view infinity pool</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon"><i class="fas fa-utensils"></i></div>
                    <h4>Restaurant</h4>
                    <p>Authentic local & continental dishes</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon"><i class="fas fa-spa"></i></div>
                    <h4>Spa & Wellness</h4>
                    <p>Rejuvenate with traditional therapies</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon"><i class="fas fa-binoculars"></i></div>
                    <h4>Guided Safaris</h4>
                    <p>Expert-led wildlife exploration</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon"><i class="fas fa-campground"></i></div>
                    <h4>Campfire Evenings</h4>
                    <p>Starlit nights with folk music</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta-section">
        <div class="container text-center">
            <h2>Ready for Your Wildlife Adventure?</h2>
            <p>Book your stay today and experience the magic of Tadoba</p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-white">Contact Us Now</a>
        </div>
    </section>

</main>

<?php get_footer(); ?>