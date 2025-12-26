if (jQuery('.history-slider').length) {

    const slider = new Splide('.history-slider', {
        type: 'slide',
        perPage: 7,
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
        
        if (window.innerWidth > 1200 && slideCount <= 7 && slideCount == 7) {
            slider.options = {
                ...slider.options,
                drag: false,
                keyboard: false,
                flickPower: 0,
                arrows: false,
                pagination: false,
            };

            // slider.refresh(); // 🔑 REQUIRED
        }
    });

    slider.mount();
}