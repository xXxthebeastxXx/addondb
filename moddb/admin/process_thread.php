<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: process_thread.php
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
require_once INCLUDES."bbcode_include.php";

if (file_exists(INFUSIONS."moddb/locale/".LOCALESET."admin/thread_create.php")) {
	include INFUSIONS."moddb/locale/".LOCALESET."admin/thread_create.php";
} else {
	include INFUSIONS."moddb/locale/English/admin/thread_create.php";
}
	
	$mod_id = ($_REQUEST['mod_id']);
	$tcdata = dbarray(dbquery("SELECT * FROM ".DB_MODS." WHERE mod_status = '0' AND mod_id = '".$mod_id."'"));
	add_to_title(" | ".$locale['moddb600']." | ".$tcdata['mod_name']);
	$name = $tcdata['mod_name'];

	$result = dbquery("SELECT thread_id, thread_subject FROM ".DB_THREADS." WHERE thread_subject = '$name'");
	if (dbrows($result) != 0) { 
	    opentable($locale['moddb700'].$locale['moddb703'].$name);
           echo "<br /><div align='center'>";
		   echo $locale['moddb706'];
		   echo "<br />";
		   echo $locale['moddb707'];
		   echo "<br /><br />";
	while ($data = dbarray($result)) { 
           echo "<a href='".BASEDIR."forum/viewthread.php?thread_id=".$data['thread_id']."'>".$data['thread_subject']."</a>";
		   echo "<br />";
		}
		echo "<br /></div>\n";
   closetable();
		   	   
              } else {
              
    $thread_subject = "".$tcdata['mod_name']."";
    $thread_author = "".$tcdata['mod_submitter_id']."";
    $post_message = "".$tcdata['mod_description']."";
              
    if (isset($_POST['postmodthread'])) {
	$forum_id = stripinput($_POST['forum_id']);
	$thread_subject = stripinput($_POST['thread_subject']);
	$thread_author = stripinput($_POST['thread_author']);
	$thread_id = stripinput($_POST['thread_id']);
    $post_message = stripinput($_POST['post_message']);
	
	$result = dbquery("INSERT INTO ".DB_THREADS." (forum_id, thread_subject, thread_author, thread_views, thread_lastpost, thread_lastpostid, thread_lastuser, thread_postcount) VALUES('".$forum_id."', '".$thread_subject."', '".$thread_author."', '0', '".time()."', '0', '".$thread_author."', '1')");
	$thread_id = mysql_insert_id();
	
	$result = dbquery("INSERT INTO ".DB_POSTS." (forum_id, thread_id, post_message, post_showsig, post_author, post_datestamp, post_ip, post_edituser, post_edittime) VALUES ('".$forum_id."', '$thread_id', '".$post_message."', '0', '".$thread_author."', '".time()."', '".$locale['moddb701']."', '0', '0')");
	$post_id = mysql_insert_id();
	
	$result = dbquery("UPDATE ".DB_FORUMS." SET forum_lastpost='".time()."', forum_postcount=forum_postcount+1, forum_threadcount=forum_threadcount+1, forum_lastuser='".$thread_author."' WHERE forum_id='".$forum_id."'");
	$result = dbquery("UPDATE ".DB_THREADS." SET thread_lastpostid='".$post_id."' WHERE thread_id='".$thread_id."'");
	$result = dbquery("UPDATE ".DB_USERS." SET user_posts=user_posts+1 WHERE user_id='".$thread_author."'");
	
	redirect(INFUSIONS."moddb/admin/submissions.php".$aidlink); }

	$catdata = dbarray(dbquery("SELECT mod_cat_id, mod_cat_name FROM ".DB_MOD_CATS." WHERE ".$tcdata['mod_cat_id']." = mod_cat_id"));
	opentable($locale['moddb700'].$locale['moddb703'].$name);

	echo "<form name='inputform' method='post' action='".FUSION_SELF.$aidlink."' enctype='multipart/form-data'>";
    echo "<table cellpadding='0' cellspacing='1' width='90%' class='center tbl-border'>\n<tr>\n";
    
    if ($tcdata['mod_submitter_id'] != '0') { $submitinfo = "<b>".$name." ".$locale['moddb704']." <a href='".BASEDIR."profile.php?lookup=".$tcdata['mod_submitter_id']."'>".$tcdata['mod_submitter_name']."</a></b>"; 
      } else { 
      $submitinfo = "<b>".$name." ".$locale['moddb704']." ".$tcdata['mod_author_name']."</b>"; }
    
    
    echo "<td class='tbl1' align='center' colspan='2'><b>".$submitinfo."<br />".$catdata['mod_cat_name']."</td>";
    echo "<tr>\n</tr>";
    echo "<td class='tbl1'>".$locale['moddb602'].":</td>";
    echo "<td class='tbl1' nowrap valign='top'>";
    echo "<label><input type='radio' name='forum_id' value='60' checked='checked' />&nbsp;".$locale['moddb709']."</label><br />\n";
	echo "<label><input type='radio' name='forum_id' value='69' />&nbsp;".$locale['moddb708']."</label></td>\n";
	echo "</td>\n";
	echo "</tr>\n<tr>";
	echo "<td class='tbl1'>".$locale['moddb705']."</td>";
	$mod_location = ("".$locale['moddb711']."[URL=http://mods.php-fusion.co.uk/infusions/moddb/view.php?mod_id=".$mod_id."][img]http://mods.php-fusion.co.uk/infusions/moddb/img/view-mod.gif[/img][/URL]");
	echo "<td class='tbl1' valign='top'><textarea name='post_message' rows='6' cols='44' class='textbox' style='width:400px;' />".stripslashes($post_message).$mod_location."</textarea><br /></td>\n</tr>\n";
	echo "<tr>\n<td class='tbl1' align='center' colspan='2'>".display_bbcodes("99%", "post_message")."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' align='center' colspan='2' nowrap valign='top'>\n";
	echo "<input type='hidden' class='textbox' name='thread_subject' value='".$tcdata['mod_name']."'>\n";
	echo "<input type='hidden' class='textbox' name='thread_author' value='".$tcdata['mod_submitter_id']."'>\n";
	echo "<br /><input type='submit' name='postmodthread' value='".$locale['moddb700']."' class='button' /><br /></td>";
	echo "</form>\n";
	echo "</tr>\n</table>\n";
	  }

	closetable();
	
require_once THEMES."templates/footer.php";
?>