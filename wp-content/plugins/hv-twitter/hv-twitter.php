<?php

	/*
	Plugin Name: HV Twitter
	Description: Uses the Twitter API with Oauth to get the timeline from a desired Twitter account.
	Author: sunnre
	Version: 0.1
	*/

	function hv_twitter() {
		if(isset($hvtwitter)) return false;
		require_once('hv-twitter-class.php');
		$hvtwitter = new hvTwitter();
		$hvtwitter->setup();
	}

?>