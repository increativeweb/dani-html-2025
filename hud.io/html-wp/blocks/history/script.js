 if (jQuery('.history-slider').length) {
    const slider = new Splide('.history-slider', {
            type: 'slide',
            perPage: 7,
            perMove: 1,
            pagination: false,
            arrows: false,
            gap: '1rem',
            breakpoints: {
                1200: {
                    perPage: 5,
                },
                992: {
                    perPage: 4,
                },
                767: {
                    destroy: true,
                }
            }
        });

        slider.on('mounted', function () {
            const slideCount = slider.length; // total slides
            if (window.innerWidth > 1400) {
                if (slideCount <= 7) {
                    // Disable all movement
                    slider.options = {
                        arrows: false,
                        pagination: false,
                        drag: false,
                        keyboard: false,
                        flickPower: 0,
                    };
                }
            }
        });

        slider.mount();
}