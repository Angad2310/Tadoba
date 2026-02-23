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

    // Add these lines inside your save_post function block

// 1. Save Indian Prices
if (isset($_POST['indian_price_actual'])) {
    update_post_meta($post_id, '_package_indian_price_actual', sanitize_text_field($_POST['indian_price_actual']));
}
if (isset($_POST['indian_price_offer'])) {
    update_post_meta($post_id, '_package_indian_price_offer', sanitize_text_field($_POST['indian_price_offer']));
}

// 2. Save Global Prices
if (isset($_POST['global_price_actual'])) {
    update_post_meta($post_id, '_package_global_price_actual', sanitize_text_field($_POST['global_price_actual']));
}
if (isset($_POST['global_price_offer'])) {
    update_post_meta($post_id, '_package_global_price_offer', sanitize_text_field($_POST['global_price_offer']));
}

// 3. Save the Checkbox
// Checkboxes are tricky: if unchecked, nothing is sent in $_POST.
$show_benefits_value = isset($_POST['show_booking_benefits']) && $_POST['show_booking_benefits'] === 'yes' ? 'yes' : 'no';
update_post_meta($post_id, '_package_show_benefits', $show_benefits_value);
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
            'all_items' => 'All Forests'
        ),
        'public' => true,
        // This line explicitly names the archive page "forests"
        'has_archive' => 'forests', 
        'menu_icon' => 'dashicons-palmtree',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        // This ensures the URL is mysite.com/forests/
        'rewrite' => array('slug' => 'forests', 'with_front' => false), 
        'show_in_rest' => true, 
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

// ... Previous Theme Setup Code ...

// =========================================
// 8. DYNAMIC FOREST EDITOR (The Magic Part)
// =========================================

// 1. Register Meta Box
function tadoba_forest_full_meta() {
    add_meta_box('forest_full_data', '🌿 Forest Content Editor', 'forest_editor_cb', 'forest', 'normal', 'high');
}
add_action('add_meta_boxes', 'tadoba_forest_full_meta');

