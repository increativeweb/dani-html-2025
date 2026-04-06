jQuery(function ($) {

    let activeID = null;
    let activeVideo = null;

    function activateMediaOnScroll() {
        if ($(window).width() < 992) return;

        const triggerPoint = window.innerHeight * 0.8;

        $(".scroll-content").each(function () {
            const $section = $(this);
            const sectionTop = $section.offset().top - $(window).scrollTop();
            const sectionHeight = $section.outerHeight();
            const id = $section.attr("id");

            if (
                sectionTop < triggerPoint &&
                sectionTop > -(sectionHeight / 2)
            ) {
                if (activeID === id) return;

                activeID = id;

                // ✅ Pause ONLY the previously active video
                if (activeVideo && !activeVideo.paused) {
                    activeVideo.pause();
                }

                // Toggle active classes
                $(".content-media, .scroll-content").removeClass("active");
                const $activeMedia = $('.content-media[data-id="' + id + '"]').addClass("active");
                $section.addClass("active");

                const video = $activeMedia.find("video").get(0);
                if (!video) return;

                activeVideo = video;
                video.currentTime = 0;

                // ✅ Safe async play
                const playPromise = video.play();
                if (playPromise !== undefined) {
                    playPromise.catch(() => {
                        // AbortError is expected during fast scroll
                    });
                }
            }
        });
    }

    // ✅ Debounced scroll handler
    let scrollTimeout;
    $(window).on("scroll", function () {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(activateMediaOnScroll, 80);
    });

    activateMediaOnScroll();

});