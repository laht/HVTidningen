<?php
/**
 * Plugin Name: hv-maps
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: A brief description of the Plugin.
 * Version: 0.1
 * Author: Joakim Jonsson
 * License: GPL2
 */
require_once('hv-post.php');
require_once('hv-location.php');
require_once('hv-maps-cache.php');
function hv_maps() {
	runScriptsAndStyles();
}
function getPosts() {

	$post_ids = get_posts(array(
	    'numberposts'   => -1, // get all posts.
	    'fields' => 'ids' // Only get post IDs
	));

	$posts = array();
	foreach ($post_ids as $key) {
		$post = get_post($key, ARRAY_A);
		$tags = wp_get_post_tags($key);

		$HVTags = array();
		if (sizeof($tags) > 0) {
			foreach ($tags as $tag) {
				if (isset($tag->name)) {
					$HVTag = $tag->name;
				}				
				array_push($HVTags, $HVTag);
			}
		}

		$HVpost = new HVPost($post['post_title'], $post['guid'], $key, $HVTags);
		array_push($posts, $HVpost);

	}
	echo json_encode($posts);
	die();
}

function activate_db() {
	jal_install();
	jal_add_locs();
}

function getLocs() {
	global $wpdb;
	$results = $wpdb->get_results( 'SELECT * FROM wp_mapLocations ORDER BY id DESC');

	$locs = array();

	foreach ($results as $key) {
		$HVlocation = new HVLocation($key->lat, $key->lng);
		array_push($locs, $HVlocation);
	}
	//print_r(json_encode($locs));
	echo json_encode($results);
	die();
}
//getLocs();
add_action('wp_ajax_nopriv_getPosts', 'getPosts');
add_action('wp_ajax_getPosts', 'getPosts');
add_action('wp_ajax_getLocs', 'getLocs');
add_action('wp_ajax_nopriv_getLocs', 'getLocs');
register_activation_hook( __FILE__, 'activate_db' );

function runScriptsAndStyles() {
	$plugin_url = defined('WP_PLUGIN_URL') ? 
								trailingslashit(WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__))) : 
								trailingslashit(get_bloginfo('wpurl')) . PLUGINDIR . '/' . dirname(plugin_basename(__FILE__));

	wp_enqueue_style('hv-maps', $plugin_url . '/hv-maps-style.css');								
	wp_enqueue_script('hv-maps', $plugin_url . '/hv-maps.js');
}