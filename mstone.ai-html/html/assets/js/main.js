/*-----------------------------------------------------------------------------------*/
/* MAIN
/*-----------------------------------------------------------------------------------*/
var $ = jQuery.noConflict();

jQuery(document).ready(function($) {
    $('[data-bs-toggle="tooltip"]').tooltip();

    $('.navbar-toggler').on('click', function (e) {
        $('.navbar-toggler,body,.main-header').toggleClass('is-visible');
        e.preventDefault();
    });
    if ($('.main-header').length) {
        if (jQuery(this).scrollTop() > 100) {
            $(".main-header").addClass("fixed-header");
        } else {
            $(".main-header").removeClass("fixed-header");
        }

        $(window).scroll(function () {
            if (jQuery(this).scrollTop() > 100) {
                $(".main-header").addClass("fixed-header");
            } else {
                $(".main-header").removeClass("fixed-header");
            }
        });
    }
    if ($('li.menu-item-has-children').length) {
        $("li.menu-item-has-children > a").after('<i class="arrow"></i>');
    }
    $('li.menu-item-has-children .arrow').on('click',function(event){
        event.preventDefault();
        $(this).toggleClass('is-active');
        $(this).parent().find('.sub-menu').first().toggle(300);
    });
    if ($('.tab-block').length) {
        const tabBlock = document.querySelector('.tab-block');
        const lottieInstances = new Map();

        const playLottieForWrapper = (wrapper) => {
            if (!wrapper) {
                return;
            }

            const container = wrapper.querySelector('.lottie-container');

            if (!container) {
                return;
            }

            const lottieId = container.id;

            if (!lottieInstances.has(lottieId)) {
                return;
            }

            const animation = lottieInstances.get(lottieId);

            if (!animation) {
                return;
            }

            animation.stop();
            animation.goToAndStop(0, true);
            animation.play();
        };

        const playVideoForWrapper = (wrapper) => {
            if (!wrapper) {
                return;
            }

            const video = wrapper.querySelector('.tab-media__video');

            if (!video) {
                return;
            }

            video.pause();

            try {
                video.currentTime = 0;
            } catch (error) {

            }

            const playPromise = video.play();

            if (playPromise !== undefined) {
                playPromise.catch(function () {
                });
            }
        };

        const pauseAllVideos = () => {
            tabBlock.querySelectorAll('.tab-media__video').forEach((videoEl) => {
                videoEl.pause();
            });
        };

        const activatePane = (paneEl) => {
            if (!paneEl) {
                return;
            }

            const mediaWrapper = paneEl.querySelector('.tab-media');

            if (!mediaWrapper) {
                return;
            }

            const mediaType = mediaWrapper.getAttribute('data-media-type');

            if (mediaType === 'lottie') {
                playLottieForWrapper(mediaWrapper);
            } else if (mediaType === 'mp4') {
                playVideoForWrapper(mediaWrapper);
            }
        };

        const lottieContainers = tabBlock.querySelectorAll('.lottie-container[data-src]');

        lottieContainers.forEach((container) => {
            const url = container.getAttribute('data-src');

            if (!url) {
                return;
            }

            const animation = lottie.loadAnimation({
                container,
                renderer: 'svg',
                loop: false,
                autoplay: false,
                path: url,
            });

            lottieInstances.set(container.id, animation);
        });

        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const activePane = tabBlock.querySelector('.tab-pane.active');
                    if (activePane) {
                        activatePane(activePane);
                    }
                    obs.disconnect();
                }
            });
        }, {
            root: null,
            threshold: 0.5
        });

        observer.observe(tabBlock);

        $('.nav-tabs .tab-link').on('click', function (event) {
            event.preventDefault();

            const $this = $(this);
            const tabId = $this.attr('data-tab');
            const $targetPane = $('#' + tabId);

            if (!$targetPane.length) {
                return;
            }

            pauseAllVideos();

            $('.nav-tabs .tab-link').removeClass('active');
            $('.tab-pane').removeClass('show active').hide();

            $this.addClass('active');
            $targetPane.fadeIn().addClass('show active');

            activatePane($targetPane.get(0));
        });
    }

    if ($('.collapse-item').length) {
        $(document).on("click", ".collapse-item .collapse-title", function () {
            var $this = $(this).closest(".collapse-item");
            
            if ($this.hasClass("is-open")) {
                $this.removeClass("is-open");
                $this.find(".collapse-body").stop(true, true).slideUp(300); // Slide up with a smooth animation (300ms)
            } else {
                $(".collapse-item").removeClass("is-open");
                $(".collapse-item").find(".collapse-body").stop(true, true).slideUp(300); // Slide up other items smoothly
                $this.addClass("is-open");
                $this.find(".collapse-body").stop(true, true).slideDown(300); // Slide down with a smooth animation (300ms)
                
                // var collapsetop = $this.find(".collapse-title");
                // $('html, body').animate({
                //     scrollTop: collapsetop.offset().top - 115
                // }, 300); // Smooth scroll to the item
            }
            return false;
        });
    }
    

    // Hero Lottie animations
    const heroLottieContainers = document.querySelectorAll(".hero-slider-block .lottie-container");
    if (heroLottieContainers.length) {
        heroLottieContainers.forEach((item) => {
            const url = item.getAttribute("data-src");

            if (!url) {
                return;
            }

            const animation = lottie.loadAnimation({
                container: item,
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: url,
            });

            const poster = item.closest('.hero-media--lottie')?.querySelector('.hero-media__poster');

            if (poster) {
                const hidePoster = () => {
                    poster.classList.add('is-hidden');
                };

                animation.addEventListener('DOMLoaded', function () {
                    requestAnimationFrame(hidePoster);
                });

                setTimeout(hidePoster, 1500);
            }
        });
    }

    // Step Progress Section
    if ($('.progress-section').length) {
        $(window).on('scroll', function() {
            updateProgressBars();
        });
    }
    
    // Step Progress Section
    if ($('.progress-section').length) {
        $('.progress-section').on('scroll', updateProgressBars);
    }

    if ($(".icw-progress-goto").length > 0) {
        var progressPath = document.querySelector('.icw-progress-goto path');
        var pathLength = progressPath.getTotalLength();
    
        progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
        progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
        progressPath.style.strokeDashoffset = pathLength;
        progressPath.getBoundingClientRect();
        progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
    
        var updateProgress = function() {
            var scroll = $(window).scrollTop();
            var height = $(document).height() - $(window).height();
            var progress = pathLength - (scroll * pathLength / height);
            progressPath.style.strokeDashoffset = progress;
        }
    
        updateProgress();
        $(window).scroll(updateProgress);
    
        var offset = 200;
        var duration = 550;
    
        jQuery(window).on('scroll', function() {
            if(jQuery(this).scrollTop() > offset) {
                jQuery('.icw-progress-goto').addClass('active-progress');
            } else {
                jQuery('.icw-progress-goto').removeClass('active-progress');
            }
        });
    
        jQuery('.icw-progress-goto').on('click', function(event) {
            event.preventDefault();
            jQuery('html, body').animate({scrollTop: 0}, duration);
            return false;
        });
    }

    const $logoBlock = $('.site-logo-block');
    if ($logoBlock.length) {
        $(window).on('scroll', function() {
            const logoBlockTop = $logoBlock.offset().top;
            const windowBottom = $(window).scrollTop() + $(window).height();

            // Toggle class based on footer visibility
            $logoBlock.toggleClass('is-animate', windowBottom >= logoBlockTop);
        });
    }


    if ($('.play-iframe').length){
        $('.play-iframe').click(function(ev){	
            videourl = $(this).data('videosrc')+"?api=1&autoplay=1&muted=1&rel=0&enablejsapi=1";
            if($(this).data('ext') == 'mp4'){
                video = '<div class="video-wrap ratio ratio-16x9"><video class="embed-responsive-item w-100" controls autoplay playsinline controlsList="nodownload" oncontextmenu="return false;"><source src="'+videourl+'" type="video/mp4"></video></div>';
            } else {
                video = '<div class="video-wrap ratio ratio-16x9"><iframe class="embed-responsive-item play-in_iframe" allow="autoplay" src="'+videourl+'" controls="0" scrolling="no" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope" allowfullscreen></iframe></div>';
            }
            
            $(this).parents('.play-video-block').html(video);
            ev.preventDefault();
        });
    }
});

