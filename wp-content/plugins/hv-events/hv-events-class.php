<?php

class hvEvents {
	
	//Initialize variables.
	var $plugin_url;
	
	public function setup() {
		//Declare the plugin URL.
		$this->plugin_url = defined('WP_PLUGIN_URL') ? 
			trailingslashit(WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__))) : 
			trailingslashit(get_bloginfo('wpurl')) . PLUGINDIR . '/' . dirname(plugin_basename(__FILE__));
		
		//Add the initial required css.
		$this->add_style('hv-events', 'hv-events.css');
		
		//Add the custom post type.
		add_action('init', array(&$this, 'add_post_type'));
		
		//Adds the widget.
		if(function_exists('register_widget')) {
			require_once('hv-events-widget-class.php');
			
			add_action('widgets_init', function() {
				register_widget('HV_Events_Widget');
			});
		}
		
		//Adds the shortcode.
		add_shortcode('hv_events', array(&$this, 'hv_events_func'));
		
		//Hooks in the appropiate function to the AJAX calls.
		//Render events.
		//add_action('wp_ajax_nopriv_get_hv_events', array(&$this, 'get_hv_events'));
		//add_action('wp_ajax_get_hv_events', array(&$this, 'get_hv_events'));
		//Get coordinates for the event map.
		add_action('wp_ajax_nopriv_get_hv_map_latlng', array(&$this, 'get_hv_map_latlng'));
		add_action('wp_ajax_get_hv_map_latlng', array(&$this, 'get_hv_map_latlng'));
		
		//Setup the events array correctly.
		$this->events = array(
			'past'		=> array(),
			'upcoming'	=> array()
		);
	}
	
	//Simplify the proccess of adding a stylesheet.
	private function add_style($handle, $file, $external = false) {
		$src = ($external) ? $file : $this->plugin_url . 'css/' . $file;
		
		add_action('wp_head', function() use ($handle, $src) {
			wp_enqueue_style($handle, $src);
		});
	}
	
	//Same as above but with scripts.
	private function add_script($handle, $file, $external = false) {
		$src = ($external) ? $file : $this->plugin_url . 'js/' . $file;
		
		add_action('wp_footer', function() use ($handle, $src) {
			wp_enqueue_script($handle, $src);
		});
	}
	
	private function register_script($handle, $file, $external = false, $dep = array('jquery'), $ver = 'v1', $in_footer = true) {
		$src = ($external) ? $file : $this->plugin_url . 'js/' . $file;
		
		wp_register_script($handle, $src, $dep, $ver, $in_footer);
	}
	
	//Function to add the shortcode.
	public function hv_events_func($atts) {
		//Extract the attributes.
		extract(shortcode_atts(array(
			'filter'	=> 'all',
			'maxposts'	=> -1
		), $atts));
		
		$posts = get_posts(array(
			'post_type'		=> 'events',
			'meta_key'		=> 'start_date',
			'orderby'		=> 'start_date',
			'order'			=> 'ASC',
			'numberposts'	=> $maxposts
		));
		
		//Create an empty array.
		$events = array(
			'past'		=> array(),
			'upcoming'	=> array()
		);
		
		foreach($posts as $post) {
			$custom = get_post_custom($post->ID);
			
			$title = $post->post_title;
			$content = $post->post_content;
			$venue = $custom['venue'][0];
			$start_date = DateTime::createFromFormat('Y-m-d H:i', $custom['start_date'][0]);
			$end_date = DateTime::createFromFormat('Y-m-d H:i', $custom['end_date'][0]);
			
			$has_been = (time() > $start_date->format('U'));
			
			//If filter is set to upcoming and this event has been, skip over.
			if($filter == 'upcoming' && $has_been)
				continue;
			
			//If filter is set to history and this event is upcoming, skip over.
			if($filter == 'history' && !$has_been)
				continue;
			
			//Build up an array.
			$event = array(
				'title'			=> $title,
				'permalink'		=> get_permalink($post->ID),
				'description'	=> $content,
				'venue'			=> $venue,
				'date'			=> array(
									'start'	=> array(
										'formatted'	=> strftime('%d %B %Y kl. %H:%M', $start_date->format('U')),
										'ISO'		=> strftime('%x', $start_date->format('U')),
										'day'		=> strftime('%d', $start_date->format('U')),
										'month'		=> strftime('%b', $start_date->format('U')),
										'year'		=> strftime('%Y', $start_date->format('U')),
										'hour'		=> strftime('%H', $start_date->format('U')),
										'minute'	=> strftime('%M', $start_date->format('U'))
									),
									'end'	=> array(
										'formatted'	=> strftime('%d %B %Y kl. %H:%M', $end_date->format('U')),
										'ISO'		=> strftime('%x', $start_date->format('U')),
										'day'		=> strftime('%d', $end_date->format('U')),
										'month'		=> strftime('%b', $end_date->format('U')),
										'year'		=> strftime('%Y', $end_date->format('U')),
										'hour'		=> strftime('%H', $end_date->format('U')),
										'minute'	=> strftime('%M', $end_date->format('U'))
									)
								)
			);
			
			if($has_been) {
				array_push($events['past'], $event);
			}
			
			else {
				array_push($events['upcoming'], $event);
			}
		}
		
		$this->add_style('hv_events', 'hv-events.css');
		$this->register_script('hv_events_render', 'render_events.js', false, array('jquery'), 'v1');
		wp_enqueue_script('hv_events_render');
		wp_localize_script('hv_events_render', 'hv_events', $events);
		
		return '<div id="hv-events"></div>';
	}
	
	//Add the custom post type.
	public function add_post_type() {
		$labels = array(
			'name'					=>		'Evenemang',
			'singular_name'			=>		'Evenemang',
			'add_new'				=>		'Lägg till nytt evenemang',
			'all_items'				=>		'Evenemang',
			'add_new_item'			=>		'Lägg till ny evenemang',
			'edit_item'				=>		'Redigera evenemang',
			'new_item'				=>		'Nytt evenemang',
			'view_item'				=>		'Se evenemang',
			'search_items'			=>		'Sök evenemang',
			'not_found'				=>		'Inga evenemang funna',
			'not_found_in_trash'	=>		'Inga evenemang funna i Papperskorgen',
			'menu_name'				=>		'Kalender'
		);
		
		$supports = array(
			'title',
			'editor'	
		);
		
		$args = array(	
			'labels'				=>		$labels,
			'public'				=>		true,
			'publicly_queryable'	=>		true,
			'exclude_from_search'	=>		false,
			'show_ui'				=>		true,
			'show_in_menu'			=>		true,
			'show_in_admin_bar'		=>		true,
			'menu_position'			=>		'25',
			'supports'				=>		$supports	
		);
		
		register_post_type('events', $args);
	}
	
	//AJAX functionality to render the events in the front-end.
