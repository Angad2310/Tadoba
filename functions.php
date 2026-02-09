<?php
/**
 * Tadoba Theme Functions
 */

// Theme Setup
function tadoba_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption'));

    register_nav_menus(array(
        'primary' => 'Primary Menu',
        'footer' => 'Footer Menu',
    ));
}
add_action('after_setup_theme', 'tadoba_theme_setup');

// Enqueue Styles & Scripts
function tadoba_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style('tadoba-fonts', 'https://fonts.googleapis.com/css2?family=Inclusive+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Anybody:wght@400;500;600;700&display=swap', array(), null);

    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');

    // Theme Stylesheet
    wp_enqueue_style('tadoba-style', get_stylesheet_uri(), array(), '1.0.0');

    // Main Theme CSS
    wp_enqueue_style('tadoba-main', get_template_directory_uri() . '/assets/css/theme-style.css', array(), '1.0.0');

    // jQuery
    wp_enqueue_script('jquery');

    // Theme JS
    wp_enqueue_script('tadoba-script', get_template_directory_uri() . '/assets/js/theme-script.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'tadoba_enqueue_assets');

// Register Custom Post Types
function tadoba_register_post_types() {
    // Packages
    register_post_type('package', array(
        'labels' => array(
            'name' => 'Packages',
            'singular_name' => 'Package',
            'add_new' => 'Add New Package',
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-tickets-alt',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'packages'),
    ));

    // Resorts
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

// Add Meta Boxes for Packages
function tadoba_add_package_meta_boxes() {
    add_meta_box('package_details', 'Package Details', 'tadoba_package_meta_box', 'package', 'normal', 'high');
}
add_action('add_meta_boxes', 'tadoba_add_package_meta_boxes');

function tadoba_package_meta_box($post) {
    wp_nonce_field('tadoba_package_meta', 'tadoba_package_nonce');

    $price = get_post_meta($post->ID, '_package_price', true);
    $old_price = get_post_meta($post->ID, '_package_old_price', true);
    $duration = get_post_meta($post->ID, '_package_duration', true);
    $location = get_post_meta($post->ID, '_package_location', true);
    $discount = get_post_meta($post->ID, '_package_discount', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label>Price (₹)</label></th>
            <td><input type="number" name="package_price" value="<?php echo esc_attr($price); ?>" style="width:100%"></td>
        </tr>
        <tr>
            <th><label>Old Price (₹)</label></th>
            <td><input type="number" name="package_old_price" value="<?php echo esc_attr($old_price); ?>" style="width:100%"></td>
        </tr>
        <tr>
            <th><label>Duration</label></th>
            <td><input type="text" name="package_duration" value="<?php echo esc_attr($duration); ?>" placeholder="3 Days / 2 Nights" style="width:100%"></td>
        </tr>
        <tr>
            <th><label>Location/Zone</label></th>
            <td><input type="text" name="package_location" value="<?php echo esc_attr($location); ?>" placeholder="Moharli Zone" style="width:100%"></td>
        </tr>
        <tr>
            <th><label>Discount Badge</label></th>
            <td><input type="text" name="package_discount" value="<?php echo esc_attr($discount); ?>" placeholder="20% OFF" style="width:100%"></td>
        </tr>
    </table>
    <?php
}

function tadoba_save_package_meta($post_id) {
    if (!isset($_POST['tadoba_package_nonce']) || !wp_verify_nonce($_POST['tadoba_package_nonce'], 'tadoba_package_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = array('package_price', 'package_old_price', 'package_duration', 'package_location', 'package_discount');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'tadoba_save_package_meta');

// Customizer Settings
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

// Social Media Links
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

// Widget Areas
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
?>