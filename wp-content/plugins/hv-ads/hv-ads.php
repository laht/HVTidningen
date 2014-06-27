<?php
/*
Plugin Name: HV Ads
Description: Add your own ad banners.
Author: sunnre
Version: 0.1
*/

// Add the custom post type for shows
add_action( 'init', function() {
	
	$labels = array(
	
		'name'					=>		'Annonser',
		'singular_name'			=>		'Annons',
		'add_new'				=>		'Lägg till ny annons',
		'all_items'				=>		'Annonser',
		'add_new_item'			=>		'Lägg till ny annons',
		'edit_item'				=>		'Redigera annons',
		'new_item'				=>		'Ny annons',
		'view_item'				=>		'Se annons',
		'search_items'			=>		'Sök annonser',
		'not_found'				=>		'Inga annonser funna',
		'not_found_in_trash'	=>		'Inga annonser funna i Papperskorgen',
		'menu_name'				=>		'Annonser'
	
	);
	
	$supports = array(
	
		'title',
		'thumbnail'
	
	);
	
	$args = array(
	
		'labels'				=>		$labels,
		'public'				=>		true,
		'publicly_queryable'	=>		true,
		'exclude_from_search'	=>		true,
		'show_ui'				=>		true,
		'show_in_menu'			=>		true,
		'show_in_admin_bar'		=>		true,
		'menu_position'			=>		'25',
		'supports'				=>		$supports
	
	);
	
	register_post_type( 'ads', $args );
} );

// Load admin functions if in the backend
if ( is_admin() ) {
	
	require_once( 'hv-ads-admin.php' );

}

//Starts a session.
add_action('init', function() {
	//Change session directory.
	session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../tmp'));
	
	//Start a session.
	session_start();
});

// Function used in the theme template to show the ads rotator.
function hv_ads($numberposts = 5) {
	//Get the ads.
	$posts = get_posts(array(
		'post_type'		=> 'ads',
		//'orderby'		=> 'rand',
		'numberposts'	=> $numberposts
	));
	
	//If no posts are found then return.
	if(empty($posts)) return;
	
	//Make sure a session variable is set.
	if(!isset($_SESSION['banners_ids'])) $_SESSION['banners_ids'] = array(0);
	
	//$num equals the number of items in the session array.
	$num = count($_SESSION['banners_ids']);
	
	//If $posts has an iteration with the index of $num:
	if(isset($posts[$num - 1])) {
		//Set the add to be that specific iteration.
		$ad = $posts[$num - 1];
		//And then add the ad to the session array.
		array_push($_SESSION['banners_ids'], $ad);
	}
	
	//If $posts doesn't have an iteration that has the index of $num it
	//means we've reached the end of the array and should start over.
	else {
		//So the first ad should be shown.
		$ad = $posts[0];
		//And we restart the session array.
		unset($_SESSION['banners_ids']);
	}
	
	//Get all the meta data attached to that ad.
	$meta = get_post_custom($ad->ID);
	//Retrieve the URL from the meta data.
	$url = (isset($meta['ad_url'])) ? $meta['ad_url'][0] : '#';
	
	//Finally echo out the final ad and markup required.
	echo '<div id="ad-container">';
		echo '<a href="' . $url . '">' . get_the_post_thumbnail($ad->ID, 'full') . '</a>';
	echo '</div>';
}

// Adds featured image functionality for Ads
	
add_action( 'after_setup_theme', function() {
	
	global $_wp_theme_features;

	if ( !isset( $_wp_theme_features['post-thumbnails'] ) ) {
	
		$_wp_theme_features['post-thumbnails'] = array( array( 'ads' ) );
			
	}

	elseif ( is_array( $_wp_theme_features['post-thumbnails'] ) ) {
        
		$_wp_theme_features['post-thumbnails'][0][] = 'ads';
			
	}
		
}, '9999' );
?>