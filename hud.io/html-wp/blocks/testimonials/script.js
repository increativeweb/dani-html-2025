if (jQuery('.testimonial-splide').length) {
    const testimonialSlider = new Splide('.testimonial-splide', {
        type: 'slide',
        perPage: 3,
        perMove: 1,
        pagination: false,
        arrows: true,
        gap: '20px',
        padding: '10px',
        updateOnMove: true,
        classes: {
            pagination: 'splide__pagination is-dark',
        },
        mediaQuery: 'max',
        breakpoints: {
            992: {
                perPage: 2,
                arrows: false,
                pagination: true,
                autoWidth: true,
                padding: '15px'
            },
            767: {
                perPage: 1,
                focus: 'center',
                gap: '15px',
            }
        }
    });
    testimonialSlider.mount();


    jQuery(window).on('resize', function () {
        testimonialSlider.refresh();
    });
}
if (jQuery('.testimonials-vertical-slider').length) {
    const testimonialSlider2 = new Splide('.testimonials-vertical-slider', {
        type: 'loop',
        direction: 'ttb',
        perPage: 1,
        perMove: 1,
        height: 'auto',
        rewind: true,
        arrows: true,
        pagination: false,
        updateOnMove: true,

        classes: {
            pagination: 'splide__pagination is-dark',
        },

        mediaQuery: 'max',
        breakpoints: {
            992: {
                // pagination: true
            },
            767: {
                // gap: '15px',
            }
        }
    });

    testimonialSlider2.mount();

    $(window).on('resize', function () {
        testimonialSlider2.refresh();
    });
}