<?php

	/*
	Plugin Name: HV Facebook
	Description: Uses the Facebook API to get the latest posts.
	Author: sunnre
	Version: 0.1
	*/

	function hv_facebook() {
		if(isset($hvfacebook)) return false;
		require_once('hv-facebook-class.php');
		$hvfacebook = new hvFacebook();
		$hvfacebook->setup();
	}

?>