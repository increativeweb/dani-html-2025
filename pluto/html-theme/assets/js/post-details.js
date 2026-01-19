jQuery(function ($) {

    const links = $('.nav-item .nav-link');
    const headings = $('.single-content h2, .single-content h3');

    if (!links.length || !headings.length) return;

    // --------------------
    // ACTIVE + SCROLL ON CLICK (NO HASH)
    // --------------------
    links.on('click', function (e) {
        e.preventDefault(); // ðŸ”¥ stop URL hash

        const targetID = $(this).attr('href').replace('#', '');
        const $target = $('#' + targetID);

        if ($target.length) {
            let offset = 100; // base offset

            // âœ… If announcement/header notice exists, add extra offset
            if ($('body').hasClass('has-header-notice')) {
                offset += 40; // 100 + 40
            }

            $('html, body').animate(
                { scrollTop: $target.offset().top - offset }, // adjust offset if needed
                100
            );
        }

        // links.removeClass('active');
        // $(this).addClass('active');
    });

    // --------------------
    // SCROLL SPY
    // --------------------
    function activateOnScroll() {

        const scrollTop = $(window).scrollTop();
        const winH = $(window).height();
        const triggerLine = scrollTop + winH * 0.5;

        let currentID = null;

        headings.each(function () {
            if ($(this).offset().top <= triggerLine) {
                currentID = this.id;
            }
        });

        if (currentID) {
            links.removeClass('active');
            links.filter(`[href="#${currentID}"]`).addClass('active');
        }
    }

    $(window).on('scroll', activateOnScroll);
    activateOnScroll(); // initial state

});