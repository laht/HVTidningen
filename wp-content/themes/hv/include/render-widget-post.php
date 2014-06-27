<?php

function render($post, $text) {
	$category = get_the_category($post->ID);
	
	$class = (preg_match('/kommentar/', $text)) ? 'text break-line' : 'text';
	
	echo '<li>';
	echo '<a class="post-link" href="' . get_permalink($post->ID) . '"><span class="arrow">&raquo; </span>' . $post->post_title;
	echo '<span class="' . $class . '">' . $text . '</span>';
	echo '<span class="meta">';
	if(function_exists('fromNow')) echo fromNow(get_post_time('U', false, $post->ID));
	else echo get_post_time('j-m-Y');
	echo ', av ' . get_the_author_meta('display_name', $post->post_author) . '</span>';
	echo '</a>';
	echo '</li>';
}

?>