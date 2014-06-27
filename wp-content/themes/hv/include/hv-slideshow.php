<?php

	//Variables.
	$images = array();
	
	//First retrieve the term.
	$posts = get_posts( 'category_name=' . $termName . '&numberposts=4' );
	
	
	foreach($posts as $post) :
		if(preg_match('/\[gallery.*ids=.(.*).\]/', $post->post_content, $ids)) {
			$id = intval(get_post_thumbnail_id($post->ID));
			
			if($id == 0) continue;
			
			$image = wp_get_attachment($id);
			
			//echo '<pre>';
			//print_r($image);
			//echo '</pre>';
			//return;
			
			$image->post_title = get_the_title($post);
			$image->post_permalink = get_permalink($post->ID);
			$image->post_date = get_post_time('Y-m-d', false, $post->ID);
			
			array_push($images, $image);
			
			/*echo '<pre>';
			print_r($image);
			echo '</pre>';*/
		}
	endforeach;

	$video = get_posts('category_name=TV&numberposts=1');
	$image = wp_get_attachment(intval(get_post_thumbnail_id($video[0]->ID)));
	$image->post_title = get_the_title($video[0]);
	$image->post_permalink = get_permalink(intval(get_post_thumbnail_id($video[0]->ID)));
	$image->post_date = get_post_time('Y-m-d', false, intval(get_post_thumbnail_id($video[0]->ID)));
	array_push($images, $image);
	

/*	echo '<pre>';
	print_r($images);
	echo '</pre>';
	
	echo '<pre>';
	print_r($posts);
	echo '</pre>';*/

	$slides = array();
	
	echo '<div id="slides" class="clearfix">';
	
	$i = 0;
	
	foreach($images as $image) {
		//If for some reason the correct image size doesn't exist, continue.
		if(!isset($image->thumbnails->hv_slideshow['file'])) continue;
		
		echo '<div class="hvslide' . ($i == 0 ? ' first' : '') . '">';
		echo '<a href="' . $image->post_permalink . '"><img src="' . $image->thumbnails->hv_slideshow['file'] . '" alt="' . $image->title .'"></a>';
		echo '<div class="meta">';
		echo '<div class="title">' . $image->post_title . '</div>';
		echo '<div class="time">' . $image->post_date . '</div>';
		echo '</div>';
		echo '</div>';
		
		//If all is well add the image to the array slides.
		array_push($slides, $image);
		
		$i++;
		
	}
	
	echo '</div>';
	
	echo '<div id="pager">';
//	for($i = 0; $i < count($slides); $i++) {
//		echo '<a href="#" class="inactive"></a>';
//	}
	echo '</div>';
	
	echo '<div id="controls"><div id="hv-slides-prev"></div><div id="hv-slides-next"></div></div>';
	
	wp_enqueue_script('jquery-cycle-lite', get_template_directory_uri() . '/js/jquery.cycle2.min.js');
	wp_enqueue_script('hv-slideshow', get_template_directory_uri() . '/js/hv-slideshow.js');
	wp_enqueue_style('hv-slideshow', get_template_directory_uri() . '/css/hv-slideshow.css');

?>