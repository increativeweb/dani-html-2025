document.addEventListener("DOMContentLoaded", function () {

    if (jQuery('.hero-thumb-slider-20-block').length) {
        var main = new Splide("#hero-img-slider", {
            type: "loop",
            lazyLoad: "nearby",
            pagination: false,
            arrows: false,
            autoWidth: true,
            rewind: false,
            gap: "15px",
            video: {
                autoplay: true,
                mute: true,
                playsinline: true,
            },
        });

        var thumbnails = new Splide("#thumb-info-slider", {
            direction: "ttb",
            height: "100%",
            perPage: 4,
            arrows: false,
            pagination: false,
            isNavigation: true,
            drag: false,

            breakpoints: {
                1200: {
                    direction: "ltr",
                    autoWidth: true,
                    height: "auto",
                },
            },
        });

        // SYNC
        main.sync(thumbnails);

        main.mount();
        thumbnails.mount();

        // ✅ VIDEO CONTROL (MAIN FIX)
        function handleVideoPlayback() {

            // Pause & reset all videos
            document.querySelectorAll('#hero-img-slider video').forEach(video => {
                video.pause();
                video.currentTime = 0;
                video.onended = null;
            });

            // Get active slide
            var activeSlide = main.Components.Slides.getAt(main.index);
            if (!activeSlide) return;

            var activeVideo = activeSlide.slide.querySelector('video');

            if (activeVideo) {
                activeVideo.muted = true;
                activeVideo.play().catch(() => {});

                
                activeVideo.onended = function () {
                main.go('>');
                };
            }
        }

        // Run on mount + slide change
        main.on('mounted move', function () {
            setTimeout(handleVideoPlayback, 200);
        });

        // ✅ Dynamic Width Function
        function updateThumbWidths() {

            if (window.innerWidth > 1200) return;

            const slides = thumbnails.Components.Elements.slides;
            const totalSlides = slides.length;

            const smallWidth = window.innerWidth < 767 ? 40 : 70;
            const container = document.querySelector("#thumb-info-slider");
            const containerWidth = container.offsetWidth;

            const totalSmallWidth = (totalSlides - 1) * smallWidth;
            const activeWidth = containerWidth - totalSmallWidth;

            slides.forEach((slide) => {
                const title = slide.querySelector('.title');
                const info = slide.querySelector('.sort-info');

                if (slide.classList.contains("is-active")) {
                slide.style.flexBasis = activeWidth + "px";
                setTimeout(() => {
                    if (title) title.style.display = "block";
                    if (info) info.style.display = "block";
                }, 300);
                } else {
                slide.style.flexBasis = smallWidth + "px";
                setTimeout(() => {
                    if (title) title.style.display = "none";
                    if (info) info.style.display = "none";
                }, 10);
                }
            });
        }

        // Trigger width update
        thumbnails.on("mounted move active updated", function () {
            requestAnimationFrame(updateThumbWidths);
        });

        // Resize
        window.addEventListener("resize", function () {
            requestAnimationFrame(updateThumbWidths);
        });

        // Initial run
        if (window.innerWidth < 992) {
            setTimeout(updateThumbWidths, 100);
        }

        handleVideoPlayback();

    }

});
window.addEventListener("scroll", function () {
    const triggerSection = document.querySelector(".hero-thumb-slider-20-block");
    const targetSection = document.querySelector(".icw-hero-sticky-section");

    if (!triggerSection || !targetSection) return;

    const rect = triggerSection.getBoundingClientRect();

    if (rect.top <= 0) {
        targetSection.classList.add("position-relative");
    } else {
        targetSection.classList.remove("position-relative");
    }
});



document.addEventListener("DOMContentLoaded", function () {

    const section   = document.querySelector(".hero-thumb-slider-20-block");
    const heroBlock = document.querySelector(".hero-slider-block");
    const bgWrap    = document.querySelector(".bg-animate-img");
    const bgInner   = document.querySelector(".bg-animate-inner");

    if (!section || !heroBlock || !bgWrap || !bgInner) return;

    let currentY = 0;

    // ✅ Initial width same as hero-slider-block
    function setInitialSize() {
        bgWrap.style.width = heroBlock.offsetWidth + "px";
        bgWrap.style.height = "100vh";
        
    }

    function animateScene() {

        const rect = section.getBoundingClientRect();
        const vh   = window.innerHeight;

        /* Progress */
        let progress = (vh - rect.top) / (vh - vh * 0.30);
        progress = Math.max(0, Math.min(progress, 1));

        /* Parallax */
        const center = vh / 2;
        const offset = rect.top + rect.height / 2 - center;

        const targetY = offset * 0.20;
        currentY += (targetY - currentY) * 0.08;

        bgInner.style.transform = `translateY(${currentY}px)`;

        /* Width Animation */
        const heroWidth   = heroBlock.offsetWidth - 150;
        console.log(heroWidth);
        
        const screenWidth = window.innerWidth;

        const width  = heroWidth + ((screenWidth - heroWidth) * progress);
        const height = 100 + (20 * progress);

        bgWrap.style.width  = width + "px";
        bgWrap.style.height = height + "vh";

        /* Padding */
        const paddingY = 120 * progress;

        heroBlock.style.paddingTop    = paddingY + "px";
        // heroBlock.style.paddingBottom = paddingY + "px";

        requestAnimationFrame(animateScene);
    }

    // ✅ Set default first
    setInitialSize();

    // ✅ Resize update
    window.addEventListener("resize", setInitialSize);

    animateScene();

});