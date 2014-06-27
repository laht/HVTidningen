<?php

	/*
	Plugin Name: HV Events
	Description: Add your own events.
	Author: sunnre
	Version: 0.1
	*/
	
	//Sets localization to swedish.
	setlocale(LC_TIME, 'swedish');
	
	//If the plugin has been loaded then don't load it again.
	if(isset($hvevents)) return false;
	//Load the class file.
	require_once('hv-events-class.php');
	$hvevents = new hvEvents();
	$hvevents->setup();
	
	// Load admin functions if in the backend
	if (is_admin()) {
		require_once( 'hv-events-admin.php' );
	}
	
	/*
	 *
	 *Setup some template tags.
	 *
	 */

	//Event title.
	function hv_event_title() {
		global $hvevents;
		echo $hvevents->event_title();
	}
	
	//Event venue.
	function hv_event_venue() {
		global $hvevents;
		echo $hvevents->event_venue();
	}
	
	//Event map.
	function hv_event_map() {
		global $hvevents;
		
		//If there isn't a map then don't do anything.
		if(!$hvevents->has_map()) return false;
		
		echo $hvevents->event_map();
	}
	
	//Event start date.
	function hv_event_start($format) {
		global $hvevents;
		echo $hvevents->event_start($format);
	}
	
	//Event start date.
	function hv_event_end($format) {
		global $hvevents;
		echo $hvevents->event_end($format);
	}
	
	//Event description.
	function hv_event_description() {
		global $hvevents;
		echo $hvevents->event_description();
	}

?>