<?php get_header(); ?>

<?php while (have_posts()) : the_post(); 
    $pid = get_the_ID();
    $location = get_post_meta($pid, '_forest_location', true);
    $best_time = get_post_meta($pid, '_forest_best_time', true);
    $airport = get_post_meta($pid, '_forest_airport', true);
    $closed_day = get_post_meta($pid, '_forest_closed_day', true);
    $timing = get_post_meta($pid, '_forest_safari_timing', true);
    
    $core_zones = maybe_unserialize(get_post_meta($pid, '_forest_core_zones', true));
    $buffer_zones = maybe_unserialize(get_post_meta($pid, '_forest_buffer_zones', true));
?>

<div class="forest-hero" style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.6)), url('<?php echo get_the_post_thumbnail_url($pid, 'full'); ?>');">
    <div class="container hero-content">
        <span class="hero-tag">National Park</span>
        <h1><?php the_title(); ?></h1>
        <p><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($location); ?></p>
    </div>
</div>

<div class="container forest-layout">
    <div class="forest-main">
        
        <div class="forest-info-bar">
            <div class="f-info-box">
                <i class="fas fa-sun"></i>
                <div><strong>Best Time</strong><span><?php echo esc_html($best_time); ?></span></div>
            </div>
            <div class="f-info-box">
                <i class="fas fa-plane"></i>
                <div><strong>Nearest City</strong><span><?php echo esc_html($airport); ?></span></div>
            </div>
            <div class="f-info-box">
                <i class="fas fa-calendar-times"></i>
                <div><strong>Closed On</strong><span><?php echo esc_html($closed_day); ?></span></div>
            </div>
        </div>

        <section class="details-section">
            <h2 class="h2-title">About the Park</h2>
            <div class="overview-txt"><?php the_content(); ?></div>
        </section>

        <section class="details-section">
            <h2 class="h2-title">Safari Zones</h2>
            <div class="zones-grid">
                <?php if($core_zones): ?>
                <div class="zone-card core">
                    <h3><i class="fas fa-paw"></i> Core Zones</h3>
                    <ul>
                        <?php foreach($core_zones as $zone) echo "<li>$zone</li>"; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if($buffer_zones): ?>
                <div class="zone-card buffer">
                    <h3><i class="fas fa-tree"></i> Buffer Zones</h3>
                    <ul>
                        <?php foreach($buffer_zones as $zone) echo "<li>$zone</li>"; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <?php if($timing): ?>
        <section class="details-section">
            <h2 class="h2-title">Safari Timings</h2>
            <div class="timing-box">
                <i class="fas fa-clock"></i>
                <p><?php echo wpautop(esc_html($timing)); ?></p>
            </div>
        </section>
        <?php endif; ?>

    </div>

    <aside class="forest-sidebar">
        <div class="sidebar-widget">
            <h3>Explore Packages</h3>
            <div class="mini-package-list">
                <?php 
                $packages = new WP_Query(array('post_type' => 'package', 'posts_per_page' => 3));
                while($packages->have_posts()): $packages->the_post(); 
                    $price = get_post_meta(get_the_ID(), '_package_price', true);
                ?>
                <a href="<?php the_permalink(); ?>" class="mini-pkg">
                    <div class="mini-img" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>');"></div>
                    <div class="mini-info">
                        <h4><?php the_title(); ?></h4>
                        <span class="mini-price">₹<?php echo $price; ?> / Person</span>
                    </div>
                </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <a href="<?php echo site_url('/packages'); ?>" class="view-all-btn">View All Safaris</a>
        </div>
    </aside>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>