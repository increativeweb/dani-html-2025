// Hero Slider

wp.domReady(function () {
    if (document.querySelectorAll('#hero-img-slider').length > 0) {
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
            type: "slide",
            direction: "ttb",
            height: "100%",
            perPage: 3,
            wheel: false,
            arrows: false,
            isNavigation: true,
            pagination: false,
        });

        main.sync(thumbnails);
        main.mount();
        thumbnails.mount();
    }

    // Post Slider
    console.log("dssdsdsd");

    if (document.getElementsByClassName('post-splide').length) {
        console.log("@@@@@");
        const slider = new Splide('.post-splide', {
            type: 'slide',
            perPage: 3,
            perMove: 1,
            pagination: true,
            arrows: false,
            gap: '20px',
            classes: {
                pagination: 'splide__pagination is-dark'
            },
            breakpoints: {
                1200: {
                    perPage: 3,
                },
                992: {
                    perPage: 2,
                    padding: '1.5rem',
                    gap: '1rem',
                    autoWidth: true,
                },
                767: {
                    perPage: 1,
                    autoWidth: true,
                    drag: true,
                }
            }
        });

        slider.on('mounted', function () {
            const slideCount = slider.length; // total slides
            if (window.innerWidth > 1400) {
                if (slideCount <= 3) {
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


    if (document.getElementsByClassName('testimonial-splide').length) {
        const testimonialSlider = new Splide('.testimonial-splide', {
            type: 'loop',
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
    
});