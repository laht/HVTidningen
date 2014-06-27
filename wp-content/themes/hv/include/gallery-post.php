<?php

	$pattern = '/\[gallery\sids="(.*.?)"\]/';
	
	if(preg_match($pattern, $content, $matches)) {
		$ids = explode(',', $matches[1]);
		$content = str_replace($matches[0], '', $content);
		
		//Create an empty array.
		$images = array();
		
		foreach($ids as $id) {
			array_push($images, wp_get_attachment((int)$id));
		}
		
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		echo $content;
		
		//Register my JavaScript.
		wp_register_script('hv-gallery', get_template_directory_uri() . '/js/hv-gallery.js', array(), 'v1', true);
		
		//Enqueue the script.
		wp_enqueue_script('hv-gallery');
		
		//Add the images as a JS object.
		wp_localize_script('hv-gallery', 'hv_gallery', $images);
		
		//Add the required stylesheet.
		wp_enqueue_style('hv-gallery', get_template_directory_uri() . '/css/hv-gallery.css');
	}
	
	else {
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		echo $content;
	}

?>