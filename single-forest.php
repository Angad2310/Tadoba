<?php 
/* Template Name: Forest Detail */
get_header(); // Needed for WP hooks, but we'll override visual header below
?>

<?php while (have_posts()) : the_post(); 
    $pid = get_the_ID();
    
    // Retrieve ALL Dynamic Data
    $hero_img = get_the_post_thumbnail_url($pid, 'full');
    $hero_sub = get_post_meta($pid, '_hero_sub', true);
    $about_desc = get_the_content(); // Main Editor
    
    $area = get_post_meta($pid, '_area_size', true);
    $distance = get_post_meta($pid, '_distance_city', true);
    
    $flora_img = get_post_meta($pid, '_flora_img', true);
    $flora_list = maybe_unserialize(get_post_meta($pid, '_flora_list', true)) ?: [];
    
    $zones_list = maybe_unserialize(get_post_meta($pid, '_zones_list', true)) ?: [];
    $timing_list = maybe_unserialize(get_post_meta($pid, '_timing_list', true)) ?: [];
    $rules_list = maybe_unserialize(get_post_meta($pid, '_rules_list', true)) ?: [];
    
    $logistics_img = get_post_meta($pid, '_logistics_img', true);
    $logistics_list = maybe_unserialize(get_post_meta($pid, '_logistics_list', true)) ?: [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Inclusive+Sans&family=Anybody:wght@400;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

   

    <section class="hero-section">
        <?php if($hero_img): ?>
        <img src="<?php echo esc_url($hero_img); ?>" alt="<?php the_title(); ?>" class="hero-image">
        <?php endif; ?>
        
        <div class="hero-content">
            <h1 class="hero-title reveal-on-scroll"><?php the_title(); ?></h1>
            <p class="section-description reveal-on-scroll" style="color:#fff;"><?php echo esc_html($hero_sub); ?></p>
            <a href="#about" class="btn-primary reveal-on-scroll">Explore Reserve</a>
        </div>
        <div class="feed-to-cream"></div>
    </section>

    <section class="section" id="about">
        <div class="pattern-bg"></div>
        <div class="container">
            <div class="about-grid">
                <div class="reveal-on-scroll">
                    <span class="section-subtitle">The Legacy</span>
                    <h2 class="section-title">An Amalgamation of <span style="color: var(--tmp-primary-color);">Wildlife</span></h2>
                    <div class="section-description">
                        <?php the_content(); ?>
                    </div>
                    
                    <div style="display: flex; gap: 30px; margin-top: 15px; justify-content: center;">
                        <div style="text-align: center;">
                            <h4 style="color: var(--tmp-heading-color); font-size: 24px;"><?php echo esc_html($area); ?></h4>
                            <p style="font-size: 11px; color: #777; text-transform: uppercase;">Total Area</p>
                        </div>
                        <div style="text-align: center;">
                            <h4 style="color: var(--tmp-heading-color); font-size: 24px;"><?php echo esc_html($distance); ?></h4>
                            <p style="font-size: 11px; color: #777; text-transform: uppercase;">Distance</p>
                        </div>
                    </div>
                </div>
                <div class="reveal-on-scroll about-image-wrapper">
                    <?php if($hero_img): ?>
                        <img src="<?php echo esc_url($hero_img); ?>" alt="About Forest" class="about-image">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="flora" style="background-color: var(--tmp-section-bg-alt);">
        <div class="feed-from-cream"></div>
        <div class="container">
            <div class="about-grid reverse">
                <div class="reveal-on-scroll about-image-wrapper">
                    <?php if($flora_img): ?>
                        <img src="<?php echo esc_url($flora_img); ?>" alt="Flora" class="about-image">
                    <?php endif; ?>
                </div>
                <div class="reveal-on-scroll">
                    <span class="section-subtitle">Nature's Canopy</span>
                    <h2 class="section-title">Rich <span style="color: var(--tmp-primary-color);">Biodiversity</span></h2>
                    
                    <div class="info-card">
                        <ul class="rules-list">
                            <?php foreach($flora_list as $f): ?>
                                <li><?php echo esc_html($f); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="zones">
        <div class="container">
            <div style="text-align: center; max-width: 800px; margin: 0 auto 30px;">
                <span class="section-subtitle">Discovery</span>
                <h2 class="section-title">Safari Gates</h2>
                <p class="section-description">Explore the various entry points to the wilderness.</p>
            </div>

            <div class="amenities-grid reveal-on-scroll">
                <?php foreach($zones_list as $zone): ?>
                <div class="amenity-card">
                    <h4><?php echo esc_html($zone['title']); ?></h4>
                    <p><?php echo esc_html($zone['desc']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section" id="timings" style="background-color: #fff;">
        <div class="feed-from-cream"></div>
        <div class="container">
            <div class="about-grid">
                <div class="reveal-on-scroll" style="width: 100%;">
                    <span class="section-subtitle">Planning</span>
                    <h2 class="section-title">Safari Timings</h2>
                    <div class="info-card">
                        <table class="info-table">
                            <thead>
                                <tr><th>Season</th><th>Morning</th><th>Evening</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach($timing_list as $t): ?>
                                <tr>
                                    <td><?php echo esc_html($t['season']); ?></td>
                                    <td><?php echo esc_html($t['am']); ?></td>
                                    <td><?php echo esc_html($t['pm']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="reveal-on-scroll" style="width: 100%;">
                    <span class="section-subtitle">Etiquette</span>
                    <h2 class="section-title">Jungle Rules</h2>
                    <div class="info-card" style="background: var(--tmp-heading-color); color: #fff;">
                        <ul class="rules-list" style="color: #eee;">
                            <?php foreach($rules_list as $r): ?>
                                <li style="color: #fff;"><?php echo esc_html($r); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="logistics" style="background-color: var(--tmp-section-bg-alt);">
        <div class="container">
            <div class="about-grid reverse">
                <div class="reveal-on-scroll about-image-wrapper">
                    <?php if($logistics_img): ?>
                        <img src="<?php echo esc_url($logistics_img); ?>" alt="Logistics" class="about-image">
                    <?php endif; ?>
                </div>
                <div class="reveal-on-scroll" style="width: 100%;">
                    <span class="section-subtitle">Logistics</span>
                    <h2 class="section-title">Getting There</h2>
                    <div class="info-card">
                        <table class="info-table">
                            <thead>
                                <tr><th>Route</th><th>Distance</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach($logistics_list as $l): ?>
                                <tr>
                                    <td><?php echo esc_html($l['route']); ?></td>
                                    <td><?php echo esc_html($l['dist']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="feed-to-dark"></div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <span class="footer-logo">WildTrek</span>
                    <p>Your expert guide to India's premier tiger corridor.</p>
                </div>
                <div>
                    <h3>Explore</h3>
                    <a href="#about">About</a>
                    <a href="#zones">Gates</a>
                    <a href="#timings">Timings</a>
                </div>
                <div>
                    <h3>Contact</h3>
                    <p>+91 98765 43210</p>
                    <p>info@tadoba.com</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> WildTrek. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleNav() {
            document.getElementById('mobileNav').classList.toggle('active');
        }

        const observerOptions = { threshold: 0.1 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) { entry.target.classList.add('is-visible'); }
            });
        }, observerOptions);
        document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));
    </script>
</body>
</html>
<?php endwhile; ?>