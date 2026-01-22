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

// Counter
if ($('.counter').length) {
    let options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.5 // Trigger when 50% of the element is visible
    };

    // Create a new observer
    let observer = new IntersectionObserver(function (entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                let $this = $(entry.target);
                var countTo = $this.attr("data-countto");
                var countDuration = parseInt($this.attr("data-duration"));

                $({ counter: $this.find('span').text() }).animate({
                    counter: countTo
                }, {
                    duration: countDuration,
                    easing: "linear",
                    step: function () {
                        $this.find('span').text(Math.floor(this.counter));
                    },
                    complete: function () {
                        $this.find('span').text(this.counter);
                    }
                });
                observer.unobserve(entry.target);
            }
        });
    }, options);

    // Target each element with the class .counter
    $('.counter').each(function () {
        observer.observe(this);
    });
}


let counterSwiper = null;
const BREAKPOINT = 992;

function prepareSlides() {
    const wrapper = document.querySelector(
        '.counter-swiper-slider .swiper-wrapper'
    );
    if (!wrapper) return;

    const slides = wrapper.children.length;

    // Duplicate slides ONLY if less than required
    if (slides < 4) {
        const originals = Array.from(wrapper.children);
        originals.forEach(slide => {
            wrapper.appendChild(slide.cloneNode(true));
        });
    }
}

function initCounterSwiper() {
    const winWidth = window.innerWidth;

    // MOBILE ONLY
    if (winWidth < BREAKPOINT && !counterSwiper) {

        prepareSlides(); // prevent loop warning

        counterSwiper = new Swiper('.counter-swiper-slider', {
            slidesPerView: 1.5,
            spaceBetween: 14,
            centeredSlides: true,
            loop: true,
            grabCursor: true,
            speed: 600,

            autoplay: {
                delay: 8000,
                disableOnInteraction: false,
            },

            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                575: {
                    slidesPerView: 2.5,
                    spaceBetween: 20,
                },
                992: {
                    slidesPerView: 4.5,
                    spaceBetween: 20,
                }
            }
        });
    }

    // DESTROY ON DESKTOP
    if (winWidth >= BREAKPOINT && counterSwiper) {
        counterSwiper.destroy(true, true);
        counterSwiper = null;
    }
}

// Init
window.addEventListener('load', initCounterSwiper);

// Resize (debounced)
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(initCounterSwiper, 200);
});

