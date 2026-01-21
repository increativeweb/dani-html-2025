/*-----------------------------------------------------------------------------------*/
/* MAIN
/*-----------------------------------------------------------------------------------*/
var $ = jQuery.noConflict();

jQuery(document).ready(function ($) {

    if ($('.site-header').length) {
        $('.navbar-toggler').on('click', function () {
            $(".site-header").toggleClass('is-visible');
            $('body').toggleClass('overflow-hidden');
            $(this).toggleClass('is-visible');
        });
    }


});
/* WOW Animation - Init */
// try {
//     wow.init();
// } catch (e) {
//     //
// };
(function () {
    const mainHeader = document.querySelector('.site-header');
    if (!mainHeader) return;

    let last = 0;
    const delta = 5;
    const headerHeight = mainHeader.offsetHeight;

    function update() {
        const scrollTop = window.scrollY;

        /* Scroll direction */
        if (scrollTop > 50 && Math.abs(scrollTop - last) > delta) {
            mainHeader.classList.toggle(
                'scroll-up',
                scrollTop > last && scrollTop > headerHeight
            );
            mainHeader.classList.toggle(
                'scroll-down',
                scrollTop <= last || scrollTop <= headerHeight
            );
            last = scrollTop;
        } else if (scrollTop <= 50) {
            mainHeader.classList.remove('scroll-up', 'scroll-down');
        }

        /* Dark navbar */
        // mainHeader.classList.toggle('navbar--dark', scrollTop >= 50);
    }

    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('load', update);
})();

