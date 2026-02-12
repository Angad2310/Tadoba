<?php
/**
 * Tadoba Theme Functions - FULL & COMPLETE VERSION
 * Includes: Package Builder, Resorts CPT, Customizer, Widgets, and Assets.
 */

// Prevent direct access
if (!defined('ABSPATH')) exit;

// =========================================
// 1. THEME SETUP
// =========================================
function tadoba_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption'));

    register_nav_menus(array(
        'primary' => 'Primary Menu',
        'footer'  => 'Footer Menu',
    ));
}
add_action('after_setup_theme', 'tadoba_theme_setup');

// =========================================
// 2. ENQUEUE ASSETS
// =========================================
function tadoba_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style('tadoba-fonts', 'https://fonts.googleapis.com/css2?family=Inclusive+Sans:ital,wght@0,400;0,600;0,700;1,400&family=Anybody:wght@400;500;600;700&display=swap');

    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

    // Theme Stylesheet
    wp_enqueue_style('tadoba-style', get_stylesheet_uri());

    // Main Theme CSS (Optional extra file - only loads if exists)
    if (file_exists(get_template_directory() . '/assets/css/theme-style.css')) {
        wp_enqueue_style('tadoba-main', get_template_directory_uri() . '/assets/css/theme-style.css', array(), '1.0.0');
    }

    // jQuery (Required)
    wp_enqueue_script('jquery');

    // Theme JS
    if (file_exists(get_template_directory() . '/assets/js/theme-script.js')) {
        wp_enqueue_script('tadoba-script', get_template_directory_uri() . '/assets/js/theme-script.js', array('jquery'), '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'tadoba_enqueue_assets');

// =========================================
// 3. REGISTER POST TYPES (PACKAGES & RESORTS)
// =========================================
function tadoba_register_post_types() {
    // Packages CPT
    register_post_type('package', array(
        'labels' => array(
            'name' => 'Packages',
            'singular_name' => 'Package',
            'add_new' => 'Add New Package',
            'add_new_item' => 'Add New Package',
            'edit_item' => 'Edit Package',
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-tickets-alt',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'packages'),
    ));

    // Resorts CPT (Restored)
    register_post_type('resort', array(
        'labels' => array(
            'name' => 'Resorts',
            'singular_name' => 'Resort',
            'add_new' => 'Add New Resort',
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-admin-home',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'resorts'),
    ));
}
add_action('init', 'tadoba_register_post_types');

// =========================================
// 4. PACKAGE BUILDER (THE EDITABLE ADMIN UI)
// =========================================

function tadoba_add_meta_boxes() {
    add_meta_box(
        'tadoba_package_details',
        '✨ Package Details (Builder)',
        'tadoba_package_details_cb',
        'package',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'tadoba_add_meta_boxes');

// =========================================
// BUILDER FUNCTION (Updated with Icon Repeater)
// =========================================
function tadoba_package_details_cb($post) {
    wp_nonce_field('tadoba_save_meta', 'tadoba_meta_nonce');

    // Retrieve Data
    $price = get_post_meta($post->ID, '_package_price', true);
    $old_price = get_post_meta($post->ID, '_package_old_price', true);
    $gallery = get_post_meta($post->ID, '_package_gallery', true);
    $map = get_post_meta($post->ID, '_package_map', true);

    // Retrieve Repeaters
    $icons = maybe_unserialize(get_post_meta($post->ID, '_package_icons', true)) ?: []; // Dynamic Icons
    $highlights = maybe_unserialize(get_post_meta($post->ID, '_package_highlights', true)) ?: [];
    $itinerary = maybe_unserialize(get_post_meta($post->ID, '_package_itinerary', true)) ?: [];
    $included = maybe_unserialize(get_post_meta($post->ID, '_package_included', true)) ?: [];
    $excluded = maybe_unserialize(get_post_meta($post->ID, '_package_excluded', true)) ?: [];
    $faqs = maybe_unserialize(get_post_meta($post->ID, '_package_faqs', true)) ?: [];
    ?>

    <style>
        .meta-section { background: #fdfdfd; border: 1px solid #ccd0d4; padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .meta-section h3 { margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px; color: #2271b1; }
        .full-width { width: 100%; margin-bottom: 10px; }
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .repeater-row { background: #fff; border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; display: flex; gap: 10px; align-items: flex-start; }
        .repeater-content { flex: 1; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
        .remove-btn { color: #d63638; cursor: pointer; font-weight: bold; padding: 5px; }
        .add-btn { background: #2271b1; color: #fff; border: none; padding: 8px 12px; cursor: pointer; border-radius: 3px; }
    </style>

    <div class="meta-section two-col">
        <div><label><strong>Current Price (₹)</strong></label><input type="number" name="package_price" value="<?php echo esc_attr($price); ?>" class="full-width"></div>
        <div><label><strong>Old Price (₹)</strong></label><input type="number" name="package_old_price" value="<?php echo esc_attr($old_price); ?>" class="full-width"></div>
    </div>

    <div class="meta-section">
        <h3>🖼️ Gallery IDs</h3>
        <input type="text" name="package_gallery" value="<?php echo esc_attr($gallery); ?>" class="full-width">
    </div>
    <div class="meta-section">
        <h3>🗺️ Map Embed URL</h3>
        <input type="text" name="package_map" value="<?php echo esc_attr($map); ?>" class="full-width">
    </div>

    <div class="meta-section">
        <h3>📍 Quick Info Icons</h3>
        <div id="icon-container">
            <?php if (!empty($icons)): foreach ($icons as $k => $icon): ?>
                <div class="repeater-row">
                    <div class="repeater-content">
                        <input type="text" name="package_icons[<?php echo $k; ?>][symbol]" value="<?php echo esc_attr($icon['symbol']); ?>" placeholder="Icon Class (fas fa-clock)">
                        <input type="text" name="package_icons[<?php echo $k; ?>][heading]" value="<?php echo esc_attr($icon['heading']); ?>" placeholder="Label (Duration)">
                        <input type="text" name="package_icons[<?php echo $k; ?>][info]" value="<?php echo esc_attr($icon['info']); ?>" placeholder="Value (3 Days)">
                    </div>
                    <span class="remove-btn">X</span>
                </div>
            <?php endforeach; endif; ?>
        </div>
        <button type="button" class="add-btn" id="add-icon">+ Add Icon</button>
    </div>

    <div class="meta-section">
        <h3>⭐ Highlights</h3>
        <textarea name="package_highlights" rows="5" class="full-width"><?php echo esc_textarea(is_array($highlights) ? implode("\n", $highlights) : $highlights); ?></textarea>
    </div>

    <div class="meta-section">
        <h3>📅 Itinerary</h3>
        <div id="itinerary-container">
            <?php if (!empty($itinerary)): foreach ($itinerary as $i => $day): ?>
                <div class="repeater-row">
                    <div class="repeater-content" style="display:block;">
                        <input type="text" name="package_itinerary[<?php echo $i; ?>][title]" value="<?php echo esc_attr($day['title']); ?>" class="full-width" placeholder="Day Title">
                        <textarea name="package_itinerary[<?php echo $i; ?>][content]" rows="3" class="full-width" placeholder="Description..."><?php echo esc_textarea($day['content']); ?></textarea>
                    </div>
                    <span class="remove-btn">X</span>
                </div>
            <?php endforeach; endif; ?>
        </div>
        <button type="button" class="add-btn" id="add-day">+ Add Day</button>
    </div>

    <div class="meta-section two-col">
        <div><h3>✅ Includes</h3><textarea name="package_included" rows="6" class="full-width"><?php echo esc_textarea(is_array($included) ? implode("\n", $included) : $included); ?></textarea></div>
        <div><h3>❌ Excludes</h3><textarea name="package_excluded" rows="6" class="full-width"><?php echo esc_textarea(is_array($excluded) ? implode("\n", $excluded) : $excluded); ?></textarea></div>
    </div>
    
    <div class="meta-section">
        <h3>❓ FAQs</h3>
        <div id="faq-container">
            <?php if (!empty($faqs)): foreach ($faqs as $j => $faq): ?>
                <div class="repeater-row">
                    <div class="repeater-content" style="display:block;">
                        <input type="text" name="package_faqs[<?php echo $j; ?>][question]" value="<?php echo esc_attr($faq['question']); ?>" class="full-width" placeholder="Question">
                        <textarea name="package_faqs[<?php echo $j; ?>][answer]" rows="2" class="full-width"><?php echo esc_textarea($faq['answer']); ?></textarea>
                    </div>
                    <span class="remove-btn">X</span>
                </div>
            <?php endforeach; endif; ?>
        </div>
        <button type="button" class="add-btn" id="add-faq">+ Add FAQ</button>
    </div>

    <script>
    jQuery(document).ready(function($){
        // Add Icon Script
        $('#add-icon').click(function(){
            var count = $('#icon-container .repeater-row').length;
            var html = '<div class="repeater-row"><div class="repeater-content">' +
                       '<input type="text" name="package_icons['+count+'][symbol]" placeholder="Icon Class (fas fa-star)">' +
                       '<input type="text" name="package_icons['+count+'][heading]" placeholder="Label">' +
                       '<input type="text" name="package_icons['+count+'][info]" placeholder="Value">' +
                       '</div><span class="remove-btn">X</span></div>';
            $('#icon-container').append(html);
        });

        // Add Itinerary Script
        $('#add-day').click(function(){
            var count = $('#itinerary-container .repeater-row').length;
            var html = '<div class="repeater-row"><div class="repeater-content" style="display:block;">' +
                       '<input type="text" name="package_itinerary['+count+'][title]" class="full-width" placeholder="Day Title">' +
                       '<textarea name="package_itinerary['+count+'][content]" rows="3" class="full-width"></textarea>' +
                       '</div><span class="remove-btn">X</span></div>';
            $('#itinerary-container').append(html);
        });

        // Add FAQ Script
        $('#add-faq').click(function(){
            var count = $('#faq-container .repeater-row').length;
            var html = '<div class="repeater-row"><div class="repeater-content" style="display:block;">' +
                       '<input type="text" name="package_faqs['+count+'][question]" class="full-width" placeholder="Question">' +
                       '<textarea name="package_faqs['+count+'][answer]" rows="2" class="full-width"></textarea>' +
                       '</div><span class="remove-btn">X</span></div>';
            $('#faq-container').append(html);
        });

        $(document).on('click', '.remove-btn', function(){ $(this).parent().remove(); });
    });
    </script>
    <?php
}

// =========================================
// SAVE FUNCTION (Updated to Save Icon Repeater)
// =========================================
function tadoba_save_meta($post_id) {
    if (!isset($_POST['tadoba_meta_nonce']) || !wp_verify_nonce($_POST['tadoba_meta_nonce'], 'tadoba_save_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['package_price'])) update_post_meta($post_id, '_package_price', sanitize_text_field($_POST['package_price']));
    if (isset($_POST['package_old_price'])) update_post_meta($post_id, '_package_old_price', sanitize_text_field($_POST['package_old_price']));
    if (isset($_POST['package_gallery'])) update_post_meta($post_id, '_package_gallery', sanitize_text_field($_POST['package_gallery']));
    if (isset($_POST['package_map'])) update_post_meta($post_id, '_package_map', sanitize_text_field($_POST['package_map']));

    // Save Textareas
    $lines = ['package_highlights', 'package_included', 'package_excluded'];
    foreach ($lines as $f) {
        if (isset($_POST[$f])) {
            $arr = array_filter(array_map('trim', explode("\n", $_POST[$f])));
            update_post_meta($post_id, '_' . $f, serialize($arr));
        }
    }

    // Save Repeaters (Itinerary, FAQs, Icons)
    if (isset($_POST['package_itinerary'])) update_post_meta($post_id, '_package_itinerary', serialize(array_values($_POST['package_itinerary'])));
    else delete_post_meta($post_id, '_package_itinerary');

    if (isset($_POST['package_faqs'])) update_post_meta($post_id, '_package_faqs', serialize(array_values($_POST['package_faqs'])));
    else delete_post_meta($post_id, '_package_faqs');

    // ** THIS IS THE FIX FOR ICONS **
    if (isset($_POST['package_icons'])) update_post_meta($post_id, '_package_icons', serialize(array_values($_POST['package_icons'])));
    else delete_post_meta($post_id, '_package_icons');
}
add_action('save_post', 'tadoba_save_meta');

// =========================================
// 6. CUSTOMIZER SETTINGS (RESTORED)
// =========================================
function tadoba_customizer($wp_customize) {
    // Hero Section
    $wp_customize->add_section('tadoba_hero', array(
        'title' => 'Hero Section',
        'priority' => 30,
    ));

    $wp_customize->add_setting('hero_image', array('default' => ''));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', array(
        'label' => 'Hero Background Image',
        'section' => 'tadoba_hero',
    )));

    $wp_customize->add_setting('hero_subtitle', array('default' => 'EMBARK ON YOUR NEXT ADVENTURE'));
    $wp_customize->add_control('hero_subtitle', array(
        'label' => 'Hero Subtitle',
        'section' => 'tadoba_hero',
        'type' => 'text',
    ));

    $wp_customize->add_setting('hero_title', array('default' => 'Discover the Wild Like Never Before'));
    $wp_customize->add_control('hero_title', array(
        'label' => 'Hero Title',
        'section' => 'tadoba_hero',
        'type' => 'text',
    ));

    $wp_customize->add_setting('hero_description', array('default' => 'Experience breathtaking safaris, hidden trails, and jungle adventures.'));
    $wp_customize->add_control('hero_description', array(
        'label' => 'Hero Description',
        'section' => 'tadoba_hero',
        'type' => 'textarea',
    ));

    // Contact Info
    $wp_customize->add_section('tadoba_contact', array(
        'title' => 'Contact Information',
        'priority' => 40,
    ));

    $wp_customize->add_setting('contact_phone', array('default' => '+91 12345 67890'));
    $wp_customize->add_control('contact_phone', array(
        'label' => 'Phone Number',
        'section' => 'tadoba_contact',
        'type' => 'text',
    ));

    $wp_customize->add_setting('contact_email', array('default' => 'info@tadoba.com'));
    $wp_customize->add_control('contact_email', array(
        'label' => 'Email Address',
        'section' => 'tadoba_contact',
        'type' => 'email',
    ));

    // Social Media
    $wp_customize->add_section('tadoba_social', array(
        'title' => 'Social Media',
        'priority' => 50,
    ));

    $socials = array('facebook', 'twitter', 'instagram', 'youtube');
    foreach ($socials as $social) {
        $wp_customize->add_setting('social_' . $social, array('default' => ''));
        $wp_customize->add_control('social_' . $social, array(
            'label' => ucfirst($social) . ' URL',
            'section' => 'tadoba_social',
            'type' => 'url',
        ));
    }
}
add_action('customize_register', 'tadoba_customizer');

// Helper function for Social Links
function tadoba_social_links() {
    $socials = array(
        'facebook' => 'fab fa-facebook-f',
        'twitter' => 'fab fa-twitter',
        'instagram' => 'fab fa-instagram',
        'youtube' => 'fab fa-youtube',
    );

    echo '<div class="social-links">';
    foreach ($socials as $social => $icon) {
        $url = get_theme_mod('social_' . $social);
        if ($url) {
            echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener"><i class="' . esc_attr($icon) . '"></i></a>';
        }
    }
    echo '</div>';
}

// =========================================
// 7. WIDGET AREAS (RESTORED)
// =========================================
function tadoba_widgets_init() {
    register_sidebar(array(
        'name' => 'Footer Column 1',
        'id' => 'footer-1',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'Footer Column 2',
        'id' => 'footer-2',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'Footer Column 3',
        'id' => 'footer-3',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'tadoba_widgets_init');

// =========================================
// 7. FOREST CPT & META BOXES
// =========================================
function tadoba_register_forest_cpt() {
    register_post_type('forest', array(
        'labels' => array(
            'name' => 'Forests',
            'singular_name' => 'Forest',
            'add_new' => 'Add New Forest',
            'add_new_item' => 'Add New Forest',
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-palmtree',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'forests'),
    ));
}
add_action('init', 'tadoba_register_forest_cpt');

function tadoba_add_forest_meta() {
    add_meta_box('forest_details', '🌿 Forest Details', 'tadoba_forest_cb', 'forest', 'normal', 'high');
}
add_action('add_meta_boxes', 'tadoba_add_forest_meta');

function tadoba_forest_cb($post) {
    wp_nonce_field('tadoba_forest_save', 'tadoba_forest_nonce');
    
    $location = get_post_meta($post->ID, '_forest_location', true);
    $best_time = get_post_meta($post->ID, '_forest_best_time', true);
    $airport = get_post_meta($post->ID, '_forest_airport', true);
    $closed_day = get_post_meta($post->ID, '_forest_closed_day', true);
    
    // Textareas for Lists
    $core_zones = maybe_unserialize(get_post_meta($post->ID, '_forest_core_zones', true)) ?: [];
    $buffer_zones = maybe_unserialize(get_post_meta($post->ID, '_forest_buffer_zones', true)) ?: [];
    $safari_timing = get_post_meta($post->ID, '_forest_safari_timing', true);
    ?>
    
    <style>
        .f-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px; }
        .f-row { margin-bottom: 15px; }
        .f-row label { font-weight: bold; display: block; margin-bottom: 5px; }
        .f-input { width: 100%; padding: 8px; }
    </style>

    <div class="f-grid">
        <div><label>📍 Location (State/District)</label><input type="text" name="forest_location" value="<?php echo esc_attr($location); ?>" class="f-input"></div>
        <div><label>☀️ Best Time to Visit</label><input type="text" name="forest_best_time" value="<?php echo esc_attr($best_time); ?>" class="f-input"></div>
    </div>

    <div class="f-grid">
        <div><label>✈️ Nearest Airport/City</label><input type="text" name="forest_airport" value="<?php echo esc_attr($airport); ?>" class="f-input"></div>
        <div><label>🚫 Weekly Closed Day</label><input type="text" name="forest_closed_day" value="<?php echo esc_attr($closed_day); ?>" class="f-input"></div>
    </div>

    <div class="f-grid">
        <div><label>🦁 Core Zones (One per line)</label><textarea name="forest_core_zones" rows="5" class="f-input"><?php echo esc_textarea(implode("\n", $core_zones)); ?></textarea></div>
        <div><label>🌳 Buffer Zones (One per line)</label><textarea name="forest_buffer_zones" rows="5" class="f-input"><?php echo esc_textarea(implode("\n", $buffer_zones)); ?></textarea></div>
    </div>

    <div class="f-row">
        <label>🚙 Safari Timing Info</label>
        <textarea name="forest_safari_timing" rows="3" class="f-input"><?php echo esc_textarea($safari_timing); ?></textarea>
    </div>
    <?php
}

function tadoba_save_forest($post_id) {
    if (!isset($_POST['tadoba_forest_nonce']) || !wp_verify_nonce($_POST['tadoba_forest_nonce'], 'tadoba_forest_save')) return;
    
    if(isset($_POST['forest_location'])) update_post_meta($post_id, '_forest_location', sanitize_text_field($_POST['forest_location']));
    if(isset($_POST['forest_best_time'])) update_post_meta($post_id, '_forest_best_time', sanitize_text_field($_POST['forest_best_time']));
    if(isset($_POST['forest_airport'])) update_post_meta($post_id, '_forest_airport', sanitize_text_field($_POST['forest_airport']));
    if(isset($_POST['forest_closed_day'])) update_post_meta($post_id, '_forest_closed_day', sanitize_text_field($_POST['forest_closed_day']));
    if(isset($_POST['forest_safari_timing'])) update_post_meta($post_id, '_forest_safari_timing', sanitize_textarea_field($_POST['forest_safari_timing']));

    if(isset($_POST['forest_core_zones'])) {
        $core = array_filter(array_map('trim', explode("\n", $_POST['forest_core_zones'])));
        update_post_meta($post_id, '_forest_core_zones', serialize($core));
    }
    if(isset($_POST['forest_buffer_zones'])) {
        $buffer = array_filter(array_map('trim', explode("\n", $_POST['forest_buffer_zones'])));
        update_post_meta($post_id, '_forest_buffer_zones', serialize($buffer));
    }
}
add_action('save_post', 'tadoba_save_forest');