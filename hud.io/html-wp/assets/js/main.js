/*-----------------------------------------------------------------------------------*/
/* MAIN
/*-----------------------------------------------------------------------------------*/
var $ = jQuery.noConflict();

jQuery(document).ready(function ($) {
    $('[data-bs-toggle="tooltip"]').tooltip();
    if ($('.main-header').length) {
        $('.navbar-toggler').on('click', function () {
            $(".main-header").toggleClass('is-visible');
            $('body').toggleClass('overflow-hidden');
            $(this).toggleClass('is-visible');
        });
    }
    if ($('li.menu-item-has-children').length) {
        $("li.menu-item-has-children").each(function () {
            const link = $(this).find("> a"); // select direct <a>
            link.wrap("<span></span>");       // wrap it inside <span>
        });
        $("li.menu-item-has-children > span").append('<i class="arrow"></i>');
    }
    $('li.menu-item-has-children .arrow').on('click', function (event) {
        event.preventDefault();
        $(this).toggleClass('is-active');
        $(this).parents().find('.sub-menu').first().slideToggle(300);

    });
    if ($('body').find('.announcement-bar').length) {
        $('body').addClass('has-announcement-bar');
    }


    if ($(".icw-progress-goto").length > 0) {
        var progressPath = document.querySelector('.icw-progress-goto path');
        var pathLength = progressPath.getTotalLength();

        progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
        progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
        progressPath.style.strokeDashoffset = pathLength;
        progressPath.getBoundingClientRect();
        progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';

        var updateProgress = function () {
            var scroll = $(window).scrollTop();
            var height = $(document).height() - $(window).height();
            var progress = pathLength - (scroll * pathLength / height);
            progressPath.style.strokeDashoffset = progress;
        }

        updateProgress();
        $(window).scroll(updateProgress);

        var offset = 200;
        var duration = 550;

        jQuery(window).on('scroll', function () {
            if (jQuery(this).scrollTop() > offset) {
                jQuery('.icw-progress-goto').addClass('active-progress');
            } else {
                jQuery('.icw-progress-goto').removeClass('active-progress');
            }
        });

        jQuery('.icw-progress-goto').on('click', function (event) {
            event.preventDefault();
            jQuery('html, body').animate({ scrollTop: 0 }, duration);
            return false;
        });
    }

});

// Splide Slider
if (jQuery('.splide:not(.splide-js)').length) {
    jQuery('.splide:not(.splide-js)').each(function () {
        new Splide(this).mount();
        jQuery(this).addClass('icw_splide-with-data'); // Mark as initialized
    });
}

// Post Slider
if (jQuery('.post-splide').length) {
    const slider = new Splide('.post-splide', {
        type: 'slide',
        perPage: 3,
        perMove: 1,
        pagination: true,
        arrows: false,
        gap: '20px',
        classes: {
            pagination: 'splide__pagination is-dark'
        },
        breakpoints: {
            1200: {
                perPage: 3,
            },
            992: {
                perPage: 2,
                padding: '1.5rem',
                gap: '1rem',
                autoWidth: true,
            },
            767: {
                perPage: 1,
                autoWidth: true,
                drag: true,
            }
        }
    });

    slider.on('mounted', function () {
        const slideCount = slider.length; // total slides
        if (window.innerWidth > 1400) {
            if (slideCount <= 3) {
                // Disable all movement
                slider.options = {
                    arrows: false,
                    pagination: false,
                    drag: false,
                    keyboard: false,
                    flickPower: 0,
                };
            }
        }
    });

    slider.mount();
}


// Collapse
if (jQuery('.collapse-item').length) {
    jQuery(document).on("click", ".collapse-item .collapse-title", function () {
        var $this = jQuery(this).closest(".collapse-item");

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


// Video Player
if ($('.play-iframe').length) {
    $('.play-iframe').click(function (ev) {
        videourl = $(this).data('videosrc') + "?api=1&autoplay=1&muted=1&rel=0&enablejsapi=1";
        if ($(this).data('ext') == 'mp4') {
            video = '<div class="video-wrap"><video class="embed-responsive-item w-100" controls autoplay playsinline controlsList="nodownload" oncontextmenu="return false;"><source src="' + videourl + '" type="video/mp4"></video></div>';
        } else {
            video = '<div class="video-wrap"><iframe class="embed-responsive-item play-in_iframe" allow="autoplay" src="' + videourl + '" controls="0" scrolling="no" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>';
        }

        $(this).parents('.media-block').html(video);
        ev.preventDefault();
    });
}

// Play Video on Observer
if ($('.media-block video').length) {
    const videos = document.querySelectorAll(".media-block video");
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            const video = entry.target;

            if (entry.intersectionRatio >= 0.5) {
                video.play();
            } else {
                video.pause();
            }
        });
    }, { threshold: [0.5] });
    videos.forEach((video) => observer.observe(video));
}


(function () {
    const navbar = document.querySelector(".navbar");
    if (!navbar) return;

    const sections = Array.from(document.querySelectorAll("[data-theme]"));

    function applyTheme(theme) {
        navbar.classList.remove("navbar--dark", "navbar--light");
        if (theme === "dark") {
            navbar.classList.add("navbar--dark");
        } else {
            navbar.classList.add("navbar--light");
        }
    }

    function update() {
        // Transparent if at very top
        if (window.scrollY <= 1) {
            navbar.classList.remove("navbar--solid");
            applyTheme("dark"); // assume hero is dark unless first section is light
            return;
        }

        // Find the section under the navbar
        const navRect = navbar.getBoundingClientRect();
        const x = window.innerWidth / 2;
        const y = Math.min(navRect.bottom + 1, window.innerHeight - 1);
        let el = document.elementFromPoint(x, y);

        let theme = "dark"; // default
        while (el && el !== document.body) {
            if (el.dataset && el.dataset.theme) {
                theme = el.dataset.theme.toLowerCase();
                break;
            }
            el = el.parentElement;
        }

        applyTheme(theme);

        // Solid background only after scrolling 10vh
        if (window.scrollY > window.innerHeight * 0.1) {
            navbar.classList.add("navbar--solid");
        } else {
            navbar.classList.remove("navbar--solid");
        }
    }

    window.addEventListener("scroll", update, { passive: true });
    window.addEventListener("resize", update, { passive: true });
    document.addEventListener("DOMContentLoaded", update);
    window.addEventListener("load", update);
})();


document.addEventListener("DOMContentLoaded", function () {
    const items = document.querySelectorAll('.scroll-animate');
    // ✅ Condition: only run if elements exist
    if (!items.length) return;
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target); // animate once
            }
        });
    }, {
        threshold: 0.35
    });
    items.forEach(item => observer.observe(item));
});
