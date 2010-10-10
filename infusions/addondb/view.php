<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: addon_view.php
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
require_once THEMES."templates/header.php";
require_once INCLUDES."comments_include.php";
require_once INCLUDES."ratings_include.php";
require_once INFUSIONS."addondb/infusion_db.php";
require_once INFUSIONS."addondb/inc/inc.functions.php";
include INFUSIONS."addondb/locale/".LOCALESET."addon_view.php";

if (isset($_GET['download']) && isnum($_GET['download'])) {
	$data = dbarray(dbquery("SELECT * FROM ".DB_ADDON_CATS." JOIN ".DB_ADDONS." USING(addon_cat_id) WHERE addon_id='".$_GET['download']."'"));
	if (checkgroup($data['addon_cat_access'])) {
		$result = dbquery("UPDATE ".DB_ADDONS." SET addon_download_count=(addon_download_count+1) WHERE addon_id='".$_GET['download']."'");
		require_once INCLUDES."class.httpdownload.php";
		redirect($addon_upload_dir.$data['addon_download']);
		ob_end_clean();
		$object = new httpdownload;
		$object->set_byfile($addon_upload_dir.$data['addon_download']);
		$object->use_resume = true;
		$object->download();
		exit;
	}
}

$addon_id = stripinput($_GET['addon_id']);
$q_addons = dbquery("SELECT * FROM ".DB_ADDON_CATS." JOIN ".DB_ADDONS." tm USING(addon_cat_id) JOIN ".DB_ADDON_VERSIONS." USING(version_id) JOIN ".DB_USERS." tu ON tm.addon_approved_user=tu.user_id WHERE addon_id='".$addon_id."'");
$d_addons = dbarray($q_addons);

