/*jslint browser: true*/
/*global $, jQuery, alert, console, autosize*/

$(document).ready(function ($) {
	"use strict";

	$('.carousel').slick({
		autoplay: true,
		autoplaySpeed: 2000,
		arrows: true,
		infinite: true,
		fade: true,
		adaptiveHeight: false
	});
	
	$('#createNew').on('click', function () {
		$('.global__create').toggleClass('active');
		if ($('.global__create').hasClass('active')) {
			$(this).html('Save Changes');
		} else {
			$(this).html('Create New');
		}
	});
});