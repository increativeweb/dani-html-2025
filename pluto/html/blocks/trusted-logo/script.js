if (jQuery('.logo-slider').length) {
    var splideOptions = {
        perPage: 7,
        autoWidth: true,
        pagination: false,
        arrows: false,
        gap: 80,
        type: 'loop',
        focus: 'center',
        autoScroll: {
            speed: 1
        },
        breakpoints: {
            767: {
                perPage: 3,
                arrows: false,
                gap: 60,
            },
        },
    };
    if (jQuery('.logo-slider').length) {
        new Splide('.logo-slider', splideOptions).mount(window.splide.Extensions);
    }
}