<?php
/**
 * Template Name: Contact Page
 */
get_header(); 
?>

<div class="page-hero" style="background: url('https://images.unsplash.com/photo-1596323604343-41c195048208?auto=format&fit=crop&q=80') center/cover no-repeat;">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <h1>Get in Touch</h1>
        <p>We'd love to hear from you. Plan your safari today.</p>
    </div>
</div>

<div class="contact-section">
    <div class="container contact-grid">
        
        <div class="contact-info">
            <h2>Contact Information</h2>
            <p>Ready for an adventure? Reach out to us directly or fill out the form.</p>
            
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <strong>Address</strong>
                    <p>Tadoba Andhari Tiger Reserve,<br>Chandrapur, Maharashtra 442401</p>
                </div>
            </div>

            <div class="info-item">
                <i class="fas fa-phone-alt"></i>
                <div>
                    <strong>Phone</strong>
                    <p><a href="tel:+911234567890">+91 12345 67890</a></p>
                </div>
            </div>

            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <strong>Email</strong>
                    <p><a href="mailto:info@tadoba.com">info@tadoba.com</a></p>
                </div>
            </div>

            <div class="social-connect">
                <h3>Follow Us</h3>
                <?php if(function_exists('tadoba_social_links')) tadoba_social_links(); ?>
            </div>
        </div>

        <div class="contact-form-wrapper">
            <h2>Send a Message</h2>
            <?php 
                while (have_posts()) : the_post();
                    the_content(); 
                endwhile; 
            ?>
        </div>

    </div>
</div>

<div class="map-section">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d119743.4146039474!2d79.28116345!3d20.21146745!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a2d5e3055555555%3A0x6b86555555555555!2sTadoba-Andhari%20National%20Park!5e0!3m2!1sen!2sin!4v1625555555555!5m2!1sen!2sin" 
        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
    </iframe>
</div>

<?php get_footer(); ?>