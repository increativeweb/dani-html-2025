import Swiper, { Autoplay } from 'swiper';
import { equalHeights } from '../parts/helpers';


const initBlockToolbox = () => {
    const blocks = document.querySelectorAll('.block-toolbox');
    if (blocks) {
        blocks.forEach((block) => {
            block.classList.add('active');

            const ToolboxCarousel = block.querySelector('.js--carousel');

            if (ToolboxCarousel && ToolboxCarousel instanceof HTMLElement) {
                const swiper = new Swiper(ToolboxCarousel, {
                    modules: [Autoplay],
                    loop: true,
                    slidesPerView: 1.2,
                    centeredSlides: true,
                    spaceBetween: 16,
                    allowTouchMove: false,
                    speed: 5000,
                    on: {
                        init: function() {
                            // Set equal heights for all slides
                            setTimeout(() => {
                                equalHeights('.block-toolbox__carousel-item');
                            }, 100);
                        },
                        slideChange: function() {
                            setTimeout(() => {
                                equalHeights('.block-toolbox__carousel-item');
                            }, 100);
                        },
                        resize: function() {
                            setTimeout(() => {
                                equalHeights('.block-toolbox__carousel-item');
                            }, 100);
                        }
                    },
                    breakpoints: {
                        400: {
                            slidesPerView: 1.4,
                            spaceBetween: 40
                        },
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 40
                        },
                        1200: {
                            slidesPerView: 2.7,
                            spaceBetween: 83,
                        },
                        1300: {
                            slidesPerView: 2.5,
                            spaceBetween: 83,
                        },
                        1500: {
                            slidesPerView: 3,
                            spaceBetween: 83,
                        }
                    }
                });
            }
        });
    }
};

window.document.addEventListener('DOMContentLoaded', initBlockToolbox, false);

/* eslint-disable no-console */
// Initialize dynamic block preview (editor).
if (window.acf) {
    window.acf?.addAction('render_block_preview', initBlockToolbox);
}

export {};
