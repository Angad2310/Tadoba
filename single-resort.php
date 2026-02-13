<?php get_header(); ?>

<style>
    .reveal-on-scroll { opacity: 1 !important; transform: none !important; }
    .resort-page-wrap { background: #fdfaf5; overflow: hidden; }
</style>

<?php while (have_posts()) : the_post(); 
    $pid = get_the_ID();
    
    // Retrieve All Data
    $subtitle = get_post_meta($pid, '_resort_subtitle', true);
    $hero_bg = get_the_post_thumbnail_url($pid, 'full');
    
    $intro_img = get_post_meta($pid, '_resort_intro_img', true);
    $showcase_img = get_post_meta($pid, '_resort_showcase_img', true);
    
    $bottom_title = get_post_meta($pid, '_resort_bottom_title', true);
    $bottom_desc = get_post_meta($pid, '_resort_bottom_desc', true);
    $bottom_img = get_post_meta($pid, '_resort_bottom_img', true);
    
    $amenities = maybe_unserialize(get_post_meta($pid, '_resort_amenities', true)) ?: [];
    $rooms = maybe_unserialize(get_post_meta($pid, '_resort_rooms', true)) ?: [];
?>

<div class="resort-page-wrap">

    <section class="resort-hero" style="position: relative; height: 85vh; display: flex; align-items: center; justify-content: center; text-align: center; color: #fff;">
        <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: #000;">
            <?php if($hero_bg): ?>
                <img src="<?php echo esc_url($hero_bg); ?>" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.7;">
            <?php endif; ?>
        </div>
        
        <div class="hero-content" style="position: relative; z-index: 2; max-width: 800px; padding: 20px;">
            <p style="font-size: 1.2rem; color: #DEED58; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 15px;">
                <?php echo esc_html($subtitle); ?>
            </p>
            <h1 style="font-size: clamp(40px, 6vw, 80px); line-height: 1.1; margin-bottom: 25px; text-shadow: 0 4px 10px rgba(0,0,0,0.5);">
                <?php the_title(); ?>
            </h1>
            <a href="#rooms" style="background: #E67D3C; color: #fff; padding: 15px 40px; border-radius: 50px; font-weight: bold; text-decoration: none; display: inline-block;">
                Explore Stays
            </a>
        </div>
        <div style="position: absolute; bottom:0; left:0; width:100%; height:100px; background: linear-gradient(to top, #fdfaf5, transparent);"></div>
    </section>

    <section class="section" style="padding: 80px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 60px; align-items: center;">
                <div>
                    <span style="color: #E67D3C; text-transform: uppercase; font-weight: bold; letter-spacing: 1px;">Nature Enthusiasts</span>
                    <h2 style="font-size: 2.5rem; color: #084D2A; margin: 15px 0 25px;">
                        Luxury in the <span style="color: #E67D3C;">Wilderness</span>
                    </h2>
                    <div style="font-size: 1.1rem; line-height: 1.8; color: #555;">
                        <?php the_content(); ?>
                    </div>
                </div>
                <div>
                    <?php if($intro_img): ?>
                        <img src="<?php echo esc_url($intro_img); ?>" style="width: 100%; border-radius: 20px; box-shadow: 20px 20px 0 rgba(230, 125, 60, 0.1);">
                    <?php else: ?>
                        <div style="width: 100%; height: 400px; background: #ddd; border-radius: 20px;"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php if($showcase_img): ?>
    <section style="height: 500px; position: relative; background-attachment: fixed; background-position: center; background-repeat: no-repeat; background-size: cover; background-image: url('<?php echo esc_url($showcase_img); ?>'); display: flex; align-items: center; justify-content: center;">
        <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.3);"></div>
        <h2 style="position: relative; z-index: 2; color: #fff; font-size: 3rem; text-shadow: 0 4px 10px rgba(0,0,0,0.5);">Immerse Yourself</h2>
    </section>
    <?php endif; ?>

    <?php if(!empty($amenities)): ?>
    <section class="section" id="activities" style="padding: 80px 0;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 50px;">
                <span style="color: #E67D3C; text-transform: uppercase; font-weight: bold;">Comforts</span>
                <h2 style="font-size: 2.5rem; color: #084D2A;">Curated Experiences</h2>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
                <?php foreach($amenities as $a): ?>
                <div style="background: #fff; padding: 30px; border-radius: 15px; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                    <div style="font-size: 35px; color: #E67D3C; margin-bottom: 15px;">
                        <i class="<?php echo esc_attr($a['icon']); ?>"></i>
                    </div>
                    <h4 style="font-size: 1.2rem; color: #084D2A; margin-bottom: 10px;"><?php echo esc_html($a['title']); ?></h4>
                    <p style="color: #666; font-size: 0.95rem;"><?php echo esc_html($a['desc']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($rooms)): ?>
    <section class="section" id="rooms" style="padding: 80px 0; background: #fff;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 50px;">
                <span style="color: #E67D3C; text-transform: uppercase; font-weight: bold;">Stay</span>
                <h2 style="font-size: 2.5rem; color: #084D2A;">Accommodation & Packages</h2>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px;">
                <?php foreach($rooms as $r): ?>
                <div style="background: #fdfdfd; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border: 1px solid #eee;">
                    <div style="height: 250px; overflow: hidden;">
                        <img src="<?php echo esc_url($r['img']); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: 0.5s;">
                    </div>
                    <div style="padding: 25px;">
                        <h3 style="font-size: 1.5rem; color: #084D2A; margin-bottom: 10px;"><?php echo esc_html($r['title']); ?></h3>
                        <div style="font-size: 1.8rem; color: #E67D3C; font-weight: bold; margin-bottom: 20px;">
                            <?php echo esc_html($r['price']); ?>
                        </div>
                        <a href="<?php echo site_url('/contact'); ?>" style="display: block; width: 100%; padding: 12px; background: #084D2A; color: #fff; text-align: center; border-radius: 30px; text-decoration: none; font-weight: bold;">Book Now</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="section" style="padding: 80px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 60px; align-items: center;">
                <div>
                    <?php if($bottom_img): ?>
                        <img src="<?php echo esc_url($bottom_img); ?>" style="width: 100%; border-radius: 20px; box-shadow: -20px 20px 0 rgba(8, 77, 42, 0.1);">
                    <?php endif; ?>
                </div>
                <div>
                    <span style="color: #E67D3C; text-transform: uppercase; font-weight: bold; letter-spacing: 1px;">About Us</span>
                    <h2 style="font-size: 2.5rem; color: #084D2A; margin: 15px 0 25px;">
                        <?php echo esc_html($bottom_title); ?>
                    </h2>
                    <p style="font-size: 1.1rem; line-height: 1.8; color: #555; margin-bottom: 25px;">
                        <?php echo nl2br(esc_html($bottom_desc)); ?>
                    </p>
                    <a href="<?php echo site_url('/contact'); ?>" style="background: #E67D3C; color: #fff; padding: 12px 30px; border-radius: 30px; text-decoration: none; font-weight: bold; display: inline-block;">Contact Us</a>
                </div>
            </div>
        </div>
    </section>

</div>

<?php endwhile; ?>
<?php get_footer(); ?>