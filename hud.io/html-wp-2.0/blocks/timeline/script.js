if (jQuery('.history-slider').length) {

    const desktopPerPage = parseInt(
        jQuery('.history-slider').data('desktop-perpage'),
        10
    ) || 7; // fallback

    const slider = new Splide('.history-slider', {
        type: 'slide',
        perPage: desktopPerPage,
        perMove: 1,
        pagination: false,
        arrows: true,
        gap: '1rem',
        breakpoints: {
            1200: { perPage: 5 },
            992: { perPage: 4 },
            767: { destroy: true },
        }
    });

    slider.on('mounted', function () {
        const slideCount = slider.Components.Slides.getLength();
        console.log(slideCount);

        if (window.innerWidth > 1200 && slideCount <= desktopPerPage && slideCount == desktopPerPage) {
            slider.options = {
                ...slider.options,
                drag: false,
                keyboard: false,
                flickPower: 0,
                arrows: false,
                pagination: false,
            };

            slider.refresh(); // 🔑 REQUIRED
        }
    });

    slider.mount();
}