// Step Progress Section
if ($('.progress-section').length) {
    updateProgressBars();
}
function updateProgressBars() {
    var scrollPosition = $(window).scrollTop();
    // Loop through each section and check if it's in the viewport
    $('.progress-content-step').each(function (index) {
        var sectionTop = $(this).offset().top - $(window).height() / 1.2; // Mid-point trigger
        var sectionHeight = $(this).outerHeight();
        var sectionBottom = sectionTop + sectionHeight;
        var progressBarId = $(this).attr('id'); // Target progress bar by ID
        
        // var sectionAnimateContentTop = $(this).offset().top - $(window).height() / 1;
        // var sectionAnimateContentBottom = sectionAnimateContentTop + sectionHeight;
        
        if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
            // Animate progress bar height to 100%
            $('.image-block').find('.progress-content-img:not(.image-static)').removeClass('is-active');

            $('[data-progress-id="' + progressBarId + '"]').css('height', '100%');
            $('.image-block').find('[data-id="' + progressBarId + '"]').addClass('is-active');
        // } else if (scrollPosition >= sectionAnimateContentTop && scrollPosition < sectionAnimateContentBottom) {
            $('.progress-content-wrapper').find('.progress-content-step').removeClass('is-active');
            $('.progress-content-wrapper').find('[id="' + progressBarId + '"]').addClass('is-active');
            
        } else if (scrollPosition <= sectionTop) {
            // Reset progress bar height when section is not in view
            $('[data-progress-id="' + progressBarId + '"]').css('height', '0');
            
        } 
    });
}

