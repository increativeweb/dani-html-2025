jQuery(function ($) {

    $(document).on('click', '#loadMoreAuthorPosts', function () {
        let btn = $(this);
        let page = parseInt(btn.data('page')) + 1;
        let max = parseInt(btn.data('max'));

        $.ajax({
            url: icw_ajax.ajax_url,
            type: "POST",
            data: {
                action: "icw_load_more_author_posts",
                nonce: icw_ajax.nonce,
                page: page,
                author_id: btn.data('author_id')
            },
            beforeSend: function () {
                // btn.text("Loading...");
                btn.html('<span class="arrow-icon icw-ajax-loading"></span> Load articles');
            },
            success: function (response) {
                $("#author-posts-wrapper").append(response);
                btn.data('page', page);
                btn.html('More articles');

                if (page >= max) //btn.hide();
                    btn.attr('disabled', 'disabled').text('You reached the end');
            }
        });
    });

});
