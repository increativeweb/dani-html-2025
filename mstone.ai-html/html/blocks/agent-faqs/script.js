if (jQuery('.faq-item').length) {
    jQuery(document).on("click", ".faq-item .faq-title", function () {
        var $this = jQuery(this).closest(".faq-item");

        if ($this.hasClass("is-open")) {
            $this.removeClass("is-open");
            $this.find(".faq-content").stop(true, true).slideUp(300);
        } else {
            $(".faq-item").removeClass("is-open");
            $(".faq-item").find(".faq-content").stop(true, true).slideUp(300); 
            $this.addClass("is-open");
            $this.find(".faq-content").stop(true, true).slideDown(300); 
        }        
        return false;
    });
}

jQuery(document).ready(function () {
    if (jQuery('.faq-item').length) {
        const $input = jQuery('.search-input-form input');
        const $faqItems = jQuery('.faq-item');
        function filterFaq() {
            const searchText = $input.val().toLowerCase().trim();
            // Reset when input is empty or less than 2 characters
            if (searchText.length < 2) {
                $faqItems.show();
                return;
            }
            $faqItems.each(function () {
                const title = jQuery(this).find('.faq-title').text().toLowerCase().replace('›', '').trim();
                if (title.includes(searchText)) {
                    jQuery(this).show();
                } else {
                    jQuery(this).hide();
                }
            });
        }
        $input.on('input', filterFaq);
        $input.on('keypress', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                filterFaq();
            }
        });
    }
});