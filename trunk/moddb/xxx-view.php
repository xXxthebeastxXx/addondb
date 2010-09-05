<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: mod_view.php
| Authors: Christian Damsgaard Jørgensen (PMM)
| Luben Kirov (Sharky)
| Claus Pedersen (flyingduck)
| Lightbox 2 Copyright Lokesh Dhakar
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

require_once INFUSIONS."moddb/infusion_db.php";
require_once INFUSIONS."moddb/inc/inc.functions.php";

$db_locale = (isset($_COOKIE['moddb_locale']) && $_COOKIE['moddb_locale'] != "Default" ? $_COOKIE['moddb_locale'] : $settings['locale']);

include INFUSIONS."moddb/locale/".$db_locale."/mod_view.php";
$ex = 0;
if (isset($_GET['download']) && isnum($_GET['download'])) {
  
	$data = dbarray(dbquery("SELECT * FROM ".DB_MOD_CATS." JOIN ".DB_MODS." USING(mod_cat_id) WHERE mod_id='".$_GET['download']."'"));
	if (checkgroup($data['mod_cat_access'])) {
		$result = dbquery("UPDATE ".DB_MODS." SET mod_download_count=(mod_download_count+1) WHERE mod_id='".$_GET['download']."'");
		require_once INCLUDES."class.httpdownload.php";
		redirect($mod_upload_dir.$data['mod_download']);
		ob_end_clean();
		// $data = dbarray($result);
		$object = new httpdownload;
		$object->set_byfile($mod_upload_dir.$data['mod_download']);
		$object->use_resume = true;
		$object->download();
		exit;
	}
}

