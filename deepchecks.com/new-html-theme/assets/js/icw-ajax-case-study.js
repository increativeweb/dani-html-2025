jQuery(document).ready(function ($) {
  $(document).on('click', '#load-more-case-study', function (e) {
    e.preventDefault();

    const $btn = $(this);
    const page = parseInt($btn.data('page')) + 1;
    const maxPage = parseInt($btn.data('max'));
    const perPage = parseInt($btn.data('per_page'));

    if ($btn.hasClass('is-loading') || page > maxPage) return;

    $btn.addClass('is-loading');

    $.ajax({
      url: icwCaseStudyAjax.ajax_url,
      type: 'POST',
      data: {
        action: 'load_more_case_studies',
        paged: page,
        per_page: perPage,
        nonce: icwCaseStudyAjax.nonce,
      },
      success: function (response) {
        if (response.success && response.data.html) {
          $('#ajax-case-study-posts').append(response.data.html);
          $btn.data('page', page);

            if (page >= maxPage) {
                const $message = $('<p class="no-more-msg">No older case study found</p>');
                $btn.parent().html($message);

                setTimeout(function () {
                $message.fadeOut(300, function () {
                    $(this).remove();
                });
                }, 3000); // 3000 ms = 3 seconds
            }

            // if (page >= maxPage) $btn.parent().html('<p>No older videos found</p>');
            // $btn.remove();
        } else {
          $btn.remove();
        }

        $btn.removeClass('is-loading');
      }
    });
  });
});