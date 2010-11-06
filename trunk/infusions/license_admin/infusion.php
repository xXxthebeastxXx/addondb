<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
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
include INFUSIONS."license_admin/infusion_db.php";

if (file_exists(INFUSIONS."license_admin/locale/".$settings['locale'].".php")) {
	include INFUSIONS."license_admin/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."license_admin/locale/English.php";
}

$inf_title = $locale['pla_001'];
$inf_description = $locale['pla_001'];
$inf_version = "1.0";
$inf_developer = "PHP-Fusion Addons Team";
$inf_email = "";
$inf_weburl = "http://php-fusion.co.uk";

$inf_folder = "license_admin";

$inf_newtables = 1;
$inf_insertdbrows = 0;
$inf_altertables = 0;
$inf_deldbrows = 0;

$inf_newtable[1] = DB_LICENSE_APPLY." (
app_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT, 
app_user SMALLINT(5) UNSIGNED DEFAULT '0' NOT NULL,
app_realname VARCHAR(200) NOT NULL,
app_address TEXT NOT NULL,
app_country VARCHAR(100) NOT NULL,
app_phone VARCHAR(100) NOT NULL,
app_vat VARCHAR(200) NOT NULL,
app_type VARCHAR(200) NOT NULL, 
app_url VARCHAR(200) DEFAULT '0' NOT NULL, 
app_text TEXT NOT NULL, 
app_status TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL, 
app_datestamp INT(10) UNSIGNED DEFAULT '0' NOT NULL, 
app_approver SMALLINT(5) UNSIGNED DEFAULT '0' NOT NULL,
app_approver_pm TEXT NOT NULL,
app_approver_comment TEXT NOT NULL, 
PRIMARY KEY (app_id)
) TYPE=MyISAM;";

$inf_droptable[1] = DB_LICENSE_APPLY;

$inf_adminpanel[1] = array(
	"title" => $locale['pla_009'],
	"image" => "license_apply.png",
	"panel" => "license_admin.php",
	"rights" => "LCAP"
);

?>