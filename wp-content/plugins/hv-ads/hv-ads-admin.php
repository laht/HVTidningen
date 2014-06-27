<?php

// Remove permalink metabox
add_action( 'admin_head', function() {
	remove_meta_box( 'slugdiv', 'ads', 'normal' );
});

// Customize and move featured image box to main column
add_action('do_meta_boxes', function() {

	add_meta_box('postimagediv', __('Annons'), 'post_thumbnail_meta_box', 'ads', 'normal', 'high');

});

add_action('admin_init', function(){
	add_meta_box('ad_url', 'URL', 'ad_url', 'ads', 'normal', 'high');
});
 
function ad_url(){
	global $post;
	$custom = get_post_custom($post->ID);
	$ad_url = (isset($custom['ad_url'])) ? $custom['ad_url'][0] : '';
	
	/*echo '<pre>';
	print_r($custom);
	echo '</pre>';*/

echo '<p>';
echo '<input name="ad_url" class="widefat" value="' . $ad_url . '" />';
echo '</p>';

}

// Save the URL data.
add_action('save_post', function() {
	$post = get_post();
	
	if(isset($post) && $post->post_type == 'ads')
		update_post_meta($post->ID, 'ad_url', $_POST['ad_url']);
});

// Adds slide image and link to slides column view
add_filter( 'manage_edit-slide_columns', function( $columns ) {

	$columns = array(
	
		'cb'         => '<input type="checkbox" />',
		'slide'      => __( 'Slide Image', 'meteor-slides' ),
		'title'      => __( 'Slide Title', 'meteor-slides' ),
		'slide-link' => __( 'Slide Link', 'meteor-slides' ),
		'date'       => __( 'Date', 'meteor-slides' )

	);

	return $columns;

});

add_action( 'manage_posts_custom_column', function( $column ) {

	global $post;

	switch ( $column ) {
	
		case 'slide' :
		
			echo the_post_thumbnail('featured-slide-thumb');
		
		break;
		
		case 'slide-link' :
		
			if ( get_post_meta($post->ID, "slide_url_value", $single = true) != "" ) {
			
				echo "<a href='" . get_post_meta($post->ID, "slide_url_value", $single = true) . "'>" . get_post_meta($post->ID, "slide_url_value", $single = true) . "</a>";
		
			}  
		
			else {
			
				_e('No Link', 'meteor-slides');
		
			}
		
		break;

	}
		
});

?>