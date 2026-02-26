import Swiper, { Autoplay, EffectFade } from 'swiper';

// Custom equal heights function with !important
const equalHeightsImportant = (selector: string) => {
    const elements = document.querySelectorAll<HTMLElement>(selector);
    if (!elements.length) return;

    // Reset heights first
    elements.forEach((element) => {
        element.style.setProperty('height', 'auto', 'important');
    });

    // Measure heights
    const heights = Array.from(elements).map((element) => element.offsetHeight);

    // Find max height
    const maxHeight = Math.max(...heights);

    // Set all elements to max height with !important
    elements.forEach((element) => {
        element.style.setProperty('height', `${maxHeight}px`, 'important');
    });
};

const RANGE_START = 10; // percent start point
const RANGE_END = 90;   // percent end point

// Global function to update slider position
const updateSliderPosition = (nav: Element, currentIndex: number, totalSlides: number) => {
    const progress = nav.querySelector('.block-cards-slider__progress') as HTMLElement;
    const handle = nav.querySelector('.block-cards-slider__handle') as HTMLElement;
    const labels = nav.querySelectorAll('.block-cards-slider__label');
    const slider = nav.querySelector('.block-cards-slider__slider') as HTMLElement;

    if (!progress || !handle || !labels.length || !slider) return;

    const sliderRect = slider.getBoundingClientRect();
    const handleHalf = handle.offsetWidth / 2;
    const min = sliderRect.width > 0 ? (handleHalf / sliderRect.width) * 100 : 0;
    const max = sliderRect.width > 0 ? 100 - (handleHalf / sliderRect.width) * 100 : 100;
    const rangeStart = Math.max(min, RANGE_START);
    const rangeEnd = Math.min(max, RANGE_END);
    const span = Math.max(0, rangeEnd - rangeStart);

    const percentage =
        span === 0
            ? rangeStart
            : totalSlides > 1
              ? rangeStart + (currentIndex / (totalSlides - 1)) * span
              : (rangeStart + rangeEnd) / 2;

    progress.style.width = `${percentage}%`;
    handle.style.left = `${percentage}%`;

    // Update active label
    labels.forEach((label, index) => {
        if (index === currentIndex) {
            label.classList.add('active');
        } else {
            label.classList.remove('active');
        }
    });
};

