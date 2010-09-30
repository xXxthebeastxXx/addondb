<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: cats.php
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
require_once ADDON_INC."inc.nav.php";

if (file_exists(ADDON_LOCALE.LOCALESET."admin/admin.php")) {
	include ADDON_LOCALE.LOCALESET."admin/admin.php";
} else {
	include ADDON_LOCALE."English/admin/admin.php";
}

// Error Messages
if (isset($_GET['error']) && isnum($_GET['error'])) {
	$errormsg = "<div class='admin-message'>\n";
	if ($_GET['error'] == 1) { $errormsg .= $locale['addondb482'];
	} elseif ($_GET['error'] == 2) { $errormsg .= $locale['addondb483'];
	} elseif ($_GET['error'] == 3) { $errormsg .= "Unknown action error occurred!";
	} elseif ($_GET['error'] == 4) { $errormsg .= "Selected cat does not exist in the database!";
	} else { $errormsg .= "An unknown error occurred!"; }
	$errormsg .= "</div>\n";
	echo $errormsg;
}

// Cancel Button
if (isset($_POST['btn_cancel'])) {
	redirect(FUSION_SELF.$aidlink);
}

// If Action and Addon CAT ID is set!
if (isset($_GET['action']) && isset($_GET['addon_cat_id']) && isnum($_GET['addon_cat_id'])) {
	$cat_result = dbquery(
		"SELECT * 
		FROM ".DB_ADDON_CATS." 
		WHERE addon_cat_id='".$_GET['addon_cat_id']."' 
		LIMIT 1"
	);
	if (dbrows($cat_result)) {
		$addon_cat_id = $_GET['addon_cat_id'];
		$cat_data = dbarray($cat_result);
		// Delete
		if ($_GET['action'] == "delete") {
			$addon_cat_order = dbresult(dbquery("SELECT addon_cat_order FROM ".DB_ADDON_CATS." WHERE addon_cat_id='".$addon_cat_id."'"),0);
			$result = dbquery("UPDATE ".DB_ADDON_CATS." SET addon_cat_order=(addon_cat_order-1) WHERE addon_cat_order>'".$addon_cat_order."'");
			$result = dbquery("DELETE FROM ".DB_ADDON_CATS." WHERE addon_cat_id='".$addon_cat_id."'");
			redirect(FUSION_SELF.$aidlink);
		// Move Up
		} elseif ($_GET['action'] == "move_up") {
			$data = dbarray(dbquery("SELECT * FROM ".DB_ADDON_CATS." WHERE addon_cat_order='".$order."'"));
			$result = dbquery("UPDATE ".DB_ADDON_CATS." SET addon_cat_order=addon_cat_order+1 WHERE addon_cat_id='".$data['addon_cat_id']."'");
			$result = dbquery("UPDATE ".DB_ADDON_CATS." SET addon_cat_order=addon_cat_order-1 WHERE addon_cat_id='".$addon_cat_id."'");
			redirect(FUSION_SELF.$aidlink);
		// Move Down
		} elseif ($_GET['action'] == "move_down") {
			$data = dbarray(dbquery("SELECT * FROM ".DB_ADDON_CATS." WHERE addon_cat_order='".$order."'"));
			$result = dbquery("UPDATE ".DB_ADDON_CATS." SET addon_cat_order=addon_cat_order-1 WHERE addon_cat_id='".$data['addon_cat_id']."'");
			$result = dbquery("UPDATE ".DB_ADDON_CATS." SET addon_cat_order=addon_cat_order+1 WHERE addon_cat_id='".$addon_cat_id."'");
			redirect(FUSION_SELF.$aidlink);
		// Edit
		} elseif ($_GET['action'] == "edit") {
			// Save Cat
			if (isset($_POST['btn_save'])) {
				$addon_cat_type = stripinput($_POST['addon_cat_type']);
				$addon_cat_name = stripinput($_POST['addon_cat_name']);
				$addon_cat_description = stripinput($_POST['addon_cat_description']);
				$addon_cat_access = stripinput($_POST['addon_cat_access']);
				if (empty($addon_cat_name)) {
					redirect(FUSION_SELF.$aidlink."&amp;error=1");
				} elseif (dbcount("(*)", DB_ADDON_CATS, "addon_cat_name='$addon_cat_name' AND addon_cat_type='$addon_cat_type'") != 0) { 
				redirect(FUSION_SELF.$aidlink."&amp;error=2");
				} else {
					$result = dbquery(
						"UPDATE ".DB_ADDON_CATS." SET 
							addon_cat_type='".$addon_cat_type."',
							addon_cat_name='".$addon_cat_name."',
							addon_cat_description='".$addon_cat_description."',
							addon_cat_access='".$addon_cat_access."' 
						WHERE addon_cat_id='".$addon_cat_id."' LIMIT 1");
					redirect(FUSION_SELF.$aidlink."&amp;update=ok");
				}
			} else {
				$addon_cat_type = $cat_data['addon_cat_type'];
				$addon_cat_name = $cat_data['addon_cat_name'];
				$addon_cat_description = $cat_data['addon_cat_description'];
				$addon_cat_access = $cat_data['addon_cat_access'];
				opentable($locale['addondb435']);
				$cat_formaction = FUSION_SELF.$aidlink."&amp;action=edit&amp;addon_cat_id=".$_GET['addon_cat_id'];			
			}
		} else {
			redirect(FUSION_SELF.$aidlink."&amp;error=3");
		}
	} else {
		redirect(FUSION_SELF.$aidlink."&amp;error=4");
	}
} elseif (isset($_POST['btn_save'])) {
	$addon_cat_type = stripinput($_POST['addon_cat_type']);
	$addon_cat_name = stripinput($_POST['addon_cat_name']);
	$addon_cat_description = stripinput($_POST['addon_cat_description']);
	$addon_cat_access = stripinput($_POST['addon_cat_access']);
	if (empty($addon_cat_name)) {
		redirect(FUSION_SELF.$aidlink."&amp;error=1");
	} elseif (dbcount("(*)", DB_ADDON_CATS, "addon_cat_name='$addon_cat_name' AND addon_cat_type='$addon_cat_type'") != 0) {
		redirect(FUSION_SELF.$aidlink."&amp;error=2");
	} else {
		$addon_cat_order = dbresult(dbquery("SELECT MAX(addon_cat_order) FROM ".DB_ADDON_CATS." WHERE addon_cat_type='$addon_cat_type'"),0) + 1;
		$result = dbquery(
			"INSERT INTO ".DB_ADDON_CATS." 
			VALUES('','".$addon_cat_type."', '".$addon_cat_name."','".$addon_cat_description."','".$addon_cat_access."','".$addon_cat_order."')"
		);
		redirect(FUSION_SELF.$aidlink."&amp;insert=ok");
	}
} else {
	$addon_cat_type = "";
	$addon_cat_name = "";
	$addon_cat_description = "";
	$addon_cat_access = "";
	opentable($locale['addondb436']);
	$cat_formaction = FUSION_SELF.$aidlink;			
}

$user_groups = getusergroups(); $access_opts = ""; $sel = "";
while (list($key, $user_group) = each($user_groups)) {
	$sel = ($addon_cat_access == $user_group['0'] ? " selected='selected'" : "");
	$access_opts .= "<option value='".$user_group['0']."'$sel>".$user_group['1']."</option>\n";
}
$addon_type_list = ""; $tsel = "";
foreach ($addon_types as $k=>$addon_type) {
	$tsel = ($addon_cat_type == $k ? " selected='selected'" : "");
	$addon_type_list .= "<option value='".$k."'$tsel>".$addon_type."</option>\n";
}
echo "<form name='add_cat' method='post' action='$cat_formaction'>
	<table align='center' cellpadding='0' cellspacing='0' class='tbl-border'>".(isset($error) ? "<tr><td class='tbl1 error' align='center' colspan='3'>".$error."</td></tr>" : "")."
		<tr>
			<td class='tbl1' nowrap>".$locale['addondb402']."<strong><span style='color:red'>*</span></strong>:</td>
			<td class='tbl1'><input type='text' class='textbox' name='addon_cat_name' value='".$addon_cat_name."' style='width:250px;'></td>
		</tr>
		<tr>
			<td class='tbl1' nowrap valign='top'>".$locale['addondb404'].":</td>
			<td class='tbl1'><textarea class='textbox' name='addon_cat_description' style='width:250px; height:40px;'>".$addon_cat_description."</textarea></td>
		</tr>
		<tr>
			<td class='tbl1' nowrap>Type</td>
			<td class='tbl1'><select class='textbox' name='addon_cat_type' style='width:250px;'>".$addon_type_list."</select></td>
		</tr>
		<tr>
			<td class='tbl1' nowrap>".$locale['addondb405'].":</td>
			<td class='tbl1'><select class='textbox' name='addon_cat_access' style='width:250px;'>".$access_opts."</select></td>
		</tr>
		<tr>
		<td class='tbl1' nowrap colspan='2' align='center'>".$locale['addondb437']."</td>
		</tr>
		<tr>
			<td class='tbl1' nowrap colspan='2' align='center'><input type='submit' class='button' name='btn_save' value='".$locale['addondb438']."' />".(isset($_GET['action']) && $_GET['action'] == "edit" || isset($error) ? "&nbsp;<input type='submit' class='button' name='btn_cancel' value='".$locale['addondb428']."' />" : "")."</td>
		</tr>
	</table>
</form>";
closetable();

opentable($locale['addondb401']);
$q_addon_cats = dbquery(
	"SELECT tc.*, COUNT(tm.addon_id) AS addon_count
	FROM ".DB_ADDON_CATS." tc LEFT JOIN ".DB_ADDONS." tm USING(addon_cat_id)
	GROUP BY addon_cat_id ORDER BY addon_cat_type,addon_cat_order"
);
$rows = dbrows($q_addon_cats);
if ($rows != 0) {
	echo "<table width='100%' align='center' cellpadding='0' cellspacing='1' class='tbl-border'>
	<tr>
	<td class='forum-caption'>".$locale['addondb402']." - ".$locale['addondb441']."</td>
	<td class='forum-caption'>Type</td>
	<td class='forum-caption'>".$locale['addondb405']."</td>
	<td class='forum-caption' align='center'>".$locale['addondb433']."</td>
	<td class='forum-caption' align='center' colspan='2'>".$locale['addondb432']."</td>
	<td class='forum-caption' align='right'>".$locale['addondb420']."</td>
	</tr>";
	$r = 0; $up_down = "";
	while ($d_addon_cats = dbarray($q_addon_cats)) {
		if ($rows != 1) {
			$addon_cat_id = $d_addon_cats['addon_cat_id'];
			$up = $d_addon_cats['addon_cat_order'] - 1;
			$down = $d_addon_cats['addon_cat_order'] + 1;
			if ($d_addon_cats['addon_cat_order'] == 1) {
				$up_down = "<a href='".FUSION_SELF.$aidlink."&amp;action=move_down&order=".$down."&addon_cat_id=".$addon_cat_id."' title='".$locale['addondb503']."'><img src='".THEME."images/down.gif' border='0' /></a>";
			} elseif ($d_addon_cats['addon_cat_order'] < $rows) {
				$up_down = "<a href='".FUSION_SELF.$aidlink."&amp;action=move_up&order=".$up."&addon_cat_id=".$addon_cat_id."' title='".$locale['addondb502']."'><img src='".THEME."images/up.gif' border='0' /></a>&nbsp;";
				$up_down .= "<a href='".FUSION_SELF.$aidlink."&amp;action=move_down&order=".$down."&addon_cat_id=".$addon_cat_id."' title='".$locale['addondb503']."'><img src='".THEME."images/down.gif' border='0' /></a>";
			} else {
				$up_down="<a href='".FUSION_SELF.$aidlink."&amp;action=move_up&order=".$up."&addon_cat_id=".$addon_cat_id."' title='".$locale['addondb502']."'><img src='".THEME."images/up.gif' border='0' /></a>";
			}
		}
		$cls = ($r++%2 == 0 ? "tbl1" : "tbl2");
		echo " <tr>
		<td class='".$cls."'><a href='".FUSION_SELF.$aidlink."&amp;action=edit&addon_cat_id=".$d_addon_cats['addon_cat_id']."' title='".$locale['addondb500']."'>".$d_addon_cats['addon_cat_name']."</a></td>
		<td class='".$cls."'><span class='small'>".get_addon_type($d_addon_cats['addon_cat_type'])."</span></td>
		<td class='".$cls."'><span class='small'>".getgroupname($d_addon_cats['addon_cat_access'])."</span></td>
		<td class='".$cls."' align='center'><span class='small'>".$d_addon_cats['addon_count']."</span></td>
		<td class='".$cls."' align='center'><span class='small'>".$d_addon_cats['addon_cat_order']."</span></td>
		<td class='".$cls."' align='center'>".$up_down."</td>
		<td class='".$cls."' align='right'><span class='small'>".($d_addon_cats['addon_count'] == 0 ? "<a href='".FUSION_SELF.$aidlink."&amp;action=delete&addon_cat_id=".$d_addon_cats['addon_cat_id']."' onClick=\"return confirmDeleteAddonCat('".$d_addon_cats['addon_cat_name']."')\" title='".$locale['addondb501']."'>".$locale['addondb422']."</a>" : "-")."</span></td>
		</tr>\n";
	}
	echo "</table>";
	echo "<script language='JavaScript'>
	function confirmDeleteAddonCat(addon_cat_name) {
		return confirm('".$locale['addondb439']."\''+addon_cat_name+'\'');
	}
	</script>\n";
} else {
	echo "<center><br />".$locale['addondb434']."<br /><br /></center>\n";
}
closetable();

require_once THEMES."templates/footer.php";
?>