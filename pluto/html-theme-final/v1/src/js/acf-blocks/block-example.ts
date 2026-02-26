import Swiper, { Autoplay } from 'swiper';

const initBlockExample = () => {
    const blocks = document.querySelectorAll('.block-example');
    if (blocks) {
        blocks.forEach((block) => {
            block.classList.add('active');

            const exampleCarousel = document.querySelector('.js--carousel');

            // Initialize Swiper only if the carousel element exists
            if (exampleCarousel && exampleCarousel instanceof HTMLElement) {
                const swiper = new Swiper(exampleCarousel, {
                    modules: [Autoplay],
                    loop: true,
                    slidesPerView: 2,
                    spaceBetween: 0,
                    allowTouchMove: false,
                    speed: 5000,
                    autoplay: {
                        delay: 0,
                        disableOnInteraction: false,
                    },
                    freeMode: {
                        enabled: true,
                        sticky: true,
                    },

                    breakpoints: {
                        576: {
                            slidesPerView: 3,
                        },
                        768: {
                            slidesPerView: 4,
                        },
                        992: {
                            slidesPerView: 6,
                        },
                        1200: {
                            slidesPerView: 6,
                        },
                        1440: {
                            slidesPerView: 6.35,
                        },
                    },
                });

            }
        });
    }
};

window.document.addEventListener('DOMContentLoaded', initBlockExample, false);

/* eslint-disable no-console */
// Initialize dynamic block preview (editor).
if (window.acf) {
    window.acf?.addAction('render_block_preview', initBlockExample);
}

export {};
