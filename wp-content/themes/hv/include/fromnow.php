<?php

function fromNow_action($timestamp) {

	$difference = current_time('timestamp') - $timestamp;

	if($difference >= 60*60*24*365){        // if more than a year ago
		$int = intval($difference / (60*60*24*365));
		$r = $int . ' år sedan';
	} elseif($difference >= 60*60*24*7*5){  // if more than five weeks ago
		$int = intval($difference / (60*60*24*30));
		if($int > 1) $s = ' månader ';
		else $s = ' månad ';
		$r = $int . $s . 'sedan';
	} elseif($difference >= 60*60*24*7){        // if more than a week ago
		$int = intval($difference / (60*60*24*7));
		if($int > 1) $s = ' veckor ';
		else $s = ' vecka ';
		$r = $int . $s . 'sedan';
	} elseif($difference >= 60*60*24){      // if more than a day ago
		$int = intval($difference / (60*60*24));
		if($int > 1) $s = ' dagar ';
		else $s = ' dag ';
		$r = $int . $s . 'sedan';
	} elseif($difference >= 60*60){         // if more than an hour ago
		$int = intval($difference / (60*60));
		if($int > 1) $s = ' timmar ';
		else $s = ' timma ';
		$r = $int . $s . 'sedan';
	} elseif($difference >= 60){            // if more than a minute ago
		$int = intval($difference / (60));
		if($int > 1) $s = ' minuter ';
		else $s = ' minut ';
		$r = $int . $s . 'sedan';
	} else {                                // if less than a minute ago
		$r = 'sekunder sedan';
	}

	return $r;
	
}
	
?>