If ($ex != 1){
$mod_id = stripinput($_GET['mod_id']);
$q_mods = dbquery("SELECT * FROM ".DB_MOD_CATS." JOIN ".DB_MODS." tm USING(mod_cat_id) JOIN ".DB_MOD_VERSIONS." USING(version_id) JOIN ".DB_USERS." tu ON tm.mod_approved_user=tu.user_id WHERE mod_id='".$mod_id."'");
$d_mods = dbarray($q_mods);

if (!isnum($mod_id) || dbrows($q_mods) == 0 || ($d_mods['mod_status'] != 0 && !iSUPERADMIN && $d_mods['mod_status'] != 0)) {
	opentable($locale['moddb430']);
	echo "<center><br>".$locale['moddb431']."<br><br><a href='index.php'>".$locale['moddb433']."</a><br><br></center>";
	closetable();
} elseif (!checkgroup($d_mods['mod_cat_access'])) {
	opentable($locale['moddb430']);
	echo "<center><br>".$locale['moddb432']."<br><br><a href='index.php'>".$locale['moddb433']."</a><br><br></center>";
	closetable();
} else {
	$ver = "v".$d_mods['version_h'].".".$d_mods['version_l'].($d_mods['version_s'] != "" ? " ".$d_mods['version_s'] : "");
	$d_rating = dbarray(dbquery("SELECT SUM(rating_vote) sum_rating, COUNT(rating_item_id) count_votes FROM ".DB_RATINGS." WHERE rating_item_id='".$mod_id."' AND rating_type='M'"));
	$num_votes = $d_rating['count_votes'];
	if ($num_votes == 0) {
		$votecount = " [".$locale['moddb416']."]";
	} elseif ($num_votes == 1) {
		$votecount = " [1 ".$locale['moddb417']."]";
	} else {
		$votecount = " [".$num_votes." ".$locale['moddb418']."]";
	}
	$rating = ($num_votes > 0 ? str_repeat("<img src='".INFUSIONS."moddb/img/star.png' alt='".$locale['moddb414']."'>",ceil($d_rating['sum_rating']/$num_votes)).$votecount : $votecount);
	$staff_rating = str_repeat("<img src='".INFUSIONS."moddb/img/star.png' alt='".$locale['moddb414']."' />",$d_mods['mod_approved_rating']);
	$urlprefix = !strstr($d_mods['mod_author_www'], "http://") ? "http://" : "";
	if ($d_mods['mod_author_name'] != "") {
		$mod_author = $d_mods['mod_author_name'];
		if (!iGUEST) {
		if ($d_mods['mod_author_email'] != "") $mod_author .= " [<a href='mailto:".$d_mods['mod_author_email']."' title='".$locale['moddb500']."'>".$locale['moddb419']."</a>]";
		}
		if ($d_mods['mod_author_www'] != "") $mod_author .= " [<a href='".$urlprefix.$d_mods['mod_author_www']."' target='_blank' title='".$locale['moddb501']."'>".$locale['moddb420']."</a>]";
	} else {
		$mod_author = "Unknown";
	}
	if ($d_mods['mod_download_count'] == 0) {
		$download_count = "[0 ".$locale['moddb422']."]";
	} elseif ($d_mods['mod_download_count'] == 1) {
		$download_count = "[1 ".$locale['moddb421']."]";
	} else {
		$download_count = "[".$d_mods['mod_download_count']." ".$locale['moddb422']."]";
	}
	opentable($locale['moddb400'].$d_mods['mod_name']);
	
	if ($d_mods['mod_date'] + 604800 > time() + ($settings['timeoffset'] * 3600)) { $new = "<img src='".INFUSIONS."moddb/img/new.gif' border='0' alt='' />";
    } else { $new = ""; }

	echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>
	<tr>
	<td width='155'>
	";
	if($d_mods['mod_img'] == ""){
    echo"<img src='img/screenshots/nos.png'>";
	} else {
	echo'
	<script type="text/javascript" src="lightbox/prototype.js"></script>
  <script type="text/javascript" src="lightbox/scriptaculous.js?load=effects,builder"></script>
  <script type="text/javascript" src="lightbox/lightbox.js"></script>
  <link rel="stylesheet" href="lightbox/lightbox.css" type="text/css" media="screen" />
	';
    echo"<div align='center'><a href='img/screenshots/".$d_mods['mod_img']."' rel='lightbox' style='outline: none;border:none;'>
    <img src='img/screenshots/t_".$d_mods['mod_img']."' style='outline: none;border:none;'></a></div>";
  }
	echo"
	</td>
	<td>
	<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>
	<tr>
	<td class='tbl2' width='80' nowrap><b>".$locale['moddb401'].":</b></td>
	<td class='tbl1' nowrap>".$d_mods['mod_name']."&nbsp;".$new."</td>
	</tr>
	<tr>
	<td class='tbl2' nowrap><b>".$locale['moddb402'].":</b></td>
	<td class='tbl1' nowrap>".$d_mods['mod_version']."</td>
	</tr>
	<tr>
	<td class='tbl2' nowrap><b>".$locale['moddb403'].":</b></td>
	<td class='tbl1' nowrap>".$d_mods['mod_cat_name']."</td>
	</tr>
	<tr>
	<td class='tbl2' nowrap><b>".$locale['moddb404'].":</b></td>
	<td class='tbl1' nowrap>".$ver."&nbsp;(".$mod_types[$d_mods['mod_type']].")</td>
	</tr>
	<tr>
	<td class='tbl2' nowrap><b>".$locale['moddb405'].":</b></td>
	<td class='tbl1' nowrap>".$mod_author."</td>
	</tr>\n";
	if ($d_mods['mod_co_author_name'] != "") {
	echo "<tr>
	<td class='tbl2' nowrap><b>".$locale['moddb405c'].":</b></td>
	<td class='tbl1' nowrap>".$d_mods['mod_co_author_name']."</td>
	</tr>\n"; }
	echo "<tr>
	<td class='tbl2' nowrap><b>".$locale['moddb406'].":</b></td>
	<td class='tbl1' nowrap>".strftime($settings['forumdate'],$d_mods['mod_date']+($settings['timeoffset']*3600))."</td>
	</tr>
	<tr>
	<td class='tbl2' nowrap><b>".$locale['moddb408'].":</b></td>
	<td class='tbl1' nowrap>".$rating."</td>
	</tr>
	<tr>
	<td class='tbl2' nowrap><b>".$locale['moddb407'].":</b></td>";
	
	if (iMEMBER) {
	echo "<td class='tbl1' nowrap><a href='".FUSION_SELF."?download=".$d_mods['mod_id']."' title='".$locale['moddb502']."'>".$locale['moddb415']."</a> ".$download_count."</td>";
	} else {
	echo "<td class='tbl1 small' nowrap>".$locale['moddb438']." ".$download_count."</td>";
	}
	echo "</tr>
	</table>
	</td>
	</tr>
	</table>";

	echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>
	<tr>
	<td class='tbl2'><b>".$locale['moddb409']."</b></td>
	</tr>
	<tr>
	<td class='tbl1'>".nl2br(parsesmileys(parseubb($d_mods['mod_description'])))."</td>
	</tr>";

	echo "</table>";

	if ($d_mods['mod_copyright'] != "") {
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>
		<tr>
		<td class='tbl2'><b>".$locale['moddb410']."</b></td>
		</tr>
		<tr>
		<td class='tbl1'>".nl2br(parsesmileys(parseubb($d_mods['mod_copyright'])))."</td>
		</tr>
		</table>";
		}

	if ($d_mods['mod_approved_user'] != 0) {
		tablebreak();
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>
		<tr>
		<td class='tbl2' width='12%' nowrap><b>".$locale['moddb411'].":</b></td>
		<td class='tbl1' width='*'>".$d_mods['user_name']."</td>
		<td class='tbl2' width='12%' nowrap><b>".$locale['moddb412'].":</b></td>
		<td class='tbl1' width='20%'>".str_repeat("<img src='".INFUSIONS."moddb/img/star.png' alt='".$locale['moddb414']."'>",$d_mods['mod_approved_rating'])."</td>
		</tr>
		<tr>\n";
		
		if (($d_mods['mod_valid_xhtml'] == 1) || ($d_mods['mod_valid_css'] == 1)) { $tdo = "<td class='tbl1' valign='top'><b>".$locale['moddb516'].":</b></td><td align='center' class='tbl1'>"; $tdc = "</td>"; $colspan = "0"; } else { $tdo = ""; $tdc = ""; $colspan = "3"; }
		if ($d_mods['mod_valid_xhtml'] == 1) { $xhtml = "<img src='".INFUSIONS."moddb/img/valid_xhtml.png' alt='".$locale['moddb514']."' />"; } elseif ($d_mods['mod_valid_xhtml'] == 0) { $xhtml = ""; }
		if ($d_mods['mod_valid_css'] == 1) { $css = "<img src='".INFUSIONS."moddb/img/valid_css.png' alt='".$locale['moddb515']."' />"; } elseif ($d_mods['mod_valid_css'] == 0) { $css = ""; }
		
		echo "<td class='tbl2' valign='top' nowrap><b>".$locale['moddb413'].":</b></td>
		<td class='tbl1' colspan='".$colspan."'>".nl2br(parsesmileys(parseubb($d_mods['mod_approved_comment'])))."</td>";
		
		echo $tdo;
		echo $xhtml;
		echo $css;
		echo $tdc;
		
		echo "</tr>";
		
        $result = dbquery("SELECT thread_id, thread_subject FROM ".DB_THREADS." WHERE thread_subject = '".$d_mods['mod_name']."'");
        if (dbrows($result) != 0) { 
	    echo "<tr><td class='tbl2' width='12%' nowrap><b>".$locale['moddb429']."</b></td>";
	    echo "<td class='tbl2' colspan='3'>";
	    while ($data = dbarray($result)) { 
	    echo "<a href='".BASEDIR."forum/viewthread.php?thread_id=".$data['thread_id']."'>".$data['thread_subject']."</a>"; }
	    echo "</td></tr>"; }
        
        echo"<tr>
		<td class='tbl2' width='12%' nowrap><b>".$locale['moddb427']."</b></td>
		<td class='tbl1' width='*'>";
		$trans="";
		$result1 = dbquery("SELECT * FROM ".DB_MOD_TRANS." WHERE trans_mod='".$d_mods['mod_id']."' ORDER BY trans_type ASC");
		if (dbrows($result1)) {
		 while ($data1 = dbarray($result1)) {
				$trans .= "<a href='".$trans_upload_dir.$data1['trans_file']."' target='_BLANK'>".get_mod_language($data1['trans_type'])."</a>, ";
				}
		} else {
			$trans = $locale['moddb511'];
		}
				
		echo"$trans</td>
		<td class='tbl2' width='12%' nowrap><b>".$locale['moddb428']."</b></td>
		<td class='tbl1' width='20%' nowrap>
		<a href ='".INFUSIONS."moddb/error.php?error=1&mod_id=".$d_mods['mod_id']."' title='".$locale['moddb503']."' style='outline: none;border:none;'><img src='".INFUSIONS."moddb/img/error.png' alt='".$locale['moddb503']."' style='outline: none;border:none;'></a>
		<a href ='".INFUSIONS."moddb/error.php?error=2&mod_id=".$d_mods['mod_id']."' title='".$locale['moddb504']."' style='outline: none;border:none;'><img src='".INFUSIONS."moddb/img/hack.png' alt='".$locale['moddb504']."' style='outline: none;border:none;'></a>
		<a href ='".INFUSIONS."moddb/error.php?error=3&mod_id=".$d_mods['mod_id']."' title='".$locale['moddb505']."' onClick=\"return confirm('".$locale['moddb437']."')\" style='outline: none;border:none;'><img src='".INFUSIONS."moddb/img/link.png' alt='".$locale['moddb505']."' style='outline: none;border:none;'></a>
		<a href ='".INFUSIONS."moddb/error.php?error=4&mod_id=".$d_mods['mod_id']."' title='".$locale['moddb506']."' style='outline: none;border:none;'><img src='".INFUSIONS."moddb/img/translate.png' alt='".$locale['moddb506']."' style='outline: none;border:none;'></a>
		</td>
		</tr>	
		";
		if (checkrights("MODS")) {
			if ($d_mods['mod_status'] != 3) {
				$suspended =  " | <a href='admin/index.php".$aidlink."&amp;action=suspend&amp;mod_id=".$d_mods['mod_id']."'>".$locate['moddb425']."</a>";
			} else {
				$suspended = " | <span style='color:red;font-weight:bold;'>".$locate['moddb426']."</span>";
			}
			echo "<tr>
			<td class='tbl2' valign='top'><b>".$locale['moddb423'].":</b></td>
			<td class='tbl1' colspan='3'><a href='admin/index.php".$aidlink."&amp;action=edit&amp;mod_cat_id=".$d_mods['mod_cat_id']."&amp;mod_id=".$d_mods['mod_id']."'>".$locate['moddb424']."</a>".$suspended." | <a href='admin/submissions.php".$aidlink."&tran=".$d_mods['mod_id']."' title='".$locale['moddb510']."'>".$locale['moddb509']."</a></td>
			</tr>";
		}
		echo "</table>";
	}
	closetable();
	
	$result = dbquery("SELECT * FROM ".DB_MODS." WHERE mod_author_name = '".$d_mods['mod_author_name']."' AND version_id = '8' AND mod_id != '".$d_mods['mod_id']."' AND mod_status = '0' ORDER BY mod_download_count DESC");
	if (dbrows($result) != 0) { 

	opentable($locale['moddb512'].$d_mods['mod_author_name']);
	
	echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'><tr>";
	echo "<td class='tbl2'><b>".$locale['moddb403']."</b></td><td class='tbl2'><b>".$locale['moddb401']."</b></td><td class='tbl2'><b>".$locale['moddb422']."</b></td><td class='tbl2'><b>".$locale['moddb412']."</b></td></tr>";
	
	while ($data = dbarray($result)) {
	
	$sf_rating = str_repeat("<img src='".INFUSIONS."moddb/img/star.png' alt='".$locale['moddb414']."' />",$data['mod_approved_rating']);
	$cat_data = dbarray(dbquery("SELECT mod_cat_name FROM ".DB_MOD_CATS." WHERE mod_cat_id = '".$data['mod_cat_id']."'"));
	echo "<tr><td class='tbl2'>".$cat_data['mod_cat_name']."</td><td class='tbl2'>&nbsp;<a href='".INFUSIONS."moddb/view.php?mod_id=".$data['mod_id']."'> ".$data['mod_name']."</a></td>";
	echo "<td width='1%' align='center' class='tbl2'>".$data['mod_download_count']."</td><td width='80' align='center' class='tbl2'>".$sf_rating."</td>\n</tr>"; }
	echo "</table>"; 
	closetable();
	
	}
	
	$result = dbquery("SELECT * FROM ".DB_MODS." WHERE mod_co_author_name = '".$d_mods['mod_author_name']."' AND version_id = '8' AND mod_id != '".$d_mods['mod_id']."' AND mod_status = '0' ORDER BY mod_download_count DESC");
	if (dbrows($result) != 0) {
	opentable($locale['moddb513'].$d_mods['mod_author_name']);
	echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'><tr>";
	echo "<tr><td class='tbl2'><b>".$locale['moddb403']."</b></td><td class='tbl2'><b>".$locale['moddb401']."</b></td><td class='tbl2'><b>".$locale['moddb405']."</b></td>";
	echo "<td class='tbl2'><b>".$locale['moddb422']."</b></td><td class='tbl2'><b>".$locale['moddb412']."</b></td></tr>";
	
	while ($data = dbarray($result)) {
	
	$sf_rating = str_repeat("<img src='".INFUSIONS."moddb/img/star.png' alt='".$locale['moddb414']."' />",$data['mod_approved_rating']);
	$cat_data = dbarray(dbquery("SELECT mod_cat_name FROM ".DB_MOD_CATS." WHERE mod_cat_id = '".$data['mod_cat_id']."'"));
	echo "<tr><td class='tbl2'>".$cat_data['mod_cat_name']."</td><td class='tbl2'>&nbsp;<a href='".INFUSIONS."moddb/view.php?mod_id=".$data['mod_id']."'> ".$data['mod_name']."</a>";
	echo "</td><td class='tbl2'>".$data['mod_author_name']."</td><td width='1%' align='center' class='tbl2'>".$data['mod_download_count']."</td><td width='80' align='center' class='tbl2'>".$sf_rating."</td>\n</tr>"; }

	echo "</table>";
	closetable();
	       }
	
	showratings("M", $mod_id, FUSION_SELF."?mod_id=".$d_mods['mod_id']);
	showcomments("M", DB_MODS, "mod_id", $d_mods['mod_id'], FUSION_SELF."?mod_id=".$d_mods['mod_id']);
	
}
}
if (!iGUEST) {
	add_to_title ($locale['moddb507'].$locale['moddb508'].$locale['moddb507'].$d_mods['mod_name']);
} else {
	add_to_title ($locale['moddb507'].$locale['moddb508'].$locale['moddb507']);
}
require_once THEMES."templates/footer.php";
?>