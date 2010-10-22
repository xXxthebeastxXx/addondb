<?php

include "maincore.php";

include "feed.class.php";

$result = "SELECT tn.*, tc.*, tu.user_id, tu.user_name, tu.user_status FROM ".DB_NEWS." tn
			LEFT JOIN ".DB_USERS." tu ON tn.news_name=tu.user_id
			LEFT JOIN ".DB_NEWS_CATS." tc ON tn.news_cat=tc.news_cat_id
			WHERE ".groupaccess('news_visibility')." AND (news_start='0'||news_start<=".time().") AND (news_end='0'||news_end>=".time().") AND news_draft='0'
			ORDER BY news_sticky DESC, news_datestamp DESC LIMIT 10";

$feed = new Feed();
$feed->title = "PHP-Fusion News Feed";
$feed->link = $settings['siteurl']."rss.php";
$feed->description = "Recent news on PHP-Fusion.";

$result = dbquery($result);
while($data = dbarray($result)) {
	$item = new RSSItem;
	$item->title = $data['news_subject'];
	$item->link  = $settings['siteurl']."news.php?readmore=".$data['news_id'];
	$item->setPubDate($data['news_datestamp']);
	$item->description = $data['news_news'];
	$feed->addItem($item);
}
$feed->displayFeed();