/**
 * Tadoba Theme JavaScript
 */
(function($) {
    'use strict';

    // Mobile Menu Toggle
    $('#mobile-menu-toggle').on('click', function() {
        $('#mobile-menu').addClass('active');
        $('body').css('overflow', 'hidden');
    });

    $('#mobile-menu-close').on('click', function() {
        $('#mobile-menu').removeClass('active');
        $('body').css('overflow', '');
    });

    // Close mobile menu on overlay click
    $('#mobile-menu').on('click', function(e) {
        if (e.target === this) {
            $(this).removeClass('active');
            $('body').css('overflow', '');
        }
    });

    // Smooth Scroll for anchor links
    $('a[href^="#"]').on('click', function(e) {
        var href = $(this).attr('href');
        if (href !== '#' && href.length > 1) {
            e.preventDefault();
            var target = $(href);
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 600);
            }
        }
    });

    // Add scroll class to header
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 100) {
            $('.site-header').addClass('scrolled');
        } else {
            $('.site-header').removeClass('scrolled');
        }
    });

    // Animation on scroll
    if (typeof IntersectionObserver !== 'undefined') {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    $(entry.target).css({
                        'opacity': '1',
                        'transform': 'translateY(0)'
                    });
                }
            });
        }, observerOptions);

        // Observe sections
        $('.welcome-section, .packages-section, .features-section, .cta-section').each(function() {
            $(this).css({
                'opacity': '0',
                'transform': 'translateY(30px)',
                'transition': 'opacity 0.6s ease, transform 0.6s ease'
            });
            observer.observe(this);
        });
    }

    // Package card hover effect
    $('.package-card').hover(
        function() {
            $(this).find('.package-img img').css('transform', 'scale(1.1)');
        },
        function() {
            $(this).find('.package-img img').css('transform', 'scale(1)');
        }
    );

})(jQuery);