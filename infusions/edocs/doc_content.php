<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: doc_content.php
| Author: Philip Daly (HobbyMan)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/

$page_ident = "1";
echo "<div id='cnt'>";
echo "<div class='tbl2'>";
echo "<h2>".strtoupper($locale['ac01'])."</h2>";
edoc_header($page_ident);
echo "</div>\n";

echo $locale['ca_header'];
echo "<div class='tbl-border' id='l202x'>";
echo "<img src='".ADMIN."images/article_cats.gif' alt='".$locale['202']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['202'])."</h3><br />\n";
echo $locale['ca_art_cats']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l203x'>";
echo "<img src='".ADMIN."images/articles.gif' alt='".$locale['203']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['203'])."</h3><br />\n"; 
echo $locale['ca_articles']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l206x'>";
echo "<img src='".ADMIN."images/c-pages.gif' alt='".$locale['206']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['206'])."</h3><br />\n"; 
echo $locale['ca_c-pages']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l208x'>";
echo "<img src='".ADMIN."images/dl_cats.gif' alt='".$locale['208']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['208'])."</h3><br />\n"; 
echo $locale['ca_dl_cats']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l209x'>";
echo "<img src='".ADMIN."images/dl.gif' alt='".$locale['209']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['209'])."</h3><br />\n";
echo $locale['ca_downloads']."</div>";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l210x'>";
echo "<img src='".ADMIN."images/faq.gif' alt='".$locale['210']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['210'])."</h3><br />\n";
echo $locale['ca_faqs']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l211y'>";
echo "<img src='".ADMIN."images/forums.gif' alt='".$locale['211']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['211'])."</h3><br />\n";
echo $locale['ca_forums']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l212x'>";
echo "<img src='".ADMIN."images/images.gif' alt='".$locale['212']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['212'])."</h3><br />\n";
echo $locale['ca_images']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l216y'>";
echo "<img src='".ADMIN."images/news.gif' alt='".$locale['216']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['216'])."</h3><br />\n";
echo $locale['ca_news']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l235x'>";
echo "<img src='".ADMIN."images/news_cats.gif' alt='".$locale['235']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['235'])."</h3><br />\n";
echo $locale['ca_news_cats']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l218x'>";
echo "<img src='".ADMIN."images/photoalbums.gif' alt='".$locale['218']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['218'])."</h3><br />\n";
echo $locale['ca_news_photo_albums']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l220x'>";
echo "<img src='".ADMIN."images/polls.gif' alt='".$locale['220']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['220'])."</h3><br />\n";
echo $locale['ca_polls']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l226x'>";
echo "<img src='".ADMIN."images/wl_cats.gif' alt='".$locale['226']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['226'])."</h3><br />\n";
echo $locale['ca_weblink_cats']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l227x'>";
echo "<img src='".ADMIN."images/wl.gif' alt='".$locale['227']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['227'])."</h3><br />\n";
echo $locale['ca_weblinks']."</div>\n";
show_int_links($page_ident);

echo "<br />\n</div>\n";
$page_ident = ($page_ident+1);

echo "<div id='usa'>";
echo "<div class='tbl2'><h2>".strtoupper($locale['ac02'])."</h2>";
edoc_header($page_ident);
echo "</div>\n";

echo $locale['ua_header'];
echo "<div class='tbl-border' id='l201x'>";
echo "<img src='".ADMIN."images/admins.gif' alt='".$locale['201']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['201'])."</h3><br />";
echo $locale['ua_admins']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l204x'>";
echo "<img src='".ADMIN."images/blacklist.gif' alt='".$locale['204']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['204'])."</h3><br />";
echo $locale['ua_blacklist']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l239x'>";
echo "<img src='".ADMIN."images/forum_ranks.gif' alt='".$locale['239']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['239'])."</h3><br />";
echo $locale['ua_forum_ranks']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l215x'>";
echo "<img src='".ADMIN."images/members.gif' alt='".$locale['215']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['215'])."</h3><br />";
echo $locale['ua_members']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l221x'>";
echo "<img src='".ADMIN."images/shout.gif' alt='".$locale['221']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['221'])."</h3><br />";
echo $locale['ua_shoutbox']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l223x'>";
echo "<img src='".ADMIN."images/submissions.gif' alt='".$locale['223']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['223'])."</h3><br />";
echo $locale['ua_submissions']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l240x'>";
echo "<img src='".ADMIN."images/user_fields_cats.gif' alt='".$locale['240']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['240'])."</h3><br />";
echo $locale['ua_uf_cats']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l238x'>";
 echo "<img src='".ADMIN."images/user_fields.gif' alt='".$locale['238']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['238'])."</h3><br />";
