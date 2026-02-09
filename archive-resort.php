<?php
/**
 * Archive Template for Resorts
 */
get_header();
?>

<!-- Hero Section -->
<section class="hero-section">
    <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1600" alt="Our Resorts" class="hero-image">
    <div class="hero-content">
        <p class="hero-subtitle reveal-on-scroll">Discover Paradise</p>
        <h1 class="hero-title reveal-on-scroll">Our <span class="highlight">Resorts</span></h1>
        <p class="hero-description reveal-on-scroll">Explore our collection of luxury jungle resorts</p>
    </div>
    <div class="hero-bottom-fade-overlay"></div>
</section>

<!-- Resorts Grid -->
<section class="section grid-section">
    <div class="pattern-bg"></div>
    <div class="container">
        <div class="safari-cards-grid">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
                <div class="safari-card reveal-on-scroll">
                    <div class="safari-card-image-wrapper">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('package-card', array('class' => 'safari-card-image', 'alt' => get_the_title())); ?>
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800" alt="<?php the_title(); ?>" class="safari-card-image">
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="safari-card-content">
                        <h3 class="safari-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn-primary" style="margin-top: 15px;">View Details</a>
                    </div>
                </div>
            <?php endwhile; else: ?>
                <p>No resorts found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
