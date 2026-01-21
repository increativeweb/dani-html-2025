import Swiper, { Autoplay, Pagination } from 'swiper';
import { equalHeights } from '../parts/helpers';

const initBlockPosts = () => {
    const blocks = document.querySelectorAll('.block-posts');
  
    if (!blocks.length) return;

    const updateNavPosition = (block: Element, index: number, total: number) => {
        const progress = block.querySelector('.block-posts__progress') as HTMLElement;
        const handle = block.querySelector('.block-posts__handle') as HTMLElement;
        if (!progress || !handle || total < 1) return;

        const percentage = total > 1 ? (index / (total - 1)) * 100 : 0;
        progress.style.width = `${percentage}%`;
        handle.style.left = `${percentage}%`;
    };

    blocks.forEach((block) => {
        block.classList.add('active');

        const exampleCarousel = block.querySelector('.js--carousel');
        const slider = block.querySelector('.block-posts__slider') as HTMLElement;
        const totalSlides =
            block.querySelectorAll('.block-posts__item:not(.swiper-slide-duplicate)').length ||
            block.querySelectorAll('.block-posts__item').length;
        const isDesktop = window.innerWidth >= 1200;

        if (exampleCarousel && exampleCarousel instanceof HTMLElement) {
            const swiper = new Swiper(exampleCarousel, {
                modules: [Autoplay, Pagination],
                loop: true,
                slidesPerView: 1.5,
                spaceBetween: 29,
                centeredSlides: true,
                speed: 1000,
                autoplay: {
                    delay: 1000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                },
                breakpoints: {
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 55,
                        speed: 2500,
                    },
                    1200: {
                        slidesPerView: 3,
                        spaceBetween: 55,
                        speed: 2500,
                        pagination: {
                            el: '',
                        },
                    },
                },
                on: {
                    init: function () {
                        setTimeout(() => {
                            equalHeights('.block-posts__item');
                            if (isDesktop) {
                                updateNavPosition(block, (this as any).realIndex, totalSlides);
                            }
                        }, 200);
                    },
                    slideChange: function () {
                        if (isDesktop) {
                            updateNavPosition(block, (this as any).realIndex, totalSlides);
                        }
                    },
                    resize: function () {
                        setTimeout(() => {
                            equalHeights('.block-posts__item');
                            if (window.innerWidth >= 1200) {
                                updateNavPosition(block, (this as any).realIndex, totalSlides);
                            } else {
                                const progress = block.querySelector('.block-posts__progress') as HTMLElement;
                                const handle = block.querySelector('.block-posts__handle') as HTMLElement;
                                if (progress) progress.style.width = '';
                                if (handle) handle.style.left = '';
                            }
                        }, 200);
                    },
                },
            });

            // Slider track click
            if (slider && isDesktop) {
                slider.addEventListener('click', (e) => {
                    const rect = slider.getBoundingClientRect();
                    const clickX = e.clientX - rect.left;
                    const percentage = Math.max(0, Math.min(1, clickX / rect.width));
                    const targetIndex = Math.round(percentage * (totalSlides - 1));
                    swiper.slideToLoop(targetIndex);
                });
            }
        }
    });
};

window.document.addEventListener('DOMContentLoaded', initBlockPosts, false);

/* eslint-disable no-console */
// Initialize dynamic block preview (editor).
if (window.acf) {
    window.acf?.addAction('render_block_preview', initBlockPosts);
}

export {};
