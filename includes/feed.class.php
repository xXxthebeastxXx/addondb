<?php
/**
 * Feed class
 * 
 * @author Johan Wilson <johan.wilson@blendtek.net>
 * @version 0.1
 * @copyright Copyright (c) 2010, Johan Wilson
 * @license http://opensource.org/licenses/agpl-v3.html GNU AFFERO GENERAL PUBLIC LICENSE v3
 */
if (!defined("IN_FUSION")) { die("Access Denied"); }

class Feed {
	
	public $title;
	public $link;
	public $description;
	public $language = "en-us";
	public $encoding = "utf-8";
	public $pubDate;
	private $items;
	private $xml;

	public function Feed() {
		$this->items = array();
	}

	public function addItem($item) {
		$this->items[] = $item;
	}

	private function setPubDate($time) {
		if(strtotime($when) == NULL)
			$this->pubDate = date("D, d M Y H:i:s ", $time) . "GMT";
		else
			$this->pubDate = date("D, d M Y H:i:s ", strtotime($time)) . "GMT";
	}

	private function getPubDate() {
		if(empty($this->pubDate))
			return date("D, d M Y H:i:s ") . "GMT";
		else
			return $this->pubDate;
	}

	private function out() {
		$this->xml  = "<?xml version=\"1.0\" encoding=\"".$this->encoding."\"?>\n";
		$this->xml .= "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
		$this->xml .= "	<channel>\n";
		$this->xml .= "		<atom:link href=\"" . $this->link . "\" rel=\"self\" type=\"application/rss+xml\" />\n";
		$this->xml .= "		<title>".$this->title."</title>\n";
		$this->xml .= "		<link>".$this->link."</link>\n";
		$this->xml .= "		<description>".$this->description . "</description>\n";
		$this->xml .= "		<language>".$this->language."</language>\n";
		$this->xml .= "		<pubDate>".$this->getPubDate()."</pubDate>\n";
		foreach($this->items as $item) $this->xml .= $item->items();
		$this->xml .= "	</channel>\n";
		$this->xml .= "</rss>\n";
		return $this->xml;
	}
	
	public function displayFeed() {
		$this->xml = $this->out();
		header("Content-type: application/rss+xml");
		echo $this->xml;
	}
}

class RSSItem extends Feed {
	
	public $title;
	public $link;
	public $description;
	public $pubDate;
	private $guid;
	private $attachment;
	private $length;
	private $mimetype;
	private $cat;
	private $xml;

	public function setPubDate($when) {
		if(strtotime($when) == NULL)
			$this->pubDate = date("D, d M Y H:i:s ", $when) . "GMT";
		else
			$this->pubDate = date("D, d M Y H:i:s ", strtotime($when)) . "GMT";
	}

	private function getPubDate() {
		if(empty($this->pubDate))
			return date("D, d M Y H:i:s ") . "GMT";
		else
			return $this->pubDate;
	}

	public function items() {
		$this->xml .= "		<item>\n";
		$this->xml .= "			<title>" . $this->title . "</title>\n";
		$this->xml .= "			<link>" . $this->link . "</link>\n";
		$this->xml .= "			<description><![CDATA[ " . $this->description . " ]]></description>\n";
		$this->xml .= "			<pubDate>" . $this->getPubDate() . "</pubDate>\n";
		if($this->attachment != NULL) $this->xml .= "			<enclosure url=\"".$this->attachment."\" length=\"".$this->length."\" type=\"".$this->mimetype."\" />\n";
		if($this->cat != NULL) $this->xml .= "			<category>".$this->cat."</category>\n";
		if(empty($this->guid)) $this->guid = $this->link;
		$this->xml .= "			<guid>" . $this->guid . "</guid>\n";
		$this->xml .= "		</item>\n";
		return $this->xml;
	}

	public function enclosure($url, $mimetype, $length) {
		$this->attachment = $url;
		$this->mimetype   = $mimetype;
		$this->length     = $length;
	}
	
	public function category($cat) {
		$this->cat = $cat;
	}
}