if (!isnum($addon_id) || dbrows($q_addons) == 0 || ($d_addons['addon_status'] != 0 && !iSUPERADMIN && $d_addons['addon_status'] != 0)) {
	opentable($locale['addondb430']);
	echo "<center><br>".$locale['addondb431']."<br><br><a href='index.php'>".$locale['addondb433']."</a><br><br></center>";
	closetable();
} elseif (!checkgroup($d_addons['addon_cat_access'])) {
	opentable($locale['addondb430']);
	echo "<center><br>".$locale['addondb432']."<br><br><a href='index.php'>".$locale['addondb433']."</a><br><br></center>";
	closetable();
} else {
	$ver = "v".$d_addons['version_h'].".".$d_addons['version_l'].($d_addons['version_s'] != "" ? " ".$d_addons['version_s'] : "");
	$d_rating = dbarray(dbquery("SELECT SUM(rating_vote) sum_rating, COUNT(rating_item_id) count_votes FROM ".DB_RATINGS." WHERE rating_item_id='".$addon_id."' AND rating_type='M'"));
	$num_votes = $d_rating['count_votes'];
	if ($num_votes == 0) {
		$votecount = " [".$locale['addondb416']."]";
	} elseif ($num_votes == 1) {
		$votecount = " [1 ".$locale['addondb417']."]";
	} else {
		$votecount = " [".$num_votes." ".$locale['addondb418']."]";
	}
	$rating = ($num_votes > 0 ? str_repeat("<img src='".ADDON_IMG."star.png' alt='".$locale['addondb414']."'>",ceil($d_rating['sum_rating']/$num_votes)).$votecount : $votecount);
	$staff_rating = str_repeat("<img src='".ADDON_IMG."star.png' alt='".$locale['addondb414']."' />",$d_addons['addon_approved_rating']);
	$urlprefix = !strstr($d_addons['addon_author_www'], "http://") ? "http://" : "";
	$urlprefix_demo = !strstr($d_addons['addon_demo_url'], "http://") ? "http://" : "";

	if ($d_addons['addon_download_count'] == 0) {
		$download_count = "[0 ".$locale['addondb422']."]";
	} elseif ($d_addons['addon_download_count'] == 1) {
		$download_count = "[1 ".$locale['addondb407']."]";
	} else {
		$download_count = "[".$d_addons['addon_download_count']." ".$locale['addondb422']."]";
	}
	include ADDON_INC."view_nav.php";
	opentable($locale['addondb400'].$d_addons['addon_name']);
	
	if ($d_addons['addon_date'] + $settings_global['set_new_time'] > time() + ($settings['timeoffset'] * 3600)) { $new = "<img src='".ADDON_IMG."new.png' border='0' alt='' />";
    } else { 
    $new = ""; 
   }

	echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>
	<tr>
	<td width='155'>
	";
	if($d_addons['addon_img'] == "" || !file_exists(ADDON_SCRN."t_".$d_addons['addon_img'])) {
    echo "<img src='".ADDON_IMG."addon_logo.png'>";
	} else {
	add_to_head("<script type='text/javascript' src='lightbox/prototype.js'></script>
    <script type='text/javascript' src='lightbox/scriptaculous.js?load=effects,builder'></script>
    <script type='text/javascript' src='lightbox/lightbox.js'></script>
    <link rel='stylesheet' href='lightbox/lightbox.css' type='text/css' media='screen' />");
    echo"<div align='center'><a href='img/screenshots/".$d_addons['addon_img']."' rel='lightbox' style='outline: none;border:none;'>
    <img src='".ADDON_SCRN."t_".$d_addons['addon_img']."' style='outline: none;border:none;'></a></div>\n";
    }
	echo"<br />\n<center><img src='".ADDON_IMG."approved_addon.png' alt='' border='0' /></center>\n";
	if ($d_addons['addon_share_status']) {include ADDON_INC."share_links_include.php";}
	echo "</td>
	<td>
	<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>
	<tr>
	<td class='tbl2' width='80' nowrap><b>".$locale['addondb401'].":</b></td>
	<td class='tbl1' nowrap>".$new." ".$d_addons['addon_name']."</td>
	<td class='tbl1' nowrap rowspan='9' align='center'><b>".$locale['addondb421'].$d_addons['addon_name']."</b><br />
	<a href='".FUSION_SELF."?download=".$d_addons['addon_id']."' title='".$locale['addondb502']."'><img border='0' src='".ADDON_IMG."download.png' alt='' /></a><br />".$download_count."
	<br /><br />";
	echo $locale['addondb440']."[".parsebytesize(filesize(ADDON."files/".$d_addons['addon_download']))."]";
	echo "</td>
	</tr>
	<tr>
	<td class='tbl2' nowrap><b>".$locale['addondb402'].":</b></td>
	<td class='tbl1' nowrap>".$d_addons['addon_version']."</td>
	</tr>
	<tr>
	<td class='tbl2' nowrap><b>".$locale['addondb403'].":</b></td>
	<td class='tbl1' nowrap>".$d_addons['addon_cat_name']."</td>
	</tr>
	<tr>
	<td class='tbl2' nowrap><b>".$locale['addondb404'].":</b></td>
	<td class='tbl1' nowrap>".$ver."&nbsp;(".$addon_types[$d_addons['addon_type']].")</td>
	</tr>
	<tr>
	<td class='tbl2' nowrap><b>".$locale['addondb405'].":</b></td>\n";
	
	$user_auth = dbarray(dbquery("SELECT 
	                                     user_id, 
	                                     user_name,
	                                     user_hide_email,  
	                                     user_status 
	                                     FROM ".DB_USERS." 
	                                     WHERE 
	                                     user_name = '".$d_addons['addon_author_name']."'
	                                     "));
	                                     
		if ($user_auth['user_hide_email'] != "1" || iADMIN) {
		if ($d_addons['addon_author_email'] != "") { $author_email = "[<a href='mailto:".$d_addons['addon_author_email']."' title='".$locale['addondb500']."'>".$locale['addondb419']."</a>]"; }
		} else { $author_email = ""; }
		if ($d_addons['addon_author_www'] != "")  { $author_www = " [<a href='".$urlprefix.$d_addons['addon_author_www']."' target='_blank' title='".$locale['addondb501']."'>".$locale['addondb420']."</a>]";
	  } else { $author_www = ""; }

	echo "<td class='tbl1' nowrap>".(isset($user_auth['user_name']) ? profile_link($user_auth['user_id'], $user_auth['user_name'], $user_auth['user_status']) : $d_addons['addon_author_name'])." ".$author_email." ".$author_www."</td>
	</tr>\n";
	if ($d_addons['addon_co_author_name'] != "") {
	echo "<tr>
	<td class='tbl2' nowrap><b>".$locale['addondb405c'].":</b></td>
	<td class='tbl1' nowrap>".$d_addons['addon_co_author_name']."</td>
	</tr>\n"; }
	echo "<tr>
	<td class='tbl2' nowrap><b>".$locale['addondb406'].":</b></td>
	<td class='tbl1' nowrap>".strftime($settings['forumdate'],$d_addons['addon_date']+($settings['timeoffset']*3600))."</td>
	</tr>
	<tr>
	<td class='tbl2' nowrap><b>".$locale['addondb408'].":</b></td>
	<td class='tbl1' nowrap>".$rating."</td>
	</tr>
	<tr>
	<td class='tbl2' nowrap><b>".$locale['addondb429a']."</b></td>
	<td class='tbl1' nowrap>";
	if ($d_addons['addon_demo_url']) { echo "<a target='_blank' href='".$urlprefix_demo.$d_addons['addon_demo_url']."'>".$d_addons['addon_demo_url']."</a>"; } else { echo "---"; }
	echo "</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>
	
	<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>
	<tr>
	<td class='tbl2'><b>".$locale['addondb409']."</b></td>
	</tr>
	<tr>
	<td class='tbl1'>".nl2br(parsesmileys(parseubb($d_addons['addon_description'])))."</td>
	</tr>";

	echo "</table>";

	if ($d_addons['addon_copyright'] != "") {
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>
		<tr>
		<td class='tbl2'><b>".$locale['addondb410']."</b></td>
		</tr>
		<tr>
		<td class='tbl1'>".nl2br(parsesmileys(parseubb($d_addons['addon_copyright'])))."</td>
		</tr>
		</table>";
		}

	if ($d_addons['addon_approved_user'] != 0) {
	
	
	$user_approve = dbarray(dbquery("SELECT 
	                                     user_id, 
	                                     user_name,  
	                                     user_status 
	                                     FROM ".DB_USERS." 
	                                     WHERE 
	                                     user_name = '".$d_addons['user_name']."'
	                                     "));
	
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>
		<tr>
		<td class='tbl2' width='12%' nowrap><b>".$locale['addondb411'].":</b></td>
		<td class='tbl1' width='*'>".profile_link($user_approve['user_id'], $d_addons['user_name'], $user_approve['user_status'])."</td>
		<td class='tbl2' width='12%' nowrap><b>".$locale['addondb412'].":</b></td>
		<td class='tbl1' width='20%'>".str_repeat("<img src='".INFUSIONS."addondb/img/star.png' alt='".$locale['addondb414']."'>",$d_addons['addon_approved_rating'])."</td>
		</tr>
		<tr>\n";
		
		echo "<td class='tbl2' valign='top' nowrap><b>".$locale['addondb413'].":</b></td>
		<td class='tbl1' colspan='3'>";
		if ($d_addons['addon_approved_comment']) { echo nl2br(parsesmileys(parseubb($d_addons['addon_approved_comment']))); } else { echo $locale['addondb439']; }
		echo "</td>";
		echo "</tr>";
        
        $result = dbquery("SELECT t.thread_id, t.thread_author, t.thread_subject, a.addon_name, a.addon_submitter_name   
                          FROM ".DB_THREADS." t 
                          LEFT JOIN ".DB_ADDONS." a 
                          ON t.thread_author=a.addon_submitter_name
                          WHERE t.thread_subject ='".$d_addons['addon_name']."'
                          ");

        if (dbrows($result) != 0) { 
	    echo "<tr><td class='tbl2' width='12%' nowrap><b>".$locale['addondb429']."</b></td>";
	    echo "<td class='tbl2' colspan='3'>";
	    while ($data = dbarray($result)) { 
	    echo "<a href='".BASEDIR."forum/viewthread.php?thread_id=".$data['thread_id']."'>".$data['thread_subject']."</a>"; }
	    echo "</td></tr>"; }
        
        echo"<tr>
		<td class='tbl2' width='12%' nowrap><b>".$locale['addondb427']."</b></td>
		<td class='tbl1' width='*'>";
		$trans="";
		$result1 = dbquery("SELECT * FROM ".DB_ADDON_TRANS." WHERE trans_mod='".$d_addons['addon_id']."' ORDER BY trans_type ASC");
		if (dbrows($result1)) {
		 while ($data1 = dbarray($result1)) {
				$trans .= "<a href='".$trans_upload_dir.$data1['trans_file']."' target='_BLANK'>".get_addon_language($data1['trans_type'])."</a>, ";
				}
		} else {
			$trans = $locale['addondb511'];
		}
				
		echo"$trans</td>
		<td class='tbl2' width='12%' nowrap><b>".$locale['addondb428']."</b></td>
		<td class='tbl1' width='20%'>";
		if (iMEMBER) {
		echo "<span class='small'><img src='".ADDON_IMG."error.png' border='0' alt='".$locale['addondb503']."' />&nbsp;
		<a href ='".ADDON."error.php?error=1&addon_id=".$d_addons['addon_id']."' title='".$locale['addondb503']."'>".$locale['addondb503']."</a></span><br /><br />
		<span class='small'><img src='".ADDON_IMG."translate.png' border='0' alt='".$locale['addondb506']."' />&nbsp;
		<a href ='".ADDON."error.php?error=4&addon_id=".$d_addons['addon_id']."' title='".$locale['addondb506']."'>".$locale['addondb506']."</a></span>\n"; } else { echo $locale['addondb438']; }
		echo "</td>
		</tr>	
		";
		if (checkrights("ADNX")) {
			if ($d_addons['addon_status'] != 3) {
				$suspended =  " | <a href='admin/index.php".$aidlink."&amp;action=suspend&amp;addon_id=".$d_addons['addon_id']."'>".$locate['addondb425']."</a>";
			} else {
				$suspended = " | <span style='color:red;font-weight:bold;'>".$locate['addondb426']."</span>";
			}
			echo "<tr>
			<td class='tbl2' valign='top'><b>".$locale['addondb423'].":</b></td>
			<td class='tbl1' colspan='3'><a href='admin/index.php".$aidlink."&amp;action=edit&amp;addon_cat_id=".$d_addons['addon_cat_id']."&amp;addon_id=".$d_addons['addon_id']."'>".$locate['addondb424']."</a>".$suspended." | <a href='admin/submissions.php".$aidlink."&tran=".$d_addons['addon_id']."' title='".$locale['addondb510']."'>".$locale['addondb509']."</a></td>
			</tr>";
		}
		echo "</table>";
	}
	closetable();
	
// Other Addons by...

	$result = dbquery("SELECT * FROM ".DB_ADDONS." WHERE addon_author_name = '".$d_addons['addon_author_name']."' AND addon_id != '".$d_addons['addon_id']."' AND addon_status = '0' ORDER BY addon_download_count DESC");
	if (dbrows($result) != 0) { 

	opentable($locale['addondb512'].$d_addons['addon_author_name']);
	
	echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'><tr>\n";
	echo "<th class='forum-caption'><b>".$locale['addondb403']."</b></th>\n
	<th class='forum-caption'><b>".$locale['addondb401']."</b></th>\n
	<th class='forum-caption'><b>".$locale['addondb422']."</b></th>\n
	<th class='forum-caption' width='120'><b>".$locale['addondb412']."</b></th>\n</tr>\n";
	
	while ($data = dbarray($result)) {
	
	$sf_rating = str_repeat("<img src='".ADDON_IMG."star.png' alt='".$locale['addondb414']."' />",$data['addon_approved_rating']);
	$cat_data = dbarray(dbquery("SELECT addon_cat_name FROM ".DB_ADDON_CATS." WHERE addon_cat_id = '".$data['addon_cat_id']."'"));
	echo "<tr>\n<td class='tbl2'>".$cat_data['addon_cat_name']."</td>\n";
	echo "<td class='tbl2'>&nbsp;<a href='".ADDON."view.php?addon_id=".$data['addon_id']."'> ".$data['addon_name']."</a></td>\n";
	echo "<td align='center' class='tbl2'>".$data['addon_download_count']."</td>\n";
	echo "<td align='center' class='tbl2'>".$sf_rating."</td>\n</tr>";
	}
	echo "</table>\n"; 
	closetable();
	
	}
	
// Addons Co-Authored by...

	$result = dbquery("SELECT * FROM ".DB_ADDONS." WHERE addon_co_author_name = '".$d_addons['addon_author_name']."' AND addon_id != '".$d_addons['addon_id']."' AND addon_status = '0' ORDER BY addon_download_count DESC");
	if (dbrows($result) != 0) {
	opentable($locale['addondb513'].$d_addons['addon_author_name']);
	echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'><tr>\n";
	echo "<th class='forum-caption'><b>".$locale['addondb403']."</b></th>\n
	<th class='forum-caption'><b>".$locale['addondb401']."</b></th>\n
	<th class='forum-caption'><b>".$locale['addondb405']."</b></th>\n
	<th class='forum-caption'><b>".$locale['addondb422']."</b></td>\n
	<th class='forum-caption' width='120'><b>".$locale['addondb412']."</b></td>\n</tr>\n";
	
	while ($data = dbarray($result)) {
	
	$sf_rating = str_repeat("<img src='".ADDON_IMG."star.png' alt='".$locale['addondb414']."' />",$data['addon_approved_rating']);
	$cat_data = dbarray(dbquery("SELECT addon_cat_name FROM ".DB_ADDON_CATS." WHERE addon_cat_id = '".$data['addon_cat_id']."'"));
	echo "<tr>\n<td class='tbl2'>".$cat_data['addon_cat_name']."</td>\n
	<td class='tbl2'>&nbsp;<a href='".ADDON."view.php?addon_id=".$data['addon_id']."'> ".$data['addon_name']."</a></td>\n
	<td class='tbl2'>".$data['addon_author_name']."</td>\n
	<td align='center' class='tbl2'>".$data['addon_download_count']."</td>\n
	<td align='center' class='tbl2'>".$sf_rating."</td>\n</tr>\n";
	}
	echo "</table>\n";
	closetable();
	       }
	
	showratings("M", $addon_id, FUSION_SELF."?addon_id=".$d_addons['addon_id']);
	if ($settings_global['set_addondb_comm'] == '0') {
	showcomments("M", DB_ADDONS, "addon_id", $d_addons['addon_id'], FUSION_SELF."?addon_id=".$d_addons['addon_id']);}
	

}
if (!iGUEST) {
	add_to_title ($locale['addondb507'].$locale['addondb508'].$locale['addondb507'].$d_addons['addon_name']);
} else {
	add_to_title ($locale['addondb507'].$locale['addondb508'].$locale['addondb507']);
}
require_once THEMES."templates/footer.php";
?>