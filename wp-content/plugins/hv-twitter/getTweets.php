<?php session_start();
	require_once("lib/twitteroauth.php"); //Path to twitteroauth library
	$twitteruser = "TidningenHv";
	$notweets = 3;
	$consumerkey = "sf8yiGBnKXVSDmuzwHzow";
	$consumersecret = "aXjmvI1jdpSwYlkt5RDdlqU3ysnIPs3D3mDMkmY";
	$accesstoken = "113624961-VSDmNcFq8KCrsKBhneVZYyo0EGl0jXcRWewEncj7";
	$accesstokensecret = "dBCgvJBcP5IbYo5YsDD2U9lRWmk0sMUZRYL4Cq9mE";
	
	function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
		$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		return $connection;
	}
	
	$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
	$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
	echo json_encode($tweets);
?>