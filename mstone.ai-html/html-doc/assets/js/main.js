/*-----------------------------------------------------------------------------------*/
/* MAIN
/*-----------------------------------------------------------------------------------*/
var $ = jQuery.noConflict();

jQuery(document).ready(function ($) {
    if ($('.main-header').length) {
        $('.navbar-toggler').on('click', function (e) {
            e.preventDefault();
            $(".main-sidebar").toggleClass('is-visible');
            $('body').toggleClass('overflow-hidden');
            $(this).toggleClass('is-visible');
            $('.sidebar-overlay').toggleClass('is-visible');

            $('.main-sidebar .sidebar-menu-block').removeClass('is-close');
            $('.main-sidebar').find('.main-menu').removeClass('is-open');
        });
        if($('.menu-item-has-children').length) {
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
    }

    if ($('.main-sidebar').length) {
        $(document).on('click', '.menu-list-collapsed .collapse-title', function (e) {
            e.preventDefault();

            var $this = $(this).closest('.menu-list-collapsed');
            var $menu = $this.find('.collapse-menu-block');

            $this.toggleClass('active');
            $menu.stop(true, true).slideToggle(300);
        });

        $(document).on('click', '.sidebar-overlay', () => {
            $('.navbar-toggler').click();
        });
        $(document).on('click', '.back-menu', function (e) {
            e.preventDefault();

            $(this).parent('.sidebar-menu-block').addClass('is-close');
            $(this).parents('.main-sidebar').find('.main-menu').addClass('is-open');
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
