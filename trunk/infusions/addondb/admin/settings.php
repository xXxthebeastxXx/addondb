<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: settings.php
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
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";

if (!checkrights("ADNX") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

require_once INFUSIONS."addondb/inc/inc.functions.php";
require_once ADDON."infusion_db.php";
require_once ADDON_INC."inc.nav.php";

if (file_exists(ADDON_LOCALE.LOCALESET."admin/settings.php")) {
	include ADDON_LOCALE.LOCALESET."admin/settings.php";
} else {
	include ADDON_LOCALE."English/admin/settings.php";
}
  
if (isset($_POST['savesettings'])) {
    $error = 0;
	$result = dbquery("UPDATE ".DB_ADDON_STGS." SET
	    set_addondb_onf='".(isnum($_POST['set_addondb_onf']) ? $_POST['set_addondb_onf'] : "0")."',
	    set_addondb_comm='".(isnum($_POST['set_addondb_comm']) ? $_POST['set_addondb_comm'] : "0")."',
	    set_addondb_sub='".(isnum($_POST['set_addondb_sub']) ? $_POST['set_addondb_sub'] : "0")."',
	    addons_per_page='".(isnum($_POST['addons_per_page']) ? $_POST['addons_per_page'] : "20")."',
	    set_new_time='".(isNum($_POST['set_new_time']) ? $_POST['set_new_time'] : "0")."',
	    set_addon_maintmsg='".addslash(descript($_POST['set_addon_maintmsg']))."'
	");
    if (!$result) { $error = 1; }
   redirect(FUSION_SELF.$aidlink."&error=".$error);
   }
   
  
  opentable($locale['addondbs100']);

  echo "<form name='settingsform' method='post' action='".FUSION_SELF.$aidlink."'>\n";
  echo "<table align='center' cellpadding='0' cellspacing='1' width='90%' class='tbl-border'>\n<tr>\n";
  echo "<th class='forum-caption' colspan='3' align='left'><b>".$locale['addondbs109']."</b><br /></th>\n";
  echo "</tr>\n<tr>\n";

  // Maintenance Mode
  echo "<td class='tbl2' align='right' valign='top'><b>".$locale['addondbs101'].":</b></td>\n";
  echo "<td class='tbl2' align='left'>\n";
  echo "<label><input type='radio' name='set_addondb_onf' value='1'".($settings_global['set_addondb_onf'] == "1" ? " checked='checked'" : "")." />&nbsp;".$locale['addondbs102']."</label>\n";
  echo "&nbsp;<label><input type='radio' name='set_addondb_onf' value='0'".($settings_global['set_addondb_onf'] == "0" ? " checked='checked'" : "")." />&nbsp;".$locale['addondbs103']."</label>\n</td>\n";
  
  echo "</tr>\n<tr>\n";
  echo "<td class='tbl2' align='right' valign='top'><b>".$locale['addondbs110']."</td>\n";
  echo "<td class='tbl2' align='left'>\n";
  echo "<textarea name='set_addon_maintmsg' rows='4' cols='44' class='textbox' style='width:300px;' />".stripslashes($settings_global['set_addon_maintmsg'])."</textarea></td>\n";
  echo "</tr>\n<tr>\n";
  
  //Allow Comments
  echo "<td class='tbl2' align='right' valign='top'><b>".$locale['addondbs104'].":</b></td>\n";
  echo "<td class='tbl2' align='left'>";
  echo "<label><input type='radio' name='set_addondb_comm' value='0'".($settings_global['set_addondb_comm'] == "0" ? " checked='checked'" : "")." />&nbsp;".$locale['addondbs105']."</label>";
  echo "<label><input type='radio' name='set_addondb_comm' value='1'".($settings_global['set_addondb_comm'] == "1" ? " checked='checked'" : "")." />&nbsp;".$locale['addondbs106']."</label>\n</td>\n";
  
  echo "</tr>\n<tr>\n";
 
  // Allow Submissions
  echo "<td class='tbl2' align='right' valign='top'><b>".$locale['addondbs107'].":</b></td>\n";
  echo "<td class='tbl2' align='left'>";
  echo "<label><input type='radio' name='set_addondb_sub' value='0'".($settings_global['set_addondb_sub'] == "0" ? " checked='checked'" : "")." />&nbsp;".$locale['addondbs105']."</label>";
  echo "&nbsp;<label><input type='radio' name='set_addondb_sub' value='1'".($settings_global['set_addondb_sub'] == "1" ? " checked='checked'" : "")." />&nbsp;".$locale['addondbs106']."</label>\n</td>\n";
  
  echo "</tr>\n<tr>\n";
  
  // Addons per page
  echo "<td class='tbl2' align='right' valign='top'><b>".$locale['addondbs108'].":</b></td>\n";
  echo "<td class='tbl2' align='left' colspan='2'>";
  echo "<input type='text' name='addons_per_page' value='".$settings_global['addons_per_page']."' maxlength='10' class='textbox' style='width:40px;' />";
  echo "</td>\n";
  
    echo "</tr>\n<tr>\n";
  
  // New Time
  
    $ntime = array(
	1 => "86400",
	2 => "172800",
	3 => "604800",
	4 => "1209600",
	5 => "2592000"
);

  echo "<td class='tbl2' align='right' valign='top'><b>".$locale['addondbs111'].":<img src='".ADDON_IMG."new.png' border='0' alt='' /></b></td>\n";
  echo "<td class='tbl2' align='left' colspan='2'>";
  echo "<select name='set_new_time' class='textbox'>\n";
  echo "<option value='".$ntime['1']."'".($settings_global['set_new_time'] == "".$ntime['1']."" ? " selected" : "").">".$locale['set_time01']."</option>";
  echo "<option value='".$ntime['2']."'".($settings_global['set_new_time'] == "".$ntime['2']."" ? " selected" : "").">".$locale['set_time02']."</option>";
  echo "<option value='".$ntime['3']."'".($settings_global['set_new_time'] == "".$ntime['3']."" ? " selected" : "").">".$locale['set_time03']."</option>";
  echo "<option value='".$ntime['4']."'".($settings_global['set_new_time'] == "".$ntime['4']."" ? " selected" : "").">".$locale['set_time04']."</option>";
  echo "<option value='".$ntime['5']."'".($settings_global['set_new_time'] == "".$ntime['5']."" ? " selected" : "").">".$locale['set_time05']."</option>";
  echo "</select>\n";
  echo "</td>\n";
  
  echo "</tr>\n<tr>\n";

  echo "<td colspan='3' align='center'>";
  echo "<br /><input type='submit' name='savesettings' value='".$locale['addondbs119']."' class='button' />";
  echo "</td>\n</tr>\n</table>\n</form>\n";


closetable();

require_once THEMES."templates/footer.php";
?>