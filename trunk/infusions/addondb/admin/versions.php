<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: versions.php
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

if (file_exists(INFUSIONS."addondb/locale/".LOCALESET."admin/versions.php")) {
	include INFUSIONS."addondb/locale/".LOCALESET."admin/versions.php";
} else {
	include INFUSIONS."addondb/locale/English/admin/versions.php";
}

// Error Messages
if (isset($_GET['error']) && isnum($_GET['error'])) {
	echo "<div class='admin-message'>\n";
	if ($_GET['error'] == 1) { echo $locale['addondb411'];
	} elseif ($_GET['error'] == 2) { echo $locale['addondb412'];
	} elseif ($_GET['error'] == 3) { echo $locale['addondb416'];
	} elseif ($_GET['error'] == 4) { echo $locale['addondb417'];
	} else { echo $locale['addondb418']; }
	echo "</div>\n";
}

// Cancel Button
if (isset($_POST['btn_cancel'])) {
	redirect(FUSION_SELF.$aidlink);
}

// If Action and Addon CAT ID is set!
if (isset($_GET['action']) && isset($_GET['version_id']) && isnum($_GET['version_id'])) {
	$version_result = dbquery(
		"SELECT * 
		FROM ".DB_ADDON_VERSIONS."
		WHERE version_id='".$_GET['version_id']."'
		LIMIT 1"
	);
	if (dbrows($version_result)) {
		$version_id = $_GET['version_id'];
		$version_data = dbarray($version_result);
		// Delete
		if ($_GET['action'] == "delete") {
			$version_order = dbresult(dbquery("SELECT version_order FROM ".DB_ADDON_VERSIONS." WHERE version_id='".$version_id."'"),0);
			$result = dbquery("UPDATE ".DB_ADDON_VERSIONS." SET version_order=(version_order-1) WHERE version_order>'".$version_order."'");
			$result = dbquery("DELETE FROM ".DB_ADDON_VERSIONS." WHERE version_id='".$version_id."'");
			redirect(FUSION_SELF.$aidlink);
		// Move Up
		} elseif ($_GET['action'] == "move_up") {
			$data = dbarray(dbquery("SELECT * FROM ".DB_ADDON_VERSIONS." WHERE version_order='".$version_order."'"));
			$result = dbquery("UPDATE ".DB_ADDON_VERSIONS." SET version_order=(version_order+1) WHERE version_id='".$data['version_id']."'");
			$result = dbquery("UPDATE ".DB_ADDON_VERSIONS." SET version_order=(version_order-1) WHERE version_id='".$version_id."'");
			redirect(FUSION_SELF.$aidlink);
		// Move Down
		} elseif ($_GET['action'] == "move_down") {
			$data = dbarray(dbquery("SELECT * FROM ".DB_ADDON_VERSIONS." WHERE version_order='".$version_order."'"));
			$result = dbquery("UPDATE ".DB_ADDON_VERSIONS." SET version_order=(version_order-1) WHERE version_id='".$data['version_id']."'");
			$result = dbquery("UPDATE ".DB_ADDON_VERSIONS." SET version_order=(version_order+1) WHERE version_id='".$version_id."'");
			redirect(FUSION_SELF.$aidlink);
		// Edit
		} elseif ($_GET['action'] == "edit") {
			// Save Update
			if (isset($_POST['btn_save'])) {
				$version_h = substr(stripinput($_POST['version_h']),0,5);
				$version_l = substr(stripinput($_POST['version_l']),0,5);
				$version_s = substr(stripinput($_POST['version_s']),0,12);
				$version_description = stripinput($_POST['version_description']);
				if (empty($version_h) || empty($version_l)) {
					redirect(FUSION_SELF.$aidlink."&amp;error=1");
				} elseif (dbcount("(*)", DB_ADDON_VERSIONS, "version_h='$version_h' AND version_l='$version_l' AND version_s='$version_s' AND version_id!='$version_id'") != 0) {
					redirect(FUSION_SELF.$aidlink."&amp;error=2");
				} else {
					$result = dbquery("
						UPDATE ".DB_ADDON_VERSIONS." SET 
							version_h='".$version_h."',
							version_l='".$version_l."',
							version_s='".$version_s."',
							version_description='".$version_description."' 
						WHERE version_id='".$version_id."'"
					);
					redirect(FUSION_SELF.$aidlink."&amp;update=ok");
				}
			// Store Data
			} else {
				$version_h = $version_data['version_h'];
				$version_l = $version_data['version_l'];
				$version_s = $version_data['version_s'];
				$version_description = $version_data['version_description'];			
				$version_formaction = FUSION_SELF.$aidlink."&amp;action=edit&amp;version_id=".$version_id;
				opentable($locale['addondb407']);
			}
		} else {
			redirect(FUSION_SELF.$aidlink."&amp;error=3");
		}
	} else {
		redirect(FUSION_SELF.$aidlink."&amp;error=4");
	}
// Save Insert
} elseif (isset($_POST['btn_save'])) {
	$version_h = substr(stripinput($_POST['version_h']),0,5);
	$version_l = substr(stripinput($_POST['version_l']),0,5);
	$version_s = substr(stripinput($_POST['version_s']),0,12);
	$version_description = stripinput($_POST['version_description']);
	if (empty($version_h) || empty($version_l)) {
		redirect(FUSION_SELF.$aidlink."&amp;error=1");
	} elseif (dbcount("(*)", DB_ADDON_VERSIONS, "version_h='$version_h' AND version_l='$version_l' AND version_s='$version_s'") != 0) {
		redirect(FUSION_SELF.$aidlink."&amp;error=2");
	} else {
		$version_order = dbresult(dbquery("SELECT MAX(version_order) FROM ".DB_ADDON_VERSIONS),0) + 1;
		$result = dbquery(
			"INSERT INTO ".DB_ADDON_VERSIONS." VALUES(
				'',
				'".$version_h."',
				'".$version_l."',
				'".$version_s."',
				'".$version_description."',
				'".$version_order."'
			)"
		);
		redirect(FUSION_SELF.$aidlink."&amp;insert=ok");
	}
} else {
	$version_h = "";
	$version_l = "";
	$version_s = "";
	$version_description = "";			
	$version_formaction = FUSION_SELF.$aidlink;
	opentable($locale['addondb408']);
}

