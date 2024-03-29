<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright � 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: popular_addons_panel.php
| Author: PHP-Fusion Addons Team
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| addonify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

include INFUSIONS."addondb/infusion_db.php";
require_once INFUSIONS."addondb/inc/inc.functions.php";

if (file_exists(INFUSIONS."popular_addons_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."popular_addons_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."popular_addons_panel/locale/English.php";
}

// Set number of addons to display
$popaddons = "5";

// Popular Addons

openside($locale['paddon_001']);

$result=dbquery("SELECT addon_id, 
                        addon_name, 
                        addon_download_count 
                        FROM ".DB_ADDONS." 
                        WHERE addon_status = '0' 
                        ORDER BY addon_download_count 
                        DESC LIMIT 0,$popaddons");

if(dbrows($result) != 0) {
	echo "<table width='100%' cellpadding='0' cellspacing='0'>\n";

	while($data = dbarray($result)) {
		echo "<tr><td class='small'><a href='".ADDON."view.php?addon_id=$data[addon_id]' class='side' title='".$data['addon_name']."'>".trimlink($data['addon_name'], 22)."</a></td>\n";
		echo "<td class='small' align='center' width='1%'>".$data['addon_download_count']."</td></tr>\n";
	}
	echo "</table>\n";

} else {
		echo "<div align='center' class='small'>".$locale['paddon_005']."</div>\n";
}


// My addons

if (iMEMBER) {

$resultm=dbquery("SELECT addon_id, 
                   addon_name, 
                   addon_download_count 
                   FROM ".DB_ADDONS." 
                   WHERE addon_status = '0' 
                   AND addon_author_name = '".$userdata['user_name']."'  
                   ORDER BY addon_download_count 
                   DESC LIMIT 0,$popaddons");

  if(dbrows($resultm) != 0) {

   echo "<hr />"; 
   echo "<table width='100%' cellpadding='0' cellspacing='0'>\n";
   echo "<tr>\n<td class='tbl2 small2' colspan='2'><b>".$locale['paddon_004']."</b></td></tr>\n";
	
	    while($datam = dbarray($resultm)) {
		  echo "<tr><td class='small'><a href='".ADDON."view.php?addon_id=$datam[addon_id]' class='side' title='".$datam['addon_name']."'>".trimlink($datam['addon_name'], 22)."</a></td>\n";
		  echo "<td class='small' align='center' width='1%'>".$datam['addon_download_count']."</td>\n</tr>\n";
		  } 
   echo "</table>\n"; 
	    }
          }
$popaddons = "";
closeside();

?>