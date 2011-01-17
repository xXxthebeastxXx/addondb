<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: condolences_admin.php
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
require_once THEMES."templates/admin_header.php";
include INFUSIONS."book_of_condolences/infusion_db.php";
require_once INCLUDES."bbcode_include.php";

if (!checkrights("MSFN") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

if (file_exists(INFUSIONS."book_of_condolences/locale/".$settings['locale'].".php")) {
	include INFUSIONS."book_of_condolences/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."book_of_condolences/locale/English.php";
}

if (isset($_GET['rowstart']) && isnum($_GET['rowstart'])) {
		$rowstart = $_GET['rowstart'];
	    } else {
		$rowstart = 0; }

$limit = "20";
$counter = (dbcount("(m4n_id)", DB_CONDOLENCES));

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

if (isset($_POST['process_cond'])) {
if(isset($_POST['cond_approve'])) {
        $Si['cond_approve'] = stripinput_fix($_POST['cond_approve']);
        foreach($Si['cond_approve'] as $key) {
                $update = dbquery("UPDATE ".DB_CONDOLENCES." SET m4n_status='1', m4n_admin='".$userdata['user_id']."' WHERE m4n_user='".$key."'");        
        }
     }

if(isset($_POST['cond_deny'])) {
        $Si['cond_deny'] = stripinput_fix($_POST['cond_deny']);
        foreach($Si['cond_deny'] as $key) {
                $update = dbquery("UPDATE ".DB_CONDOLENCES." SET m4n_status='2', m4n_admin='".$userdata['user_id']."' WHERE m4n_user='".$key."'");        
        }
     }
 }

 if (isset($_GET['action']) && ($_GET['action'] == 1)) {
     $result = dbquery("DELETE FROM ".DB_CONDOLENCES." WHERE m4n_id='".$_GET['action_id']."'");
  }

opentable($locale['m4n_001']);

            $result = dbquery(
            "SELECT a.m4n_id, a.m4n_user, a.m4n_status, a.m4n_admin, a.m4n_text, a.m4n_datestamp, u.user_id, u.user_name, u.user_status
			FROM ".DB_CONDOLENCES." a
			LEFT JOIN ".DB_USERS." u ON u.user_id=a.m4n_user 
			WHERE a.m4n_status = '0'
			ORDER BY m4n_datestamp
			DESC LIMIT 0,$limit
		");

if (dbrows($result)) {
     echo "<form id='process_cond' name='process_cond' method='post' action='".FUSION_SELF.$aidlink."'>\n";
     echo "<table width='100%' class='tbl-border'>\n<tr>\n";
     echo "<th class='forum-caption' colspan='5'>".$locale['m4n_002']."</th>\n";
     echo "</tr>\n<tr>\n";
     echo "<td class='tbl1'>".$locale['m4n_016']."</td>\n";
     echo "<td class='tbl1'>".$locale['m4n_017']."</td>\n";
     echo "<td class='tbl1'>".$locale['m4n_018']."</td>\n";
     echo "<td class='tbl1' align='center'>".$locale['m4n_007']."</td>\n";
     echo "<td class='tbl1' align='center'>".$locale['m4n_008']."</td>\n";
     echo "</tr>\n";

	while($data = dbarray($result)) {
	echo "<tr>\n<td class='tbl2' valign='top'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."</td>\n";
	echo "<td class='tbl2'>";
	$text = nl2br(parseubb(censorwords($data['m4n_text'])));
	echo (isset($text) ? $text : "");
	echo "</td>\n";
	echo "<td class='tbl2' valign='top'>".showdate("%d/%m/%Y", $data['m4n_datestamp'])."</td>\n";
	echo "<td class='tbl2' width='1%' align='center'><label><input type='checkbox' name='cond_approve[]' value='".$data['user_id']."' /></label></td>\n";
	echo "<td class='tbl2' width='1%' align='center'><label><input type='checkbox' name='cond_deny[]' value='".$data['user_id']."' /></label></td>\n";
	echo "</tr>\n";
	}

	echo "<tr>\n<td class='tbl1' colspan='5' align='center'><input type='submit' name='process_cond' value='".$locale['m4n_006']."' class='button' />\n";
	echo "</tr>\n</table>\n</form>\n";
} else { echo "<table width='100%' class='tbl-border'>\n<tr>\n";
         echo "<th class='forum-caption'>".$locale['m4n_002']."</th>\n";
         echo "</tr>\n<tr>\n";
         echo "<td>&nbsp;</td>\n";
         echo "</tr>\n<tr>\n";
         echo "<tr>\n<td class='tbl1' colspan='5' align='center'>".$locale['m4n_004']."</td>\n";
         echo "</tr>\n</table>\n"; }

closetable();

opentable($locale['m4n_003']);

            $result = dbquery(
            "SELECT a.m4n_id, a.m4n_user, a.m4n_status, a.m4n_admin, a.m4n_text, a.m4n_datestamp, u.user_id, u.user_name, u.user_status
			FROM ".DB_CONDOLENCES." a
			LEFT JOIN ".DB_USERS." u ON u.user_id=a.m4n_user 
			WHERE a.m4n_status = '1'
			ORDER BY m4n_datestamp
			DESC LIMIT $rowstart,$limit
			");

     echo "<table border='0' width='100%' class='tbl-border'>\n<tr>\n";
     echo "<th class='forum-caption' colspan='4'>".$locale['m4n_003']."</th>\n";
     echo "</tr>\n<tr>\n";
     echo "<td class='tbl1'>".$locale['m4n_016']."</td>\n";
     echo "<td class='tbl1'>".$locale['m4n_017']."</td>\n";
     echo "<td class='tbl1'>".$locale['m4n_018']."</td>\n";
     echo "<td class='tbl1'>".$locale['m4n_019']."</td>\n";
     echo "</tr>\n";

if (dbrows($result)) {

	while($data = dbarray($result)) {
	echo "<tr>\n<td class='tbl2' valign='top'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."</td>\n";
	echo "<td class='tbl2'>";
	$text = nl2br(parseubb(censorwords($data['m4n_text'])));
	echo (isset($text) ? $text : "");
	echo "</td>\n";
	echo "<td class='tbl2' valign='top'>".showdate("%d/%m/%Y", $data['m4n_datestamp'])."</td>\n";
	$get_admin = dbarray(dbquery("SELECT user_id, user_name, user_status FROM ".DB_USERS." WHERE user_id = '".$data['m4n_admin']."'"));
	echo "<td class='tbl2' valign='top'>".profile_link($get_admin['user_id'], $get_admin['user_name'], $get_admin['user_status'])."</td>\n";
	echo "</tr>\n";
	}

} else { echo "<tr>\n<td class='tbl1' align='center' colspan='4'>".$locale['m4n_005']."</td>\n</tr>\n"; }
	echo "</table>\n";

closetable();

opentable($locale['m4n_020']);

            $result = dbquery(
            "SELECT a.m4n_id, a.m4n_user, a.m4n_status, a.m4n_admin, a.m4n_text, a.m4n_datestamp, u.user_id, u.user_name, u.user_status
			FROM ".DB_CONDOLENCES." a
			LEFT JOIN ".DB_USERS." u ON u.user_id=a.m4n_user 
			WHERE a.m4n_status = '2'
			ORDER BY m4n_datestamp
			DESC LIMIT 0,$limit
		");

     echo "<table border='0' width='100%' class='tbl-border'>\n<tr>\n";
     echo "<th class='forum-caption' colspan='5'>".$locale['m4n_020']."</th>\n";
     echo "</tr>\n<tr>\n";
     echo "<td class='tbl1'>".$locale['m4n_016']."</td>\n";
     echo "<td class='tbl1'>".$locale['m4n_017']."</td>\n";
     echo "<td class='tbl1'>".$locale['m4n_018']."</td>\n";
     echo "<td class='tbl1'>".$locale['m4n_013']."</td>\n";
     echo "<td class='tbl1'>".$locale['m4n_027']."</td>\n";
     echo "</tr>\n";
     
if (dbrows($result)) {
	while($datab = dbarray($result)) {
	echo "<tr>\n<td class='tbl2' valign='top'>".profile_link($datab['user_id'], $datab['user_name'], $datab['user_status'])."</td>\n";
	echo "<td class='tbl2'>";
	$text = nl2br(parseubb(censorwords($datab['m4n_text'])));
	echo (isset($text) ? $text : "");
	echo "</td>\n";
	echo "<td class='tbl2' valign='top'>".showdate("%d/%m/%Y", $datab['m4n_datestamp'])."</td>\n";
	$get_admin = dbarray(dbquery("SELECT user_id, user_name, user_status FROM ".DB_USERS." WHERE user_id = '".$datab['m4n_admin']."'"));
	echo "<td class='tbl2' valign='top'>".profile_link($get_admin['user_id'], $get_admin['user_name'], $get_admin['user_status'])."</td>\n";
	echo "<td class='tbl2' valign='top'><a href='".FUSION_SELF.$aidlink."&action=1&action_id=".$datab['m4n_id']."'>".$locale['m4n_028']."</a></td>\n";
		echo "</tr>\n";

	}
} else { echo "<tr>\n<td class='tbl1' colspan='5' align='center'>".$locale['m4n_021']."</td>\n</tr>\n"; }
	echo "</table>\n";

closetable();

if ($counter > $limit) { echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart, $limit, $counter, 3, FUSION_SELF.$aidlink."&amp;")."</div>"; }

require_once THEMES."templates/footer.php";

?>