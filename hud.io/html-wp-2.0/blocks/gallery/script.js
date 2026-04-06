jQuery('.gallery-slider').each(function () {

    let lightbox;
    const $slider = jQuery(this);

    // ✅ Always read as number
    const autoScrollEnabled = Number($slider.attr('data-gallery-autoscroll')) === 1;

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
        splideOptions.autoScroll = false;
        splideOptions.perMove = 1;
    }

    console.log('AutoScroll:', autoScrollEnabled, splideOptions);

    const splide = new Splide(this, splideOptions);

    // 🔥 IMPORTANT: mount AutoScroll extension
    splide.mount(
        window.splide?.Extensions || {}
    );

    splide.on('mounted moved refreshed', function () {
        if (lightbox) {
            lightbox.destroy();
        }

        lightbox = GLightbox({
            selector: '.gallery-slider .glightbox',
        });
    });

    jQuery(window).on('resize', function () {
        splide.refresh();
    });

});