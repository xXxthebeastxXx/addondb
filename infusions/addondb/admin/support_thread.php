<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: support_thread.php
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

if (!checkrights("ADNX") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { die("Access Denied"); }

require_once INFUSIONS."addondb/infusion_db.php";
require_once INFUSIONS."addondb/inc/inc.functions.php";
require_once INFUSIONS."addondb/inc/inc.nav.php";

if (file_exists(ADDON_LOCALE.LOCALESET."admin/support_thread.php")) {
	include ADDON_LOCALE.LOCALESET."admin/support_thread.php";
} else {
	include ADDON_LOCALE."English/admin/support_thread.php";
}
              
    if (isset($_POST['postaddonthread'])) {
    
    $addon_data = dbarray(dbquery("SELECT addon_id, addon_name, addon_description, addon_submitter_id, addon_img  FROM ".DB_ADDONS." WHERE addon_id  = '".$_REQUEST['addon_id']."'"));
    $status_check = dbarray(dbquery("SELECT addon_author_status FROM ".DB_ADDONS." WHERE addon_author_name = '".$addon_data['addon_submitter_id']."'"));
 
	$addon_id = stripinput($_POST['addon_id']);
	$addon_name = $addon_data['addon_name'];
	if ($addon_data['addon_img']) {
	$addon_description = ("[img]".$settings['siteurl']."infusions/addondb/img/screenshots/t_".$addon_data['addon_img']."[/img]");
	} else {
	$addon_description = ("[img]".$settings['siteurl']."infusions/addondb/img/addon_logo.png[/img]");
	}
	if ($status_check['addon_author_status'] == '2') {
	$addon_description .= ("[img]".$settings['siteurl']."infusions/addondb/img/approved_addon.png[/img]"); }
	$addon_description .= $addon_data['addon_description'];
	$addon_description .= ("".$locale['addondb711']."[addon=".$addon_id."]".$locale['addondb605']."[/addon]");
	$addon_submitter = $addon_data['addon_submitter_id'];
	$forum_id = stripinput($_POST['forum_id']);
	$thread_id = stripinput($_POST['thread_id']);
	
	$result = dbquery("INSERT INTO ".DB_THREADS." (forum_id, thread_subject, thread_author, thread_views, thread_lastpost, thread_lastpostid, thread_lastuser, thread_postcount) VALUES('".$forum_id."', '".$addon_name."', '".$addon_submitter."', '0', '".time()."', '0', '".$addon_submitter."', '1')");
	$thread_id = mysql_insert_id();
	
	$result = dbquery("UPDATE ".DB_ADDONS." SET addon_forum_status='2' WHERE addon_id='".$_REQUEST['addon_id']."'");
	
	$result = dbquery("INSERT INTO ".DB_POSTS." (forum_id, thread_id, post_message, post_showsig, post_author, post_datestamp, post_ip, post_edituser, post_edittime) VALUES ('".$forum_id."', '$thread_id', '".$addon_description."', '0', '".$addon_submitter."', '".time()."', '".$locale['addondb701']."', '0', '0')");
	$post_id = mysql_insert_id();
	
	$result = dbquery("UPDATE ".DB_FORUMS." SET forum_lastpost='".time()."', forum_postcount=forum_postcount+1, forum_threadcount=forum_threadcount+1, forum_lastuser='".$addon_submitter."' WHERE forum_id='".$forum_id."'");
	$result = dbquery("UPDATE ".DB_THREADS." SET thread_lastpostid='".$post_id."' WHERE thread_id='".$thread_id."'");
	$result = dbquery("UPDATE ".DB_USERS." SET user_posts=user_posts+1 WHERE user_id='".$addon_submitter."'");
	
	redirect(FUSION_SELF.$aidlink); 
	
	} else {
	
	opentable($locale['addondb700']);

	echo "<form name='inputform' method='post' action='".FUSION_SELF.$aidlink."' enctype='multipart/form-data'>";
    echo "<table cellpadding='0' cellspacing='1' width='90%' class='center tbl-border'>\n<tr>\n";
    echo "<td class='tbl1'>".$locale['addondb603'].":</td>";
    echo "<td class='tbl1' nowrap valign='top'>";
    
    
            $acat_list = ""; $sel = ""; $data_acat = "";
			$result = dbquery("SELECT * FROM ".DB_ADDONS." WHERE addon_status = '0' AND addon_forum_status = '0' ORDER BY addon_date DESC");
			if (dbrows($result) != 0) {
		    while ($datam = dbarray($result)) {
		    $sel = ($data_acat == $datam['addon_name'] ? " selected='selected'" : "");
		    $acat_list .= "<option value='".$datam['addon_id']."'$sel>".$datam['addon_name']."</option>\n";
				}
				 }
	echo "<select name='addon_id' class='textbox' style='width:300px;'>\n<option value='0'>".$locale['addondb604']."</option>\n".$acat_list."</select>\n";
    
    echo "</td>\n";
	echo "</tr>\n<tr>";
	
	echo "<td class='tbl1'>".$locale['addondb602'].":</td>";
    echo "<td class='tbl1' nowrap valign='top'>";
	
	
	       $fcat_list = ""; $sel = ""; $data_fcat = "";
			$result = dbquery("SELECT * FROM ".DB_FORUMS." WHERE forum_id = '77' OR forum_id = '78' OR forum_id = '79' OR forum_id = '80' AND forum_access = '0' ORDER BY forum_name ASC");
			if (dbrows($result) != 0) {
		    while ($datam = dbarray($result)) {
		    $sel = ($data_fcat == $datam['forum_name'] ? " selected='selected'" : "");
		    $fcat_list .= "<option value='".$datam['forum_id']."'$sel>".$datam['forum_name']."</option>\n";
				}
				 }
	echo "<select name='forum_id' class='textbox' style='width:300px;'>\n<option value='0'>".$locale['addondb604']."</option>\n".$fcat_list."</select>\n";
	
	echo "</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' align='center' colspan='2' nowrap valign='top'>\n";;
	echo "<br /><input type='submit' name='postaddonthread' value='".$locale['addondb700']."' class='button' /><br /></td>";
	echo "</form>\n";
	echo "</tr>\n</table>\n";

	closetable();
	}
	
require_once THEMES."templates/footer.php";
?>