<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: license_admin.php
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
include INFUSIONS."license_admin/infusion_db.php";
require_once INCLUDES."infusions_include.php";

if (file_exists(INFUSIONS."license_admin/locale/".$settings['locale'].".php")) {
	include INFUSIONS."license_admin/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."license_admin/locale/English.php";
}

if (!checkrights("LCAP") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

if (isset($_GET['status'])) {
	if ($_GET['status'] == "del") {
		$title = $locale['pla_600'];
		$message = "<strong>".$locale['pla_601']."</strong>";
	} elseif ($_GET['status'] == "apr") {
		$title = $locale['pla_604'];
		$message = "<strong>".$locale['pla_605']."</strong>";
	}
	opentable($title);
	echo "<div style='text-align:center'>".$message."</div>\n";
	closetable();
}

	if (isset($_POST['edit_app'])) {
		$app_user = stripinput($_POST['app_user']);
		$app_status = stripinput($_POST['app_status']);
		$app_approver = stripinput($_POST['app_approver']);
		$app_approver_pm = stripinput($_POST['app_approver_pm']);
		$app_approver_comment = stripinput($_POST['app_approver_comment']);
		$result = dbquery("UPDATE ".DB_LICENSE_APPLY." SET app_status = '$app_status', app_approver='".$userdata['user_id']."', app_approver_pm='$app_approver_pm', app_approver_comment='$app_approver_comment' WHERE app_id='".$_GET['app_id']."'");
		$sendpm = send_pm($app_user, $userdata['user_id'], $locale['pla_004'], $app_approver_pm);
		redirect(FUSION_SELF.$aidlink."&status=apr");
		
	} elseif ((isset($_GET['action']) && $_GET['action'] == "delete") && (isset($_GET['app_id']) && isnum($_GET['app_id']))) {
	$result = dbquery("DELETE FROM ".DB_LICENSE_APPLY." WHERE app_id='".$_GET['app_id']."'");
	redirect(FUSION_SELF.$aidlink."&status=del");
} else {
	if ((isset($_GET['action']) && $_GET['action'] == "edit") && (isset($_GET['app_id']) && isnum($_GET['app_id']))) {
		$result = dbquery("SELECT * FROM ".DB_LICENSE_APPLY." WHERE app_id='".$_GET['app_id']."'");
		if (dbrows($result)) {
			$data = dbarray($result);
			$app_user = $data['app_user'];
			$app_realname = $data['app_realname'];
			$app_type = $data['app_type'];
			$app_url = $data['app_url'];
			$app_text = $data['app_text'];
			$app_status = $data['app_status'];
			$app_datestamp = $data['app_datestamp'];
			$app_approver = $userdata['user_id'];
			$app_approver_pm = $data['app_approver_pm'];
			$app_approver_comment = $data['app_approver_comment'];
			$form_title = $locale['pla_603'];
			$form_action = FUSION_SELF.$aidlink."&amp;action=edit&amp;app_id=".$data['app_id'];
		} else {
			redirect(FUSION_SELF.$aidlink);
		}
	} else {
		$app_user = "";
		$app_realname = "";
		$app_approver = "";
		$app_approver_pm = "";
		$app_approver_comment = "";
		$form_title = $locale['pla_602'];
		$form_action = FUSION_SELF.$aidlink;
}
	$license_types = array(
             1 => $locale['pla_106'],
             2 => $locale['pla_107'], 
             3 => $locale['pla_105']
);

	if ((isset($_GET['action']) && $_GET['action'] == "edit") && (isset($_GET['app_id']) && isnum($_GET['app_id']))) {
	$get_user = dbarray(dbquery("SELECT user_name, user_status FROM ".DB_USERS." WHERE user_id = '".$app_user."'"));
	opentable($form_title);

        echo "<form name='appform' method='post' action='".$form_action."' >\n";
        echo "<br />\n<table cellpadding='0' align='center' cellspacing='0' width='100%' class='tbl-border'>\n<tr>\n";
        echo "<th colspan='2' class='forum-caption'>".$locale['pla_131']."</th>\n";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' colspan='2'>&nbsp;</td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' width='20%'>".$locale['pla_112']."</td>";
        echo "<td claas='tbl1'>".profile_link($app_user, $get_user['user_name'], $get_user['user_status'])."</td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' width='20%'>".$locale['pla_140']."</td>";
        echo "<td claas='tbl1'>".$data['app_realname']."</td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' width='20%'>".$locale['pla_109']."</td>";
        echo "<td class='tbl1' nowrap valign='top'>".$license_types[$data['app_type']]."</td>\n";
	    echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' valign='top' width='20%'>".$locale['pla_113']."</td>";
        echo "<td class='quote' valign='top'>";
        $text = nl2br(parseubb(censorwords($data['app_text'])));
	    echo (isset($text) ? $text : "");
	    echo "</td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' valign='top' width='20%'>".$locale['pla_117']."</td>";
        echo "<td class='tbl1' valign='top'>".(isset($data['app_url']) ? $data['app_url'] : $locale['pla_608'])."</td>";
        echo "</tr>\n<tr>\n"; 
        echo "<td class='tbl1' width='20%'>".$locale['pla_133'].":</td>";
        echo "<td class='tbl1' nowrap valign='top'>";
    	echo "<select name='app_status' class='textbox'>\n";
    	echo "<option value='0' ".($app_status == 0 ? "selected" : "").">".$locale['pla_110']."</option>\n";
    	echo "<option value='1' ".($app_status == 1 ? "selected" : "").">".$locale['pla_135']."</option>\n";
    	echo "<option value='2' ".($app_status == 2 ? "selected" : "").">".$locale['pla_136']."</option>\n";
    	echo "<option value='3' ".($app_status == 3 ? "selected" : "").">".$locale['pla_137']."</option>\n";
    	echo "</select>\n</td>\n";
	    echo "</tr>\n<tr>\n";
	    echo "<td class='tbl1' colspan='2'><hr /></td>";
	    echo "</tr>\n<tr>\n";
	    echo "<td class='tbl1' valign='top' width='20%'>".$locale['pla_613'].":</td>";
        echo "<td class='tbl1' valign='top'><textarea class='textbox' name='app_approver_pm' style='width:300px; height:100px;'>".$data['app_approver_pm']."</textarea><br />".$locale['pla_609']."</td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' valign='top' width='20%'>".$locale['pla_610'].":</td>";
        echo "<td class='tbl1' valign='top'><textarea class='textbox' name='app_approver_comment' style='width:300px; height:100px;'>".$data['app_approver_comment']."</textarea><br />".$locale['pla_611']."</td>";
        echo "</tr>\n<tr>\n"; 
        echo "<td colspan='2' align='center'>";
        echo "<input type='hidden' name='app_user' value='".$data['app_user']."' />\n";
        echo "<input type='submit' name='edit_app' value='".$locale['pla_116']."' class='button' />\n</td>\n";
        echo "</tr>\n</table>\n</form>\n<br />\n";
	closetable();
	echo "<br />\n";
	}
	
	opentable($locale['pla_602']);
	$rows = dbcount("(app_id)", DB_LICENSE_APPLY);
	if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) { $_GET['rowstart'] = 0; }
		$result = dbquery(
			"SELECT a.app_id, a.app_user, a.app_type, a.app_realname, a.app_url, a.app_text, a.app_status, a.app_datestamp, a.app_approver, a.app_approver_pm, a.app_approver_comment, u.user_id, u.user_name, u.user_status
			FROM ".DB_LICENSE_APPLY." a
			LEFT JOIN ".DB_USERS." u ON u.user_id=a.app_user 
			WHERE a.app_status = '1'
			ORDER BY app_datestamp DESC
			LIMIT ".$_GET['rowstart'].",20"
		);
		if (dbrows($result)) {
		$i = 0;
		echo "<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border center'>\n<tr>\n";
		echo "<td class='tbl2'>".$locale['pla_124']."</td>\n";
		echo "<td class='tbl2'>".$locale['pla_140']."</td>\n";
		echo "<td class='tbl2'>".$locale['pla_125']."</td>\n";
		echo "<td class='tbl2'>".$locale['pla_127']."</td>\n";
		echo "<td class='tbl2'>".$locale['pla_128']."</td>\n";
		echo "<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>".$locale['pla_133']."</td>\n";
		echo "</tr>\n";
		while ($data = dbarray($result)) {
			$row_color = ($i % 2 == 0 ? "tbl1" : "tbl2");
			echo "<tr>\n";
			echo "<td class='$row_color'>".(isset($data['user_name']) ? profile_link($data['user_id'], $data['user_name'], $data['user_status']) : $locale['pla_608'])."</td>\n";
			echo "<td class='$row_color'>".$data['app_realname']."</td>\n";
			echo "<td class='$row_color'>".$license_types[$data['app_type']]."</td>\n";
	if (!strstr($data['app_url'], "http://") && !strstr($data['app_url'], "https://")) {
			$urlprefix = "http://";
		} else {
			$urlprefix = "";
		}
	       echo "<td class='$row_color'>";
	if ($data['app_url']) { echo "<a href='".$urlprefix.$data['app_url']."' title='".$urlprefix.$data['app_url']."' target='_blank'>".$data['app_url']."</a>"; }
	       echo "</td>\n";
	       echo "<td class='$row_color'>".showdate("shortdate", $data['app_datestamp'])."</td>\n";
		   echo "<td align='center' width='1%' class='$row_color' style='white-space:nowrap'><a href='".FUSION_SELF.$aidlink."&amp;action=edit&amp;app_id=".$data['app_id']."'>".$locale['pla_138']."</a> -\n";
		   echo "<a href='".FUSION_SELF.$aidlink."&amp;action=delete&amp;app_id=".$data['app_id']."'>".$locale['pla_139']."</a></td>\n";
		   echo "</tr>\n";
		}
		echo "</table>\n";
	} else {
		echo "<div style='text-align:center'><br />\n".$locale['pla_607'].$locale['pla_602']."<br /><br />\n</div>\n";
	}
	closetable();
	echo "<br />\n";

	opentable($locale['pla_606']);

		$result = dbquery(
			"SELECT a.app_id, a.app_user, a.app_type, a.app_realname, a.app_url, a.app_text, a.app_status, a.app_datestamp, a.app_approver, a.app_approver_pm, a.app_approver_comment, u.user_id, u.user_name, u.user_status
			FROM ".DB_LICENSE_APPLY." a
			LEFT JOIN ".DB_USERS." u ON u.user_id=a.app_user 
			WHERE a.app_status = '2'
			ORDER BY app_datestamp DESC
			LIMIT ".$_GET['rowstart'].",20"
		);
		if (dbrows($result)) {
		$i = 0;
		echo "<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border center'>\n<tr>\n";
		echo "<td class='tbl2'>".$locale['pla_124']."</td>\n";
		echo "<td class='tbl2'>".$locale['pla_140']."</td>\n";
		echo "<td class='tbl2'>".$locale['pla_125']."</td>\n";
		echo "<td class='tbl2'>".$locale['pla_612']."</td>\n";
		echo "<td class='tbl2'>".$locale['pla_127']."</td>\n";
		echo "<td class='tbl2'>".$locale['pla_128']."</td>\n";
		echo "<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>".$locale['pla_133']."</td>\n";
		echo "</tr>\n";
		while ($data = dbarray($result)) {
			$row_color = ($i % 2 == 0 ? "tbl1" : "tbl2");
			echo "<tr>\n";
			echo "<td class='$row_color'>".(isset($data['user_name']) ? profile_link($data['user_id'], $data['user_name'], $data['user_status']) : $locale['pla_608'])."</td>\n";
			echo "<td class='$row_color'>".$data['app_realname']."</td>\n";
			echo "<td class='$row_color'>".$license_types[$data['app_type']]."</td>\n";
			$get_admin = dbarray(dbquery("SELECT user_name, user_status FROM ".DB_USERS." WHERE user_id = '".$data['app_approver']."'"));
			echo "<td class='$row_color'>".profile_link($data['app_approver'], $get_admin['user_name'], $get_admin['user_status'])."</td>\n";
	if (!strstr($data['app_url'], "http://") && !strstr($data['app_url'], "https://")) {
			$urlprefix = "http://";
		} else {
			$urlprefix = "";
		}
	       echo "<td class='$row_color'>";
	if ($data['app_url']) { echo "<a href='".$urlprefix.$data['app_url']."' title='".$urlprefix.$data['app_url']."' target='_blank'>".$data['app_url']."</a>"; }
	       echo "</td>\n";
	       echo "<td class='$row_color'>".showdate("shortdate", $data['app_datestamp'])."</td>\n";
		   echo "<td align='center' width='1%' class='$row_color' style='white-space:nowrap'><a href='".FUSION_SELF.$aidlink."&amp;action=edit&amp;app_id=".$data['app_id']."'>".$locale['pla_138']."</a> -\n";
		   echo "<a href='".FUSION_SELF.$aidlink."&amp;action=delete&amp;app_id=".$data['app_id']."'>".$locale['pla_139']."</a></td>\n";
		   echo "</tr>\n";
		}
		echo "</table>\n";
	} else {
		echo "<div style='text-align:center'><br />\n".$locale['pla_607'].$locale['pla_606']."<br /><br />\n</div>\n";
	}
	closetable();
	
echo "<br />\n";
	opentable($locale['pla_122']);

		$result = dbquery(
			"SELECT a.app_id, a.app_user, a.app_type, a.app_realname, a.app_url, a.app_text, a.app_status, a.app_datestamp, a.app_approver, a.app_approver_pm, a.app_approver_comment, u.user_id, u.user_name, u.user_status
			FROM ".DB_LICENSE_APPLY." a
			LEFT JOIN ".DB_USERS." u ON u.user_id=a.app_user 
			WHERE a.app_status = '3'
			ORDER BY app_datestamp DESC
			LIMIT ".$_GET['rowstart'].",20"
		);
		if (dbrows($result)) {
		$i = 0;
		echo "<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border center'>\n<tr>\n";
		echo "<td class='tbl2'>".$locale['pla_124']."</td>\n";
		echo "<td class='tbl2'>".$locale['pla_140']."</td>\n";
		echo "<td class='tbl2'>".$locale['pla_125']."</td>\n";
		echo "<td class='tbl2'>".$locale['pla_612']."</td>\n";
		echo "<td class='tbl2'>".$locale['pla_127']."</td>\n";
		echo "<td class='tbl2'>".$locale['pla_128']."</td>\n";
		echo "<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>".$locale['pla_133']."</td>\n";
		echo "</tr>\n";
		while ($data = dbarray($result)) {
			$row_color = ($i % 2 == 0 ? "tbl1" : "tbl2");
			echo "<tr>\n";
			echo "<td class='$row_color'>".(isset($data['user_name']) ? profile_link($data['user_id'], $data['user_name'], $data['user_status']) : $locale['pla_608'])."</td>\n";
			echo "<td class='$row_color'>".$data['app_realname']."</td>\n";
			echo "<td class='$row_color'>".$license_types[$data['app_type']]."</td>\n";
			$get_admin = dbarray(dbquery("SELECT user_name, user_status FROM ".DB_USERS." WHERE user_id = '".$app_approver."'"));
			echo "<td class='$row_color'>".profile_link($data['app_approver'], $get_admin['user_name'], $get_admin['user_status'])."</td>\n";
	if (!strstr($data['app_url'], "http://") && !strstr($data['app_url'], "https://")) {
			$urlprefix = "http://";
		} else {
			$urlprefix = "";
		}
	       echo "<td class='$row_color'>";
	if ($data['app_url']) { echo "<a href='".$urlprefix.$data['app_url']."' title='".$urlprefix.$data['app_url']."' target='_blank'>".$data['app_url']."</a>"; }
	       echo "</td>\n";
	       echo "<td class='$row_color'>".showdate("shortdate", $data['app_datestamp'])."</td>\n";
		   echo "<td align='center' width='1%' class='$row_color' style='white-space:nowrap'><a href='".FUSION_SELF.$aidlink."&amp;action=edit&amp;app_id=".$data['app_id']."'>".$locale['pla_138']."</a> -\n";
		   echo "<a href='".FUSION_SELF.$aidlink."&amp;action=delete&amp;app_id=".$data['app_id']."'>".$locale['pla_139']."</a></td>\n";
		   echo "</tr>\n";
		}
		echo "</table>\n";
	} else {
		echo "<div style='text-align:center'><br />\n".$locale['pla_607'].$locale['pla_122']."<br /><br />\n</div>\n";
	}
	closetable();
	if (($rows) > 20) { echo "<div align='center' style=';margin-top:5px;'>\n".makepagenav($_GET['rowstart'],20,$rows,3,FUSION_SELF.$aidlink."&amp;")."\n</div>\n"; }
}

require_once THEMES."templates/footer.php";
?>