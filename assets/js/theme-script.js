/**
 * Tadoba Theme JavaScript - FINAL MERGED VERSION
 * Handles: Mobile Menu, Smooth Scroll, Animations, and Package Details (Tabs/Accordion)
 */
(function($) {
    'use strict';

    // ==========================================
    // 1. MOBILE MENU (Your Existing Code)
    // ==========================================
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

    // ==========================================
    // 2. SMOOTH SCROLL (Your Existing Code)
    // ==========================================
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

    // ==========================================
    // 3. HEADER SCROLL EFFECT (Your Existing Code)
    // ==========================================
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 100) {
            $('.site-header').addClass('scrolled');
        } else {
            $('.site-header').removeClass('scrolled');
        }
    });

    // ==========================================
    // 4. SCROLL ANIMATIONS (Your Existing Code)
    // ==========================================
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

        $('.welcome-section, .packages-section, .features-section, .cta-section').each(function() {
            $(this).css({
                'opacity': '0',
                'transform': 'translateY(30px)',
                'transition': 'opacity 0.6s ease, transform 0.6s ease'
            });
            observer.observe(this);
        });
    }

    // ==========================================
    // 5. PACKAGE CARD HOVER (Your Existing Code)
    // ==========================================
    $('.package-card').hover(
        function() {
            $(this).find('.package-img img').css('transform', 'scale(1.1)');
        },
        function() {
            $(this).find('.package-img img').css('transform', 'scale(1)');
        }
    );

    // ==========================================
    // 6. NEW: SINGLE PACKAGE PAGE LOGIC
    // ==========================================
    
    // A. Tabs Switching (Overview / Itinerary / Costs)
    $('.tab-btn').on('click', function(e) {
        // Prevent default anchor behavior
        e.preventDefault(); 

        // 1. Remove Active Class from all buttons and content
        $('.tab-btn').removeClass('active');
        $('.tab-content').hide().removeClass('active');

        // 2. Add Active Class to clicked button
        $(this).addClass('active');

        // 3. Find the target ID
        // Note: This logic looks for 'data-tab' attribute OR uses text content as fallback
        var targetId = $(this).attr('data-tab');
        
        if (!targetId) {
            // Fallback: If you didn't add data-tab, try to guess ID from text (e.g. "Overview" -> "#overview")
            targetId = $(this).text().trim().toLowerCase();
        }

        // 4. Show the target content
        $('#' + targetId).fadeIn();
    });

    // B. Itinerary Accordion (Expand/Collapse Days)
    $('.day-header').on('click', function() {
        // Toggle the content panel
        $(this).next('.day-body').slideToggle();
        
        // Toggle the Plus/Minus icon
        $(this).find('i').toggleClass('fa-plus fa-minus');
    });

    // C. Gallery Thumbnail Switcher (Optional - if you use thumbnails)
    $('.gallery-thumbs img').on('click', function() {
        var fullImgUrl = $(this).data('full');
        var mainImg = $('#main-gallery-img');
        
        if(fullImgUrl && mainImg.length) {
            mainImg.fadeOut(200, function() {
                $(this).attr('src', fullImgUrl).fadeIn(200);
            });
            $('.gallery-thumbs img').removeClass('active');
            $(this).addClass('active');
        }
    });

})(jQuery);

