jQuery(function($) {
	
	$.getJSON('wp-content/plugins/hv-twitter/getTweets.php', function(items) {
		//Stop the loader.
		$('.widget-loader', $('#hv-twitter')).hide();
		
		//console.log(items[0]);
		
		$.each(items, function(index, item) {
			render(item);
		});
		
		$('#hv-twitter div.items-cont').niceScroll({cursoropacitymin:1});
	});
	
	function render(item) {
		var tweet_div = $('<article class="item">');
		//var tweet_author = $('<div class="author">');
		var tweet_time = $('<div class="time">');
		var tweet_body = $('<div class="body">');
		
		//$(tweet_author).html('<a href="http://twitter.com/'+item.user.screen_name+'" target="_blank">'+item.user.screen_name+'</a> tweetade');
		$(tweet_time).html(moment(Date.parse(item.created_at).toString('u'), "YYYY-MM-DD HH:mm:ssZ").fromNow());
		$(tweet_body).html(modifytext(item.text));
		
		$(tweet_div)
			//.append(tweet_author)
			.append(tweet_time)
			.append('<div class="clear">')
			.append(tweet_body);
		$('#hv-twitter div.items').append(tweet_div);
	}
	
	//Function modified from Stack Overflow
	function modifytext(data) {
		//Add link to all http:// links within tweets
		data = data.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
			return '<a href="'+url+'" >'+url+'</a>';
		});
		
		//Add a span and link to hashtags.
		data = data.replace(/#(\w+)/g, function(hashtag) {
		   return '<span class="hashtag">'+hashtag+'</span>';
		});
 
		//Add link to @usernames used within tweets
		data = data.replace(/\B@([_a-z0-9]+)/ig, function(reply) {
			return '<a href="http://twitter.com/'+reply.substring(1)+'" style="font-weight:lighter;" >'+reply.charAt(0)+reply.substring(1)+'</a>';
		});
		
		return data;
	}
	
});