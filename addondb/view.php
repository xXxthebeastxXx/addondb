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

$db_locale = (isset($_COOKIE['addondb_locale']) && $_COOKIE['addondb_locale'] != "Default" ? $_COOKIE['addondb_locale'] : $settings['locale']);

include INFUSIONS."addondb/locale/".$db_locale."/addon_view.php";
$ex = 0;
if (isset($_GET['download']) && isnum($_GET['download'])) {
  
	$data = dbarray(dbquery("SELECT * FROM ".DB_ADDON_CATS." JOIN ".DB_ADDONS." USING(addon_cat_id) WHERE addon_id='".$_GET['download']."'"));
	if (checkgroup($data['addon_cat_access'])) {
		$result = dbquery("UPDATE ".DB_ADDONS." SET addon_download_count=(addon_download_count+1) WHERE addon_id='".$_GET['download']."'");
		require_once INCLUDES."class.httpdownload.php";
		redirect($addon_upload_dir.$data['addon_download']);
		ob_end_clean();
		// $data = dbarray($result);
		$object = new httpdownload;
		$object->set_byfile($addon_upload_dir.$data['addon_download']);
		$object->use_resume = true;
		$object->download();
		exit;
	}
}

If ($ex != 1){
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
	$rating = ($num_votes > 0 ? str_repeat("<img src='".INFUSIONS."addondb/img/star.png' alt='".$locale['addondb414']."'>",ceil($d_rating['sum_rating']/$num_votes)).$votecount : $votecount);
	$staff_rating = str_repeat("<img src='".INFUSIONS."addondb/img/star.png' alt='".$locale['addondb414']."' />",$d_addons['addon_approved_rating']);
	$urlprefix = !strstr($d_addons['addon_author_www'], "http://") ? "http://" : "";

	if ($d_addons['addon_download_count'] == 0) {
		$download_count = "[0 ".$locale['addondb422']."]";
	} elseif ($d_addons['addon_download_count'] == 1) {
		$download_count = "[1 ".$locale['addondb407']."]";
	} else {
		$download_count = "[".$d_addons['addon_download_count']." ".$locale['addondb422']."]";
	}
	opentable($locale['addondb400'].$d_addons['addon_name']);
	
	if ($d_addons['addon_date'] + 604800 > time() + ($settings['timeoffset'] * 3600)) { $new = "<img src='".INFUSIONS."addondb/img/new.gif' border='0' alt='' />";
    } else { $new = ""; }

	echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>
	<tr>
	<td width='155'>
	";
	if($d_addons['addon_img'] == "" || !file_exists(ADDON_SCRN."t_".$d_addons['addon_img'])) {
    echo "<img src='".ADDON_SCRN."nos.png'>";
	} else {
	add_to_head("<script type='text/javascript' src='lightbox/prototype.js'></script>
    <script type='text/javascript' src='lightbox/scriptaculous.js?load=effects,builder'></script>
    <script type='text/javascript' src='lightbox/lightbox.js'></script>
    <link rel='stylesheet' href='lightbox/lightbox.css' type='text/css' media='screen' />");
    echo"<div align='center'><a href='img/screenshots/".$d_addons['addon_img']."' rel='lightbox' style='outline: none;border:none;'>
    <img src='".ADDON_SCRN."t_".$d_addons['addon_img']."' style='outline: none;border:none;'></a></div>\n";
    }
	echo"</td>
	<td>
	<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>
	<tr>
	<td class='tbl2' width='80' nowrap><b>".$locale['addondb401'].":</b></td>
	<td class='tbl1' nowrap>".$d_addons['addon_name']."&nbsp;".$new."</td>
	<td class='tbl1' nowrap rowspan='9' align='center'><b>".$locale['addondb421'].$d_addons['addon_name']."</b><br />
	<a href='".FUSION_SELF."?download=".$d_addons['addon_id']."' title='".$locale['addondb502']."'><img border='0' src='".ADDON_IMG."download.png' alt='' /></a><br />".$download_count."</td>
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
	</table>
	</td>
	</tr>
	</table>";

	echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>
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
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>
		<tr>
		<td class='tbl2' width='12%' nowrap><b>".$locale['addondb411'].":</b></td>
		<td class='tbl1' width='*'>".$d_addons['user_name']."</td>
		<td class='tbl2' width='12%' nowrap><b>".$locale['addondb412'].":</b></td>
		<td class='tbl1' width='20%'>".str_repeat("<img src='".INFUSIONS."addondb/img/star.png' alt='".$locale['addondb414']."'>",$d_addons['addon_approved_rating'])."</td>
		</tr>
		<tr>\n";
		
		if (($d_addons['addon_valid_xhtml'] == 1) || ($d_addons['addon_valid_css'] == 1)) 
		{ $tdo = "<td class='tbl1' valign='top'><b>".$locale['addondb516'].":</b></td><td align='center' class='tbl1'>"; $tdc = "</td>"; $colspan = "0"; } else { $tdo = ""; $tdc = ""; $colspan = "3"; }
		if ($d_addons['addon_valid_xhtml'] == 1) { $xhtml = "<img src='".ADDON_IMG."valid_xhtml.png' alt='".$locale['addondb514']."' />"; } elseif ($d_addons['addon_valid_xhtml'] == 0) { $xhtml = ""; }
		if ($d_addons['addon_valid_css'] == 1) { $css = "<img src='".ADDON_IMG."valid_css.png' alt='".$locale['addondb515']."' />"; } elseif ($d_addons['addon_valid_css'] == 0) { $css = ""; }
		
		echo "<td class='tbl2' valign='top' nowrap><b>".$locale['addondb413'].":</b></td>
		<td class='tbl1' colspan='".$colspan."'>";
		if ($d_addons['addon_approved_comment']) { echo nl2br(parsesmileys(parseubb($d_addons['addon_approved_comment']))); } else { echo $locale['addondb439']; }
		echo "</td>";
		
		echo $tdo;
		echo $xhtml;
		echo $css;
		echo $tdc;
		
		echo "</tr>";
		
        $result = dbquery("SELECT thread_id, thread_subject FROM ".DB_THREADS." WHERE thread_subject = '".$d_addons['addon_name']."'");
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
		<td class='tbl1' width='20%' nowrap>
		<a href ='".INFUSIONS."addondb/error.php?error=1&addon_id=".$d_addons['addon_id']."' title='".$locale['addondb503']."' style='outline: none;border:none;'><img src='".INFUSIONS."addondb/img/error.png' alt='".$locale['addondb503']."' style='outline: none;border:none;'></a>
		<a href ='".INFUSIONS."addondb/error.php?error=2&addon_id=".$d_addons['addon_id']."' title='".$locale['addondb504']."' style='outline: none;border:none;'><img src='".INFUSIONS."addondb/img/hack.png' alt='".$locale['addondb504']."' style='outline: none;border:none;'></a>
		<a href ='".INFUSIONS."addondb/error.php?error=3&addon_id=".$d_addons['addon_id']."' title='".$locale['addondb505']."' onClick=\"return confirm('".$locale['addondb437']."')\" style='outline: none;border:none;'><img src='".INFUSIONS."addondb/img/link.png' alt='".$locale['addondb505']."' style='outline: none;border:none;'></a>
		<a href ='".INFUSIONS."addondb/error.php?error=4&addon_id=".$d_addons['addon_id']."' title='".$locale['addondb506']."' style='outline: none;border:none;'><img src='".INFUSIONS."addondb/img/translate.png' alt='".$locale['addondb506']."' style='outline: none;border:none;'></a>
		</td>
		</tr>	
		";
		if (checkrights("AddonS")) {
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
	
	$result = dbquery("SELECT * FROM ".DB_ADDONS." WHERE addon_author_name = '".$d_addons['addon_author_name']."' AND addon_id != '".$d_addons['addon_id']."' AND addon_status = '0' ORDER BY addon_download_count DESC");
	if (dbrows($result) != 0) { 

	opentable($locale['addondb512'].$d_addons['addon_author_name']);
	
	echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'><tr>";
	echo "<td class='tbl2'><b>".$locale['addondb403']."</b></td><td class='tbl2'><b>".$locale['addondb401']."</b></td><td class='tbl2'><b>".$locale['addondb422']."</b></td><td class='tbl2'><b>".$locale['addondb412']."</b></td></tr>";
	
	while ($data = dbarray($result)) {
	
	$sf_rating = str_repeat("<img src='".INFUSIONS."addondb/img/star.png' alt='".$locale['addondb414']."' />",$data['addon_approved_rating']);
	$cat_data = dbarray(dbquery("SELECT addon_cat_name FROM ".DB_ADDON_CATS." WHERE addon_cat_id = '".$data['addon_cat_id']."'"));
	echo "<tr><td class='tbl2'>".$cat_data['addon_cat_name']."</td><td class='tbl2'>&nbsp;<a href='".INFUSIONS."addondb/view.php?addon_id=".$data['addon_id']."'> ".$data['addon_name']."</a></td>";
	echo "<td width='1%' align='center' class='tbl2'>".$data['addon_download_count']."</td><td width='80' align='center' class='tbl2'>".$sf_rating."</td>\n</tr>"; }
	echo "</table>"; 
	closetable();
	
	}
	
	$result = dbquery("SELECT * FROM ".DB_ADDONS." WHERE addon_co_author_name = '".$d_addons['addon_author_name']."' AND addon_id != '".$d_addons['addon_id']."' AND addon_status = '0' ORDER BY addon_download_count DESC");
	if (dbrows($result) != 0) {
	opentable($locale['addondb513'].$d_addons['addon_author_name']);
	echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'><tr>";
	echo "<tr><td class='tbl2'><b>".$locale['addondb403']."</b></td><td class='tbl2'><b>".$locale['addondb401']."</b></td><td class='tbl2'><b>".$locale['addondb405']."</b></td>";
	echo "<td class='tbl2'><b>".$locale['addondb422']."</b></td><td class='tbl2'><b>".$locale['addondb412']."</b></td></tr>";
	
	while ($data = dbarray($result)) {
	
	$sf_rating = str_repeat("<img src='".INFUSIONS."addondb/img/star.png' alt='".$locale['addondb414']."' />",$data['addon_approved_rating']);
	$cat_data = dbarray(dbquery("SELECT addon_cat_name FROM ".DB_ADDON_CATS." WHERE addon_cat_id = '".$data['addon_cat_id']."'"));
	echo "<tr><td class='tbl2'>".$cat_data['addon_cat_name']."</td><td class='tbl2'>&nbsp;<a href='".INFUSIONS."addondb/view.php?addon_id=".$data['addon_id']."'> ".$data['addon_name']."</a>";
	echo "</td><td class='tbl2'>".$data['addon_author_name']."</td><td width='1%' align='center' class='tbl2'>".$data['addon_download_count']."</td><td width='80' align='center' class='tbl2'>".$sf_rating."</td>\n</tr>"; }

	echo "</table>";
	closetable();
	       }
	
	showratings("M", $addon_id, FUSION_SELF."?addon_id=".$d_addons['addon_id']);
	showcomments("M", DB_ADDONS, "addon_id", $d_addons['addon_id'], FUSION_SELF."?addon_id=".$d_addons['addon_id']);
	
}
}
if (!iGUEST) {
	add_to_title ($locale['addondb507'].$locale['addondb508'].$locale['addondb507'].$d_addons['addon_name']);
} else {
	add_to_title ($locale['addondb507'].$locale['addondb508'].$locale['addondb507']);
}
require_once THEMES."templates/footer.php";
?>