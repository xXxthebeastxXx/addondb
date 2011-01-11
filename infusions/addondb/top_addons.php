<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: top_addons.php
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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

require_once INFUSIONS."addondb/inc/inc.functions.php";
require_once ADDON."infusion_db.php";
include ADDON_LOCALE.LOCALESET."addons.php";
$popaddons = $settings_global['addons_per_page'];
include ADDON_INC."view_nav.php";

opentable(sprintf($locale['paddon_001'],$popaddons));

$addon_type = array(
	       1 => $locale['paddon_008'], 
	       2 => $locale['paddon_009'], 
	       3 => $locale['paddon_010'], 
	       4 => $locale['paddon_011']
	       );

             $result = (dbquery("SELECT 
                                         a.addon_id, 
                                         a.addon_type, 
                                         a.addon_name, 
                                         a.addon_version, 
                                         a.addon_submitter_name, 
                                         a.addon_author_name, 
                                         a.addon_download_count, 
                                         u.user_id, 
                                         u.user_name, 
                                         u.user_status 
                                         FROM ".DB_ADDONS." a 
                                         LEFT JOIN ".DB_USERS." u 
                                         ON a.addon_author_name=u.user_name 
                                         WHERE a.addon_status = '0' 
                                         ORDER BY addon_download_count 
                                         DESC LIMIT 0,$popaddons"));

if(dbrows($result) != 0) {
	echo "<table width='100%' class='tbl-border'>\n<tr>\n";
	echo "<th class='forum-caption'>".$locale['paddon_002']."</th>\n";
	echo "<th class='forum-caption'>".$locale['paddon_003']."</th>\n";
	echo "<th class='forum-caption'>".$locale['paddon_004']."</th>\n";
	echo "<th class='forum-caption'>".$locale['paddon_005']."</th>\n";
	echo "<th class='forum-caption'>".$locale['paddon_006']."</th>\n</tr>\n";

	while($data = dbarray($result)) {
		echo "<tr>\n<td class='tbl1'><a href='".ADDON."view.php?addon_id=$data[addon_id]' title='".$data['addon_name']."'>".trimlink($data['addon_name'], 22)."</a></td>\n";
		echo "<td class='tbl1'>".$addon_type[$data['addon_type']]."</td>\n";
		echo "<td class='tbl1'>".(isset($data['user_name']) ? profile_link($data['user_id'], $data['user_name'], $data['user_status']) : $data['addon_author_name'])."</td>\n";
		echo "<td align='center' class='tbl1' width='1%'>".$data['addon_version']."</td>\n";
		echo "<td align='center' class='tbl1' width='1%'>".$data['addon_download_count']."</td></tr>\n";
	}
	echo "</table>\n";

} else {
		echo "<div align='center' class='small'>".$locale['paddon_007']."</div>\n";
}


closetable();

opentable(sprintf($locale['paddon_012'],$popaddons));

$addon_type = array(
	       1 => $locale['paddon_008'], 
	       2 => $locale['paddon_009'], 
	       3 => $locale['paddon_010'], 
	       4 => $locale['paddon_011']
	       );

             $result = (dbquery("SELECT 
                                         a.addon_id, 
                                         a.addon_type, 
                                         a.addon_name, 
                                         a.addon_version, 
                                         a.addon_submitter_name, 
                                         a.addon_author_name, 
                                         a.addon_date, 
                                         u.user_id, 
                                         u.user_name, 
                                         u.user_status 
                                         FROM ".DB_ADDONS." a 
                                         LEFT JOIN ".DB_USERS." u 
                                         ON a.addon_author_name=u.user_name 
                                         WHERE a.addon_status = '0' 
                                         ORDER BY addon_date 
                                         DESC LIMIT 0,$popaddons"));

if(dbrows($result) != 0) {
	echo "<table width='100%' class='tbl-border'>\n<tr>\n";
	echo "<th class='forum-caption'>".$locale['paddon_002']."</th>\n";
	echo "<th class='forum-caption'>".$locale['paddon_003']."</th>\n";
	echo "<th class='forum-caption'>".$locale['paddon_004']."</th>\n";
	echo "<th class='forum-caption'>".$locale['paddon_005']."</th>\n";
	echo "<th class='forum-caption'>".$locale['paddon_013']."</th>\n</tr>\n";

	while($datab = dbarray($result)) {
		echo "<tr>\n<td class='tbl1'><a href='".ADDON."view.php?addon_id=$datab[addon_id]' title='".$datab['addon_name']."'>".trimlink($datab['addon_name'], 22)."</a></td>\n";
		echo "<td class='tbl1'>".$addon_type[$datab['addon_type']]."</td>\n";
		echo "<td class='tbl1'>".(isset($datab['user_name']) ? profile_link($datab['user_id'], $datab['user_name'], $datab['user_status']) : $datab['addon_author_name'])."</td>\n";
		echo "<td align='center' class='tbl1' width='1%'>".$datab['addon_version']."</td>\n";;
		echo "<td align='center' class='tbl1' width='1%'>".strftime('%d/%m/%Y', $datab['addon_date']+($settings['timeoffset']*3600))."</td></tr>\n";
	}
	echo "</table>\n";

} else {
		echo "<div align='center' class='small'>".$locale['paddon_007']."</div>\n";
}


closetable();
require_once THEMES."templates/footer.php";
?>