const initCustomSlider = (nav: Element, totalSlides: number, getSwiper: () => any) => {
    if (nav.getAttribute('data-nav-attached') === '1') return;

    const slider = nav.querySelector('.block-cards-slider__slider') as HTMLElement;
    const progress = nav.querySelector('.block-cards-slider__progress') as HTMLElement;
    const handle = nav.querySelector('.block-cards-slider__handle') as HTMLElement;
    const labels = nav.querySelectorAll('.block-cards-slider__label');

    if (!slider || !progress || !handle || !labels.length) {
        return;
    }

    nav.setAttribute('data-nav-attached', '1');
    let isDragging = false;
    let startX = 0;
    let sliderRect = slider.getBoundingClientRect();

    const getBounds = () => {
        sliderRect = slider.getBoundingClientRect();
        const handleHalf = handle.offsetWidth / 2;
        const min = sliderRect.width > 0 ? (handleHalf / sliderRect.width) * 100 : 0;
        const max = sliderRect.width > 0 ? 100 - (handleHalf / sliderRect.width) * 100 : 100;
        const rangeStart = Math.max(min, RANGE_START);
        const rangeEnd = Math.min(max, RANGE_END);
        const span = Math.max(0, rangeEnd - rangeStart);
        return { min, max, rangeStart, rangeEnd, span, sliderRect };
    };

    const applyPosition = (percent: number) => {
        const { rangeStart, rangeEnd, span } = getBounds();
        const clamped = Math.max(rangeStart, Math.min(rangeEnd, percent));
        progress.style.width = `${clamped}%`;
        handle.style.left = `${clamped}%`;
        return { clamped, rangeStart, rangeEnd, span };
    };

    // Handle mouse/touch start
    const handleStart = (clientX: number) => {
        isDragging = true;
        startX = clientX;
        sliderRect = slider.getBoundingClientRect();
        handle.style.transition = 'none';
        progress.style.transition = 'none';
        document.body.style.userSelect = 'none';
    };

    // Handle mouse/touch move
    const handleMove = (clientX: number) => {
        if (!isDragging) return;

        const newLeft = Math.max(0, Math.min(sliderRect.width, clientX - sliderRect.left));
        const percentage = sliderRect.width > 0 ? (newLeft / sliderRect.width) * 100 : 0;

        const { clamped, rangeStart, rangeEnd, span } = applyPosition(percentage);

        // Calculate which slide to highlight
        const normalized = span > 0 ? (clamped - rangeStart) / span : 0;
        const slideIndex = Math.round(normalized * (totalSlides - 1));
        const clampedIndex = Math.max(0, Math.min(totalSlides - 1, slideIndex));

        labels.forEach((label, index) => {
            if (index === clampedIndex) {
                label.classList.add('active');
            } else {
                label.classList.remove('active');
            }
        });
    };

    // Handle mouse/touch end
    const handleEnd = () => {
        if (!isDragging) return;

        isDragging = false;
        handle.style.transition = '';
        progress.style.transition = '';
        document.body.style.userSelect = '';

        const currentLeft = parseFloat(handle.style.left || '0');
        const { rangeStart, rangeEnd, span } = getBounds();
        const normalized = span > 0 ? (currentLeft - rangeStart) / span : 0;
        const slideIndex = Math.round(normalized * (totalSlides - 1));
        const clampedIndex = Math.max(0, Math.min(totalSlides - 1, slideIndex));

        const swiper = getSwiper();
        if (swiper) {
            swiper.slideToLoop(clampedIndex);
        }
    };

    // Mouse events
    handle.addEventListener('mousedown', (e) => {
        e.preventDefault();
        handleStart(e.clientX);
    });

    slider.addEventListener('mousedown', (e) => {
        e.preventDefault();
        handleStart(e.clientX);
        const rect = slider.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const clickPercentage = rect.width > 0 ? (clickX / rect.width) * 100 : 0;
        const segmentIndex = Math.round((clickPercentage / 100) * (totalSlides - 1));
        const clampedIndex = Math.max(0, Math.min(totalSlides - 1, segmentIndex));
        const { rangeStart, rangeEnd, span } = getBounds();
        const segmentCenter = span > 0 ? rangeStart + (clampedIndex / (totalSlides - 1)) * span : rangeStart;

        applyPosition(segmentCenter);
    });

    document.addEventListener('mousemove', (e) => {
        handleMove(e.clientX);
    });

    document.addEventListener('mouseup', handleEnd);

    // Touch events
    handle.addEventListener('touchstart', (e) => {
        e.preventDefault();
        handleStart(e.touches[0].clientX);
    });

    slider.addEventListener('touchstart', (e) => {
        e.preventDefault();
        const rect = slider.getBoundingClientRect();
        const touchX = e.touches[0].clientX - rect.left;
        const touchPercentage = rect.width > 0 ? (touchX / rect.width) * 100 : 0;
        const segmentIndex = Math.round((touchPercentage / 100) * (totalSlides - 1));
        const clampedIndex = Math.max(0, Math.min(totalSlides - 1, segmentIndex));
        const { rangeStart, rangeEnd, span } = getBounds();
        const segmentCenter = span > 0 ? rangeStart + (clampedIndex / (totalSlides - 1)) * span : rangeStart;

        applyPosition(segmentCenter);
        handleStart(e.touches[0].clientX);
    });

    document.addEventListener('touchmove', (e) => {
        handleMove(e.touches[0].clientX);
    });

    document.addEventListener('touchend', handleEnd);

    // Click on labels
    labels.forEach((label, index) => {
        label.addEventListener('click', () => {
            const swiper = getSwiper();
            if (swiper) {
                swiper.slideToLoop(index);
            }
        });
    });

    // Initialize position
    updateSliderPosition(nav, 0, totalSlides);
};

