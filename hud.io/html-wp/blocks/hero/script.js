if (jQuery('.hero-section').length) {
    var main = new Splide("#hero-img-slider", {
        type: "loop",
        pagination: false,
        arrows: false,
        autoWidth: true,
        rewind: false,
        gap: '15px',
        padding: '0.938rem',
        isNavigation: false,
        // autoplay: true,
        // interval: 8000,
        breakpoints: {
            992: {
                pagination: true,
            },
        }
    });

    var thumbnails = new Splide("#thumbnail-info-slider", {
        // type: "slide",
        direction: "ttb",
        height: "100%",
        perPage: 3,
        wheel: false,
        arrows: false,
        isNavigation: true,
        pagination: false,
        drag: false, // Disables drag functionality
    });

    main.sync(thumbnails);
    main.mount();
    thumbnails.mount();
}