// if ($('.splide').length) {
//     var splide_sliders = $('.splide');
//     for (var i = 0; i < splide_sliders.length; i++) {
//         new Splide(splide_sliders[i]).mount();
//     }
// }

// Splide Slider
if ($('.splide:not(.splide-js)').length) {
    $('.splide:not(.splide-js)').each(function() {
        new Splide(this).mount();
        $(this).addClass('icw_splide-with-data'); // Mark as initialized
    });
}
// Counter
if ($('.counter').length) {
    let options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.5 // Trigger when 50% of the element is visible
    };

    // Create a new observer
    let observer = new IntersectionObserver(function (entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                let $this = $(entry.target);
                var countTo = $this.attr("data-countto");
                var countDuration = parseInt($this.attr("data-duration"));
                
                $({ counter: $this.find('span').text() }).animate({
                    counter: countTo
                }, {
                    duration: countDuration,
                    easing: "linear",
                    step: function () {
                        $this.find('span').text(Math.floor(this.counter));
                    },
                    complete: function () {
                        $this.find('span').text(this.counter);
                    }
                });
                observer.unobserve(entry.target);
            }
        });
    }, options);

    // Target each element with the class .counter
    $('.counter').each(function () {
        observer.observe(this);    
    });
    
}

if ($('.thumbnail-slider-block').length) {
    var main = new Splide( '.use-case-splide-slider', {
        type      : 'fade',
        rewind    : true,
        pagination: false,
        arrows    : false,
    } );
    
    var thumbnails = new Splide( '.useCase-thumbnail-splide-slider', {       
        gap         : 8,
        rewind      : true,
        pagination  : false,
        arrows  : false,
        isNavigation: true,
        autoWidth: true,
    } );
    
    main.sync( thumbnails );
    main.mount();
    thumbnails.mount();
}

function animateCircle() {
	const lottieContainers = document.querySelectorAll(".metrics-section .image-block-lottie");

	if (!lottieContainers.length) { return; }

	lottieContainers.forEach((item) => {
		const url = item.getAttribute("data-src");

		lottie.loadAnimation({
			container: item,
			renderer: 'svg',
			loop: true,
			autoplay: true,
			path: url,
		});
	});
}

function animateCount(element, start, end, duration) {
	const stepTime = Math.abs(Math.floor(duration / (end - start)));
	let current = start;
	const increment = end > start ? 1 : -1;

	const timer = setInterval(() => {
		current += increment;
		element.textContent = current + "%";
		if (current === end) {
			clearInterval(timer);
		}
	}, stepTime);
}

function initAnimateCount() {
	const section = document.querySelector(".metrics-section");
    const countElements = document.querySelectorAll(".count");

    if (!section) { return; }

    let hasAnimated = false;

    const observerCount = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && !hasAnimated) {
                hasAnimated = true;
                countElements.forEach((el) => {
                    const target = parseInt(el.textContent, 10);
                    el.textContent = "0";
                    animateCount(el, 0, target, 2000);
                });
                observerCount.disconnect();
            }
        });
    }, { threshold: 0.5 });

    observerCount.observe(section);
}

