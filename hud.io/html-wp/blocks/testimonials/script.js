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