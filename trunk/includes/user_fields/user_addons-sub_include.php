<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: user_addons-sub_include.php
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

require_once INFUSIONS."addondb/infusion_db.php";

if ($profile_method == "input") {
	//Nothing here
} elseif ($profile_method == "display") {

if (iMEMBER) {
$addoncount = number_format(dbcount("(addon_id)", DB_ADDONS, "addon_author_name='".$user_data['user_name']."' && addon_status = '0'"));

     if ($addoncount > 0) {
	echo "<tr>\n";
	if (file_exists(INFUSIONS."addondb/img/approved_dev.png")) {
	echo "<td colspan='2' valign='top' align='right'><img src='".INFUSIONS."addondb/img/approved_dev.png' alt='' border='0' /></td>\n";
	echo "</tr>\n<tr>\n"; }
	echo "<td width='1%' class='tbl1' style='white-space:nowrap'>".$locale['uf_asubs_001']."</td>\n";
	echo "<td align='right' class='tbl1'>".$addoncount."</td>\n";
	echo "</tr>\n";
	}
}

	
} elseif ($profile_method == "validate_insert") {
	//Nothing here
} elseif ($profile_method == "validate_update") {
	//Nothing here
}
?>