jQuery(function ($) {
    $(document).on('click', '#loadMorePosts', function () {
        let btn = $(this);
        let page = parseInt(btn.data('page')) + 1;
        let max = parseInt(btn.data('max'));

        $.ajax({
            url: icw_ajax.ajax_url,
            type: "POST",
            data: {
                action: "icw_load_more_blog",
                nonce: icw_ajax.nonce,
                page: page
            },
            beforeSend: function () {
                btn.html('<span class="arrow-icon icw-ajax-loading"></span> Load articles');
            },
            success: function (response) {
                $("#blog-posts-wrapper").append(response);
                btn.data('page', page);
                btn.html('More articles');

                if (page >= max) //btn.hide();
                    btn.attr('disabled', 'disabled').text('You reached the end');
            }
        });
    });
});

// Post Slider
if (jQuery('.post-splide').length) {
    const slider = new Splide('.post-splide', {
        type: 'slide',
        perPage: 3,
        perMove: 1,
        pagination: true,
        arrows: false,
        gap: '56px',
        classes: {
            pagination: 'splide__pagination is-dark'
        },
        breakpoints: {
            1200: {
                perPage: 3,
            },
            992: {
                perPage: 2,
                padding: '1rem',
                gap: '1.5rem',
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