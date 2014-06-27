<?php
	setlocale(LC_ALL, '');

	if(isset($_GET["url"]) && !empty($_GET['url']))
		$url = urldecode($_GET["url"]);
	else
		$url = "http://www.forsvarsmakten.se/sv/aktuellt/feed.rss";

	header('Content-Type: application/json');
	
	// Use cURL to fetch text
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$str = curl_exec($ch);
	curl_close($ch);
	
	// Manipulate string into object
	$feed = new DOMDocument();
	$feed->loadXML($str);
	
	$json = array();
	
	$json['title'] = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('title')->item(0)->firstChild->nodeValue;
	$json['description'] = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('description')->item(0)->firstChild->nodeValue;
	$json['link'] = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('link')->item(0)->firstChild->nodeValue;
	
	$items = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('item');
	
	$json['entries'] = array();
	$i = 0;
	
	
	foreach($items as $item) {
		
		if($i > 3) break;
	
	   $title = $item->getElementsByTagName('title')->item(0)->firstChild->nodeValue;
	   $description = $item->getElementsByTagName('description')->item(0)->firstChild->nodeValue;
	   $pubDate = $item->getElementsByTagName('pubDate')->item(0)->firstChild->nodeValue;
	   $guid = $item->getElementsByTagName('guid')->item(0)->firstChild->nodeValue;
	   
	   $json['entries'][$i]['title'] = $title;
	   $json['entries'][$i]['description'] = $description;
	   $json['entries'][$i]['pubdate'] = $pubDate;
	   $json['entries'][$i]['guid'] = $guid;   
	   
	   $i++;
		 
	}
	
	echo json_encode($json);

?>