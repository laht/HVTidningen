<?php

	/*
	Plugin Name: HV RSS
	Description: Uses the built in XML parser to get a RSS feed and convert it to JSON.
	Author: sunnre
	Version: 0.1
	*/

	function hv_rss() {
		if(isset($hvrss)) return false;
		require_once('hv-rss-class.php');
		$hvrss = new hvRSS();
		$hvrss->setup();
	}

?>