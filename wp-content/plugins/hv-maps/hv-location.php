<?php

class HVLocation{
	public $m_lat;	
	public $m_lng;
	
	public function __construct($lat, $lng) {
		$this->m_lat = $lat;
		$this->m_lng = $lng;
	}
}