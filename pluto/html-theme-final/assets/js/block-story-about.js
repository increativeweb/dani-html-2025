if (jQuery('.story-slider').length) {
    var splideOptions = {
        perPage: 4,
        autoWidth: true,
        pagination: false,
        arrows: false,
        gap: 24,
        type: 'loop',
        focus: 'center',
        autoScroll: {
            speed: 1
        },
        breakpoints: {
            1200: { perPage: 3 },
            992: { perPage: 2 },
            767: {
                perPage: 1,
                gap: 20
            },
        }
    };
    if (jQuery('.story-slider').length) {
        new Splide('.story-slider', splideOptions).mount(window.splide.Extensions);
    }
}