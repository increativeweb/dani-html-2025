(function ($) {
	$doc = $(document);
	jQuery(document).ready(function ($) {
		let isLoading = false;
		let isEnd = false;

		const $container = $('#container-async');
		const $content = $container.find('.content');
		const $status = $container.find('.status');
		const $pager = $container.find('.infscr-pager a');

		let activeTerms = '';
		let page = 1;
		/* ================================
		AJAX FETCH
		================================ */
		function get_faq_posts(params, append = false) {

			if (isLoading || isEnd) return;
			isLoading = true;
			// $status.text('Loading posts...');
			if ($pager.data('infscr') == 'load') {
			    $pager.removeClass('btn btn-white mx-auto').html(spinnerHtml());
            }
			$('.q-loader').addClass('show');
			$.ajax({
				url: icw.ajax_url,
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'do_filter_qa_posts',
					nonce: icw.nonce,
					params: params,
					pager: $pager.data('infscr') ? 'infscr' : 'pager'
				},
				success: function (res) {

					if (res.status !== 200 && res.status !== 201) {
						$status.text(res.message || 'Error loading posts');
						return;
					}

					if (!append || params.page === 1) {
						$content.html(res.content);
					} else {
						$content.append(res.content);
					}

					if (res.next && res.next > 0) {
						page = res.next;
						if ($pager.data('infscr') == 'scroll') {
							$pager.show().removeClass('btn btn-white mx-auto d-none').html(spinnerHtml());
						} else if ($pager.data('infscr') == 'load') {
							$pager.show().removeAttr('disabled').addClass('btn btn-white mx-auto').text('Load questions');
						}
					}
					else if (res.next == 0) {
						isEnd = true;
						$pager.show().attr('disabled', true).text('You reached the end');
					}

					if (res.message) {
						$content.html('<div class="text-center w-100"><div class="alert alert-danger">' + res.message + '</div></div>');
					}
				},
				error: function () {
					$content.html('<div class="text-center w-100"><div class="alert alert-danger">Something went wrong</div></div>');
				},
				complete: function (res) {
					$('.q-loader').removeClass('show');
					var res = res.responseJSON;
					isLoading = false;
					if (res.next == 0 && isEnd && $('#q').val().length < 1) {
						$pager.show().removeClass('btn btn-white mx-auto').html(spinnerHtml()).text('You reached the end');
						setTimeout(function () {
							$pager.hide();
						}, 5000);
					} else if ($pager.data('infscr') !== 'scroll') {
						$pager.show().addClass('btn btn-white mx-auto').text('Load articles');
					}
				}
			});
		}

		/* ================================
		FILTER CLICK
		================================ */
		$(document).on('click', '#container-async a[data-filter]', function (e) {
			e.preventDefault();

			const $this = $(this);

			page = 1;
			isEnd = false;

			$this.closest('ul').find('.active').removeClass('active');
			$this.parent().addClass('active');

			activeTerms = $this.data('term') === 'all-terms' ? 'all-terms' : $this.data('term');
			$('#q').val('');
			get_faq_posts(buildParams(), false);
		});

		/* ================================
		LOAD MORE CLICK
		================================ */
		$(document).on('click', '.infscr-pager a[data-infscr="load"]', function (e) {
			e.preventDefault();
			get_faq_posts(buildParams(), true);
		});

		/* ================================
		INFINITE SCROLL
		================================ */
		if ($pager.data('infscr') === 'scroll') {
			$(window).on('scroll', function () {
				if (isLoading || isEnd) return;

				const triggerPoint =
					$(window).scrollTop() + $(window).height() >
					$container.offset().top + $container.outerHeight() - 200;

				if (triggerPoint) {
					get_faq_posts(buildParams(), true);
				}
			});
			// https://www.geeksforgeeks.org/javascript/infinite-scroll-using-javascript-intersection-observer-api/
			/*const io = new IntersectionObserver((entries) => {
				entries.forEach((entry) => {
					if (!entry.isIntersecting) {
						return;
					}
					get_faq_posts(buildParams(), true);
				});
			});
			io.observe(document.querySelector(".pagination.infscr-pager"));
			*/
		}

		/* ================================
		PARAM BUILDER
		================================ */
		function buildParams() {
			return {
				page: page,
				terms: activeTerms,
				qty: $container.data('paged'),
				postnotin: $container.data('post_not_in'),
				q: $('#q').val()
			};
		}

		/* ================================
		SPINNER
		================================ */
		function spinnerHtml() {
			return `
			<span class="icw-spinner">
				<svg width="48" height="48" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" aria-label="Loading" role="img"><defs><linearGradient id="spinnerGradient" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#7654FC" stop-opacity="1" /><stop offset="70%" stop-color="#AA80FD" stop-opacity="0.6" /><stop offset="100%" stop-color="#AA80FD" stop-opacity="0.15" /></linearGradient></defs><circle cx="25" cy="25" r="20" fill="none" stroke="url(#spinnerGradient)" stroke-width="6" stroke-linecap="round" stroke-dasharray="90 150"><animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite" /></circle></svg>
			</span>`;
		}


		/**
		 * Bind get_faq_posts to tag cloud and navigation
		 */
		let typingTimer;
		$("#q").on("keyup", function (event) {
			const $this = $(this);
			$('.q-loader').addClass('show');
			// console.log('q change');
			clearTimeout(typingTimer);
			typingTimer = setTimeout(function () {
				page = 1;
				isEnd = false;
				$active = {};
				$terms = $('ul.nav-filter').find('.active');

				if ($terms.length) {
					$.each($terms, function (index, term) {
						$a = $(term).find('a');
						$tax = $a.data('filter');
						$slug = $a.data('term');
						$active = $slug;
					});
				}

				$params = {
					'page': 1,
					'terms': $active,
					'qty': $this.closest('#container-async').data('paged'),
					'postnotin': $this.closest('#container-async').data('post_not_in'),
					'q': $('#q').val()
				};
				$('.q-loader').removeClass('show');
				// Run query
				get_faq_posts($params);
			}, 700);
		});


		$('.q-search').click(function (event) {
			// console.log("q-search event start");
			if (event.preventDefault) { event.preventDefault(); }
			$(this).closest('.post-search').toggleClass('active');
			page = 1;
			isEnd = false;
			if ($('.post-search').hasClass('active')) {
				$('.post-search').find('#q').removeAttr('tabindex');
				$('.post-search').find('#q').focus();
			} else {
				$('.post-search').find('#q').val('');
				$('.post-search').find('#q').attr('tabindex', '-1');
				$("#q").trigger('keyup');
			}
		});

		$('#q').on('keyup click', function () {
			const val = $(this).val().trim();
			if (val.length >= 2) {
				$(this).closest('.post-search').addClass('active');
			} else {
				$(this).closest('.post-search').removeClass('active');
			}
		});

		/**
		 * Show all posts on page load
		 */
		$('a[data-term="all-terms"]').trigger('click');
	});
})(jQuery);

