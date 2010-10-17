<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: dev_applications.php
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

if (file_exists(ADDON_LOCALE.LOCALESET."apply_dev.php")) {
	include ADDON_LOCALE.LOCALESET."apply_dev.php";
} else {
	include ADDON_LOCALE."English/apply_dev.php";
}


if (!function_exists("stripinput_fix")) {
function stripinput_fix($text) {
	if (!is_array($text)) {
		if (QUOTES_GPC) $text = stripslashes($text);
		$search = array("&", "\"", "'", "\\", '\"', "\'", "<", ">", "&nbsp;");
		$replace = array("&amp;", "&quot;", "&#39;", "&#92;", "&quot;", "&#39;", "&lt;", "&gt;", " ");
		$text = str_replace($search, $replace, $text);
	} else {
		while (list($key, $value) = each($text)) {
			$text[$key] = stripinput($value);
		}
	  }
	return $text;
  }
}

if (isset($_POST['cancel'])) {
	redirect(FUSION_SELF.(FUSION_QUERY ? "?".FUSION_QUERY : ""));
}

if (isset($_POST['dev_approve'])) {
$apply_id = stripinput($_POST['apply_id']);
if(isset($_POST['user_approve'])) {
        $Si['user_approve'] = stripinput_fix($_POST['user_approve']);
        foreach($Si['user_approve'] as $key) {
                $update = dbquery("UPDATE ".DB_ADDONS." SET addon_author_status='2' WHERE addon_author_name='".$key."'");
                $result = dbquery("DELETE FROM ".DB_ADDON_DEV_APPLY." WHERE apply_id='".$apply_id."'");     
        }
     }
if(isset($_POST['user_deny'])) {
        $Si['user_deny'] = stripinput_fix($_POST['user_deny']);
        foreach($Si['user_deny'] as $key) {
                $update = dbquery("UPDATE ".DB_ADDONS." SET addon_author_status='0' WHERE addon_author_name='".$key."'");
                $result = dbquery("DELETE FROM ".DB_ADDON_DEV_APPLY." WHERE apply_id='".$apply_id."'");
        }
     }
 }

opentable($locale['apdev001']);

                              $result = dbquery("SELECT 
				                                         a.apply_id, 
				                                         a.apply_user, 
				                                         a.apply_comment, 
				                                         u.user_id, 
				                                         u.user_name, 
				                                         u.user_status 
				                                         FROM ".DB_ADDON_DEV_APPLY." a
				                                         LEFT JOIN ".DB_USERS." u 
				                                         ON a.apply_user=u.user_id 
				                                         ORDER BY u.user_lastvisit DESC
				                                         ");
		echo "<form id='dev_approve' name='dev_approve' method='post' action='".FUSION_SELF.$aidlink."'>\n";
		echo "<table cellpadding='0' cellspacing='0' width='950' class='tbl-border'>\n<tr>\n";
        echo "<th colspan='4' class='forum-caption'>".$locale['apdev030']."</th>\n";
        echo "</tr>\n<tr>\n";
        echo "<td claas='tbl1' colspan='2'>&nbsp;</td>\n";
        
        if (dbrows($result)) {
        echo "<td class='tbl1'>".$locale['apdev032']."</td>\n";
        echo "<td class='tbl1'>".$locale['apdev033']."</td>\n";
        echo "</tr>\n<tr>\n";               
				              
				              while ($data = dbarray($result)) {
				              
		echo "<td class='tbl1' valign='top'>".$locale['apdev003']."</td>";
        echo "<td claas='tbl1' valign='top'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."</td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' valign='top'>".$locale['apdev004']."</td>";
        echo "<td claas='tbl1' valign='top'>".$data['apply_comment']."</td>";
        echo "<td class='tbl1' align='center'><label><input type='checkbox' name='user_approve[]' value='".$data['user_name']."' /></label></td>\n";
	    echo "<td class='tbl1' align='center'><label><input type='checkbox' name='user_deny[]' value='".$data['user_name']."' /></label></td>\n";
        echo "</tr>\n<tr>\n";
        echo "<td claas='tbl1' colspan='4'><hr /></td>\n";
        echo "</tr>\n";
        echo "<input type='hidden' name='apply_id' value='".$data['apply_id']."' />";        	                     
		      }
		echo "<tr>\n<td class='tbl2' colspan='4' align='center'><input type='submit' name='dev_approve' value='".$locale['apdev031']."' class='button' />\n";
		echo "&nbsp;<input type='submit' name='cancel' value='".$locale['apdev034']."' class='button' /></td>\n";
		echo "</tr>\n</table>\n</form>\n";
				              
		} else { echo "<tr>\n<td class='tbl1' align='center' colspan='4'>".$locale['apdev035']."</td>\n</tr>\n</table>\n</form>\n"; }


closetable();

echo "<br />\n";
opentable($locale['apdev036']);
 
				               $result = dbquery("SELECT a.addon_id, 
				                                         a.addon_name, 
				                                         a.addon_author_name, 
				                                         a.addon_author_status, 
				                                         u.user_id, 
				                                         u.user_name,
				                                         u.user_joined, 
				                                         u.user_lastvisit,  
				                                         u.user_status 
				                                         FROM ".DB_ADDONS." a
				                                         LEFT JOIN ".DB_USERS." u 
				                                         ON a.addon_submitter_id=u.user_id 
				                                         WHERE a.addon_status = '0' 
				                                         AND a.addon_author_status = '2' 
				                                         ORDER BY a.addon_author_name ASC
				                                         ");
       

		echo "<table cellpadding='0' cellspacing='0' width='950' class='tbl-border'>\n<tr>\n";
        echo "<th colspan='4' class='forum-caption'>".$locale['apdev030']."</th>\n";
        echo "</tr>\n<tr>\n";
        echo "<td claas='tbl1' colspan='4'>&nbsp;</td>\n";
        echo "</tr>\n<tr>\n";
        
  if(dbrows($result) != 0) {

        echo "<td class='tbl1'>".$locale['apdev003']."</td>\n";
        echo "<td class='tbl1' align='center'>".$locale['apdev037']."</td>\n";
        echo "<td class='tbl1'>".$locale['apdev038']."</td>\n";
        echo "<td class='tbl1'>".$locale['apdev039']."</td>\n";
        echo "</tr>\n";

		while ($data = dbarray($result)) {
		$addon_count = dbcount("(addon_id)", DB_ADDONS, "addon_submitter_id = '".$data['user_id']."'");
         echo "<tr>\n<td claas='tbl1' valign='top'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."</td>";
         echo "<td claas='tbl1' valign='top' align='center'>".$addon_count."</td>";
         echo "<td claas='tbl1' valign='top'>".showdate("shortdate", $data['user_joined'])."</td>";
         echo "<td claas='tbl1' valign='top'>".showdate("shortdate", $data['user_lastvisit'])."</td>";
         echo "</tr>\n";
        }
        echo "</table>\n";
   } else { echo "<td class='tbl1' align='center' colspan='4'>".$locale['apdev040']."</td>\n</tr>\n</table>\n";
 }
closetable();

require_once THEMES."templates/footer.php";
?>