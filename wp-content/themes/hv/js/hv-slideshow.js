jQuery(document).ready(function($) {
	
	$('#hv-slideshow #slides').cycle({
		'slides': 'div.hvslide',
		'next': '#hv-slides-next',
		'prev': '#hv-slides-prev',
		'pager': '#pager',
		'swipe': true,
		'starting-slide': 0
	});
	
	var controls = $('#hv-slideshow #controls');
	
	$('#hv-slideshow').mouseenter(function() {
		$(controls).show();
	}).mouseleave(function() {
		$(controls).hide();
	});
	
});