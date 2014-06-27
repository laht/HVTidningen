jQuery(function($) {
	
	$.getJSON('wp-content/plugins/hv-rss/getRSSFeed.php', function(data) {
		//Stop the loader.
		$('.widget-loader', $('#hv-rss')).hide();
		
		//console.log(data);
		
		$.each(data.entries, function(index, item) {
			render(item);
		});
		
		$('#hv-rss div.items-cont').niceScroll({cursoropacitymin:1});
	});
	
	function render(entry) {
	//	console.log(item);
		var entry_div = $('<article class="item">');
		var entry_title = $('<div class="title">');
		var entry_time = $('<div class="time">');
		var entry_body = $('<div class="body">');
		
		$(entry_title).html('<a href="'+entry.guid+'" target="_blank">'+entry.title+'</a>')
		$(entry_body).html(entry.description);
		$(entry_time).html(moment(Date.parse(entry.pubdate).toString('u'), 'YYYY-MM-DD HH:mm:ssZ').subtract('hours', 2).fromNow());
		
		$(entry_div)
			.append(entry_title)
			.append(entry_time)
			.append('<div class="clear">')
			.append(entry_body);

		$('#hv-rss div.items').append(entry_div);
	}
	
});