echo "<form name='frm_version' method='post' action='$version_formaction'>
<table align='center' cellpadding='0' cellspacing='0' class='tbl-border'>".(isset($err) ? "<tr><td colspan='3' class='tbl1 error' align='center' colspan='2'>".$err."</td></tr>" : "")."
<tr>
<td class='tbl1' nowrap>".$locale['addondb401']."<strong><span style='color:red;'>*</span></strong>:</td>
<td class='tbl1' nowrap>v&nbsp;<input type='text' class='textbox' name='version_h' value='".$version_h."' style='width:30px;text-align:right;'>&nbsp;.&nbsp;<input type='text' class='textbox' name='version_l' value='".$version_l."' style='width:50px;'>&nbsp;&nbsp;<input type='text' class='textbox' name='version_s' value='".$version_s."' style='width:100px;'></td>
</tr>
<tr>
<td class='tbl1' nowrap valign='top'>".$locale['addondb402'].":</td>
<td class='tbl1' nowrap><textarea class='textbox' name='version_description' style='width:211px; height:40px;'>".$version_description."</textarea></td>
</tr>
<tr>
<td class='tbl1' nowrap colspan='2' align='center'>".$locale['addondb413']."</td>
</tr>
<tr>
<td class='tbl1' nowrap colspan='2' align='center'><input type='submit' class='button' name='btn_save' value='".$locale['addondb409']."'>".((isset($_GET['action']) && $_GET['action'] == "edit") ? "&nbsp;<input type='submit' class='button' name='btn_cancel' value='".$locale['addondb410']."'>" : "")."</td>
</tr>
</table>
</form>";
closetable();

opentable($locale['addondb400']);
$result = dbquery("SELECT * FROM ".DB_ADDON_VERSIONS." ORDER BY version_order");
if (dbrows($result)) {
	echo "<table align='center' cellpadding='0' cellspacing='1' class='tbl-border'>\n";
	echo "<tr>\n";
	echo "<td class='forum-caption'>".$locale['addondb401']." - ".$locale['addondb414']."</td>\n";
	echo "<td class='forum-caption' align='center' colspan='2'>".$locale['addondb403']."</td>\n";
	echo "<td class='forum-caption' align='right'>".$locale['addondb404']."</td>\n";
	echo "</tr>\n";
	$r = 0;
	while ($data = dbarray($result)) {
		$ver = "v".$data['version_h'].".".$data['version_l'].($data['version_s'] != "" ? " ".$data['version_s'] : "");
		if ($rows != 1) {
			$version_id = $data['version_id'];
			$up = $data['version_order'] - 1;
			$down = $data['version_order'] + 1;
			if ($data['version_order'] == 1) {
				$up_down = "<a href='".FUSION_SELF.$aidlink."&amp;action=move_down&order=".$down."&version_id=".$version_id."' title='".$locale['addondb505']."'><img src='".ADDON_IMG."down.png' border='0' /></a>";
			} elseif ($data['version_order'] < $rows) {
				$up_down = "<a href='".FUSION_SELF.$aidlink."&amp;action=move_up&order=".$up."&version_id=".$version_id."' title='".$locale['addondb504']."'><img src='".ADDON_IMG."up.png' border='0' /></a>";
				$up_down .= "<a href='".FUSION_SELF.$aidlink."&amp;action=move_down&order=".$down."&version_id=".$version_id."' title='".$locale['addondb505']."'><img src='".ADDON_IMG."down.png' border='0' /></a>";
			} else {
				$up_down = "<a href='".FUSION_SELF.$aidlink."&amp;action=move_up&order=".$up."&version_id=".$version_id."' title='".$locale['addondb504']."'><img src='".ADDON_IMG."up.png' border='0' /></a>";
			}
		} else {
			$up_down = "-";
		}
		$cls = ($r++%2 == 0 ? "tbl1" : "tbl2");
		echo "<tr>\n";
		echo "<td class='".$cls."'><a href='".FUSION_SELF.$aidlink."&amp;action=edit&version_id=".$data['version_id']."' title='".$locale['addondb506']."'>".$ver."</a></td>\n";
		echo "<td class='".$cls."' align='center'>".$data['version_order']."</td>\n";
		echo "<td class='".$cls."' align='center'>".$up_down."</td>\n";
		echo "<td class='".$cls."' align='right'><a href='".FUSION_SELF.$aidlink."&amp;action=delete&version_id=".$data['version_id']."' onClick=\"return confirmDeleteVersion('".$ver."')\" title='".$locale['addondb405']."'>".$locale['addondb405']."</a></td>\n";
		echo "</tr>\n";
	}
	echo "</table>";
	echo "<script language='JavaScript'>
	function confirmDeleteVersion(version_name) {
		return confirm('".$locale['addondb415']."\''+version_name+'\'');
	}
	</script>\n";
} else {
	echo "<center><br />".$locale['addondb406']."<br /><br /></center>\n";
}
closetable();

require_once THEMES."templates/footer.php";
?>