function init() {
	jQuery.ajax({
		url: 'wp-admin/admin-ajax.php',
		type: 'POST',
		data: {
			action: 'get_hv_map_latlng',
			post_id: hv_events_map.postID
		},
		dataType: 'json',
		success: function(response) {
			var lat = response.lat;
			var lng = response.lng;
			var myLatLng = new google.maps.LatLng(lat, lng);
					
			var mapOptions = {
				center: myLatLng,
				zoom: 12,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			
			var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			
			var marker = new google.maps.Marker({
				position: myLatLng,
				map: map
			});
		}
	});
}

google.maps.event.addDomListener(window, 'load', init);