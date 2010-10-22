<?php

require_once "maincore.php";
require_once INCLUDES."feed.class.php";

isset($_GET['type']) || !empty($_GET['type']) ? $_GET['type'] : $_GET['type'] = "404";

switch($_GET['type']) {
	case "addon":
	$result = "
	SELECT tm.addon_id, tm.addon_name, tm.addon_description, tm.addon_date, tm.addon_download, tc.addon_cat_type, tc.addon_cat_name 
	FROM ".DB_PREFIX."addondb_cats tc
	LEFT JOIN ".DB_PREFIX."addondb_addons tm USING(addon_cat_id)
	WHERE addon_status = 0
	ORDER BY addon_date
	DESC LIMIT 10";
	$feed = new Feed();
	$feed->title = "Addons Feed";
	$feed->link = $settings['siteurl']."rss.php";
	$feed->description = "Latest Addons on PHP-Fusion.";
	$result = dbquery($result);
	while($data = dbarray($result)) {
		$filesize = filesize(INFUSIONS."addondb/files/".$data['addon_download']);
		$item = new RSSItem;
		$item->title = $data['addon_name'];
		$item->link  = $settings['siteurl']."/infusions/addondb/view.php?addon_id=".$data['addon_id'];
		$item->setPubDate($data['addon_date']);
		$item->description = $data['addon_description'];
		$item->category($data['addon_cat_name']);
		$item->enclosure($settings['siteurl']."infusions/addondb/files/".$data['addon_download'], "application/zip", $filesize );
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