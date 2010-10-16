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

if (file_exists(INFUSIONS."testimonials_admin/locale/".$settings['locale'].".php")) {
	include INFUSIONS."testimonials_admin/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."testimonials_admin/locale/English.php";
}

// Infusion general information
$inf_title = $locale['ltp_001'];
$inf_description = $locale['ltp_001'];
$inf_version = "1.0";
$inf_developer = "PHP-Fusion Addons Team";
$inf_email = "";
$inf_weburl = "http://php-fusion.co.uk";

$inf_folder = "testimonials_admin";


$inf_adminpanel[1] = array(
	"title" => $locale['ltp_009'],
	"image" => "approval.png",
	"panel" => "testimonials_admin.php",
	"rights" => ""
);

?>