//	public function get_hv_events() {
//		echo json_encode($this->events);
//		die();
//	}
	
	//AJAX functionality to retrieve the coordinates for the event map.
	public function get_hv_map_latlng() {
		//Global $wpdb.
		global $wpdb;
		
		//Get the current post ID from the query string.
		$id = $_REQUEST['post_id'];
		
		//Get the custom meta.
		$custom = get_post_custom($id);
		
		//JSON encode it and echo it.
		echo json_encode(array('lat' => $custom['venue_lat'][0], 'lng' => $custom['venue_long'][0]));
		
		//Die.
		die();
	}
	
	//Below is some functions used in theme templates.
	public function get_meta($key) {
		global $post;
		
		$custom = get_post_custom($post->ID);
		
		//If the metakey is missing return false, else return the value.
		if(!isset($custom[$key])) return false;
		return $custom[$key][0];
	}
	
	//Checks if the current post has coordinates assigned to it.
	public function has_map() {
		//If either the latitude or the longitude value is missing return false.
		if(strlen($this->get_meta('venue_lat')) == 0 || strlen($this->get_meta('venue_long')) == 0)
			return false;
			
		return true;
	}
	
	//Echos out the current event's title.
	public function event_title() {
		global $post;
		return $post->post_title;
	}
	
	//Echoes out the current event's venue.
	public function event_venue() {
		return $this->get_meta('venue'); 
	}
	
	//Enqueues all the necessary JS files and echoes out a canvas for the map.
	public function event_map() {
		//Global $post.
		global $post;
		
		//Add the Google JS.
		$this->add_script('google_maps_api', 'http://maps.google.com/maps/api/js?key=AIzaSyBw5UwaW-Jv5zOmnCA6vzevrOM_h3d5FQk&sensor=false', true);
		//Register my script.
		$this->register_script('hv_events_map_generator', 'map-generator.js', false, array('google_maps_api'), 'v1', true);
		//Enqueue it.
		wp_enqueue_script('hv_events_map_generator');
		//Pass along the post ID.
		wp_localize_script('hv_events_map_generator', 'hv_events_map', array('postID' => $post->ID));
		
		$return_str = '<div id="map-container">';
			$return_str .= '<div id="map-canvas"></div>';
		$return_str .= '</div>';
		
		return $return_str;
	}
	
	//Shows the current event's start date.
	public function event_start($format) {
		$date = DateTime::createFromFormat('Y-m-d H:i', $this->get_meta('start_date'));
		return strftime($format, $date->format('U'));
	}
	
	//Shows the current event's end date.
	public function event_end($format) {
		$date = DateTime::createFromFormat('Y-m-d H:i', $this->get_meta('end_date'));
		return strftime($format, $date->format('U'));
	}
	
	//Echoes out the current event's description.
	public function event_description() {
		global $post;
		return $post->post_content;
	}
	
}

?>