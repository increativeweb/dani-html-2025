if (jQuery('.image-gallery-slider').length) {
    const imageGallerySplide = new Splide('.image-gallery-slider', {
        type: 'loop',
        perPage: 3,
        perMove: 1,
        pagination: false,
        autoWidth: true,
        arrows: true,
        gap: '20px',
        mediaQuery: 'max',
        autoplay: true,
        breakpoints: {
            1200: {
                perPage: 2,
                padding: '15px'
            },
            767: {
                perPage: 1,
                gap: '15px',
            }
        }
    });
    imageGallerySplide.mount();

    jQuery(window).on('resize', function () {
        imageGallerySplide.refresh();
    });
}