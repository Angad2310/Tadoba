<?php get_header(); ?>

<?php while (have_posts()) : the_post(); 
    $pid = get_the_ID();
    
    // Data Retrieval
    $price = get_post_meta($pid, '_package_price', true);
    $old_price = get_post_meta($pid, '_package_old_price', true);
    $gallery_raw = get_post_meta($pid, '_package_gallery', true);
    $gallery_ids = !empty($gallery_raw) ? explode(',', $gallery_raw) : [];
    $map = get_post_meta($pid, '_package_map', true);

    // Arrays
    $icons = maybe_unserialize(get_post_meta($pid, '_package_icons', true));
    $highlights = maybe_unserialize(get_post_meta($pid, '_package_highlights', true));
    $itinerary = maybe_unserialize(get_post_meta($pid, '_package_itinerary', true));
    $included = maybe_unserialize(get_post_meta($pid, '_package_included', true));
    $excluded = maybe_unserialize(get_post_meta($pid, '_package_excluded', true));
    $faqs = maybe_unserialize(get_post_meta($pid, '_package_faqs', true));
?>

<div class="package-view-wrapper">
    <?php if (!empty($gallery_ids)) : ?>
    <div class="package-collage">
        <div class="collage-large" style="background-image: url('<?php echo wp_get_attachment_image_url(trim($gallery_ids[0]), 'full'); ?>')">
             <div class="days-label"><span>7</span> Days</div>
        </div>
        <div class="collage-thumbs">
            <div class="thumb-box" style="background-image: url('<?php echo isset($gallery_ids[1]) ? wp_get_attachment_image_url(trim($gallery_ids[1]), 'large') : ''; ?>')"></div>
            <div class="thumb-box" style="background-image: url('<?php echo isset($gallery_ids[2]) ? wp_get_attachment_image_url(trim($gallery_ids[2]), 'large') : ''; ?>')">
                <div class="overlay-txt"><i class="fas fa-camera"></i> Gallery</div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="container package-main-flex">
        <div class="package-left">
            <h1 class="package-main-title"><?php the_title(); ?></h1>

            <?php if(!empty($icons)): ?>
            <div class="package-icon-bar horizontal">
                <?php foreach($icons as $icon): ?>
                <div class="p-icon-box">
                    <i class="<?php echo esc_attr($icon['symbol']); ?>"></i> 
                    <p><?php echo esc_html($icon['heading']); ?></p>
                    <span><?php echo esc_html($icon['info']); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <section class="details-section">
                <h2 class="h2-title">Overview</h2>
                <div class="overview-txt"><?php the_content(); ?></div>
                <h3 class="h3-subtitle">Highlights</h3>
                <ul class="highlight-check-list">
                    <?php if($highlights) foreach($highlights as $hl) : ?>
                        <li><i class="fas fa-check-circle"></i> <?php echo esc_html($hl); ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <section class="details-section">
                <h2 class="h2-title">Itinerary</h2>
                <div class="orange-path-timeline">
                    <?php if(!empty($itinerary)) : foreach($itinerary as $k => $day) : ?>
                    <div class="path-day">
                        <div class="path-dot"></div>
                        <div class="path-info">
                            <h4>Day <?php echo $k + 1; ?>: <?php echo esc_html($day['title']); ?></h4>
                            <div class="path-text"><?php echo wpautop(esc_html($day['content'])); ?></div>
                        </div>
                    </div>
                    <?php endforeach; endif; ?>
                </div>
            </section>

            <section class="details-section">
                <h2 class="h2-title">Cost</h2>
                <div class="cost-split-row">
                    <div class="cost-item inc">
                        <h3>Included</h3>
                        <ul><?php if($included) foreach($included as $in) echo '<li><i class="fas fa-check"></i> '.$in.'</li>'; ?></ul>
                    </div>
                    <div class="cost-item exc">
                        <h3>Excluded</h3>
                        <ul><?php if($excluded) foreach($excluded as $ex) echo '<li><i class="fas fa-times"></i> '.$ex.'</li>'; ?></ul>
                    </div>
                </div>
            </section>

            <?php if(!empty($faqs)): ?>
            <section class="details-section">
                <h2 class="h2-title">Frequently Asked Questions</h2>
                <div class="faq-accordion">
                    <?php foreach($faqs as $faq): ?>
                    <div class="faq-item">
                        <button class="faq-trigger"><?php echo esc_html($faq['question']); ?> <i class="fas fa-chevron-down"></i></button>
                        <div class="faq-answer"><p><?php echo esc_html($faq['answer']); ?></p></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <?php if($map): ?>
            <section class="details-section">
                <h2 class="h2-title">Map</h2>
                <div class="map-container">
                    <iframe src="<?php echo esc_url($map); ?>" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </section>
            <?php endif; ?>
        </div>

        <aside class="package-sidebar">
            <div class="sticky-wrapper">
                <div class="sticky-price-card">
                    <div class="price-data">
                        <?php if($old_price): ?><span class="old-p">₹<?php echo $old_price; ?></span><?php endif; ?>
                        <div class="new-p">₹<?php echo $price; ?> <span>/ Person</span></div>
                    </div>
                    <a href="<?php echo site_url('/contact'); ?>" class="cta-booking-btn">Check Availability</a>
                    <p class="cta-help">Questions? <a href="#">Contact Us</a></p>
                </div>

                <?php if(!empty($icons)): ?>
                <div class="sidebar-icons-vertical">
                    <?php foreach($icons as $icon): ?>
                    <div class="v-icon-box">
                        <i class="<?php echo esc_attr($icon['symbol']); ?>"></i>
                        <div>
                            <strong><?php echo esc_html($icon['heading']); ?></strong>
                            <span><?php echo esc_html($icon['info']); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </aside>
    </div>
</div>

<script>
jQuery(document).ready(function($){
    $('.faq-trigger').click(function(){
        $(this).next('.faq-answer').slideToggle();
        $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
    });
});
</script>

<?php endwhile; ?>
<?php get_footer(); ?>