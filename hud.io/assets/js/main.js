/*-----------------------------------------------------------------------------------*/
/* MAIN
/*-----------------------------------------------------------------------------------*/
var $ = jQuery.noConflict();

jQuery(document).ready(function($) {
    $('[data-bs-toggle="tooltip"]').tooltip();

   
    if ($('.main-header').length) {
        if (jQuery(this).scrollTop() > 10) {
            $(".main-header").addClass("fixed-header");
        } else {
            $(".main-header").removeClass("fixed-header");
        }

        $(window).scroll(function () {
            if (jQuery(this).scrollTop() > 10) {
            $(".main-header").addClass("fixed-header");
            } else {
            $(".main-header").removeClass("fixed-header");
            }
        });
    }
    $('.menu-sidebar').on('click',function(){
        $(".main-header").toggleClass('is-visible');
        $(".bg-overlay").toggleClass('is-visible');
        $(this).toggleClass('is-visible');
        $(body).toggleClass('overflow-hidden')
    });

});
