<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
| Author: Philip Daly (HobbyMan)
| Web: http://www.phpnuclear.com/
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

include INFUSIONS."spam_report_panel/infusion_db.php";

if (file_exists(INFUSIONS."spam_report_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."spam_report_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."spam_report_panel/locale/English.php";
}

// Infusion general information
$inf_title = $locale['spr_001'];
$inf_description = $locale['spr_002'];
$inf_version = "1.0";
$inf_developer = "HobbyMan";
$inf_email = "";
$inf_weburl = "http://www.phpnuclear.com/";

$inf_folder = "spam_report_panel";

$inf_newtable[1] = DB_SPAM_REPORT." (
	spr_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
	spr_user SMALLINT(5) UNSIGNED DEFAULT '0' NOT NULL,
	spr_page VARCHAR(200) DEFAULT '' NOT NULL,
	spr_status TINYINT(1) DEFAULT '0' NOT NULL,
	spr_datestamp INT(10) UNSIGNED DEFAULT '0' NOT NULL,
	PRIMARY KEY (spr_id)
) TYPE=MyISAM;";

$inf_insertdbrow[1] = DB_PANELS." SET panel_name='".$locale['spr_001']."', panel_filename='".$inf_folder."', panel_content='', panel_side=1, panel_order='2', panel_type='file', panel_access='101', panel_display='0', panel_status='1' ";

$inf_deldbrow[1] = DB_PANELS." WHERE panel_filename='$inf_folder'";
$inf_droptable[1] = DB_SPAM_REPORT;

?>