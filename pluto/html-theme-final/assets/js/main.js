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
try {
    new WOW({
        boxClass: 'wow',
        animateClass: 'animated',
        offset: 80,       // trigger before element fully enters viewport
        mobile: true,
        live: true
    }).init();

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
                observer.unobserve(entry.target); // remove if only once
            } else {
                entry.target.classList.remove('is-animated');
            }
        });
    },
    {
        root: null,
        // Trigger when TOP of element reaches 50% viewport
        rootMargin: '-30% 0px -30% 0px',
        threshold: 0
    }
);

animatedSections.forEach(section => observer.observe(section));
