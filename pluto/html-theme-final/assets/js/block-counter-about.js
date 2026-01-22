// ==============================
// COUNTER (Reusable)
// ==============================
function initCounters(context = document) {
    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;

            const el = entry.target;

            // Prevent re-counting
            if (el.dataset.counted === "true") return;
            el.dataset.counted = "true";

            const $el = $(el);
            const countTo = parseInt($el.attr("data-countto"), 10);
            const duration = parseInt($el.attr("data-duration"), 10);

            $({ counter: 0 }).animate(
                { counter: countTo },
                {
                    duration,
                    easing: "linear",
                    step() {
                        $el.find("span").text(Math.floor(this.counter));
                    },
                    complete() {
                        $el.find("span").text(this.counter);
                    }
                }
            );

            observer.unobserve(el);
        });
    }, options);

    context.querySelectorAll(".counter").forEach(el => {
        observer.observe(el);
    });
}

// ==============================
// INIT NORMAL COUNTERS
// ==============================
if ($('.counter').length) {
    initCounters();
}

// ==============================
// COUNTER SWIPER
// ==============================
if ($('.counter-swiper-slider').length) {
    let counterSwiper = null;
    const BREAKPOINT = 992;
    let originalSlidesCount = 0;

    function prepareSlides() {
        const wrapper = document.querySelector(
            '.counter-swiper-slider .swiper-wrapper'
        );
        if (!wrapper) return;

        originalSlidesCount = wrapper.children.length;

        if (originalSlidesCount < 4) {
            const originals = Array.from(wrapper.children);
            originals.forEach(slide => {
                wrapper.appendChild(slide.cloneNode(true));
            });
        }
    }

    function initCounterSwiper() {
        const winWidth = window.innerWidth;

        if (winWidth < BREAKPOINT && !counterSwiper) {

            prepareSlides();

            counterSwiper = new Swiper('.counter-swiper-slider', {
                slidesPerView: 1.35,
                spaceBetween: 14,
                centeredSlides: true,
                loop: true,
                loopedSlides: originalSlidesCount,
                grabCursor: true,
                speed: 600,

                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },

                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    renderBullet(index, className) {
                        if (index >= originalSlidesCount) return '';
                        return `<span class="${className}"></span>`;
                    }
                },

                breakpoints: {
                    575: {
                        slidesPerView: 2.5,
                        spaceBetween: 20,
                    }
                },

                on: {
                    init() {
                        initCounters(this.el);
                    },
                    slideChangeTransitionStart() {
                        initCounters(this.el);
                    }
                }
            });
        }


        if (winWidth >= BREAKPOINT && counterSwiper) {
            counterSwiper.destroy(true, true);
            counterSwiper = null;
        }
    }


    window.addEventListener('load', initCounterSwiper);

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(initCounterSwiper, 200);
    });
}