function initBenefitsSections() {
    const sections = document.querySelectorAll('[data-benefits-section]');

    if (!sections.length) {
        return;
    }

    sections.forEach((section) => {
        const variant = section.getAttribute('data-benefits-variant') || 'default';
        const isScrollVariant = variant === 'alt';
        const mediaQueryDesktop = window.matchMedia('(min-width: 992px)');
        const mediaQueryTablet = window.matchMedia('(max-width: 991px)');

        const scrollTarget = section.querySelector('[data-benefits-scroll]');
        const slider = isScrollVariant ? scrollTarget : section.querySelector('[data-benefits-slider]');
        const scrollContainer = isScrollVariant ? scrollTarget : null;

        const slides = slider ? Array.from(slider.querySelectorAll('[data-benefits-slide]')) : [];
        const dotsWrapper = slider ? slider.querySelector('[data-benefits-dots]') : null;
        const altSlidesWrapper = isScrollVariant && slider ? slider.querySelector('.benefits-section-alt__slides') : null;
        const autoplayDelay = slider ? parseInt(slider.getAttribute('data-autoplay'), 10) || 2000 : 2000;
        const lottieElement = section.querySelector('[data-benefits-lottie]');
        const lottiePoster = lottieElement ? lottieElement.querySelector('[data-benefits-lottie-poster]') : null;
        const videoElement = section.querySelector('[data-benefits-video]');
        const lottieSrc = lottieElement ? lottieElement.getAttribute('data-src') : '';
        const display = isScrollVariant ? section.querySelector('[data-benefits-display]') : null;
        const displayTitle = display ? display.querySelector('[data-benefits-display-title]') : null;
        const displayText = display ? display.querySelector('[data-benefits-display-text]') : null;

        const hasSlider = Boolean(slider && slides.length);
        const hasScrollSteps = Boolean(isScrollVariant && scrollContainer && slides.length);
        const isScrollMode = () => hasScrollSteps && mediaQueryDesktop.matches;
        const scrollbar = section.querySelector('[data-benefits-scrollbar]');
        const scrollbarBulletsContainer = scrollbar ? scrollbar.querySelector('.benefits-section-alt__scrollbar-bullets') : null;
        const scrollbarThumb = scrollbar ? scrollbar.querySelector('.benefits-section-alt__scrollbar-thumb') : null;
        const scrollbarThumbSegments = scrollbarThumb ? scrollbarThumb.querySelector('.benefits-section-alt__scrollbar-thumb-segments') : null;
        let currentIndex = 0;
        const slideProgress = new Map();
        // Przechowuj pozycję scrollTop w momencie aktywacji każdego slajdu
        const slideActivationScrollTop = new Map();
        let autoplayTimer = null;
        let hasIntersected = false;
        let lottieInstance = null;
        let lottieReady = false;
        let isMobileLooping = false;
        let displayTransitionTimeout = null;
        const showLottiePoster = () => {
            if (!lottiePoster) {
                return;
            }
            lottiePoster.classList.remove('is-hidden');
            lottiePoster.removeAttribute('hidden');
        };

        const hideLottiePoster = () => {
            if (!lottiePoster) {
                return;
            }
            lottiePoster.classList.add('is-hidden');
            lottiePoster.setAttribute('hidden', 'hidden');
        };

        function updateAltSliderHeight(slideEl) {
            if (!isScrollVariant || !altSlidesWrapper) {
                return;
            }
            if (isScrollMode()) {
                altSlidesWrapper.style.height = '';
                return;
            }
            const target = slideEl || altSlidesWrapper.querySelector('.benefits-section-alt__slide.is-active');
            const height = target ? target.offsetHeight : 0;
            if (height) {
                altSlidesWrapper.style.height = `${height}px`;
            }
        }

        function setActiveSlide(index) {
            if (!slides.length) {
                return;
            }

            const targetSlide = slides[index];

            function updateDisplayContent() {
                if (!isScrollMode() || !display || !targetSlide) {
                    return;
                }

                const sourceTitle = targetSlide.querySelector('[data-benefits-slide-title]');
                const sourceText = targetSlide.querySelector('[data-benefits-slide-text]');

                if (displayTitle) {
                    displayTitle.innerHTML = sourceTitle ? sourceTitle.innerHTML : '';
                }

                if (displayText) {
                    displayText.innerHTML = sourceText ? sourceText.innerHTML : '';
                }
            }

            if (isScrollMode() && display) {
                display.classList.remove('is-visible');
                display.classList.add('is-transitioning');
                if (displayTransitionTimeout) {
                    window.clearTimeout(displayTransitionTimeout);
                }
                displayTransitionTimeout = window.setTimeout(() => {
                    updateDisplayContent();
                    display.classList.add('is-visible');
                    display.classList.remove('is-transitioning');
                }, 200);
            } else {
                updateDisplayContent();
            }

            slides.forEach((slide, idx) => {
                const isActive = idx === index;
                slide.classList.toggle('is-active', isActive);
                slide.setAttribute('aria-hidden', isActive ? 'false' : 'true');
            });

            if (hasSlider && dotsWrapper) {
                const dots = dotsWrapper.querySelectorAll('[data-benefits-dot]');
                dots.forEach((dot, idx) => {
                    const isActive = idx === index;
                    dot.classList.toggle('is-active', isActive);
                    dot.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                });
            }

            const previousIndex = currentIndex;
            currentIndex = index;
            
            if (isScrollVariant && previousIndex !== index) {
                const currentScrollTop = window.scrollY || window.pageYOffset;
                const goingBackward = index < previousIndex;
                
                if (goingBackward) {
                    const slide = slides[index];
                    if (slide) {
                        const slideHeight = slide.offsetHeight || slide.getBoundingClientRect().height;
                        const windowHeight = window.innerHeight;
                        const scrollableHeight = Math.max(slideHeight - windowHeight, slideHeight * 0.5);                       
        
                        slideActivationScrollTop.set(index, currentScrollTop - scrollableHeight);
                        slideProgress.set(index, 1);
                    } else {
                        slideActivationScrollTop.set(index, currentScrollTop);
                        slideProgress.set(index, 1);
                    }
                    if (scrollbar && scrollbarBulletsContainer) {
                        updateScrollbar();
                    }
                } else {
                    slideProgress.set(index, 0);
                    slideActivationScrollTop.set(index, currentScrollTop);
                }
            }

            if (isScrollVariant && altSlidesWrapper) {
                window.requestAnimationFrame(() => updateAltSliderHeight(targetSlide));
            }
        }

        function goToNextSlide() {
            if (!hasSlider || slides.length < 2) {
                return;
            }
            const nextIndex = (currentIndex + 1) % slides.length;
            setActiveSlide(nextIndex);
            triggerLottie();
        }

        function stopAutoplay() {
            if (autoplayTimer) {
                clearInterval(autoplayTimer);
                autoplayTimer = null;
            }
        }

        function startAutoplay() {
            if (!mediaQueryDesktop.matches || !hasSlider || slides.length < 2 || isScrollVariant) {
                return;
            }

            stopAutoplay();
            autoplayTimer = window.setInterval(goToNextSlide, autoplayDelay);
            triggerLottie();
        }

        function startMobileLottie() {
            if (!lottieInstance || !lottieReady || isMobileLooping) {
                return;
            }
            lottieInstance.loop = true;
            lottieInstance.play();
            isMobileLooping = true;
        }

        function stopMobileLottie() {
            if (!lottieInstance || !isMobileLooping) {
                return;
            }
            isMobileLooping = false;
            lottieInstance.pause();
        }

        const shouldUseLottie = () => Boolean(lottieElement && window.lottie && lottieSrc && mediaQueryDesktop.matches);

        function destroyLottieInstance() {
            stopMobileLottie();
            if (lottieInstance) {
                lottieInstance.destroy();
                lottieInstance = null;
            }
            lottieReady = false;
            isMobileLooping = false;
            showLottiePoster();
        }

        function initLottieInstance() {
            if (!shouldUseLottie() || lottieInstance) {
                return;
            }

            lottieInstance = window.lottie.loadAnimation({
                container: lottieElement,
                renderer: 'svg',
                loop: false,
                autoplay: false,
                path: lottieSrc
            });

            lottieInstance.addEventListener('DOMLoaded', () => {
                lottieReady = true;
                hideLottiePoster();
                if (hasIntersected) {
                    if (hasScrollSteps) {
                        triggerLottie();
                    } else if (hasSlider && mediaQueryDesktop.matches) {
                        triggerLottie();
                    } else if (hasSlider) {
                        startMobileLottie();
                    }
                }
            });
        }

        function updateVisualMode() {
            if (!lottieElement) {
                return;
            }
            if (shouldUseLottie()) {
                section.classList.remove('has-static-benefits-visual');
                initLottieInstance();
            } else {
                section.classList.add('has-static-benefits-visual');
                destroyLottieInstance();
            }
        }

        function triggerLottie() {
            if (!lottieInstance || !lottieReady) {
                return;
            }

            if (hasSlider && !mediaQueryDesktop.matches) {
                return;
            }

            if (hasSlider) {
                stopMobileLottie();
            }

            lottieInstance.loop = false;
            lottieInstance.goToAndPlay(0, true);
        }

        if (hasSlider) {
            if (dotsWrapper && slides.length > 1) {
                dotsWrapper.innerHTML = '';
                const dotClassName = dotsWrapper.dataset.benefitsDotClass || (isScrollVariant ? 'benefits-section-alt__dot' : 'benefits-section__dot');
                slides.forEach((slide, idx) => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = dotClassName + (idx === 0 ? ' is-active' : '');
                    button.dataset.benefitsDot = idx;
                    button.setAttribute('aria-label', slide.dataset.benefitsLabel || `Slide ${idx + 1}`);
                    button.setAttribute('aria-pressed', idx === 0 ? 'true' : 'false');
                    button.addEventListener('click', () => {
                        setActiveSlide(idx);
                        if (mediaQueryDesktop.matches) {
                            triggerLottie();
                            startAutoplay();
                        }
                    });
                    dotsWrapper.appendChild(button);
                });
            } else if (dotsWrapper) {
                dotsWrapper.remove();
            }

            setActiveSlide(0);
        } else if (dotsWrapper) {
            dotsWrapper.remove();
        }

        function initScrollbarBullets() {
            if (!isScrollVariant || !scrollbar || !scrollbarBulletsContainer || !slides.length) {
                return;
            }

            if (isScrollMode() && slides.length > 0) {
                const vh90 = window.innerHeight * 0.9;
                const baseHeight = Math.min(Math.max(window.innerHeight * 0.6, vh90), 1100);
                
                slides.forEach((slide) => {
                    slide.style.height = `${baseHeight}px`;
                    slide.style.minHeight = `${baseHeight}px`;
                });
            }

            scrollbarBulletsContainer.innerHTML = '';

            slides.forEach((slide, index) => {
                const bullet = document.createElement('div');
                bullet.className = 'benefits-section-alt__scrollbar-bullet';
                bullet.setAttribute('data-slide-index', index);
                scrollbarBulletsContainer.appendChild(bullet);
            });

            if (scrollbarThumbSegments) {
                scrollbarThumbSegments.innerHTML = '';
                slides.forEach((slide, index) => {
                    const segment = document.createElement('div');
                    segment.className = 'benefits-section-alt__scrollbar-thumb-segment';
                    segment.setAttribute('data-slide-index', index);
                    scrollbarThumbSegments.appendChild(segment);
                    slideProgress.set(index, 0);
                });
            }
        }

        function updateScrollbar() {
            if (!isScrollVariant || !scrollbar || !scrollbarBulletsContainer || !isScrollMode() || !slides.length) {
                if (scrollbar) {
                    scrollbar.style.display = 'none';
                }
                return;
            }

            const sectionRect = section.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            const isSectionVisible = sectionRect.bottom > 0 && sectionRect.top < windowHeight;
            
            if (isSectionVisible && display && currentIndex === 0) {
                const currentScrollTop = window.scrollY || window.pageYOffset;
                const existingActivationTop = slideActivationScrollTop.get(0);
                
                if (existingActivationTop === undefined) {
                    const scrollContainer = section.querySelector('[data-benefits-scroll]');
                    
                    if (scrollContainer) {
                        const containerRect = scrollContainer.getBoundingClientRect();
                        const containerAbsoluteTop = containerRect.top + currentScrollTop;
                        
                        let stickyTopValue = 80;
                        try {
                            const computedTop = getComputedStyle(display).top;
                            if (computedTop.includes('var')) {
                                stickyTopValue = Math.max(80, (windowHeight - 520) / 2);
                            } else {
                                const topMatch = computedTop.match(/(\d+\.?\d*)px/);
                                if (topMatch) {
                                    stickyTopValue = parseFloat(topMatch[1]);
                                }
                            }
                        } catch (e) {
                            stickyTopValue = Math.max(80, (windowHeight - 520) / 2);
                        }
                        
                        const stickyActivationScrollTop = containerAbsoluteTop - stickyTopValue;
                        
                        slideActivationScrollTop.set(0, stickyActivationScrollTop);
                        slideProgress.set(0, 0);
                    }
                }
            }

            if (!isSectionVisible) {
                if (scrollbar) {
                    scrollbar.style.display = 'none';
                }
                return;
            }

            let bullets = scrollbarBulletsContainer.querySelectorAll('.benefits-section-alt__scrollbar-bullet');
            if (bullets.length !== slides.length) {
                initScrollbarBullets();
                bullets = scrollbarBulletsContainer.querySelectorAll('.benefits-section-alt__scrollbar-bullet');
            }

            if (bullets.length === 0) {
                return;
            }

            const thumbSegments = scrollbarThumbSegments ? scrollbarThumbSegments.querySelectorAll('.benefits-section-alt__scrollbar-thumb-segment') : [];
            if (thumbSegments.length !== slides.length) {
                initScrollbarBullets();
                return;
            }

            const currentScrollTop = window.scrollY || window.pageYOffset;
            
            for (let i = 0; i <= currentIndex; i++) {
                if (!slides[i]) continue;
                
                const slide = slides[i];
                const activationScrollTop = slideActivationScrollTop.get(i);
                
                if (activationScrollTop === undefined) {
                    if (i === currentIndex) {
                        slideActivationScrollTop.set(i, currentScrollTop);
                        slideProgress.set(i, 0);
                    } else {
                        slideActivationScrollTop.set(i, currentScrollTop);
                        slideProgress.set(i, 1);
                    }
                } else {
                    const scrollDelta = currentScrollTop - activationScrollTop;
                    
                    const slideHeight = slide.offsetHeight || slide.getBoundingClientRect().height;

                    const scrollableHeight = Math.max(slideHeight - windowHeight, slideHeight * 0.5);
                    
                    let progress = scrollDelta / scrollableHeight;
                    
                    progress = Math.min(1, Math.max(0, progress));
                    
                    slideProgress.set(i, progress);
                }
            }
            
            for (let i = currentIndex + 1; i < slides.length; i++) {
                slideProgress.set(i, 0);
                slideActivationScrollTop.delete(i);
            }
            
            thumbSegments.forEach((segment, index) => {
                const progress = slideProgress.get(index) || 0;
                const previousProgress = parseFloat(segment.style.transform.replace('scaleY(', '').replace(')', '')) || 0;
                
                if (index < currentIndex) {
                    segment.classList.add('is-active');
                    segment.style.transform = 'scaleY(1)';
                    segment.style.opacity = '1';
                    segment.style.transition = '';
                } else if (index === currentIndex) {
                    const clampedProgress = Math.max(0, Math.min(1, progress));
                    
                    if (clampedProgress < previousProgress) {
                        segment.style.transition = 'none';
                    } else {
                        segment.style.transition = '';
                    }
                    
                    if (clampedProgress > 0) {
                        segment.classList.add('is-active');
                        segment.style.transform = `scaleY(${clampedProgress})`;
                        segment.style.opacity = '1';
                    } else {
                        segment.classList.remove('is-active');
                        segment.style.transform = 'scaleY(0)';
                        segment.style.opacity = '0';
                    }
                } else {
                    segment.classList.remove('is-active');
                    segment.style.transform = 'scaleY(0)';
                    segment.style.opacity = '0';
                    segment.style.transition = 'none';
                }
            });

            scrollbar.style.display = 'block';
        }

        if (hasScrollSteps) {
            setActiveSlide(0);

            const scrollObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!isScrollMode()) {
                        return;
                    }
                    if (!entry.isIntersecting) {
                        return;
                    }

                    const idx = slides.indexOf(entry.target);
                    if (idx === -1 || idx === currentIndex) {
                        return;
                    }

                    setActiveSlide(idx);
                    triggerLottie();
                    if (scrollbar && scrollbarBulletsContainer) {
                        updateScrollbar();
                    }
                });
            }, { rootMargin: '-30% 0px -30% 0px', threshold: 0.1 });

            slides.forEach((slide) => {
                scrollObserver.observe(slide);
            });
        }

        updateVisualMode();

        if (videoElement) {
            videoElement.addEventListener('loadeddata', () => {
                videoElement.play().catch(() => {});
            });
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                const scrollModeActive = isScrollMode();
                if (entry.isIntersecting) {
                    hasIntersected = true;
                    if (scrollModeActive) {
                        if (lottieInstance && lottieReady) {
                            triggerLottie();
                        }
                        if (scrollbar && scrollbarBulletsContainer) {
                            updateScrollbar();
                        }
                    } else if (hasSlider && mediaQueryDesktop.matches) {
                        startAutoplay();
                    } else if (hasSlider) {
                        startMobileLottie();
                    }
                } else {
                    if (scrollModeActive) {
                        if (lottieInstance && lottieReady) {
                            lottieInstance.pause();
                        }
                        const sectionRect = section.getBoundingClientRect();
                        if (sectionRect.bottom < 0 && scrollbar) {
                            scrollbar.style.display = 'none';
                        }
                    } else if (hasSlider && mediaQueryDesktop.matches) {
                        stopAutoplay();
                    } else if (hasSlider) {
                        stopMobileLottie();
                    }
                }
            });
        }, { threshold: hasScrollSteps ? 0.15 : 0.35 });

        observer.observe(section);

        if (isScrollVariant && scrollbar && scrollbarBulletsContainer) {
            if (isScrollMode()) {
                initScrollbarBullets();
            }

            let scrollTimeout = null;
            const handleScroll = () => {
                if (!isScrollMode()) {
                    if (scrollbar) {
                        scrollbar.style.display = 'none';
                    }
                    return;
                }
                if (scrollTimeout) {
                    cancelAnimationFrame(scrollTimeout);
                }
                scrollTimeout = requestAnimationFrame(updateScrollbar);
            };

            window.addEventListener('scroll', handleScroll, { passive: true });
            window.addEventListener('resize', () => {
                if (isScrollMode()) {
                    if (slides.length > 0) {
                        const vh90 = window.innerHeight * 0.9;
                        const baseHeight = Math.min(Math.max(window.innerHeight * 0.6, vh90), 1100);
                        slides.forEach((slide) => {
                            slide.style.height = `${baseHeight}px`;
                            slide.style.minHeight = `${baseHeight}px`;
                        });
                    }
                    initScrollbarBullets();
                }
                handleScroll();
            }, { passive: true });

            if (isScrollMode()) {
                updateScrollbar();
            }
        }

        const handleDesktopChange = (event) => {
            updateVisualMode();
            if (!hasIntersected || !hasSlider || isScrollVariant) {
                return;
            }

            if (event.matches) {
                stopAutoplay();
                stopMobileLottie();
                if (hasSlider) {
                    setActiveSlide(currentIndex);
                }
                startAutoplay();
            } else {
                stopAutoplay();
                startMobileLottie();
            }
        };

        const handleTabletChange = (event) => {
            updateVisualMode();
            if (!hasSlider) {
                return;
            }
            if (event.matches) {
                slider.removeAttribute('data-auto-play-disabled');
                stopAutoplay();
                stopMobileLottie();
                initTouchControls();
            } else {
                removeTouchControls();
                startAutoplay();
            }
        };

        const handleDesktopInit = () => {
            if (mediaQueryDesktop.matches) {
                if (!isScrollVariant) {
                    startAutoplay();
                }
                removeTouchControls();
            } else if (mediaQueryTablet.matches) {
                initTouchControls();
            }
        };

        const handleScrollVariantChange = () => {
            if (!isScrollVariant) {
                return;
            }
            setActiveSlide(currentIndex);
            if (altSlidesWrapper) {
                if (isScrollMode()) {
                    altSlidesWrapper.style.height = '';
                } else {
                    updateAltSliderHeight(slides[currentIndex]);
                }
            }
            if (scrollbar && scrollbarBulletsContainer) {
                if (isScrollMode()) {
                    initScrollbarBullets();
                }
                updateScrollbar();
            }
        };

        if (hasSlider) {
            if (typeof mediaQueryDesktop.addEventListener === 'function') {
                mediaQueryDesktop.addEventListener('change', handleDesktopChange);
            } else if (typeof mediaQueryDesktop.addListener === 'function') {
                mediaQueryDesktop.addListener(handleDesktopChange);
            }

            if (typeof mediaQueryTablet.addEventListener === 'function') {
                mediaQueryTablet.addEventListener('change', handleTabletChange);
            } else if (typeof mediaQueryTablet.addListener === 'function') {
                mediaQueryTablet.addListener(handleTabletChange);
            }

            if (isScrollVariant) {
                if (typeof mediaQueryDesktop.addEventListener === 'function') {
                    mediaQueryDesktop.addEventListener('change', handleScrollVariantChange);
                } else if (typeof mediaQueryDesktop.addListener === 'function') {
                    mediaQueryDesktop.addListener(handleScrollVariantChange);
                }
            }

            handleDesktopInit();
        }


        if (isScrollVariant && altSlidesWrapper) {
            updateAltSliderHeight(slides[currentIndex]);
            window.addEventListener('resize', () => {
                updateAltSliderHeight(slides[currentIndex]);
            });
        }

        let touchStartX = 0;
        let touchEndX = 0;

        function onTouchStart(event) {
            touchStartX = event.changedTouches[0].screenX;
        }

        function onTouchEnd(event) {
            touchEndX = event.changedTouches[0].screenX;
            handleGesture();
        }

        function handleGesture() {
            const threshold = 50;

            if (touchStartX - touchEndX > threshold) {
                goToNextSlide();
            }

            if (touchEndX - touchStartX > threshold) {
                const prevIndex = (currentIndex - 1 + slides.length) % slides.length;
                setActiveSlide(prevIndex);
                triggerLottie();
            }
        }

        function initTouchControls() {
            if (!slider || slider.dataset.touchEnabled === 'true') {
                return;
            }
            slider.dataset.touchEnabled = 'true';
            slider.addEventListener('touchstart', onTouchStart, { passive: true });
            slider.addEventListener('touchend', onTouchEnd, { passive: true });
        }

        function removeTouchControls() {
            if (!slider || slider.dataset.touchEnabled !== 'true') {
                return;
            }
            slider.dataset.touchEnabled = 'false';
            slider.removeEventListener('touchstart', onTouchStart);
            slider.removeEventListener('touchend', onTouchEnd);
        }
    });
}

