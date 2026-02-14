<?php
/**
 * Template Name: Homepage
 * Description: Professional, Responsive, Dynamic Homepage with Forest/Resort Showcase
 */
get_header(); ?>

<main class="site-main">

    <section class="hero-section">
        <?php
        $hero_img = get_theme_mod('hero_image');
        if (!$hero_img) {
            $hero_img = 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1920&h=1080&fit=crop';
        }
        ?>
        <div class="hero-bg" style="background-image: url('<?php echo esc_url($hero_img); ?>')"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content fade-in-up">
            <div class="container">
                <span class="hero-label"><?php echo esc_html(get_theme_mod('hero_subtitle', 'EMBARK ON YOUR NEXT ADVENTURE')); ?></span>
                <h1 class="hero-title"><?php echo esc_html(get_theme_mod('hero_title', 'Discover the Wild Like Never Before')); ?></h1>
                <p class="hero-text"><?php echo esc_html(get_theme_mod('hero_description', 'Experience breathtaking safaris, hidden trails, and jungle adventures.')); ?></p>
                <div class="hero-buttons">
                    <a href="<?php echo esc_url(home_url('/packages')); ?>" class="btn-primary">Explore Packages</a>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-outline-white">Plan My Trip</a>
                </div>
            </div>
        </div>
    </section>

    <section class="welcome-section">
        <div class="container">
            <div class="welcome-grid">
                <div class="welcome-content">
                    <span class="section-badge">WELCOME TO TADOBA</span>
                    <h2>Experience Wildlife Like Never Before</h2>
                    <p>Nestled in the heart of Maharashtra, Tadoba Andhari Tiger Reserve is one of India's premier wildlife destinations. Our resort offers you the perfect gateway to explore this magnificent wilderness.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-paw"></i> Prime location near Moharli Gate</li>
                        <li><i class="fas fa-user-friends"></i> Expert naturalists & safari guides</li>
                        <li><i class="fas fa-leaf"></i> Luxury accommodations with jungle views</li>
                        <li><i class="fas fa-utensils"></i> Authentic local & continental cuisine</li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/about')); ?>" class="btn-secondary">Learn More</a>
                </div>
                <div class="welcome-image">
                    <img src="https://images.unsplash.com/photo-1549366021-9f761d450615?w=800&h=600&fit=crop" alt="About Tadoba">
                    <div class="image-offset-border"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="packages-section bg-light">
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
                    'posts_per_page' => 3, // Show top 3 packages
                ));

                if ($packages->have_posts()):
                    while ($packages->have_posts()): $packages->the_post();
                        $price = get_post_meta(get_the_ID(), '_package_price', true);
                        $duration = get_post_meta(get_the_ID(), '_package_duration', true);
                        $location = get_post_meta(get_the_ID(), '_package_location', true);
                ?>
                    <div class="package-card">
                        <div class="package-img">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('medium_large'); ?>
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?w=600&h=400&fit=crop" alt="<?php the_title(); ?>">
                            <?php endif; ?>
                            <div class="card-overlay">
                                <a href="<?php the_permalink(); ?>" class="btn-view">View Details</a>
                            </div>
                        </div>
                        <div class="package-body">
                            <div class="meta-top">
                                <span><i class="far fa-clock"></i> <?php echo esc_html($duration); ?></span>
                                <span><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($location); ?></span>
                            </div>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="package-price-row">
                                <span class="price-label">Starting From</span>
                                <span class="price-val">₹<?php echo number_format($price); ?></span>
                            </div>
                        </div>
                    </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
            
            <div class="text-center mt-5">
    <a href="<?php echo esc_url(get_post_type_archive_link('package')); ?>" class="btn-primary">View All Packages</a>
