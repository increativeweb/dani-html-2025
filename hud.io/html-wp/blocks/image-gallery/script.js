if (jQuery('.image-gallery-slider').length) {
    const imageGallerySplide = new Splide('.image-gallery-slider', {
        type: 'loop',
        perPage: 3,
        perMove: 1,
        pagination: false,
        autoWidth: true,
        arrows: true,
        focus: 'center',
        gap: '20px',
        mediaQuery: 'max',
        autoplay: true,
        breakpoints: {
            1200: {
                perPage: 2,
            },
            767: {
                perPage: 1,
                gap: '12px',
            }
        }
    });
    imageGallerySplide.mount();

    jQuery(window).on('resize', function () {
        imageGallerySplide.refresh();
    });
}