echo $locale['ua_user_fields']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l225x'>";
echo "<img src='".ADMIN."images/user_groups.gif' alt='".$locale['225']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['225'])."</h3><br />";
echo $locale['ua_user_groups']."</div>\n";
show_int_links($page_ident);

echo "<br />\n</div>\n";
$page_ident = ($page_ident+1);

echo "<div id='sys'>";
echo "<div class='tbl2'><h2>".strtoupper($locale['ac03'])."</h2>";
edoc_header($page_ident); 
echo "</div>\n";

echo $locale['sy_header'];

echo "<div class='tbl-border' id='l245x'>";
echo "<img src='".ADMIN."images/banners.gif' alt='".$locale['245']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['245'])."</h3><br />";
echo $locale['sy_banners']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l236x'>";
echo "<img src='".ADMIN."images/bbcode.gif' alt='".$locale['236']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['236'])."</h3><br />";
echo $locale['sy_bbcodes']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l207x'>";
echo "<img src='".ADMIN."images/db_backup.gif' alt='".$locale['207']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['207'])."</h3><br />";
echo $locale['sy_db_backup']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l213x'>";
echo "<img src='".ADMIN."images/infusions.gif' alt='".$locale['213']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['213'])."</h3><br />";
echo $locale['sy_infusions']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l217x'>";
echo "<img src='".ADMIN."images/panels.gif' alt='".$locale['217']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['217'])."</h3><br />";
echo $locale['sy_panels']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l219x'>";
echo "<img src='".ADMIN."images/phpinfo.gif' alt='".$locale['219']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['219'])."</h3><br />";
echo $locale['sy_phpinfo']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l222x'>";
echo "<img src='".ADMIN."images/site_links.gif' alt='".$locale['222']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['222'])."</h3><br />"; 
echo $locale['sy_site_links']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l237x'>";
echo "<img src='".ADMIN."images/smileys.gif' alt='".$locale['237']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['237'])."</h3><br />";
echo $locale['sy_smileys']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l224x'>";
echo "<img src='".ADMIN."images/upgrade.gif' alt='".$locale['224']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['224'])."</h3><br />";
echo $locale['sy_upgrade']."</div>\n";
show_int_links($page_ident);

echo "<br />\n</div>\n";
$page_ident = ($page_ident+1);

echo "<div id='sts'>";
echo "<div class='tbl2'>";
echo "<h2>".strtoupper($locale['ac04'])."</h2>";
edoc_header($page_ident);
echo "</div>\n";

echo $locale['st_header'];

echo "<div class='tbl-border' id='edoc008x'>";
echo "<img src='".ADMIN."images/settings_dl.gif' alt='".$locale['209']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['209'])."</h3><br />";
echo $locale['st_downloads']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l211x'>";
echo "<img src='".ADMIN."images/settings_forum.gif' alt='".$locale['211']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['211'])."</h3><br />";
echo $locale['st_forums']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l244x'>";
echo "<img src='".ADMIN."images/settings_ipp.gif' alt='".$locale['244']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['244'])."</h3><br />";
echo $locale['st_ipp']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l228x'>";
echo "<img src='".ADMIN."images/settings.gif' alt='".$locale['228']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['228'])."</h3><br />";
echo $locale['st_main']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l233x'>";
echo "<img src='".ADMIN."images/settings_misc.gif' alt='".$locale['233']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['233'])."</h3><br />";
echo $locale['st_misc']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l216x'>";
echo "<img src='".ADMIN."images/settings_news.gif' alt='".$locale['216']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['216'])."</h3><br />";
echo $locale['st_news']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l232x'>";
echo "<img src='".ADMIN."images/photoalbums.gif' alt='".$locale['232']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['232'])."</h3><br />";
echo $locale['st_photo_gallery']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l234x'>";
echo "<img src='".ADMIN."images/settings_pm.gif' alt='".$locale['234']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['234'])."</h3><br />";
echo $locale['st_pm_options']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l231x'>";
echo "<img src='".ADMIN."images/registration.gif' alt='".$locale['231']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['231'])."</h3><br />";
echo $locale['st_registration']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l246x'>";
echo "<img src='".ADMIN."images/security.gif' alt='".$locale['246']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['246'])."</h3><br />";
echo $locale['st_security']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l229x'>";
echo "<img src='".ADMIN."images/settings_time.gif' alt='".$locale['edoc010']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['edoc010'])."</h3><br />";
echo $locale['st_time_date']."</div>\n";
show_int_links($page_ident);

echo "<div class='tbl-border' id='l247x'>";
echo "<img src='".ADMIN."images/user_management.gif' alt='".$locale['247']."' style='margin:5px' align='left'  border='0' /><h3>".strtoupper($locale['247'])."</h3><br />";
echo $locale['st_user_man']."</div>\n";
show_int_links($page_ident);

echo "<br />\n</div>\n";
$page_ident = ""; 

?>