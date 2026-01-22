if ($('.story-swiper-slider').length) {
    // new Swiper('.story-swiper-slider', {
    //     slidesPerView: 'auto',
    //     spaceBetween: 20,
    //     loop: true,
    //     speed: 9000,
    //     grabCursor: true,
    //     allowTouchMove: true,
    //     initialSlide: 2,
    //     autoplay: {
    //         delay: 0,
    //         disableOnInteraction: false,
    //         pauseOnMouseEnter: true,
    //     },

    //     freeMode: true,
    //     freeModeMomentum: false,
    //     loopAdditionalSlides: 12,

    //     breakpoints: {
    //         767: {
    //             spaceBetween: 24,
    //         },
    //     }
    // });
    var swiper = new Swiper(".story-swiper-slider", {
        slidesPerView: 'auto',
        loop: true,
        centeredSlides: true,
        spaceBetween: 20,
        speed: 9000,
        grabCursor: true,
        allowTouchMove: true,
        autoplay: {
            delay: 0,
            enabled: true,
        },
        breakpoints: {
            767: {
                spaceBetween: 24,
            },
        }
    });
}
