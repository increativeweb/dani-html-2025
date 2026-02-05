/*-----------------------------------------------------------------------------------*/
/* MAIN
/*-----------------------------------------------------------------------------------*/
var $ = jQuery.noConflict();

jQuery(document).ready(function ($) {
    if ($('.main-header').length) {
        $('.navbar-toggler').on('click', function () {
            $(".main-sidebar").toggleClass('is-visible');
            $('body').toggleClass('overflow-hidden');
            $(this).toggleClass('is-visible');
        });
        $('.menu-item-has-children').on('click', function (e) {
            e.stopPropagation(); 

            $(this).find('.sub-menu').toggleClass('is-open');
        });
        $('.sub-menu').on('click', function (e) {
            e.stopPropagation();
        });
        $(document).on('click', function () {
            $('.sub-menu').removeClass('is-open');
        });
    }
});
const $logoBlock = $('.site-logo-block');
if ($logoBlock.length) {
    $(window).on('scroll', function() {
        const logoBlockTop = $logoBlock.offset().top;
        const windowBottom = $(window).scrollTop() + $(window).height();

        // Toggle class based on footer visibility
        $logoBlock.toggleClass('is-animate', windowBottom >= logoBlockTop);
    });
}
if ($('.main-sidebar').length) {
    $(document).on('click', '.menu-list-collapsed .collapse-title', function (e) {
        e.preventDefault();

        var $this = $(this).closest('.menu-list-collapsed');
        var $menu = $this.find('.collapse-menu-block');

        $this.toggleClass('active');
        $menu.stop(true, true).slideToggle(300);
        // Close other open menus
        // $('.menu-list-collapsed').not($this)
        //     .removeClass('active')
        //     .find('.collapse-menu-block')
        //     .stop(true, true)
        //     .slideUp(300);

        // // Toggle current menu
        // if ($this.hasClass('active')) {
        //     $this.removeClass('active');
        //     $menu.stop(true, true).slideUp(300);
        // } else {
        //     $this.addClass('active');
        //     $menu.stop(true, true).slideDown(300);
        // }
    });

}
