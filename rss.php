<?php

require_once "maincore.php";
require_once "feed.class.php";

isset($_GET['type']) || !empty($_GET['type']) ? $_GET['type'] : $_GET['type'] = "404";

switch($_GET['type']) {
	case "addon":
	$result = "
	SELECT addon_id, addon_name, addon_description, addon_date
	FROM ".DB_ADDONS."
	WHERE addon_status = 0
	ORDER BY addon_date
	DESC LIMIT 10";
	$feed = new Feed();
	$feed->title = "Addons Feed";
	$feed->link = $settings['siteurl']."rss.php";
	$feed->description = "Latest Addons on PHP-Fusion.";
	$result = dbquery($result);
	while($data = dbarray($result)) {
		$item = new RSSItem;
		$item->title = $data['addon_name'];
		$item->link  = $settings['siteurl']."/infusions/addondb/view.php?addon_id=".$data['addon_id'];
		$item->setPubDate($data['addon_date']);
		$item->description = $data['addon_description'];
		$feed->addItem($item);
	}
	$feed->displayFeed();
	break;
}



if ($settings['login_method'] == "sessions") {
	session_write_close();
}

if (ob_get_length() !== FALSE){
	ob_end_flush();
}

mysql_close($db_connect);