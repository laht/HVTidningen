<?php

//Global reference to the class object.
add_action('admin_init', function(){
	add_meta_box('event_venue', 'Plats', 'event_venue_metabox', 'events', 'normal', 'low');
	add_meta_box('event_date', 'Från - till', 'event_date_metabox', 'events', 'side', 'low');
});

add_action('admin_init', function() {
	global $pagenow, $typenow, $hvevents;
	
	if(empty($typenow) && !empty($_GET['post'])) {
		$post = get_post($_GET['post']);
		$typenow = $post->post_type;
	}
	
	if($pagenow == 'post-new.php' || $pagenow == 'post.php' && $typenow == 'events') {
		$template_url = get_bloginfo('stylesheet_directory');
		
		wp_enqueue_script('jquery_ui_datepicker', $hvevents->plugin_url . '/js/jquery-ui-1.10.3.custom.min.js');
		wp_enqueue_script('jquery_ui_timepicker', $hvevents->plugin_url . '/js/jquery-ui-timepicker-addon.js');
		wp_enqueue_script('jquery_ui_datepicker_sv', $hvevents->plugin_url . '/js/jquery-ui-datepicker-sv.js');
		wp_enqueue_script('jquery_ui_timepicker_sv', $hvevents->plugin_url . '/js/jquery-ui-timepicker-sv.js');
		wp_enqueue_script('google_maps_api', 'http://maps.google.com/maps/api/js?key=AIzaSyBw5UwaW-Jv5zOmnCA6vzevrOM_h3d5FQk&sensor=false');
		wp_enqueue_script('jquery_ui_addresspicker', $hvevents->plugin_url . '/js/jquery.ui.addresspicker.js');
		wp_enqueue_script('hv_events_js', $hvevents->plugin_url . '/js/js.js');
		
		wp_enqueue_style('jquery_ui_datepicker', $hvevents->plugin_url . '/css/jquery-ui-1.10.3.custom.css');
		wp_enqueue_style('jquery_ui_timepicker', $hvevents->plugin_url . '/css/jquery-ui-timepicker-addon.css');
	}
});

function event_venue_metabox() {
	global $post;
	
	$custom = get_post_custom($post->ID);
	$venue = (isset($custom['venue'])) ? $custom['venue'][0] : '';
	$lat = (isset($custom['venue_lat'])) ? $custom['venue_lat'][0] : '';
	$long = (isset($custom['venue_long'])) ? $custom['venue_long'][0] : '';
	
	echo '<p>';
		echo '<label for="venue">Plats:</label>';
		echo '<input type="text" name="venue" id="venue" class="widefat" value="' . $venue . '">';
		echo '<input type="hidden" name="venue_lat" id="venue_lat" value="' . $lat . '">';
		echo '<input type="hidden" name="venue_long" id="venue_long" value="' . $long . '">';
	echo '</p>';
}

function event_date_metabox() {
	global $post;
	
	$custom = get_post_custom($post->ID);
	$start_date = (isset($custom['start_date'])) ? $custom['start_date'][0] : date('Y-m-d H:i');
	$end_date = (isset($custom['end_date'])) ? $custom['end_date'][0] : date('Y-m-d H:i');
	
	echo '<p>';
		echo '<label for="start_date">Startdatum:</label>';
		echo '<input type="text" name="start_date" id="start_date" class="widefat" value="' . $start_date . '">';
		echo '<small>Format: ÅÅÅÅ-MM-DD HH:MM</small>';
	echo '</p>';
	
	echo '<p>';
		echo '<label for="start_date">Slutdatum:</label>';
		echo '<input type="text" name="end_date" id="end_date" class="widefat" value="' . $end_date . '">';
		echo '<small>Format: ÅÅÅÅ-MM-DD HH:MM</small>';
	echo '</p>';
}

//Add action to save our custom post data.
add_action('save_post', function() {
	global $post;
	
	if(isset($post)) {
		update_post_meta($post->ID, 'venue', $_POST['venue']);
		update_post_meta($post->ID, 'venue_lat', $_POST['venue_lat']);
		update_post_meta($post->ID, 'venue_long', $_POST['venue_long']);
		update_post_meta($post->ID, 'start_date', $_POST['start_date']);
		update_post_meta($post->ID, 'end_date', $_POST['end_date']);
	}
});

//Change sort order in the posts list.
add_filter('parse_query', function($query) {
	if(isset($_GET['post_type']) && $_GET['post_type'] == 'events') {
		$query->query_vars['orderby']	= 'meta_value';
		$query->query_vars['meta_key']	= 'start_date';
		$query->query_vars['order']		= 'ASC';
	}
});

//Adds custom columns to the posts list.
add_filter('manage_edit-events_columns', function($columns) {
	$columns = array(
		'cb'			=> '<input type="checkbox" />',
		'title'			=> 'Evenemang',
		'description'	=> 'Beskrivning',
		'venue'			=> 'Plats',
		'start_date'	=> 'Startdatum',
		'end_date'		=> 'Slutdatum'
    );
	
	return $columns;
});

add_action('manage_posts_custom_column', function($column) {
	global $post;
	
	$custom = get_post_custom($post->ID);
 
	switch ($column) {
		case 'description':
			the_content();
			break;
		case 'venue':
			echo $custom['venue'][0];
			break;
    	case 'start_date':
			echo $custom['start_date'][0];
			break;
		case 'end_date':
			echo $custom['end_date'][0];
			break;
  }
});

?>