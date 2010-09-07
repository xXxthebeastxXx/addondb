<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: latest_addons_panel.php
| CVS Version: 1.03
| Author: PHP-Fusion MODs & Infusions Team
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

if (file_exists(INFUSIONS."latest_addons_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."latest_addons_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."latest_addons_panel/locale/English.php";
}

// Set number of addons to display
$numaddons = "10";

$lmptitle = "".sprintf($locale['laddon_001'], $numaddons)."";

openside($lmptitle);
                
        $result = dbquery(
			"SELECT 
			m.addon_id, 
			m.addon_name, 
			m.addon_author_name, 
			m.addon_download_count, 
			u.user_id, 
			u.user_name, 
			u.user_status
			FROM ".DB_ADDONS." m
			LEFT JOIN ".DB_USERS." u 
			ON u.user_name=m.addon_author_name
			ORDER BY addon_date 
			DESC LIMIT 0,$numaddons"
			);

  if(dbrows($result) != 0) {
     echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>\n";
	
	    while($data = dbarray($result)) {
		  echo "<tr>\n<td class='small'><a href='".INFUSIONS."addondb/view.php?addon_id=$data[addon_id]' class='side' title='".$data['addon_name']."'>".trimlink($data['addon_name'], 10)."</a></td>\n";
		  echo "<td class='small'> ".(isset($data['user_name']) ? profile_link($data['user_id'], $data['user_name'], $data['user_status']) : $data['addon_author_name'])."</td>\n";
		  echo "<td class='small' align='center' width='1%'>".$data['addon_download_count']."</td></tr>\n";
		  }
		  echo "</table>\n";
	    } else {
		echo "<div align='center' class='small'>".$locale['laddon_005']."</div>\n";
		         }
$numaddons = ""; $lmptitle = "";
closeside();

?>