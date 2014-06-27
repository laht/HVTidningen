<?php

class HVPost{
	public $m_title;	
	public $m_guid;
	public $m_id;
	public $m_tags;
	
	public function __construct($title, $guid, $id, $tags) {
		$this->m_title = $title;
		$this->m_guid = $guid;
		$this->m_id = $id;
		$this->m_tags = $tags;
	}
}