</div>
        </div>
    </section>

    <section class="forests-section bg-light">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-badge">STAY IN NATURE</span>
                <h2>Our Jungle Resorts</h2>
                <p>Luxury accommodation in the heart of the forest</p>
            </div>

            <div class="packages-grid">
                <?php
                $resorts = new WP_Query(array(
                    'post_type' => 'resort',
                    'posts_per_page' => 3, 
                ));

                if ($resorts->have_posts()):
                    while ($resorts->have_posts()): $resorts->the_post();
                ?>
                <div class="package-card">
                    <div class="package-img">
                         <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('medium_large'); ?>
                         <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&h=400&fit=crop" alt="Resort">
                         <?php endif; ?>
                         <div class="card-overlay">
                            <a href="<?php the_permalink(); ?>" class="btn-view">View Room</a>
                        </div>
                    </div>
                    
                    <div class="package-body">
                        <div class="meta-top">
                            <span><i class="fas fa-wifi"></i> Free Wifi</span>
                            <span><i class="fas fa-wind"></i> AC Rooms</span>
                        </div>
                        
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        
                        <div class="package-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 12); ?>
                        </div>

                        <div class="package-price-row">
                            <ul style="padding:0; list-style:none; display:flex; gap:10px; font-size:0.85rem; color:#666; margin:0;">
                                <li><i class="fas fa-swimming-pool" style="color:#d4a373;"></i> Pool</li>
                                <li><i class="fas fa-utensils" style="color:#d4a373;"></i> Dining</li>
                            </ul>
                            <a href="<?php the_permalink(); ?>" style="color:#2c5f2d; font-weight:bold; text-decoration:none;">Book Now &rarr;</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
            
            <div class="text-center mt-5" style="margin-top: 40px;">
    <a href="<?php echo esc_url(get_post_type_archive_link('resort')); ?>" class="btn-primary">View All Resorts</a>
</div>
        </div>
    </section>

    <section class="features-section">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-badge">WHY CHOOSE US</span>
                <h2>Resort Amenities & Facilities</h2>
            </div>

            <div class="features-grid">
                <div class="feature-box">
                    <div class="icon-circle"><i class="fas fa-wifi"></i></div>
                    <h4>High-Speed WiFi</h4>
                    <p>Stay connected even in the wild with our dedicated high-speed internet.</p>
                </div>
                <div class="feature-box">
                    <div class="icon-circle"><i class="fas fa-swimming-pool"></i></div>
                    <h4>Infinity Pool</h4>
                    <p>Relax and unwind in our crystal clear pool overlooking the jungle.</p>
                </div>
                <div class="feature-box">
                    <div class="icon-circle"><i class="fas fa-utensils"></i></div>
                    <h4>Multi-Cuisine</h4>
                    <p>Authentic local Maharashtrian dishes and continental favorites.</p>
                </div>
                <div class="feature-box">
                    <div class="icon-circle"><i class="fas fa-spa"></i></div>
                    <h4>Luxury Spa</h4>
                    <p>Rejuvenate your senses with our traditional ayurvedic spa therapies.</p>
                </div>
                <div class="feature-box">
                    <div class="icon-circle"><i class="fas fa-utensils"></i></div>
                    <h4>Multi-Cuisine</h4>
                    <p>Authentic local Maharashtrian dishes and continental favorites.</p>
                </div>
                <div class="feature-box">
                    <div class="icon-circle"><i class="fas fa-binoculars"></i></div>
                    <h4>Guided Safaris</h4>
                    <p>Expert naturalists to guide you through the tiger trails.</p>
                </div>
                <div class="feature-box">
                    <div class="icon-circle"><i class="fas fa-fire"></i></div>
                    <h4>Campfire</h4>
                    <p>Enjoy starlit nights with folk music and warm campfires.</p>
                </div>
                <div class="feature-box">
                    <div class="icon-circle"><i class="fas fa-binoculars"></i></div>
                    <h4>Guided Safaris</h4>
                    <p>Expert naturalists to guide you through the tiger trails.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section" style="background-image: url('https://images.unsplash.com/photo-1504198266287-16594a556bd1?w=1600');">
        <div class="cta-overlay"></div>
        <div class="container text-center relative-z">
            <h2>Ready for the Adventure of a Lifetime?</h2>
            <p>Book your stay today and experience the magic of Tadoba</p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-gold-lg">Contact Us Now</a>
        </div>
    </section>

</main>

<?php get_footer(); ?>