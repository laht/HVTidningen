jQuery(function($) {
	
	function preload(file) {
		(new Image()).src = file;
	}
	
	//Setup the function that changes the image being shown.
	function imageViewer(image) {
		//Change the image.
		$('#image-viewer img').attr('src', image.fullsize);
		$('#image-viewer span.img-caption').text(image.caption);
		
		$("#images").getNiceScroll().resize();
	}
	
	//Get the JSON objects.
	var images = hv_gallery;
	
	//HTML elements.
	var images_container = $('<section id="post-gallery" class="post-gallery grid-100 clearfix">');
	var viewer_div = $('<div id="image-viewer">');
	var thumbnails = $('<div class="thumbnails">');
	var thumbnailsList = $('<div class="thumbnails-list">');
	
	//Append some tags.
	$(viewer_div)
		.append('<img>')
		.append('<span class="img-caption">');
		
	//More appends.
	$('section#main').prepend(images_container);
	$(images_container).append('<div id="gallery">');
	$('div#gallery', images_container).append(viewer_div);
	$('div#gallery', images_container).append(thumbnails);
	$(thumbnails).append(thumbnailsList);
	
	//Console log for object references. REMEMBER TO COMMENT OUT.
	console.log(images[0]);
	
	$.each(images, function(index, image) {
		//First check if the large thumbnail is available and if it's not then we'll use the fullsize image.
		if(!image.thumbnails.hasOwnProperty('large')) {
			image.fullsize = image.file;
		}
		
		else {
			//If the largest thumbnail is available then it will be used.
			image.fullsize = image.thumbnails.large.file;
		}
		
		//Set up the thumbnail.
		image.thumbnail = image.thumbnails.small.file;
		
		//Preload the larger image.
		preload(image.fullsize);
		
		//If it's the first image it should be shown.
		if(index === 0) {
			$('img', viewer_div).attr('src', image.fullsize);
			
			$('span.img-caption', viewer_div).text(image.caption);
		}
		
		//HTML elements
		var image_div = $('<div class="image">');
		var image_a = $('<a>');
		var image_img = $('<img>');
		
		//Attributes
		$(image_a).attr('href', image.fullsize);
		$(image_img).attr('src', image.thumbnail);
		$(image_img).attr('alt', image.title);
		
		//If it's the first image the active class should be added.
		if(index === 0) $(image_a).addClass('active');
		
		//Event binds
		$(image_a).on('click', function(e) {
			e.preventDefault();
			
			//If the image that is active right now is clicked then do nothing.
			if($(this).hasClass('active')) {
				return false;
			}
			
			//Remove the active class from the current image.
			$('#images a.active').removeClass('active');
			
			//Add it to the one is that is going to be active.
			$(this).addClass('active');
			
			imageViewer(image);
		});
		
		//Appends
		$(thumbnailsList).append(image_div);
		$(image_div).append(image_a);
		$(image_a).append(image_img);
	});

	$('#images').niceScroll({cursoropacitymin:1});
	
});