<?php
	setlocale(LC_ALL, '');

	if(isset($_GET["url"]) && !empty($_GET['url']))
		$url = urldecode($_GET["url"]);
	else
		$url = "http://www.forsvarsmakten.se/sv/Aktuellt/RSS-floden/Alla-nyheter/";

	header('Content-Type: application/json');
	$feed = new DOMDocument();
	$feed->load($url);
	$json = array();
	print_r($feed);
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