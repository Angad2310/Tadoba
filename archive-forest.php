<?php get_header(); ?>

<section class="hero-section" style="height: 60vh; min-height: 400px; position: relative;">
    <img src="https://images.unsplash.com/photo-1511497584788-876760111969?w=1600" alt="Jungle Canopy" class="hero-image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4);"></div>
    
    <div class="hero-content" style="position: relative; z-index: 2; text-align: center; color: #fff; top: 50%; transform: translateY(-50%);">
        <h1 class="hero-title" style="font-size: 3rem; margin-bottom: 15px;">Explore India's Untamed Forests</h1>
        <p style="font-size: 1.2rem; max-width: 700px; margin: 0 auto;">
            Discover pristine tiger reserves, lush biodiversity, and the hidden gems of the wild. Choose your next adventure.
        </p>
    </div>
</section>

<section class="section" style="padding: 80px 0; background-color: #F7F0E5;"> <div class="container">
        
        <?php if (have_posts()) : ?>
            <div class="forest-archive-grid">
                <?php while (have_posts()) : the_post(); 
                    $pid = get_the_ID();
                    
                    // Get Custom Fields (Location, Best Time, Area)
                    $location = get_post_meta($pid, '_forest_location', true);
                    $best_time = get_post_meta($pid, '_forest_best_time', true);
                    $area = get_post_meta($pid, '_area_size', true);
                    
                    // Get Thumbnail
                    $thumb_url = get_the_post_thumbnail_url($pid, 'large');
                ?>
                
                <article class="forest-card">
                    <a href="<?php the_permalink(); ?>" class="f-card-img-link">
                        <?php if($thumb_url): ?>
                            <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title(); ?>" class="f-card-img">
                        <?php else: ?>
                            <div class="f-card-placeholder" style="background-color: #ccc; width: 100%; height: 100%;"></div>
                        <?php endif; ?>
                        <span class="f-card-badge"><i class="fas fa-tree"></i> National Park</span>
                    </a>

                    <div class="f-card-content">
                        <div class="f-card-meta">
                            <span><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($location); ?></span>
                            <?php if($area): ?>
                                <span><i class="fas fa-ruler-combined"></i> <?php echo esc_html($area); ?></span>
                            <?php endif; ?>
                        </div>

                        <h2 class="f-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <p class="f-card-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                        </p>

                        <div class="f-card-footer">
                            <div class="f-season">
                                <i class="fas fa-sun"></i>
                                <div>
                                    <small>Best Season</small>
                                    <strong><?php echo esc_html($best_time); ?></strong>
                                </div>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn-circle">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>

            <div class="pagination-wrapper">
                <?php 
                echo paginate_links(array(
                    'prev_text' => '<i class="fas fa-chevron-left"></i>',
                    'next_text' => '<i class="fas fa-chevron-right"></i>',
                )); 
                ?>
            </div>

        <?php else : ?>
            <div style="text-align: center; padding: 100px 0;">
                <h2 style="color: #084D2A;">No Forests Found</h2>
                <p>Go to your Dashboard > Forests > Add New to create your first listing!</p>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<?php get_footer(); ?>