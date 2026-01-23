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

// Counter Slider
if (jQuery('.counter-splide').length) {

    let counterSplide = null;
    const BREAKPOINT = 767;

    function initCounterSplide() {
        const winWidth = window.innerWidth;

        // INIT on mobile
        if (winWidth < BREAKPOINT && !counterSplide) {
            counterSplide = new Splide('.counter-splide', {
                type: 'loop',
                perPage: 1,
                perMove: 1,
                gap: '20px',
                arrows: false,
                pagination: true,
                autoWidth: true,
                focus: 'center',
                classes: {
                    pagination: 'splide__pagination is-dark',
                },
            });

            counterSplide.mount();
        }

        // DESTROY on desktop
        if (winWidth >= BREAKPOINT && counterSplide) {
            counterSplide.destroy(true);
            counterSplide = null;
        }
    }

    // Init on load
    window.addEventListener('load', initCounterSplide);

    // Re-check on resize (debounced)
    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(initCounterSplide, 200);
    });
}
