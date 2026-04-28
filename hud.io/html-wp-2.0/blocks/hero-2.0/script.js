document.addEventListener("DOMContentLoaded", function () {

    if (jQuery('.hero-thumb-slider-20-block').length) {

    var section = document.querySelector('.hero-thumb-slider-20-block');

    var main = new Splide("#hero-img-slider", {
        type: "loop",
        lazyLoad: "nearby",
        pagination: false,
        arrows: false,
        autoWidth: true,
        rewind: false,
        gap: "15px",
        video: {
            autoplay: false,
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

    main.sync(thumbnails);

    main.mount();
    thumbnails.mount();

    /* =====================================
       CHECK SECTION IN VIEWPORT TOP 100px
    ===================================== */
    function isHeroVisible() {
        const rect = section.getBoundingClientRect();
        const vh = window.innerHeight;

        return rect.top <= 100 && rect.bottom > 150;
    }

    /* =====================================
       STOP ALL VIDEOS
    ===================================== */
    function stopAllVideos() {
        document.querySelectorAll('#hero-img-slider video').forEach(video => {
            video.pause();
            video.currentTime = 0;
            video.onended = null;
        });
    }

    /* =====================================
       PLAY ACTIVE VIDEO ONLY IF VISIBLE
    ===================================== */
    function handleVideoPlayback() {

        stopAllVideos();

        if (!isHeroVisible()) return;

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

    /* =====================================
       EVENTS
    ===================================== */
    main.on('mounted move', function () {
        setTimeout(handleVideoPlayback, 200);
    });

    window.addEventListener('scroll', function () {
        requestAnimationFrame(handleVideoPlayback);
    });

    window.addEventListener('resize', function () {
        requestAnimationFrame(handleVideoPlayback);
    });

    /* =====================================
       THUMB WIDTH
    ===================================== */
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

    thumbnails.on("mounted move active updated", function () {
        requestAnimationFrame(updateThumbWidths);
    });

    window.addEventListener("resize", function () {
        requestAnimationFrame(updateThumbWidths);
    });

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

  if (!section || !heroBlock || !bgWrap) return;

  function animateHero() {

    const rect = heroBlock.getBoundingClientRect();
    const vh   = window.innerHeight;
    const vw   = window.innerWidth;

    const triggerPoint = vh - 100;

    let progress = (triggerPoint - rect.top) / (vh * 0.7);
    progress = Math.max(0, Math.min(progress, 1));

    const heroWidth = heroBlock.offsetWidth;
    const fullWidth = vw;

    const width = heroWidth + ((fullWidth - heroWidth) * progress);

    bgWrap.style.width = width + "px";

    const defaultPadding = window.innerWidth < 992 ? 10 : 30;
    const animPadding = window.innerWidth < 992 ? 50 : 120;
    const padding = defaultPadding + ((animPadding - defaultPadding) * progress);

    heroBlock.style.paddingTop = padding + "px";
    // heroBlock.style.paddingBottom = padding + "px";

    requestAnimationFrame(animateHero);
  }

  animateHero();

});