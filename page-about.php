<?php 
/* Template Name: About Us Page */
get_header(); 
?>

<?php while (have_posts()) : the_post(); 
    // Retrieve Data
    $intro_img = get_post_meta(get_the_ID(), '_about_intro_img', true);
    $hero_img = get_post_meta(get_the_ID(), '_about_hero_img', true);
    $quote = get_post_meta(get_the_ID(), '_about_quote', true);
    $stats = maybe_unserialize(get_post_meta(get_the_ID(), '_about_stats', true)) ?: [];
    $features = maybe_unserialize(get_post_meta(get_the_ID(), '_about_features', true)) ?: [];
    $team = maybe_unserialize(get_post_meta(get_the_ID(), '_about_team', true)) ?: [];
    $founder_name = get_post_meta(get_the_ID(), '_about_founder_name', true);
    $founder_role = get_post_meta(get_the_ID(), '_about_founder_role', true);
    $founder_img = get_post_meta(get_the_ID(), '_about_founder_img', true);
?>

<section class="section about-intro">
    <div class="about-bg-pattern"></div>
    
    <div class="container">
        <!-- FLEXBOX LAYOUT: 60% Text (Left) | 40% Image (Right) with 20px gap -->
        <div class="about-header-grid">
            
            <!-- LEFT COLUMN: TEXT CONTENT -->
            <div class="about-text-section">
                <span class="about-eyebrow">Who We Are</span>
                <h1 class="about-main-title"><?php the_title(); ?></h1>
                
                <div class="about-main-desc">
                    <?php 
                        $content = get_the_content();
                        $blocks = explode("\n", $content);
                        $first_paragraph = array_shift($blocks);
                        $rest_content = implode("\n", $blocks);
                    ?>
                    
                    <p class="lead-paragraph"><?php echo wp_strip_all_tags($first_paragraph); ?></p>
                    <div class="regular-content">
                        <?php echo wpautop($rest_content); ?>
                    </div>
                </div>
                
                <div class="about-signature">
                    <div class="sig-line"></div>
                    <span>WildTrek Since 1995</span>
                </div>
            </div>

            <!-- RIGHT COLUMN: IMAGE -->
            <div class="about-image-section">
                <div class="img-frame-decoration"></div>
                <?php if($intro_img): ?>
                    <img src="<?php echo esc_url($intro_img); ?>" class="about-intro-img" alt="About WildTrek">
                <?php else: ?>
                    <div class="about-intro-placeholder" style="height:550px; background:#eee; display:flex; align-items:center; justify-content:center; border-radius:180px 180px 20px 20px;">
                        <p style="color:#666;">Add 'Intro Image' in Dashboard</p>
                    </div>
                <?php endif; ?>

                <div class="about-badge-circle">
                    <svg viewBox="0 0 100 100" width="100%" height="100%">
                      <path id="circlePath" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" fill="transparent" />
                      <text fill="#084D2A" font-size="13" font-weight="bold" letter-spacing="1.2">
                        <textPath xlink:href="#circlePath">ESTABLISHED • 1995 • WILDTREK •</textPath>
                      </text>
                    </svg>
                    <i class="fas fa-paw"></i>
                </div>
            </div>

        </div>
    </div>
</section>

<?php if($hero_img): ?>
<section class="about-hero-img-sec">
    <img src="<?php echo esc_url($hero_img); ?>" class="about-wide-img" alt="WildTrek Landscape">
</section>
<?php endif; ?>

<section class="section about-story">
    <div class="container">
        <div class="story-grid">
            <div>
                <span class="section-subtitle">Our Journey</span>
                <h2 class="section-title">Roam Through Our <br><span class="highlight">Safari Tales</span></h2>
                <div class="story-content">
                    <p>Whether you're dreaming of witnessing a majestic lion or exploring the dense undergrowth, we bring you closer to nature.</p>
                    
                    <?php if($founder_name): ?>
                    <div class="founder-box">
                        <?php if($founder_img): ?>
                            <img src="<?php echo esc_url($founder_img); ?>" class="founder-img" alt="<?php echo esc_attr($founder_name); ?>">
                        <?php else: ?>
                            <div style="width:60px; height:60px; background:#ddd; border-radius:50%;"></div>
                        <?php endif; ?>

                        <div>
                            <strong><?php echo esc_html($founder_name); ?></strong><br>
                            <span><?php echo esc_html($founder_role); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="quote-box-wrap">
                <i class="fas fa-quote-left quote-icon"></i>
                <blockquote class="about-quote">
                    "<?php echo $quote ? esc_html($quote) : 'Connecting travelers with nature...'; ?>"
                </blockquote>
            </div>
        </div>
    </div>
</section>

<?php if(!empty($stats)): ?>
<section class="section about-stats">
    <div class="container">
        <div class="stats-flex">
            <?php foreach($stats as $s): ?>
            <div class="stat-item">
                <div class="stat-icon"><i class="<?php echo esc_attr($s['icon']); ?>"></i></div>
                <h3 class="stat-num"><?php echo esc_html($s['num']); ?></h3>
                <span class="stat-label"><?php echo esc_html($s['label']); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if(!empty($features)): ?>
<section class="section why-choose">
    <div class="container">
        <div class="center-intro">
            <h2 class="section-title">Why Choose WildTrek?</h2>
        </div>
        <div class="why-grid">
            <?php foreach($features as $f): ?>
            <div class="why-card">
                <span class="why-num"><?php echo esc_html($f['num']); ?></span>
                <h4><?php echo esc_html($f['title']); ?></h4>
                <p><?php echo esc_html($f['desc']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if(!empty($team)): ?>
<section class="section team-section">
    <div class="container">
        <div class="center-intro">
            <span class="section-subtitle">Our Guides</span>
            <h2 class="section-title">Meet the Team</h2>
        </div>
        
        <div class="team-grid">
            <?php foreach($team as $t): ?>
            <div class="team-card">
                <div class="team-img-box">
                    <img src="<?php echo esc_url($t['img']); ?>" alt="<?php echo esc_attr($t['name']); ?>">
                </div>
                <div class="team-info">
                    <h3><?php echo esc_html($t['name']); ?></h3>
                    <span><?php echo esc_html($t['role']); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section join-cta">
    <div class="container">
        <span class="cta-sub">Join Our Team</span>
        <h2 class="cta-title">Your Safari, Our Passion!</h2>
        <p class="cta-desc">We are always looking for passionate individuals to join our conservation efforts.</p>
        <a href="<?php echo site_url('/contact'); ?>" class="btn-cta">Apply Now</a>
    </div>
</section>

<?php endwhile; ?>
<?php get_footer(); ?>