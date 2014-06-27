<?php

function wp_get_attachment_action($attachment_id) {
	
	if(!is_int($attachment_id)) return 0;

	$attachment = get_post($attachment_id);
	
	$metadata = wp_get_attachment_metadata($attachment->ID);
	
	$path = explode('/', $metadata['file']);
	$file = $path[count($path)-1];
	unset($path[count($path)-1]);
	$url = explode('/', 'http://' . $_SERVER['HTTP_HOST'] . '/wp-content/uploads');
	$path = array_merge($url, $path);
	$path = implode('/', $path);
	$path = $path . '/';
	
	//I'll make a seperate array containing the thumbnails.
	foreach($metadata['sizes'] as $key => $value) {
		if($key == 'thumbnail') $key = 'small';
		$thumbnails[$key] = $value;
	}
	
	//I need to change the value of file to be an absolute filepath to the image file.
	//First I'll grab the keys of the array.
	$keys = array_keys($thumbnails);
	//Then I'll iterate through the array.
	for($i = 0; $i < count($thumbnails); $i++) {
		//Since my keys are named I reference the $keys to reach the desired key.
		if(isset($thumbnails[$keys[$i]]['file'])) $thumbnails[$keys[$i]]['file'] = $path . $thumbnails[$keys[$i]]['file'];
	}
	
	$attachment_data = array(
		'title' => $attachment->post_title,
		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'permalink' => get_permalink( $attachment->ID ),
		'file' => $path . $file,
		'thumbnails' => (object)$thumbnails
	);
	
	return (object)$attachment_data;
	
}
	
?>