<?php

	global $post;

	$thumb_id = get_post_thumbnail_id($post->ID);

	$args = array(
	'post_type' => 'attachment',
	'post_status' => null,
	'post_parent' => $post->ID,
	'include'  => $thumb_id
	); 

	$thumbnail_image = get_posts($args);

	if ($thumbnail_image && isset($thumbnail_image[0])) {
		//Caption.
		echo $thumbnail_image[0]->post_excerpt; 
	}

?>