/*-----------------------------------------------------------------------------------*/
/* MAIN
/*-----------------------------------------------------------------------------------*/
var $ = jQuery.noConflict();

jQuery(document).ready(function ($) {

    if ($('.main-header').length) {
        if (jQuery(this).scrollTop() > 50) {
            $(".main-header").addClass("fixed-header");
        } else {
            $(".main-header").removeClass("fixed-header");
        }

        $(window).scroll(function () {
            if (jQuery(this).scrollTop() > 50) {
                $(".main-header").addClass("fixed-header");
            } else {
                $(".main-header").removeClass("fixed-header");
            }
        });
        $('.navbar-toggler').on('click', function () {
            $(".main-header").toggleClass('is-visible');
            $('body').toggleClass('overflow-hidden');
            $(this).toggleClass('is-visible');
        });
    }

});