const initBlockCardsSlider = () => {
    const blocks = document.querySelectorAll('.block-cards-slider');
    if (!blocks.length) return;

    blocks.forEach((block) => {
        block.classList.add('active');

        const mobileNav = block.querySelector('.block-cards-slider__mobile .block-cards-slider__navigation');
        const desktopNav = block.querySelector('.block-cards-slider__desktop .block-cards-slider__navigation');
        const totalSlides =
            (mobileNav?.querySelectorAll('.block-cards-slider__label').length ?? 0) ||
            (desktopNav?.querySelectorAll('.block-cards-slider__label').length ?? 0) ||
            block.querySelectorAll('.block-cards-slider__label').length;

        let mobileSwiper: any = null;
        let contentSwiper: any = null;
        let imageSwiper: any = null;
        let currentMode: 'mobile' | 'desktop' | null = null;
        let resizeTimeout: number | undefined;

        const syncNavs = (index: number) => {
            if (mobileNav) {
                updateSliderPosition(mobileNav, index, totalSlides);
            }
            if (desktopNav) {
                updateSliderPosition(desktopNav, index, totalSlides);
            }
        };

        const applyEqualHeights = () => {
            setTimeout(() => {
                equalHeightsImportant('.block-cards-slider__carousel-content-area');
            }, 200);
        };

        const getActiveSwiper = () => (currentMode === 'desktop' ? contentSwiper : mobileSwiper);

        if (mobileNav) {
            initCustomSlider(mobileNav, totalSlides, () => mobileSwiper);
        }
        if (desktopNav) {
            initCustomSlider(desktopNav, totalSlides, () => contentSwiper);
        }

        const destroyMobileSwiper = () => {
            if (mobileSwiper) {
                mobileSwiper.destroy(true, true);
                mobileSwiper = null;
            }
        };

        const destroyDesktopSwipers = () => {
            if (contentSwiper) {
                contentSwiper.destroy(true, true);
                contentSwiper = null;
            }
            if (imageSwiper) {
                imageSwiper.destroy(true, true);
                imageSwiper = null;
            }
        };

        const initMobileSwiper = () => {
            const mainCarousel = block.querySelector('.js--cards-carousel');
            if (!mainCarousel || !(mainCarousel instanceof HTMLElement)) {
                console.error('Main carousel element not found');
                return;
            }

            mobileSwiper = new Swiper(mainCarousel, {
                modules: [Autoplay],
                loop: true,
                slidesPerView: 1,
                spaceBetween: 0,
                allowTouchMove: true,
                speed: 800,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                on: {
                    init: function () {
                        applyEqualHeights();
                        syncNavs((this as any).realIndex);
                    },
                    slideChange: function () {
                        syncNavs((this as any).realIndex);
                        applyEqualHeights();
                    },
                    resize: function () {
                        applyEqualHeights();
                    },
                },
            });

            currentMode = 'mobile';
        };

        const initDesktopSwipers = () => {
            const contentEl = block.querySelector('.js--cards-content');
            const imageEl = block.querySelector('.js--cards-images');

            if (!contentEl || !(contentEl instanceof HTMLElement) || !imageEl || !(imageEl instanceof HTMLElement)) {
                console.error('Desktop sliders missing');
                return;
            }

            imageSwiper = new Swiper(imageEl, {
                modules: [Autoplay],
                loop: true,
                slidesPerView: 1,
                spaceBetween: 0,
                allowTouchMove: false,
                speed: 800,
                autoplay: false,
            });

            contentSwiper = new Swiper(contentEl, {
                modules: [Autoplay, EffectFade],
                loop: true,
                slidesPerView: 1,
                spaceBetween: 0,
                allowTouchMove: false,
                speed: 800,
                effect: 'fade',
                fadeEffect: { crossFade: true },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                on: {
                    init: function () {
                        const realIndex = (this as any).realIndex;
                        if (imageSwiper) {
                            imageSwiper.slideToLoop(realIndex, 0);
                        }
                        syncNavs(realIndex);
                        applyEqualHeights();
                    },
                    slideChange: function () {
                        const realIndex = (this as any).realIndex;
                        if (imageSwiper) {
                            imageSwiper.slideToLoop(realIndex);
                        }
                        syncNavs(realIndex);
                        applyEqualHeights();
                    },
                    resize: function () {
                        applyEqualHeights();
                    },
                },
            });

            currentMode = 'desktop';
        };

        const setupMode = () => {
            const shouldDesktop = window.innerWidth >= 992;

            if (shouldDesktop && currentMode !== 'desktop') {
                destroyMobileSwiper();
                initDesktopSwipers();
            } else if (!shouldDesktop && currentMode !== 'mobile') {
                destroyDesktopSwipers();
                initMobileSwiper();
            }
        };

        setupMode();

        window.addEventListener('resize', () => {
            if (resizeTimeout) {
                window.clearTimeout(resizeTimeout);
            }
            resizeTimeout = window.setTimeout(() => {
                setupMode();
            }, 200);
        });
    });
};

window.document.addEventListener('DOMContentLoaded', initBlockCardsSlider, false);

// Initialize dynamic block preview (editor).
if (window.acf) {
    window.acf?.addAction('render_block_preview', initBlockCardsSlider);
}

export {};
