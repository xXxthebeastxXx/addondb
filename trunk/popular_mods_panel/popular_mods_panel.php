<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: popular_mods_panel.php
| CVS Version: 1.02
| Author: PHP-Fusion MODs & Infusions Team
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

include INFUSIONS."moddb/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."popular_mods_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."popular_mods_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."popular_mods_panel/locale/English.php";
}

// Set number of mods to display
$popmods = "5";

// Popular Mods

openside($locale['pmod_001']);

$result7=dbquery("SELECT mod_id, mod_name, mod_download_count FROM ".DB_MODS." WHERE mod_status = '0' AND version_id = '8' OR version_id = '12' ORDER BY mod_download_count DESC LIMIT 0,$popmods");

  if(dbrows($result7) != 0) {
     echo "<table width='100%' cellpadding='0' cellspacing='0'>\n";

	    while($data7 = dbarray($result7)) {
		  echo "<tr><td class='small'><a href='".INFUSIONS."moddb/view.php?mod_id=$data7[mod_id]' class='side' title='".$data7['mod_name']."'>".trimlink($data7['mod_name'], 22)."</a></td>\n";
		  echo "<td class='small' align='center' width='1%'>".$data7['mod_download_count']."</td></tr>\n";
		  } 
	    } else {
		echo "<div align='center' class='small'>".$locale['pmod_005']."</div>\n";
		         }
echo "</table>\n"; 

// My Mods

if (iMEMBER) {

$resultm=dbquery("SELECT mod_id, mod_name, mod_download_count FROM ".DB_MODS." WHERE mod_status = '0' AND mod_author_name = '".$userdata['user_name']."' AND (version_id = '8' OR version_id = '12') ORDER BY mod_download_count DESC LIMIT 0,$popmods");

  if(dbrows($resultm) != 0) {

   echo "<hr />"; 
   echo "<table width='100%' cellpadding='0' cellspacing='0'>\n";
   echo "<tr><td class='tbl2 small2' colspan='2'><b>".$locale['pmod_004']."</b></td></tr>\n";
	
	    while($datam = dbarray($resultm)) {
		  echo "<tr><td class='small'><a href='".INFUSIONS."moddb/view.php?mod_id=$datam[mod_id]' class='side' title='".$datam['mod_name']."'>".trimlink($datam['mod_name'], 22)."</a></td>\n";
		  echo "<td class='small' align='center' width='1%'>".$datam['mod_download_count']."</td></tr>\n";
		  } 
   echo "</table>\n"; 
	    }
          }
$popmods = "";
closeside();

?>