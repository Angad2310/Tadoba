<?php
$duration = get_post_meta(get_the_ID(), '_package_duration', true);
$price = get_post_meta(get_the_ID(), '_package_price', true);
$old_price = get_post_meta(get_the_ID(), '_package_old_price', true);
$discount = get_post_meta(get_the_ID(), '_package_discount', true);
$zone = get_post_meta(get_the_ID(), '_package_zone', true);
?>

<div class="wpte-card wpte-card--t-b">
    <div class="wpte-card-wrap">
        <div class="wpte-card-media">
            <?php if ($discount): ?>
                <div class="wpte-badge wpte-badge-discount">
                    <span class="wpte-badge-text"><?php echo esc_html($discount); ?></span>
                </div>
            <?php endif; ?>
            
            <figure class="wpte-card-image">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('package-card'); ?>
                </a>
            </figure>
        </div>
        
        <div class="wpte-card-content">
            <?php if ($zone): ?>
                <div class="wpte-card-location">
                    <span><?php echo esc_html($zone); ?></span>
                </div>
            <?php endif; ?>
            
            <h3 class="wpte-card-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
            
            <?php if ($duration): ?>
                <div class="wpte-card-meta">
                    <span><?php echo esc_html($duration); ?></span>
                </div>
            <?php endif; ?>
            
            <div class="wpte-card-price">
                <?php if ($old_price): ?>
                    <del>₹<?php echo esc_html($old_price); ?></del>
                <?php endif; ?>
                <?php if ($price): ?>
                    <ins>₹<?php echo esc_html($price); ?></ins>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
