/*-----------------------------------------------------------------------------------*/
/* MAIN
/*-----------------------------------------------------------------------------------*/
var $ = jQuery.noConflict();

jQuery(document).ready(function ($) {
    if ($('.main-header').length) {
        $('.navbar-toggler').on('click', function (e) {
            e.preventDefault();
            $(".main-sidebar").toggleClass('is-visible');
            $('body').toggleClass('overflow-hidden');
            $(this).toggleClass('is-visible');
            $('.sidebar-overlay').toggleClass('is-visible');

            $('.main-sidebar .sidebar-menu-block').removeClass('is-close');
            $('.main-sidebar').find('.main-menu').removeClass('is-open');
        });
        if($('.menu-item-has-children').length) {
            $('.menu-item-has-children').on('click', function (e) {
                e.stopPropagation(); 

                $(this).find('.sub-menu').toggleClass('is-open');
            });
            $('.sub-menu').on('click', function (e) {
                e.stopPropagation();
            });
            $(document).on('click', function () {
                $('.sub-menu').removeClass('is-open');
            });
        }
    }

    if ($('.main-sidebar').length) {
        $(document).on('click', '.menu-list-collapsed .collapse-title', function (e) {
            e.preventDefault();

            var $this = $(this).closest('.menu-list-collapsed');
            var $menu = $this.find('.collapse-menu-block');

            $this.toggleClass('active');
            $menu.stop(true, true).slideToggle(300);
        });

        $(document).on('click', '.sidebar-overlay', () => {
            $('.navbar-toggler').click();
        });
        $(document).on('click', '.back-menu', function (e) {
            e.preventDefault();

            $(this).parent('.sidebar-menu-block').addClass('is-close');
            $(this).parents('.main-sidebar').find('.main-menu').addClass('is-open');
        });
    }
    if($('.table-of-contents-block').length) {
        $(document).on('click', '.table-of-contents-block .collapse-title', function (e) {
            e.preventDefault();

            var $this = $(this).closest('.table-of-contents');
            var $toc_list = $this.find('.table-of-content-list');

            $this.toggleClass('active');
            $toc_list.stop(true, true).slideToggle(300);
        });
    }
});

const $logoBlock = $('.site-logo-block');
if ($logoBlock.length) {
    $(window).on('scroll', function() {
        const logoBlockTop = $logoBlock.offset().top;
        const windowBottom = $(window).scrollTop() + $(window).height();

        // Toggle class based on footer visibility
        $logoBlock.toggleClass('is-animate', windowBottom >= logoBlockTop);
    });
}

document.addEventListener('DOMContentLoaded', () => {

    const content = document.querySelector('.content-block');
    if (!content) return;

    const tocLists = document.querySelectorAll('.table-of-content-list');
    const headings = content.querySelectorAll('h2, h3');

    // 👉 Build TOC HTML once
    const tocFragment = document.createDocumentFragment();

    headings.forEach(heading => {

        // Generate ID
        if (!heading.id) {
            heading.id = heading.textContent
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
        }

        // Add anchor link
        if (!heading.querySelector('.anchor-link')) {
            const anchor = document.createElement('a');
            anchor.href = `#${heading.id}`;
            anchor.textContent = '#';
            anchor.className = 'anchor-link';
            heading.appendChild(anchor);
        }

        // Create TOC item
        const li = document.createElement('li');
        const a = document.createElement('a');

        a.href = `#${heading.id}`;
        a.textContent = heading.childNodes[0].textContent.trim();

        if (heading.tagName === 'H3') {
            li.classList.add('sub-heading');
        }

        li.appendChild(a);
        tocFragment.appendChild(li);
    });

    // 👉 Clone TOC into all containers
    tocLists.forEach(list => {
        list.innerHTML = '';
        list.appendChild(tocFragment.cloneNode(true));
    });

    // ScrollSpy
    window.addEventListener('scroll', () => {

        let current = '';

        headings.forEach(section => {
            const sectionTop = section.offsetTop - 120;
            if (scrollY >= sectionTop) {
                current = section.id;
            }
        });

        tocLists.forEach(list => {
            list.querySelectorAll('a').forEach(link => {
                link.classList.toggle(
                    'active',
                    link.getAttribute('href') === `#${current}`
                );
            });
        });

    });

});



