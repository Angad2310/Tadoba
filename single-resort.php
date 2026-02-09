<?php
/**
 * Single Resort Template
 */
get_header();

while (have_posts()) : the_post();
    $phone = get_post_meta(get_the_ID(), '_resort_phone', true);
    $email = get_post_meta(get_the_ID(), '_resort_email', true);
    $location_text = get_post_meta(get_the_ID(), '_resort_location_text', true);
    $features = get_post_meta(get_the_ID(), '_resort_features', true);
    $features_array = !empty($features) ? explode("\n", $features) : array();
?>

<!-- 1. HERO SECTION -->
<section class="hero-section">
    <?php if (has_post_thumbnail()): ?>
        <?php the_post_thumbnail('hero-image', array('class' => 'hero-image', 'alt' => get_the_title())); ?>
    <?php else: ?>
        <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1600" alt="<?php the_title(); ?>" class="hero-image">
    <?php endif; ?>
    <div class="hero-content">
        <p class="hero-subtitle reveal-on-scroll">Welcome to <?php the_title(); ?></p>
        <h1 class="hero-title reveal-on-scroll"><?php the_title(); ?></h1>
        <p class="hero-description reveal-on-scroll"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
        <a href="#packages" class="btn-primary reveal-on-scroll">Explore Our Stays</a>
    </div>
    <div class="hero-bottom-fade-overlay"></div>
</section>

<!-- 2. NATURE ENTHUSIASTS (TEXT) -->
<section class="section grid-section" id="enthusiasts">
    <div class="pattern-bg"></div>
    <div class="container">
        <div class="about-grid">
            <!-- Text (First) -->
            <div class="about-content reveal-on-scroll">
                <p class="section-subtitle">Nature Enthusiasts</p>
                <h2 class="section-title">Outdoor Adventures for <span style="color: var(--tmp-primary-color);">Nature Enthusiasts</span></h2>
                <div class="section-description">
                    <?php the_content(); ?>
                </div>
                <?php if (!empty($features_array)): ?>
                <div style="margin-top: 30px;">
                    <ul class="features-list">
                        <?php foreach ($features_array as $feature): 
                            $feature = trim($feature);
                            if (empty($feature)) continue;
                            // Split by colon to get title and description
                            $parts = explode(':', $feature, 2);
                            $title = isset($parts[0]) ? trim($parts[0]) : '';
                            $desc = isset($parts[1]) ? trim($parts[1]) : '';
                        ?>
                            <li>
                                <i class="fas fa-map-marker-alt"></i> 
                                <span><strong><?php echo esc_html($title); ?>:</strong> <?php echo esc_html($desc); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                <div style="margin-top: 30px; display: flex; gap: 20px; flex-wrap: wrap;">
                    <a href="#booking" class="btn-primary">Check Availability</a>
                    <?php if ($phone): ?>
                        <a href="tel:<?php echo esc_attr($phone); ?>" class="btn-primary" style="background: #fff; color: var(--tmp-primary-color); border: 2px solid var(--tmp-primary-color);">
                            Call: <?php echo esc_html($phone); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Image (Hidden on Mobile for flow) -->
            <div class="reveal-on-scroll">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('resort-thumbnail', array('class' => 'about-image', 'alt' => get_the_title())); ?>
                <?php else: ?>
                    <img src="https://images.unsplash.com/photo-1583341612074-ccea5cd64f6a?w=800" alt="Resort View" class="about-image">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- 3. RESORT IMAGE SHOWCASE (IMAGE) -->
<section class="resort-showcase-section" id="showcase">
    <div class="section-fade-top"></div>
    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600" alt="Resort Ambience" class="resort-showcase-image">
    <div class="section-fade-bottom"></div>
</section>

