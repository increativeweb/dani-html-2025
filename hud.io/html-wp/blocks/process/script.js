jQuery(function ($) {
    let activeID = null; // track currently active video
    function activateMediaOnScroll() {
        if ($(window).width() < 992) return;
        const triggerPoint = window.innerHeight * 0.80;
        $(".scroll-content").each(function () {
            const sectionTop = $(this).offset().top - $(window).scrollTop();
            if (sectionTop < triggerPoint && sectionTop > -($(this).height() / 2)) {
                const id = $(this).attr("id");
                if (activeID === id) return;
                activeID = id;

                // Pause ALL videos first
                $(".content-media video").each(function () {
                    this.pause();
                });

                // Activate the correct media box
                $(".content-media").removeClass("active");
                $(".scroll-content").removeClass("active");
                const activeMedia = $('.content-media[data-id="' + id + '"]').addClass("active");
                $('.scroll-content[id="' + id + '"]').addClass("active");

                // Play the matched video
                const video = activeMedia.find("video").get(0);
                if (video) {
                    video.currentTime = 0;
                    // Safe play with async handling
                    video.play().catch(err => {
                        console.warn("Play interrupted", err);
                    });
                    // console.log(id);
                }
            }
        });
    }
    // Debounce for smoother behavior
    let scrollTimeout;
    $(window).on("scroll", function () {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(activateMediaOnScroll, 50);
    });
    activateMediaOnScroll();
});