(function ($) {

    const $slider = $('.logo-slider');

    // ✅ Safe exit (NO illegal return)
    if (!$slider.length) {
        return;
    }

    const desktopPerPage = parseInt($slider.data('desktop-perpage'), 10) || 7;
    const autoScrollEnabled = parseInt($slider.data('autoscroll'), 10) == 1;

    let splideOptions = {
        perPage: desktopPerPage,
        preloadPages: "6",
        lazyLoad: 'nearby', // or 'sequential'
        pagination: false,
        arrows: false,
        gap: 80,
        // drag: false,
        breakpoints: {
            991: {
                autoWidth: true,
                perPage: 5,
                gap: 50,
                type: 'loop',
                focus: 'center',
                autoScroll: {
                    speed: 0.5
                }
            },
            767: {
                perPage: 3,
            },
        },
    };
    if (desktopPerPage > 7) {
        splideOptions.breakpoints[1920] = {
            drag: false
        };
    }

    // ✅ Enable loop + autoscroll
    if (autoScrollEnabled) {
        splideOptions.autoWidth = true;
        splideOptions.type = 'loop';
        splideOptions.focus = 'center';
        splideOptions.autoScroll = { speed: 0.5 };
    }

    const splide = new Splide($slider[0], splideOptions);

    splide.on('mounted', function () {
        const slideCount = splide.Components.Slides.getLength();

        // ✅ Disable slider if slides fit
        if (window.innerWidth > 991 && slideCount <= desktopPerPage && slideCount == desktopPerPage) {
            splide.options = {
                ...splide.options,
                drag: false,
                keyboard: false,
                flickPower: 0,
                arrows: false,
                pagination: false,
                type: 'slide',
                autoScroll: false
            };
        }
    });

    splide.mount(window.splide.Extensions);

})(jQuery);
