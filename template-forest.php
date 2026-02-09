<?php
/*
Template Name: Forest Guide Page
*/

get_header(); 

// 1. Get the ID of the current page so we can retrieve its custom fields
$post_id = get_the_ID();
?>

    <section class="hero-section">
        <?php 
            $hero_image = get_post_meta($post_id, 'hero_bg_image', true); 
            // Fallback: If no image is set in Dashboard, use a default one
            if( empty($hero_image) ) { $hero_image = 'https://images.unsplash.com/photo-1591824438708-ce405f36ba3d?w=1600'; }
        ?>
        <img src="<?php echo esc_url($hero_image); ?>" alt="Hero Background" class="hero-image">
        
        <div class="hero-content">
            <h1 class="hero-title reveal-on-scroll">
                <?php 
                    $h_title = get_post_meta($post_id, 'hero_title', true);
                    echo $h_title ? $h_title : 'The Land of Tigers'; // Show default if empty
                ?>
            </h1>
            
            <p class="section-description reveal-on-scroll" style="color:#fff;">
                <?php 
                    $h_sub = get_post_meta($post_id, 'hero_subtitle', true);
                    echo $h_sub ? $h_sub : 'Maharashtra\'s oldest and largest National Park.';
                ?>
            </p>
            
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
                    <p class="section-description">
                        Situated in Chandrapur, Tadoba was recognized as a Tiger Reserve in <strong>1995</strong>. It combines the Tadoba National Park and the Andhari Wildlife Sanctuary.
                    </p>
                    
                    <div style="display: flex; gap: 30px; margin-top: 15px; justify-content: center;">
                        <div style="text-align: center;">
                            <h4 style="color: var(--tmp-heading-color); font-size: 24px;">
                                <?php echo get_post_meta($post_id, 'stat_area', true) ?: '1,727'; ?>
                            </h4>
                            <p style="font-size: 11px; color: #777; text-transform: uppercase;">Total Sq. Km</p>
                        </div>
                        <div style="text-align: center;">
                            <h4 style="color: var(--tmp-heading-color); font-size: 24px;">
                                <?php echo get_post_meta($post_id, 'stat_distance', true) ?: '150km'; ?>
                            </h4>
                            <p style="font-size: 11px; color: #777; text-transform: uppercase;">From Nagpur</p>
                        </div>
                    </div>
                </div>
                <div class="reveal-on-scroll about-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1549366021-9f761d450615?w=800" alt="Majestic Tiger" class="about-image">
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="flora" style="background-color: var(--tmp-section-bg-alt);">
        <div class="feed-from-cream"></div>
        <div class="container">
            <div class="about-grid reverse">
                <div class="reveal-on-scroll about-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1440613905118-99b921706b5c?w=800" alt="Forest Canopy" class="about-image">
                </div>
                <div class="reveal-on-scroll">
                    <span class="section-subtitle">Nature's Canopy</span>
                    <h2 class="section-title">Rich <span style="color: var(--tmp-primary-color);">Biodiversity</span></h2>
                    <p class="section-description">
                        Dominated by <strong>Teak and Bamboo</strong>, this Southern Tropical Dry Deciduous forest is home to approximately 88 Bengal Tigers.
                    </p>
                    <div class="info-card">
                        <ul class="rules-list">
                            <li><strong>Flora:</strong> 141 recorded tree species.</li>
                            <li><strong>Fauna:</strong> Tigers, Leopards, Sloth Bears.</li>
                            <li><strong>Avian:</strong> 195+ recorded Bird species.</li>
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
                <p class="section-description">
                    Tadoba consists of <strong>6 core zones</strong>. Online booking 90 days in advance is highly recommended.
                </p>
            </div>

            <div class="amenities-grid reveal-on-scroll">
                <div class="amenity-card">
                    <h4>Moharli Gate</h4>
                    <p>The oldest entrance. Known for the Teliya Lake and frequent tiger sightings.</p>
                </div>
                <div class="amenity-card">
                    <h4>Kolara Gate</h4>
                    <p>Located on the northern side, famous for core access and leopard tracking.</p>
                </div>
                <div class="amenity-card">
                    <h4>Navegaon Gate</h4>
                    <p>Territory of dominant tigers. Features beautiful water bodies and forest trails.</p>
                </div>
                <div class="amenity-card">
                    <h4>Junona (Buffer)</h4>
                    <p>Unique for its <strong>Night Safaris</strong> and proximity to vital core corridors.</p>
                </div>
                <div class="amenity-card">
                    <h4>Agrazari (Buffer)</h4>
                    <p>Popular for Jharna Nala and Crocodile Point. Open year-round.</p>
                </div>
                <div class="amenity-card">
                    <h4>Madnapur (Buffer)</h4>
                    <p>Close to Kolara, famous for sightings even during the monsoon seasons.</p>
                </div>
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
                                <tr><td>Oct - Nov</td><td>06:00 - 10:00</td><td>14:30 - 18:30</td></tr>
                                <tr><td>Dec - Feb</td><td>06:30 - 11:00</td><td>14:00 - 18:00</td></tr>
                                <tr><td>Mar - Apr</td><td>05:30 - 10:00</td><td>15:00 - 18:30</td></tr>
                                <tr><td>May - Jun</td><td>05:00 - 09:30</td><td>15:30 - 19:00</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="reveal-on-scroll" style="width: 100%;">
                    <span class="section-subtitle">Etiquette</span>
                    <h2 class="section-title">Jungle Rules</h2>
                    <div class="info-card" style="background: var(--tmp-heading-color); color: #fff;">
                        <ul class="rules-list" style="color: #eee;">
                            <li style="color: #fff;">Carry original Photo ID at all times.</li>
                            <li style="color: #fff;">Wear earth-toned colors (Beige, Brown).</li>
                            <li style="color: #fff;">Silence is mandatory during sightings.</li>
                            <li style="color: #fff;">No littering inside the reserve.</li>
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
                    <img src="https://images.unsplash.com/photo-1547407139-3c921a66005c?w=800" alt="Safari Jeep" class="about-image">
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
                                <tr><td>Nagpur</td><td>120 km</td></tr>
                                <tr><td>Chandrapur</td><td>35 km</td></tr>
                                <tr><td>Hyderabad</td><td>435 km</td></tr>
                                <tr><td>Mumbai</td><td>919 km</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="feed-to-dark"></div>
    </section>

<?php get_footer(); ?>