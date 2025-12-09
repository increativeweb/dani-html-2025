/*-----------------------------------------------------------------------------------*/
/* MAIN
/*-----------------------------------------------------------------------------------*/
var $ = jQuery.noConflict();

jQuery(document).ready(function ($) {
    $('[data-bs-toggle="tooltip"]').tooltip(); 
    if ($('.main-header').length) {
        // if (jQuery(this).scrollTop() > 50) {
        //     $(".main-header").addClass("fixed-header");
        // } else {
        //     $(".main-header").removeClass("fixed-header");
        // }

        // $(window).scroll(function () {
        //     if (jQuery(this).scrollTop() > 50) {
        //         $(".main-header").addClass("fixed-header");
        //     } else {
        //         $(".main-header").removeClass("fixed-header");
        //     }
        // });
        $('.navbar-toggler').on('click',function(){
            $(".main-header").toggleClass('is-visible');
            $(".bg-overlay").toggleClass('is-visible');
            $(this).toggleClass('is-visible');
        });
    }
    if ($('li.menu-item-has-children').length) {
        $("li.menu-item-has-children > a, li.menu-item-has-children > span").after('<i class="arrow"></i>');
    }
    $('li.menu-item-has-children .arrow').on('click', function (event) {
        event.preventDefault();
        $(this).toggleClass('is-active');
        $(this).parent().find('.sub-menu').first().slideToggle(300);

    });


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
if ($('.splide:not(.splide-js)').length) {
    $('.splide:not(.splide-js)').each(function() {
        new Splide(this).mount();
        $(this).addClass('icw_splide-with-data'); // Mark as initialized
    });
}

// Video Player
if ($('.play-iframe').length){
    $('.play-iframe').click(function(ev){	
        videourl = $(this).data('videosrc')+"?api=1&autoplay=1&muted=1&rel=0&enablejsapi=1";
        if($(this).data('ext') == 'mp4'){
            video = '<div class="video-wrap"><video class="embed-responsive-item w-100" controls autoplay playsinline controlsList="nodownload" oncontextmenu="return false;"><source src="'+videourl+'" type="video/mp4"></video></div>';
        } else {
            video = '<div class="video-wrap"><iframe class="embed-responsive-item play-in_iframe" allow="autoplay" src="'+videourl+'" controls="0" scrolling="no" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>';
        }  
        
        $(this).parents('.media-block').html(video);
        ev.preventDefault();
    });
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