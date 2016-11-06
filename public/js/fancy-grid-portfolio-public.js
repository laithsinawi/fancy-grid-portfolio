(function ($) {
    'use strict';

    var fadeInSpeed = 500;
    var fadeOutSpeed = 500;

    // Mouseenter overlay
    $('ul#fgp-gallery li').on('mouseenter', function () {

        // Remove overlay div left in dom
        $(this).find('.overlay').remove();

        // Get data attribute values
        var title = $(this).children().data('title');
        var desc = $(this).children().data('desc');

        // Validation
        if (desc == '') {
            desc = 'Click to Enlarge';
        }

        if (title == null) {
            title = '';
        }

        // Create overlay div
        $(this).append('<div class="overlay"></div>');

        // Get the overlay div
        var overlay = $(this).children('.overlay');

        // Add html to overlay
        overlay.html('<h3>' + title + '</h3><p>' + desc + '</p>');

        // Fade in overlay
        overlay.fadeIn(fadeInSpeed);
    });

    // Mouseleave overlay
    $('ul#fgp-gallery li').on('mouseleave', function () {
        // Create overlay div
        $(this).append('<div class="overlay"></div>');

        // Get the overlay div
        var overlay = $(this).children('.overlay');

        // Fade out overlay
        overlay.fadeOut(fadeOutSpeed);
    });

    // Init MixItup
    $('#fgp-gallery').mixItUp({
        selectors: {
            filter: '.fgp-filter'
        }
    });

})(jQuery);
