
jQuery(document).ready(function(){	
"use strict";

    function syncAlphabetWithResults() {
        const availableLetters = [];

        // Collect letters from glossary results
        $('#glossary-results .glossary-col').each(function () {
            const letter = $(this).data('letter');
            if (letter) {
                availableLetters.push(letter.toLowerCase());
            }
        });

        // Reset all alphabet items
        $('#a-z li').removeClass('active');

        // Activate matching alphabet letters
        $('#a-z li').each(function () {
            const letter = $(this).data('letter');
            if (availableLetters.includes(letter)) {
                $(this).addClass('active');
            }
        });
    }

    // Run on page load
    syncAlphabetWithResults();
	
	let initial_first_letter = jQuery('#a-z li.active:eq(0)').data('letter');
	let click_first_char;
	let status_showing = jQuery('.result-status');
	let title_showing = jQuery('#showing');
	let az_li = jQuery('#a-z li');
	let title_show_all = jQuery('#show-all');
	let glossary_results_li = jQuery("#glossary-results .glossary-col");
	
	// Click A-Z menu item
	jQuery('#a-z li.active').click(function() {
		jQuery("#glossary-results .glossary-col").removeClass('show');
		click_first_char = jQuery(this).data('letter');
		jQuery('#a-z li.active').removeClass('current');
		title_showing.text(click_first_char);
		// title_show_all.show();
		status_showing.addClass('show');
		jQuery(this).addClass('current');
		jQuery("#glossary-results .glossary-col[data-letter="+click_first_char+"]").addClass('show');
	});
	
	// Show all posts
	title_show_all.click(function() {
		glossary_results_li.addClass('show');
		title_showing.text('All');
		az_li.removeClass('current');
		// jQuery(this).hide(); 
		status_showing.removeClass('show');
	}); 
}); 

// $( nowprocket
var elements = document.querySelectorAll("#glossary-results .glossary-col");
for (var i = 0; i < elements.length; i++) {
    elements[i].classList.add("show");
}