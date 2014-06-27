<?php
global $jal_db_version;
$jal_db_version = "1.0";

function jal_install () {
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix."mapLocations";

	$sql = "CREATE TABLE $table_name(
		id int NOT NULL AUTO_INCREMENT,
		lat tinytext NOT NULL,
		lng tinytext NOT NULL,
		UNIQUE KEY id (id)
		);"
	;

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	add_option("jal_db_version", $jal_db_version);


}

function jal_add_locs() {	
	global $wpdb;
	$locs = array(  1 => array("lat" => "67.8557995", "lng" => "20.2252821"),
					2 => array("lat" => "65.8251188","lng" => "21.6887028"),
					3 => array("lat" => "63.8258471", "lng" => "20.2630354"),
					4 => array("lat" => "63.1766832", "lng" => "14.6360681"),
					5 => array("lat" => "62.6322698", "lng" => "17.9408714"),
					6 => array("lat" => "60.6748796", "lng" => "17.1412726"),
					7 => array("lat" => "60.60646000000001", "lng" => "15.6355"),
					8 => array("lat" => "59.63569090000001", "lng" => "17.0778228"),
					9 => array("lat" => "59.37745229999999", "lng" => "17.0321193"),
					10 => array("lat" => "59.32932349999999", "lng" => "18.0685808"),
					11 => array("lat" => "57.21892", "lng" => "16.03989"),
					12 => array("lat" => "59.2752626", "lng" => "15.2134105"),
					13 => array("lat" => "58.3902782", "lng" => "13.8461208"),
					14 => array("lat" => "58.38333300000001", "lng" => "11.666667"),
					15 => array("lat" => "57.70887", "lng" => "11.97456"),
					16 => array("lat" => "56.6743748", "lng" => "12.8577884"),
					17 => array("lat" => "55.71666699999999", "lng" => "13.483333"),
					18 => array("lat" => "57.6651652", "lng" => "14.9732214"),
					19 => array("lat" => "56.8790044", "lng" => "14.8058522"),
					20 => array("lat" => "56.161224", "lng" => "15.5869"),
					21 => array("lat" => "57.6348", "lng" => "18.29484"),
					22 => array("lat" => "58.4148255", "lng" => "15.520488"));
	
	$table_name = $wpdb->prefix."mapLocations";
	for ($i=1; $i <= count($locs); $i++) {
		$wpdb->insert($table_name, array('lat' => $locs[$i]['lat'], 'lng' => $locs[$i]['lng']));	
	}

}