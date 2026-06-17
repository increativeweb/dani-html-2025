if (jQuery('.security-card').length) {
    $(document).on('click', '.security-card .card-title', function (e) {
        if ($(window).width() >= 767) return;
        e.preventDefault();
        var $this = jQuery(this).closest(".security-card");
        
        if ($this.hasClass("is-open")) {
            $this.removeClass("is-open");
            $this.find(".card-body").stop(true, true).slideUp(300);
        } else {
            jQuery(".security-card").removeClass("is-open");
            jQuery(".security-card").find(".card-body").stop(true, true).slideUp(300); 
            $this.addClass("is-open");
            $this.find(".card-body").stop(true, true).slideDown(300);
        }
        return false;
    });
}
function securityCardCollapse() {
    if ($(window).width() < 767) {
        $('.security-card').removeClass('is-open');
        $('.security-card .card-body').hide();
        $('.security-card').first().addClass('is-open');
        $('.security-card').first().find('.card-body').show();

    } else {
        $('.security-card').removeClass('is-open');
        $('.security-card .card-body').removeAttr('style');
    }
}
// Initial load
securityCardCollapse();

// Update on resize
$(window).on('resize', function () {
    securityCardCollapse();
});