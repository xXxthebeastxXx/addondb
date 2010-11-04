<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: licenses.php
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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";
require_once INFUSIONS."addondb/infusion_db.php";
$addon_global = dbarray(dbquery("SELECT addons_dev_qual FROM ".DB_ADDON_STGS));

include INFUSIONS."license_admin/infusion_db.php";

if (file_exists(INFUSIONS."license_admin/locale/".$settings['locale'].".php")) {
	include INFUSIONS."license_admin/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."license_admin/locale/English.php";
}
add_to_title($locale['global_200'].$locale['pla_001']);

$slink = array(
	array("link_name" => "Copyright Removal License", "link_url" => "infusions/license_admin/crl.php", "link_window" => false),
	array("link_name" => "Commercial Core License", "link_url" => "infusions/license_admin/ccl.php", "link_window" => false),
	array("link_name" => "Enduser PHP-Fusion Addon License", "link_url" => "infusions/license_admin/epal.php", "link_window" => false),
	array("link_name" => "How to apply for a license", "link_url" => "infusions/license_admin/license_apply.php", "link_window" => false)
);

opentable($locale['pla_001']);

echo "<div class='grid_15 alpha omega'>";
     echo "<table class='tbl-border'>\n<tr>\n";
     echo "<td class='tbl1'><img src='".INFUSIONS."license_admin/img/shake.png' align='left' alt='' />".$locale['pla_400']."</td>\n";
     echo "</tr>\n<tr>\n";
     echo "<td class='tbl1' valign='top'>".sprintf($locale['pla_401'], $addon_global['addons_dev_qual'])."</td>\n";
     echo "</tr>\n</table>\n";
closetable();
echo "</div>";

echo "<div id='aside' class='grid_7 push_1 alpha omega'>";
build_navigation("Text of Licenses", $slink);
echo "</div>";

require_once THEMES."templates/footer.php";
?>