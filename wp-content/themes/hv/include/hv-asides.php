<?php

	$args = array(
    'tax_query' => array(
        array(
            'taxonomy' => 'post_format',
            'field' => 'slug',
            'terms' => array( 'post-format-aside' )
            )
        ),
	'numberposts' => 5
    );
	
	$asides = get_posts($args);
	
	if(empty($asides)) return;
	
	//echo '<pre>';
	//print_r($asides);
	//echo '</pre>';
	
	echo '<header class="header" clearfix">';
	echo '<img src="'.get_template_directory_uri().'/images/aside-icon.png">';
	echo '<h1>Notiser</h1>';
	echo '</header>';
	
	echo '<div class="items">';
	
	foreach($asides as $aside) {
		echo '<div class="item">';
		echo '<div class="title"><a href="'.$aside->guid.'">'.$aside->post_title.'</a></div>';
		//echo get_the_time('U', $aside->ID);
		echo '<div class="time">'.fromNow(get_post_time('U', false, $aside->ID)).'</div>';
		echo '<div class="body">'.$aside->post_content.'</div>';
		echo '</div>';
	}
	
	function js() {
		echo '<script type="text/javascript">jQuery(document).ready(function($){$("#hv-asides").niceScroll();});</script>';
	}
	
	add_action('wp_footer', 'js');
	
?>