// 2. The Admin Interface
function forest_editor_cb($post) {
    wp_nonce_field('forest_save_nonce', 'forest_nonce');

    // Retrieve ALL Data
    $hero_sub = get_post_meta($post->ID, '_hero_sub', true);
    $area = get_post_meta($post->ID, '_area_size', true);
    $distance = get_post_meta($post->ID, '_distance_city', true);
    $flora_img = get_post_meta($post->ID, '_flora_img', true);
    $flora_list = maybe_unserialize(get_post_meta($post->ID, '_flora_list', true)) ?: [];
    $zones_list = maybe_unserialize(get_post_meta($post->ID, '_zones_list', true)) ?: [];
    $timing_list = maybe_unserialize(get_post_meta($post->ID, '_timing_list', true)) ?: [];
    $rules_list = maybe_unserialize(get_post_meta($post->ID, '_rules_list', true)) ?: [];
    $logistics_img = get_post_meta($post->ID, '_logistics_img', true);
    $logistics_list = maybe_unserialize(get_post_meta($post->ID, '_logistics_list', true)) ?: [];
    ?>

    <style>
        .meta-grp { background: #f8f8f8; border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; }
        .meta-grp h3 { margin-top: 0; color: #084D2A; border-bottom: 2px solid #DEED58; padding-bottom: 10px; }
        .row-item { background: #fff; padding: 10px; margin-bottom: 5px; border: 1px solid #eee; display: flex; gap: 10px; align-items: center;}
        .w-100 { width: 100%; margin-bottom: 5px; padding: 5px; }
        .btn-add { background: #084D2A; color: #fff; border: none; padding: 5px 10px; cursor: pointer; }
        .btn-rem { color: red; cursor: pointer; font-weight: bold; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    </style>

    <div class="meta-grp">
        <h3>1. Hero & About Stats</h3>
        <label>Hero Subtitle:</label>
        <input type="text" name="hero_sub" value="<?php echo esc_attr($hero_sub); ?>" class="w-100">
        <div class="grid-2">
            <div><label>Total Area (e.g. 1,727 Sq. Km):</label><input type="text" name="area_size" value="<?php echo esc_attr($area); ?>" class="w-100"></div>
            <div><label>Distance (e.g. 150km from Nagpur):</label><input type="text" name="distance_city" value="<?php echo esc_attr($distance); ?>" class="w-100"></div>
        </div>
    </div>

    <div class="meta-grp">
        <h3>2. Biodiversity (Flora/Fauna)</h3>
        <label>Image URL:</label>
        <input type="text" name="flora_img" value="<?php echo esc_attr($flora_img); ?>" class="w-100" placeholder="Paste Image URL">
        <label>Bullet Points:</label>
        <div id="flora-con">
            <?php foreach($flora_list as $f): ?>
                <div class="row-item"><input type="text" name="flora_list[]" value="<?php echo esc_attr($f); ?>" class="w-100"><span class="btn-rem">X</span></div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" onclick="addSimpleRow('flora-con', 'flora_list[]')">+ Add Bullet Point</button>
    </div>

    <div class="meta-grp">
        <h3>3. Safari Zones</h3>
        <div id="zones-con">
            <?php foreach($zones_list as $k => $z): ?>
                <div class="row-item">
                    <input type="text" name="zones_list[<?php echo $k; ?>][title]" value="<?php echo esc_attr($z['title']); ?>" placeholder="Gate Name">
                    <input type="text" name="zones_list[<?php echo $k; ?>][desc]" value="<?php echo esc_attr($z['desc']); ?>" placeholder="Description">
                    <span class="btn-rem">X</span>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" id="add-zone">+ Add Zone</button>
    </div>

    <div class="meta-grp">
        <h3>4. Timings & Rules</h3>
        <h4>Timings Table</h4>
        <div id="timing-con">
            <?php foreach($timing_list as $k => $t): ?>
                <div class="row-item">
                    <input type="text" name="timing_list[<?php echo $k; ?>][season]" value="<?php echo esc_attr($t['season']); ?>" placeholder="Season (e.g. Oct-Nov)">
                    <input type="text" name="timing_list[<?php echo $k; ?>][am]" value="<?php echo esc_attr($t['am']); ?>" placeholder="Morning Time">
                    <input type="text" name="timing_list[<?php echo $k; ?>][pm]" value="<?php echo esc_attr($t['pm']); ?>" placeholder="Evening Time">
                    <span class="btn-rem">X</span>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" id="add-time">+ Add Time Row</button>
        
        <br><br><h4>Jungle Rules</h4>
        <div id="rules-con">
            <?php foreach($rules_list as $r): ?>
                <div class="row-item"><input type="text" name="rules_list[]" value="<?php echo esc_attr($r); ?>" class="w-100"><span class="btn-rem">X</span></div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" onclick="addSimpleRow('rules-con', 'rules_list[]')">+ Add Rule</button>
    </div>

    <div class="meta-grp">
        <h3>5. Logistics</h3>
        <label>Image URL:</label>
        <input type="text" name="logistics_img" value="<?php echo esc_attr($logistics_img); ?>" class="w-100">
        <div id="logistics-con">
            <?php foreach($logistics_list as $k => $l): ?>
                <div class="row-item">
                    <input type="text" name="logistics_list[<?php echo $k; ?>][route]" value="<?php echo esc_attr($l['route']); ?>" placeholder="Route (e.g. Nagpur)">
                    <input type="text" name="logistics_list[<?php echo $k; ?>][dist]" value="<?php echo esc_attr($l['dist']); ?>" placeholder="Distance (e.g. 120km)">
                    <span class="btn-rem">X</span>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" id="add-log">+ Add Distance Row</button>
    </div>

    <script>
        function addSimpleRow(id, name) {
            var el = document.getElementById(id);
            var div = document.createElement('div');
            div.className = 'row-item';
            div.innerHTML = '<input type="text" name="'+name+'" class="w-100"><span class="btn-rem" onclick="this.parentNode.remove()">X</span>';
            el.appendChild(div);
        }
        
        document.getElementById('add-zone').addEventListener('click', function(){
            var idx = document.querySelectorAll('#zones-con .row-item').length;
            var html = '<div class="row-item"><input type="text" name="zones_list['+idx+'][title]" placeholder="Gate Name"><input type="text" name="zones_list['+idx+'][desc]" placeholder="Desc"><span class="btn-rem" onclick="this.parentNode.remove()">X</span></div>';
            document.getElementById('zones-con').insertAdjacentHTML('beforeend', html);
        });

        document.getElementById('add-time').addEventListener('click', function(){
            var idx = document.querySelectorAll('#timing-con .row-item').length;
            var html = '<div class="row-item"><input type="text" name="timing_list['+idx+'][season]" placeholder="Season"><input type="text" name="timing_list['+idx+'][am]" placeholder="AM"><input type="text" name="timing_list['+idx+'][pm]" placeholder="PM"><span class="btn-rem" onclick="this.parentNode.remove()">X</span></div>';
            document.getElementById('timing-con').insertAdjacentHTML('beforeend', html);
        });

        document.getElementById('add-log').addEventListener('click', function(){
            var idx = document.querySelectorAll('#logistics-con .row-item').length;
            var html = '<div class="row-item"><input type="text" name="logistics_list['+idx+'][route]" placeholder="Route"><input type="text" name="logistics_list['+idx+'][dist]" placeholder="Distance"><span class="btn-rem" onclick="this.parentNode.remove()">X</span></div>';
            document.getElementById('logistics-con').insertAdjacentHTML('beforeend', html);
        });

        document.querySelectorAll('.btn-rem').forEach(btn => btn.addEventListener('click', function(){ this.parentNode.remove() }));
    </script>
    <?php
}

// 3. Save Data
function save_forest_full_data($post_id) {
    if (!isset($_POST['forest_nonce']) || !wp_verify_nonce($_POST['forest_nonce'], 'forest_save_nonce')) return;
    
    // Simple Fields
    $fields = ['hero_sub', 'area_size', 'distance_city', 'flora_img', 'logistics_img'];
    foreach($fields as $f) {
        if(isset($_POST[$f])) update_post_meta($post_id, '_'.$f, sanitize_text_field($_POST[$f]));
    }

    // Array Fields
    if(isset($_POST['flora_list'])) update_post_meta($post_id, '_flora_list', serialize($_POST['flora_list']));
    if(isset($_POST['rules_list'])) update_post_meta($post_id, '_rules_list', serialize($_POST['rules_list']));
    
    // Complex Repeater Fields
    if(isset($_POST['zones_list'])) update_post_meta($post_id, '_zones_list', serialize(array_values($_POST['zones_list'])));
    if(isset($_POST['timing_list'])) update_post_meta($post_id, '_timing_list', serialize(array_values($_POST['timing_list'])));
    if(isset($_POST['logistics_list'])) update_post_meta($post_id, '_logistics_list', serialize(array_values($_POST['logistics_list'])));
}
add_action('save_post', 'save_forest_full_data');

// =========================================
// 9. RESORT CPT & BUILDER (Updated)
// =========================================

// 1. Register Post Type
function tadoba_register_resort_cpt() {
    register_post_type('resort', array(
        'labels' => array('name' => 'Resorts', 'singular_name' => 'Resort', 'add_new' => 'Add Resort', 'all_items' => 'All Resorts'),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-building',
        'supports' => array('title', 'editor', 'thumbnail'), // Featured Image = Hero Background
        'rewrite' => array('slug' => 'resorts'),
    ));
}
add_action('init', 'tadoba_register_resort_cpt');

// 2. Meta Boxes
function tadoba_resort_meta() {
    add_meta_box('resort_data', '🏨 Resort Page Builder', 'resort_builder_cb', 'resort', 'normal', 'high');
}
add_action('add_meta_boxes', 'tadoba_resort_meta');

// 3. Builder Interface
function resort_builder_cb($post) {
    wp_nonce_field('resort_save', 'resort_nonce');
    
    // Retrieve all values
    $subtitle = get_post_meta($post->ID, '_resort_subtitle', true);
    $intro_img = get_post_meta($post->ID, '_resort_intro_img', true);
    $showcase_img = get_post_meta($post->ID, '_resort_showcase_img', true);
    
    // Bottom Section Data
    $bottom_title = get_post_meta($post->ID, '_resort_bottom_title', true);
    $bottom_desc = get_post_meta($post->ID, '_resort_bottom_desc', true);
    $bottom_img = get_post_meta($post->ID, '_resort_bottom_img', true);
    
    $amenities = maybe_unserialize(get_post_meta($post->ID, '_resort_amenities', true)) ?: [];
    $rooms = maybe_unserialize(get_post_meta($post->ID, '_resort_rooms', true)) ?: [];
    ?>
    
    <style>
        .r-group { background: #fdfdfd; padding: 15px; border: 1px solid #ddd; margin-bottom: 20px; }
        .r-group h3 { margin-top: 0; color: #E67D3C; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .r-row { display: flex; gap: 10px; margin-bottom: 10px; align-items: center; background: #fff; padding: 10px; border: 1px solid #eee; }
        .w-100 { width: 100%; padding: 8px; margin-bottom: 10px; }
        .btn-add { background: #084D2A; color: white; padding: 8px 15px; border: none; cursor: pointer; }
        .btn-del { color: red; cursor: pointer; margin-left: 10px; font-weight: bold; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    </style>

    <div class="r-group">
        <h3>1. Hero Section</h3>
        <label>Subtitle (e.g. Welcome to Nature's Sprout):</label>
        <input type="text" name="resort_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="w-100">
    </div>

    <div class="r-group">
        <h3>2. Intro Image (Nature Enthusiasts)</h3>
        <label>Side Image URL:</label>
        <input type="text" name="resort_intro_img" value="<?php echo esc_attr($intro_img); ?>" class="w-100" placeholder="https://...">
    </div>

    <div class="r-group">
        <h3>3. Parallax Showcase</h3>
        <label>Full Width Image URL:</label>
        <input type="text" name="resort_showcase_img" value="<?php echo esc_attr($showcase_img); ?>" class="w-100" placeholder="https://...">
    </div>

    <div class="r-group">
        <h3>4. Amenities</h3>
        <div id="amenity-list">
            <?php foreach($amenities as $k => $a): ?>
            <div class="r-row">
                <input type="text" name="amenities[<?php echo $k; ?>][icon]" value="<?php echo esc_attr($a['icon']); ?>" placeholder="Icon (fas fa-wifi)">
                <input type="text" name="amenities[<?php echo $k; ?>][title]" value="<?php echo esc_attr($a['title']); ?>" placeholder="Title">
                <input type="text" name="amenities[<?php echo $k; ?>][desc]" value="<?php echo esc_attr($a['desc']); ?>" placeholder="Short Desc">
                <span class="btn-del" onclick="this.parentNode.remove()">X</span>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" id="add-amenity">+ Add Amenity</button>
    </div>

    <div class="r-group">
        <h3>5. Rooms / Packages</h3>
        <div id="room-list">
            <?php foreach($rooms as $k => $r): ?>
            <div class="r-row">
                <input type="text" name="rooms[<?php echo $k; ?>][title]" value="<?php echo esc_attr($r['title']); ?>" placeholder="Room Name" style="width: 30%;">
                <input type="text" name="rooms[<?php echo $k; ?>][price]" value="<?php echo esc_attr($r['price']); ?>" placeholder="Price" style="width: 20%;">
                <input type="text" name="rooms[<?php echo $k; ?>][img]" value="<?php echo esc_attr($r['img']); ?>" placeholder="Image URL" style="width: 50%;">
                <span class="btn-del" onclick="this.parentNode.remove()">X</span>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" id="add-room">+ Add Room</button>
    </div>

    <div class="r-group">
        <h3>6. Bottom About Section</h3>
        <label>Title:</label>
        <input type="text" name="resort_bottom_title" value="<?php echo esc_attr($bottom_title); ?>" class="w-100">
        <label>Description:</label>
        <textarea name="resort_bottom_desc" rows="3" class="w-100"><?php echo esc_textarea($bottom_desc); ?></textarea>
        <label>Side Image URL:</label>
        <input type="text" name="resort_bottom_img" value="<?php echo esc_attr($bottom_img); ?>" class="w-100">
    </div>

    <script>
        document.getElementById('add-amenity').addEventListener('click', function(){
            var i = document.querySelectorAll('#amenity-list .r-row').length;
            var h = '<div class="r-row"><input type="text" name="amenities['+i+'][icon]" placeholder="Icon"><input type="text" name="amenities['+i+'][title]" placeholder="Title"><input type="text" name="amenities['+i+'][desc]" placeholder="Desc"><span class="btn-del" onclick="this.parentNode.remove()">X</span></div>';
            document.getElementById('amenity-list').insertAdjacentHTML('beforeend', h);
        });
        document.getElementById('add-room').addEventListener('click', function(){
            var i = document.querySelectorAll('#room-list .r-row').length;
            var h = '<div class="r-row"><input type="text" name="rooms['+i+'][title]" placeholder="Name" style="width:30%"><input type="text" name="rooms['+i+'][price]" placeholder="Price" style="width:20%"><input type="text" name="rooms['+i+'][img]" placeholder="Image URL" style="width:50%"><span class="btn-del" onclick="this.parentNode.remove()">X</span></div>';
            document.getElementById('room-list').insertAdjacentHTML('beforeend', h);
        });
    </script>
    <?php
}

// 4. Save Logic
function tadoba_save_resort($post_id) {
    if (!isset($_POST['resort_nonce']) || !wp_verify_nonce($_POST['resort_nonce'], 'resort_save')) return;
    
    $fields = ['resort_subtitle', 'resort_intro_img', 'resort_showcase_img', 'resort_bottom_title', 'resort_bottom_desc', 'resort_bottom_img'];
    foreach($fields as $f) if(isset($_POST[$f])) update_post_meta($post_id, '_'.$f, sanitize_text_field($_POST[$f]));

    if(isset($_POST['amenities'])) update_post_meta($post_id, '_resort_amenities', serialize(array_values($_POST['amenities'])));
    if(isset($_POST['rooms'])) update_post_meta($post_id, '_resort_rooms', serialize(array_values($_POST['rooms'])));
}
add_action('save_post', 'tadoba_save_resort');

// =========================================
// 10. ABOUT PAGE BUILDER (Fixed & Renamed)
// =========================================

function tadoba_about_meta() {
    global $post;
    if(!empty($post)) {
        $page_template = get_post_meta($post->ID, '_wp_page_template', true);
        if($page_template == 'page-about.php') {
            add_meta_box('about_page_data', '🌿 About Page Builder', 'about_builder_cb', 'page', 'normal', 'high');
        }
    }
}
add_action('add_meta_boxes', 'tadoba_about_meta');

// Updated Builder Interface
function about_builder_cb($post) {
    wp_nonce_field('about_save', 'about_nonce');
    
    // Retrieve Existing Data
    $intro_img = get_post_meta($post->ID, '_about_intro_img', true);
    $hero_img = get_post_meta($post->ID, '_about_hero_img', true);
    $quote = get_post_meta($post->ID, '_about_quote', true);
    
    // NEW: Founder/Signature Data
    $founder_name = get_post_meta($post->ID, '_about_founder_name', true);
    $founder_role = get_post_meta($post->ID, '_about_founder_role', true);
    $founder_img = get_post_meta($post->ID, '_about_founder_img', true);
    
    // Arrays
    $stats = maybe_unserialize(get_post_meta($post->ID, '_about_stats', true)) ?: [];
    $features = maybe_unserialize(get_post_meta($post->ID, '_about_features', true)) ?: [];
    $team = maybe_unserialize(get_post_meta($post->ID, '_about_team', true)) ?: [];
    ?>
    
    <style>
        .a-group { background: #fdfdfd; padding: 15px; border: 1px solid #ddd; margin-bottom: 20px; }
        .a-group h3 { margin-top: 0; color: #E67D3C; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .a-row { display: flex; gap: 10px; margin-bottom: 10px; align-items: center; background: #fff; padding: 10px; border: 1px solid #eee; }
        .w-100 { width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; }
        .btn-add { background: #084D2A; color: white; padding: 8px 15px; border: none; cursor: pointer; border-radius: 4px; }
        .btn-del { color: red; cursor: pointer; margin-left: 10px; font-weight: bold; }
        label { font-weight: bold; display: block; margin-bottom: 5px; }
    </style>

    <div class="a-group">
        <h3>1. Top Section (Right Side)</h3>
        <label>Intro Image URL:</label>
        <input type="text" name="about_intro_img" value="<?php echo esc_attr($intro_img); ?>" class="w-100">
    </div>

    <div class="a-group">
        <h3>2. Middle Hero Section</h3>
        <label>Wide Safari Image URL:</label>
        <input type="text" name="about_hero_img" value="<?php echo esc_attr($hero_img); ?>" class="w-100">
    </div>

    <div class="a-group">
        <h3>3. Journey Section (Quote & Signature)</h3>
        <label>Main Quote Text:</label>
        <textarea name="about_quote" rows="3" class="w-100"><?php echo esc_textarea($quote); ?></textarea>
        
        <hr style="margin: 15px 0; border: 0; border-top: 1px solid #eee;">
        
        <label>Signature Name (e.g. James Walker):</label>
        <input type="text" name="about_founder_name" value="<?php echo esc_attr($founder_name); ?>" class="w-100">
        
        <label>Signature Role (e.g. Founder & CEO):</label>
        <input type="text" name="about_founder_role" value="<?php echo esc_attr($founder_role); ?>" class="w-100">
        
        <label>Signature Image URL:</label>
        <input type="text" name="about_founder_img" value="<?php echo esc_attr($founder_img); ?>" class="w-100">
    </div>

    <div class="a-group">
        <h3>4. Stats Counter</h3>
        <div id="stats-list">
            <?php foreach($stats as $k => $s): ?>
            <div class="a-row">
                <input type="text" name="tadoba_stats[<?php echo $k; ?>][num]" value="<?php echo esc_attr($s['num']); ?>" placeholder="Number">
                <input type="text" name="tadoba_stats[<?php echo $k; ?>][label]" value="<?php echo esc_attr($s['label']); ?>" placeholder="Label">
                <input type="text" name="tadoba_stats[<?php echo $k; ?>][icon]" value="<?php echo esc_attr($s['icon']); ?>" placeholder="Icon">
                <span class="btn-del" onclick="this.parentNode.remove()">X</span>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" id="add-stat">+ Add Stat</button>
    </div>

    <div class="a-group">
        <h3>5. Why Choose Us</h3>
        <div id="feat-list">
            <?php foreach($features as $k => $f): ?>
            <div class="a-row">
                <input type="text" name="tadoba_features[<?php echo $k; ?>][num]" value="<?php echo esc_attr($f['num']); ?>" placeholder="01" style="width: 60px;">
                <input type="text" name="tadoba_features[<?php echo $k; ?>][title]" value="<?php echo esc_attr($f['title']); ?>" placeholder="Title">
                <input type="text" name="tadoba_features[<?php echo $k; ?>][desc]" value="<?php echo esc_attr($f['desc']); ?>" placeholder="Description" style="width: 50%;">
                <span class="btn-del" onclick="this.parentNode.remove()">X</span>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" id="add-feat">+ Add Feature</button>
    </div>

    <div class="a-group">
        <h3>6. Team Members</h3>
        <div id="team-list">
            <?php foreach($team as $k => $t): ?>
            <div class="a-row">
                <input type="text" name="tadoba_team[<?php echo $k; ?>][name]" value="<?php echo esc_attr($t['name']); ?>" placeholder="Name">
                <input type="text" name="tadoba_team[<?php echo $k; ?>][role]" value="<?php echo esc_attr($t['role']); ?>" placeholder="Role">
                <input type="text" name="tadoba_team[<?php echo $k; ?>][img]" value="<?php echo esc_attr($t['img']); ?>" placeholder="Image URL" style="width: 40%;">
                <span class="btn-del" onclick="this.parentNode.remove()">X</span>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" id="add-team">+ Add Member</button>
    </div>

    <script>
        const addRow = (id, html) => {
            const container = document.getElementById(id);
            const count = container.querySelectorAll('.a-row').length;
            container.insertAdjacentHTML('beforeend', html.replace(/INDEX/g, count));
        };
        document.getElementById('add-stat').onclick = () => addRow('stats-list', '<div class="a-row"><input type="text" name="tadoba_stats[INDEX][num]" placeholder="Num"><input type="text" name="tadoba_stats[INDEX][label]" placeholder="Label"><input type="text" name="tadoba_stats[INDEX][icon]" placeholder="Icon"><span class="btn-del" onclick="this.parentNode.remove()">X</span></div>');
        document.getElementById('add-feat').onclick = () => addRow('feat-list', '<div class="a-row"><input type="text" name="tadoba_features[INDEX][num]" placeholder="01" style="width:60px"><input type="text" name="tadoba_features[INDEX][title]" placeholder="Title"><input type="text" name="tadoba_features[INDEX][desc]" placeholder="Desc" style="width:50%"><span class="btn-del" onclick="this.parentNode.remove()">X</span></div>');
        document.getElementById('add-team').onclick = () => addRow('team-list', '<div class="a-row"><input type="text" name="tadoba_team[INDEX][name]" placeholder="Name"><input type="text" name="tadoba_team[INDEX][role]" placeholder="Role"><input type="text" name="tadoba_team[INDEX][img]" placeholder="Image URL" style="width:40%"><span class="btn-del" onclick="this.parentNode.remove()">X</span></div>');
    </script>
    <?php
}

function tadoba_save_about($post_id) {
    if (!isset($_POST['about_nonce']) || !wp_verify_nonce($_POST['about_nonce'], 'about_save')) return;
    
    // Save Standard Fields
    $fields = ['about_intro_img', 'about_hero_img', 'about_quote', 'about_founder_name', 'about_founder_role', 'about_founder_img'];
    foreach($fields as $f) {
        if(isset($_POST[$f])) update_post_meta($post_id, '_'.$f, sanitize_text_field($_POST[$f]));
    }
    
    // Save Arrays
    if(isset($_POST['tadoba_stats'])) update_post_meta($post_id, '_about_stats', serialize(array_values($_POST['tadoba_stats'])));
    if(isset($_POST['tadoba_features'])) update_post_meta($post_id, '_about_features', serialize(array_values($_POST['tadoba_features'])));
    if(isset($_POST['tadoba_team'])) update_post_meta($post_id, '_about_team', serialize(array_values($_POST['tadoba_team'])));
}
add_action('save_post', 'tadoba_save_about');
