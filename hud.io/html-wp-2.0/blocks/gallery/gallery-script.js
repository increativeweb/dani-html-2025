jQuery('.gallery-slider').each(function () {

    let lightbox;
    const sliderEl = this;
    const $slider = jQuery(sliderEl);

    // ✅ Always read numeric value
    const autoScrollEnabled =
        Number($slider.attr('data-gallery-autoscroll')) === 1;

    // 🔹 Base options
    const splideOptions = {
        type: 'loop',
        perPage: 3,
        pagination: false,
        autoWidth: true,
        gap: '20px',
        mediaQuery: 'max',
        cloneStatus: false,
        preloadPages: 3,
        lazyLoad: 'nearby',
        breakpoints: {
            1200: { perPage: 2 },
            767: { perPage: 1.5, gap: '12px' }
        }
    };

    // ✅ IF auto-scroll enabled
    if (autoScrollEnabled) {
        splideOptions.focus = 'center';
        splideOptions.arrows = false;
        splideOptions.drag = 'free';
        splideOptions.autoScroll = { speed: 1 };
    }
    // ✅ ELSE (normal slider)
    else {
        splideOptions.arrows = true;
        splideOptions.autoplay = true;
        splideOptions.perMove = 1;
    }

    console.log('AutoScroll:', autoScrollEnabled, splideOptions);

    const splide = new Splide(sliderEl, splideOptions);

    /**
     * 🔥 GLightbox init (scoped + safe)
     */
    function initLightbox() {
        if (lightbox) {
            lightbox.destroy();
        }

        lightbox = GLightbox({
            selector: '.gallery-slider .glightbox'
        });
    }

    // ✅ Bind Splide events CORRECTLY
    splide.on('mounted', initLightbox);
    splide.on('move', initLightbox);
    splide.on('refresh', initLightbox);

    // ✅ Mount with extensions (AutoScroll)
    splide.mount(
        window.splide?.Extensions || {}
    );

    jQuery(window).on('resize', function () {
        splide.refresh();
    });

});