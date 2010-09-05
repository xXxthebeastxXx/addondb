<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: thread_create.php
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
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";

if (!checkrights("MODS") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { die("Access Denied"); }

require_once INFUSIONS."moddb/infusion_db.php";
require_once INFUSIONS."moddb/inc/inc.functions.php";
require_once INFUSIONS."moddb/inc/inc.nav.php";

if (file_exists(INFUSIONS."moddb/locale/".LOCALESET."admin/thread_create.php")) {
	include INFUSIONS."moddb/locale/".LOCALESET."admin/thread_create.php";
} else {
	include INFUSIONS."moddb/locale/English/admin/thread_create.php";
}

add_to_title(" | ".$locale['moddb600']);

opentable($locale['moddb601']);

	echo "<form name='select' method='post' action='process_thread.php".$aidlink."'>\n";
    echo "<br /><table cellpadding='0' cellspacing='1' width='80%' class='center tbl-border' align='center'><tr>";
    echo "<td class='tbl1'>".$locale['moddb603'].":</td>";
    echo "<td class='tbl1' nowrap valign='top'>";
  
    	    $mcat_list = ""; $sel = ""; $data_mcat = "";
			$result = dbquery("SELECT * FROM ".DB_MODS." WHERE mod_status = '0' AND mod_forum_status = '0' ORDER BY mod_date DESC LIMIT 0,40");
			if (dbrows($result) != 0) {
		    while ($datam = dbarray($result)) {
		    $sel = ($data_mcat == $datam['mod_name'] ? " selected='selected'" : "");
		    $mcat_list .= "<option value='".$datam['mod_id']."'$sel>".$datam['mod_name']."</option>\n";
				}
				 }
				 
	echo "<select name='mod_id' class='textbox' style='width:300px;' onChange='submit()'><option value='0'>".$locale['moddb702']."</option>".$mcat_list."</select>\n</td>\n";
	echo "</tr>\n</table>\n";
	echo "</form>\n";

closetable();

require_once THEMES."templates/footer.php";
?>