function initSidebarNav() {
    const sidebarNav = document.querySelector('[data-sidebar-nav]');
    
    if (!sidebarNav) return;
    
    const navItems = sidebarNav.querySelectorAll('[data-sidebar-nav-item]');
    const contentElement = document.querySelector('[data-post-content]');
    
    if (!navItems.length || !contentElement) return;
    
    const headingIds = Array.from(navItems).map(item => {
        const href = item.getAttribute('href');
        return href.startsWith('#') ? href.substring(1) : href;
    });
    
    const headings = Array.from(contentElement.querySelectorAll('h1, h2, h3, h4, h5, h6')).filter(heading => {
        const id = heading.getAttribute('id');
        return id && headingIds.includes(id);
    });
    
    if (!headings.length) return;
    
    function updateActiveNavItem() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const offset = 112;
        
        let activeHeading = null;
        
        for (let i = headings.length - 1; i >= 0; i--) {
            const heading = headings[i];
            const rect = heading.getBoundingClientRect();
            
            // Check if heading is in the viewport with offset consideration
            if (rect.top <= offset) {
                activeHeading = heading;
                break;
            }
        }
        
        navItems.forEach(item => {
            item.classList.remove('-active');
        });
        
        if (activeHeading) {
            const activeId = activeHeading.getAttribute('id');
            const activeNavItem = Array.from(navItems).find(item => {
                const href = item.getAttribute('href');
                return href === `#${activeId}` || href === activeId;
            });
            
            if (activeNavItem) {
                activeNavItem.classList.add('-active');
            }
        }
    }
    
    window.addEventListener('scroll', updateActiveNavItem);
    
    updateActiveNavItem();
    
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            const href = this.getAttribute('href');
            const targetId = href.startsWith('#') ? href.substring(1) : href;
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const offset = 112;
                const targetPosition = targetElement.offsetTop - offset;
                
                const newUrl = window.location.pathname + '#' + targetId;
                window.history.pushState({}, '', newUrl);
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

document.addEventListener("DOMContentLoaded", () => {
	animateCircle();
	initAnimateCount();
    initBenefitsSections();
    initSidebarNav();
});