<!-- 4. FEATURES (TEXT/ICONS) -->
<section class="section activities-section-redesigned" id="activities">
    <div class="container">
        <div class="activities-intro reveal-on-scroll">
            <p class="section-subtitle">Curated Experiences</p>
            <h2 class="section-title">Unforgettable Adventures Await</h2>
            <p class="section-description">Immerse yourself in the wild beauty with our handpicked experiences.</p>
        </div>

        <div class="amenities-grid reveal-on-scroll">
            <div class="amenity-card"><div class="amenity-icon"><i class="fas fa-utensils"></i></div><h4>Bush Breakfast</h4><p>Breakfast in wilderness</p></div>
            <div class="amenity-card"><div class="amenity-icon"><i class="fas fa-swimming-pool"></i></div><h4>Swimming Pool</h4><p>Relax by the pool</p></div>
            <div class="amenity-card"><div class="amenity-icon"><i class="fas fa-star"></i></div><h4>Star Gazing</h4><p>Crystal clear night skies</p></div>
            <div class="amenity-card"><div class="amenity-icon"><i class="fas fa-camera"></i></div><h4>Photography Tours</h4><p>Guided sessions</p></div>
            <div class="amenity-card"><div class="amenity-icon"><i class="fas fa-users"></i></div><h4>Tribal Visits</h4><p>Local culture</p></div>
            <div class="amenity-card"><div class="amenity-icon"><i class="fas fa-child"></i></div><h4>Kids Activities</h4><p>Safe nature activities</p></div>
            <div class="amenity-card"><div class="amenity-icon"><i class="fas fa-spa"></i></div><h4>Wellness & Yoga</h4><p>Morning sessions</p></div>
            <div class="amenity-card"><div class="amenity-icon"><i class="fas fa-music"></i></div><h4>Bonfire & Music</h4><p>Evening entertainment</p></div>
        </div>
    </div>
</section>

<!-- 5. PACKAGES (Safari) -->
<section class="accommodations-section-safari section-with-decoration" id="packages">
    <div class="section-fade-white-top"></div>
    <div class="container">
        <div class="safari-header reveal-on-scroll">
            <p class="safari-subtitle">WILDLIFE WONDERS</p>
            <h2 class="safari-title">Explore the Heart of the Wilderness with <span class="safari-title-accent">Classic Safari Adventures</span></h2>
        </div>
        <div class="safari-cards-grid">
            <?php
            $packages = new WP_Query(array(
                'post_type' => 'package',
                'posts_per_page' => 6,
                'orderby' => 'date',
                'order' => 'DESC'
            ));
            
            if ($packages->have_posts()):
                while ($packages->have_posts()): $packages->the_post();
                    $duration = get_post_meta(get_the_ID(), '_package_duration', true);
                    $price = get_post_meta(get_the_ID(), '_package_price', true);
                    $old_price = get_post_meta(get_the_ID(), '_package_old_price', true);
                    $discount = get_post_meta(get_the_ID(), '_package_discount', true);
                    $badge = get_post_meta(get_the_ID(), '_package_badge', true);
                    $zone = get_post_meta(get_the_ID(), '_package_zone', true);
            ?>
                <!-- Package Card -->
                <div class="safari-card reveal-on-scroll">
                    <div class="safari-card-image-wrapper">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('package-card', array('class' => 'safari-card-image', 'alt' => get_the_title())); ?>
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800" alt="<?php the_title(); ?>" class="safari-card-image">
                        <?php endif; ?>
                        <?php if ($discount || $badge): ?>
                        <div class="safari-card-badges">
                            <?php if ($discount): ?>
                                <span class="badge-discount"><?php echo esc_html($discount); ?></span>
                            <?php endif; ?>
                            <?php if ($badge): ?>
                                <span class="badge-featured"><?php echo esc_html($badge); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="safari-card-content">
                        <?php if ($zone): ?>
                            <div class="safari-location"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($zone); ?></div>
                        <?php endif; ?>
                        <h3 class="safari-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="safari-pricing">
                            <?php if ($duration): ?>
                                <div class="safari-duration"><i class="far fa-calendar"></i> <?php echo esc_html($duration); ?></div>
                            <?php endif; ?>
                            <?php if ($price): ?>
                                <div class="safari-price">
                                    <?php if ($old_price): ?>
                                        <span class="price-old">₹<?php echo esc_html($old_price); ?></span>
                                    <?php endif; ?>
                                    <span class="price-new">₹<?php echo esc_html($price); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
    <div class="section-fade-white-bottom"></div>
</section>

<?php
endwhile;
get_footer();
?>
