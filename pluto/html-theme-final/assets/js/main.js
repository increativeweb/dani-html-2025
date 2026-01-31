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

    $('.hash-item > a').on('click', function (e) {
        if (this.hash && this.hash !== '#') {
            // e.preventDefault();
            // Hide header if visible
            $('body').removeClass('overflow-hidden');
            $('.site-header').removeClass('is-visible');
            $('.site-header .navbar-toggler').removeClass('is-visible');
            const target = $(this.hash);
            if (target.length) {
                $('html, body').animate({ scrollTop: target.offset().top }, 300);
            }
        }
    });

});
/* WOW Animation - Init */
try {
    new WOW().init();

} catch (e) {
    //
};

(function () {
    const mainHeader = document.querySelector('.site-header');
    if (!mainHeader) return;

    let last = 0;
    const delta = 5;
    const headerHeight = mainHeader.offsetHeight;

    function update() {
        const scrollTop = window.scrollY;

        /* Scroll direction */
        if (scrollTop > 20 && Math.abs(scrollTop - last) > delta) {
            mainHeader.classList.toggle(
                'scroll-up',
                scrollTop > last && scrollTop > headerHeight
            );
            mainHeader.classList.toggle(
                'scroll-down',
                scrollTop <= last || scrollTop <= headerHeight
            );
            last = scrollTop;
        } else if (scrollTop <= 20) {
            mainHeader.classList.remove('scroll-up', 'scroll-down');
        }

        /* Dark navbar */
        // mainHeader.classList.toggle('navbar--dark', scrollTop >= 50);
    }

    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('load', update);
})();

const animatedSections = document.querySelectorAll('section');
const observer = new IntersectionObserver(
    (entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-animated');
            } else {
                entry.target.classList.remove('is-animated');
            }
        });
    },
    {
        root: null,
        // Top of element reaches middle of viewport
        rootMargin: '-30% 0px -30% 0px',
        threshold: 0
    }
);
animatedSections.forEach(el => observer.observe(el));


// Disable right-click on IMG, SVG, and Lottie
document.addEventListener('contextmenu', function (e) {

    const target = e.target;

    const imgEl = target.tagName === 'IMG' ? target : null;
    const svgEl = target.closest && target.closest('svg');
    const lottieEl = target.closest && target.closest('lottie-player');

    const el = imgEl || svgEl || lottieEl;

    if (el) {
        e.preventDefault();

        el.classList.add('icw-zigzag-effect');

        setTimeout(() => {
            el.classList.remove('icw-zigzag-effect');
        }, 500); // match animation duration
    }
});