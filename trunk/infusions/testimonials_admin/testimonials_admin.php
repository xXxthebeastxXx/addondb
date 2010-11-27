<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: testimonials_admin.php
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

if (!checkrights("M") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

if (file_exists(INFUSIONS."testimonials_admin/locale/".$settings['locale'].".php")) {
	include INFUSIONS."testimonials_admin/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."testimonials_admin/locale/English.php";
}

$limit = "10";

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

if (isset($_POST['approve_test'])) {
if(isset($_POST['user_approve'])) {
        $Si['user_approve'] = stripinput_fix($_POST['user_approve']);
        foreach($Si['user_approve'] as $key) {
                $update = dbquery("UPDATE ".DB_USERS." SET user_approve='0' WHERE user_id='".$key."'");        
        }
     }
if(isset($_POST['user_deny'])) {
        $Si['user_deny'] = stripinput_fix($_POST['user_deny']);
        foreach($Si['user_deny'] as $key) {
                $update = dbquery("UPDATE ".DB_USERS." SET user_testimonial='' WHERE user_id='".$key."'");
                $update = dbquery("UPDATE ".DB_USERS." SET user_approve='1' WHERE user_id='".$key."'");        
        }
     }
 }

opentable($locale['ltp_001']);

              $result=dbquery("
                               SELECT 
                               user_id, 
                               user_name, 
                               user_status, 
                               user_testimonial, 
                               user_approve  
                               FROM ".DB_USERS." 
                               WHERE user_status = '0' 
                               AND user_testimonial !='' 
                               AND user_approve ='1'
                               ORDER BY user_lastvisit 
                               DESC LIMIT 0,$limit
                               ");
if (dbrows($result)) {
     echo "<form id='approve_test' name='approve_test' method='post' action='".FUSION_SELF.$aidlink."'>\n";
     echo "<table width='100%' class='tbl-border'>\n<tr>\n";
     echo "<th class='forum-caption' colspan='4'>".$locale['ltp_002']."</th>\n";
     echo "</tr>\n<tr>\n";
     echo "<td colspan='2'>&nbsp;</td>\n";
     echo "<td class='tbl1' align='center'>".$locale['ltp_007']."</td>\n";
     echo "<td class='tbl1' align='center'>".$locale['ltp_008']."</td>\n";
     echo "</tr>\n";

	while($data = dbarray($result)) {
	echo "<tr>\n<td class='tbl1'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."</td>\n";
	echo "<td class='tbl2'>";
	$text = nl2br(parseubb(censorwords($data['user_testimonial'])));
	echo (isset($text) ? $text : "");
	echo "</td>\n";
	echo "<td class='tbl2' align='center'><label><input type='checkbox' name='user_approve[]' value='".$data['user_id']."' /></label></td>\n";
	echo "<td class='tbl2' align='center'><label><input type='checkbox' name='user_deny[]' value='".$data['user_id']."' /></label></td>\n";
	echo "</tr>\n";
	}
	echo "<tr>\n<td class='tbl2' colspan='4' align='center'><input type='submit' name='approve_test' value='".$locale['ltp_006']."' class='button' />\n";
	echo "</tr>\n</table>\n</form>\n";
} else { echo "<table width='100%' class='tbl-border'>\n<tr>\n";
         echo "<th class='forum-caption'>".$locale['ltp_002']."</th>\n";
         echo "</tr>\n<tr>\n";
         echo "<td>&nbsp;</td>\n";
         echo "</tr>\n<tr>\n";
         echo "<tr>\n<td class='tbl1' align='center'>".$locale['ltp_004']."</td>\n";
         echo "</tr>\n</table>\n"; }

$counter = (dbcount("(user_id)", DB_USERS, "user_approve !='1' && user_testimonial != '' && user_status = '0'"));
if (isset($_GET['rowstart']) && isnum($_GET['rowstart'])) {
		$rowstart = $_GET['rowstart'];
	    } else {
		$rowstart = 0;
	}

$limit = "20";
              
              $result=dbquery("
                               SELECT 
                               user_id, 
                               user_name, 
                               user_status, 
                               user_testimonial 
                               FROM ".DB_USERS." 
                               WHERE user_status = '0' 
                               AND user_testimonial !='' 
                               AND user_approve !='1' 
                               ORDER BY user_lastvisit 
                               DESC LIMIT $rowstart,$limit
                               ");
 
     echo "<table border='0' width='100%' class='tbl-border'>\n<tr>\n";
     echo "<th class='forum-caption' colspan='2'>".$locale['ltp_003']."</th>\n";
     echo "</tr>\n<tr>\n";
     echo "<td colspan='2'>&nbsp;</td>\n";
     echo "</tr>\n";
if (dbrows($result)) {
	while($data = dbarray($result)) {
	echo "<tr>\n<td class='tbl1'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."</td>\n";
	echo "<td class='tbl2'>";
	$text = nl2br(parseubb(censorwords($data['user_testimonial'])));
	echo (isset($text) ? $text : "");
	echo "</td>\n</tr>\n";
	}
} else { echo "<tr>\n<td class='tbl1'>".$locale['ltp_005']."</td>\n</tr>\n"; }
	echo "</table>\n";

closetable();

if ($counter > $limit) { echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart, $limit, $counter, 3, FUSION_SELF.$aidlink."&amp;")."</div>"; }

require_once THEMES."templates/footer.php";
?>