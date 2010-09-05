<?php

/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: latest_mods_panel.php
| CVS Version: 1.00
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
if (file_exists(INFUSIONS."latest_mods_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."latest_mods_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."latest_mods_panel/locale/English.php";
}

if (iMEMBER) {

// Set number of mods to display

$nummods = "10";
$lmptitle = "".sprintf($locale['lmod_001'], $nummods)."";
openside($lmptitle);

$result=dbquery("SELECT * FROM ".DB_MODS." WHERE mod_status = '0' ORDER BY mod_date DESC LIMIT 0,$nummods");

  if(dbrows($result) != 0) {
     echo "<table width='100%' cellpadding='0' cellspacing='0'>\n";
     echo "<tr><td class='tbl2 small2'>".$locale['lmod_002']."</td><td class='tbl2 small2'>".$locale['lmod_003']."</td><td class='tbl2' align='center' width='1%'><img src='".THEME."images/down.gif' alt='".$locale['lmod_004']."' /></td></tr>\n";

	    while($data = dbarray($result)) {
		  echo "<tr><td class='small'><a href='".INFUSIONS."moddb/view.php?mod_id=$data[mod_id]' class='side' title='".$data['mod_name']."'>".trimlink($data['mod_name'], 10)."</a></td>\n";
		  echo "<td class='small'>".trimlink($data['mod_author_name'], 10)."</td>\n";
		  echo "<td class='small' align='center' width='1%'>".$data['mod_download_count']."</td></tr>\n";
		  } 
	    } else {
		echo "<div align='center' class='small'>".$locale['lmod_005']."</div>\n";
		         }
echo "</table>\n";

closeside();
                   }
?>