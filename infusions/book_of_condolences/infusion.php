<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
| Author: PHP-Fusion Addons Team
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }
include INFUSIONS."book_of_condolences/infusion_db.php";

if (file_exists(INFUSIONS."book_of_condolences/locale/".$settings['locale'].".php")) {
	include INFUSIONS."book_of_condolences/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."book_of_condolences/locale/English.php";
}

// Infusion general information
$inf_title = $locale['m4n_001'];
$inf_description = $locale['m4n_001'];
$inf_version = "1.0";
$inf_developer = "PHP-Fusion Addons Team";
$inf_email = "";
$inf_weburl = "http://php-fusion.co.uk";

$inf_folder = "book_of_condolences";

$inf_newtable[1] = DB_CONDOLENCES." (
m4n_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
m4n_user MEDIUMINT(8) UNSIGNED NOT NULL,
m4n_status TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
m4n_admin MEDIUMINT(8) UNSIGNED NOT NULL,
m4n_text TEXT NOT NULL,
m4n_datestamp INT(10) UNSIGNED DEFAULT '0' NOT NULL,
PRIMARY KEY (m4n_id)
) TYPE=MyISAM;";

$inf_droptable[1] = DB_CONDOLENCES;

$inf_adminpanel[1] = array(
	"title" => $locale['m4n_009'],
	"image" => "ribbon.png",
	"panel" => "condolences_admin.php",
	"rights" => "MSFN"
);

$inf_sitelink[1] = array(
	"title" => $locale['m4n_001'],
	"url" => "condolences.php",
	"visibility" => "0"
);

?>