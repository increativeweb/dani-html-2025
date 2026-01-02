jQuery(function ($) {
    if (!$('.vertical-splide').length) return;

    // Slider 1: Top → Bottom
    new Splide('.vertical-splide--down', {
        perPage: 3,
        pagination: false,
        arrows: false,
        gap: 20,
        fixedHeight : '240px',
        fixedWidth : '240px',
        direction: 'ttb',
        height: '100%',
        type: 'loop',
        focus: 'center',
        autoScroll: {
            speed: 1,
            rewind: false
        },
        breakpoints: {
            1200: {
                fixedHeight : '210px',
                fixedWidth : '210px',
            },
            992: {
                direction: 'ltr',
            },
        },
    }).mount(window.splide.Extensions);

    // Slider 2: Bottom → Top (reverse)
    new Splide('.vertical-splide--up', {
        perPage: 3,
        pagination: false,
        arrows: false,
        gap: 20,
        direction: 'ttb',
        height: '100%',
        type: 'loop',
        focus: 'center',
        fixedHeight : '240px',
        fixedWidth : '240px',
        autoScroll: {
            speed: -1, // 👈 reverse direction
            rewind: false
        },
        breakpoints: {
            1200: {
                fixedHeight : '210px',
                fixedWidth : '210px',
            },
            992: {
                direction: 'ltr',
            },
        },
    }).mount(window.splide.Extensions);
});
