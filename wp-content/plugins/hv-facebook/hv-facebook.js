jQuery(function($) {
	
	$.getJSON('wp-content/plugins/hv-facebook/getFacebookPosts.php', function(data) {
		//Stop the loader.
		$('.widget-loader', $('#hv-facebook')).hide();
		
		//console.log(data.data[0]);
		
		$.each(data.data, function(index, item) {
			render(item);
		});
		
		$('#hv-facebook div.items-cont').niceScroll({cursoropacitymin:1});
	});
	
	function render(item) {
	//	console.log(item);
		var post_div = $('<article class="item">');
		//var post_author = $('<div class="author">');
		var post_time = $('<div class="time">');
		var post_body = $('<div class="body">');
		
		//$(post_author).html('<a href="http://facebook.com/'+item.from.id+'" target="_blank">'+item.from.name+'</a>')
		$(post_body).html(item.message);
		$(post_time).html(moment(Date.parse(item.created_time).toString('u'), 'YYYY-MM-DD HH:mm:ssZ').fromNow());
		
		$(post_div)
			//.append(post_author)
			.append(post_time)
			.append('<div class="clear">')
			.append(post_body);
		
		if(item.hasOwnProperty('link')) {	
			var link_a = $('<a class="block-link">');
			var link_span = $('<span>');
			var link_img = $('<img class="link-img">');
			var link_header = $('<header>');
			
			$(link_a).attr('href', item.link);
			$(link_a).append(link_span);
			
			$(link_span)
				.append(link_img)
				.append(link_header);
			
			if(item.hasOwnProperty('picture')) $(link_img).attr('src', item.picture).attr('alt', item.description);
				
			$(link_header)
				.append('<h1>'+item.name+'</h1>')
				.append('<h2>'+item.caption+'</h1>')
				.append('<p>'+item.description+'</p>');	
			
			$(post_div).append(link_a);
		}

		$('#hv-facebook div.items').append(post_div);
	}
	
});