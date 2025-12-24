jQuery(function ($) {

    const links = $('.nav-item .nav-link');
    const headings = $('.single-content h2, .single-content h3');

    if (!links.length || !headings.length) return;

    // --------------------
    // ACTIVE ON CLICK
    // --------------------
    links.on('click', function () {
        links.removeClass('active');
        $(this).addClass('active');
    });

    // --------------------
    // SCROLL SPY
    // --------------------
    function activateOnScroll() {

        const scrollTop = $(window).scrollTop();
        const winH = $(window).height();
        const triggerLine = scrollTop + winH * 0.25;

        let currentID = null;

        headings.each(function () {
            if ($(this).offset().top <= triggerLine) {
                currentID = this.id;
            }
        });

        if (currentID) {
            links.removeClass('active');
            $(`.nav-link[href="#${currentID}"]`).addClass('active');
        }
    }

    $(window).on('scroll', activateOnScroll);
    activateOnScroll(); // initial state

});