jQuery(function($) {
	$.datepicker.setDefaults( $.datepicker.regional[ 'sv' ] );
	
	var addresspicker = $('#venue').addresspicker({
		regionBias:	'sv',
		elements: {
			lat:		'#venue_lat',
			lng:		'#venue_long'
		}
	});
	
	$('#venue').keydown(function(e) {
		$('#venue_lat').val('');
		$('#venue_long').val('');
	});
});

jQuery(document).ready(function($) {
	$('#start_date').datetimepicker();
	$('#end_date').datetimepicker();
});