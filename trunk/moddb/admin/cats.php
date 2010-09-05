<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: cats.php
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

if (file_exists(INFUSIONS."moddb/locale/".LOCALESET."admin/admin.php")) {
	include INFUSIONS."moddb/locale/".LOCALESET."admin/admin.php";
} else {
	include INFUSIONS."moddb/locale/English/admin/admin.php";
}

// Error Messages
if (isset($_GET['error']) && isnum($_GET['error'])) {
	echo "<div class='admin-message'>\n";
	if ($_GET['error'] == 1) { echo $locale['moddb482'];
	} elseif ($_GET['error'] == 2) { echo $locale['moddb483'];
	} elseif ($_GET['error'] == 3) { echo "Unknown action error occurred!";
	} elseif ($_GET['error'] == 4) { echo "Selected cat does not exist in the database!";
	} else { echo "An unknown error occurred!"; }
	echo "</div>\n";
}

// Cancel Button
if (isset($_POST['btn_cancel'])) {
	redirect(FUSION_SELF.$aidlink);
}

// If Action and MOD CAT ID is set!
if (isset($_GET['action']) && isset($_GET['mod_cat_id']) && isnum($_GET['mod_cat_id'])) {
	$cat_result = dbquery(
		"SELECT * 
		FROM ".DB_MOD_CATS." 
		WHERE mod_cat_id='".$_GET['mod_cat_id']."'
		LIMIT 1"
	);
	if (dbrows($cat_result)) {
		$mod_cat_id = $_GET['mod_cat_id'];
		$cat_data = dbarray($cat_result);
		// Delete
		if ($_GET['action'] == "delete") {
			$mod_cat_order = dbresult(dbquery("SELECT mod_cat_order FROM ".DB_MOD_CATS." WHERE mod_cat_id='".$mod_cat_id."'"),0);
			$result = dbquery("UPDATE ".DB_MOD_CATS." SET mod_cat_order=(mod_cat_order-1) WHERE mod_cat_order>'".$mod_cat_order."'");
			$result = dbquery("DELETE FROM ".DB_MOD_CATS." WHERE mod_cat_id='".$mod_cat_id."'");
			redirect(FUSION_SELF.$aidlink);
		// Move Up
		} elseif ($_GET['action'] == "move_up") {
			$data = dbarray(dbquery("SELECT * FROM ".DB_MOD_CATS." WHERE mod_cat_order='".$order."'"));
			$result = dbquery("UPDATE ".DB_MOD_CATS." SET mod_cat_order=mod_cat_order+1 WHERE mod_cat_id='".$data['mod_cat_id']."'");
			$result = dbquery("UPDATE ".DB_MOD_CATS." SET mod_cat_order=mod_cat_order-1 WHERE mod_cat_id='".$mod_cat_id."'");
			redirect(FUSION_SELF.$aidlink);
		// Move Down
		} elseif ($_GET['action'] == "move_down") {
			$data = dbarray(dbquery("SELECT * FROM ".DB_MOD_CATS." WHERE mod_cat_order='".$order."'"));
			$result = dbquery("UPDATE ".DB_MOD_CATS." SET mod_cat_order=mod_cat_order-1 WHERE mod_cat_id='".$data['mod_cat_id']."'");
			$result = dbquery("UPDATE ".DB_MOD_CATS." SET mod_cat_order=mod_cat_order+1 WHERE mod_cat_id='".$mod_cat_id."'");
			redirect(FUSION_SELF.$aidlink);
		// Edit
		} elseif ($_GET['action'] == "edit") {
			// Save Cat
			if (isset($_POST['btn_save'])) {
				$mod_cat_name = stripinput($_POST['mod_cat_name']);
				$mod_cat_description = stripinput($_POST['mod_cat_description']);
				$mod_cat_access = stripinput($_POST['mod_cat_access']);
				if (empty($mod_cat_name)) {
					redirect(FUSION_SELF.$aidlink."&amp;error=1");
				} elseif (dbcount("(*)", DB_MOD_CATS, "mod_cat_name='$mod_cat_name' AND mod_cat_id!='$mod_cat_id'") != 0) {
					redirect(FUSION_SELF.$aidlink."&amp;error=2");
				} else {
					$result = dbquery(
						"UPDATE ".DB_MOD_CATS." SET 
							mod_cat_name='".$mod_cat_name."',
							mod_cat_description='".$mod_cat_description."',
							mod_cat_access='".$mod_cat_access."' 
						WHERE mod_cat_id='".$mod_cat_id."' LIMIT 1");
					redirect(FUSION_SELF.$aidlink."&amp;update=ok");
				}
			} else {
				$mod_cat_name = $cat_data['mod_cat_name'];
				$mod_cat_description = $cat_data['mod_cat_description'];
				$mod_cat_access = $cat_data['mod_cat_access'];
				opentable($locale['moddb435']);
				$cat_formaction = FUSION_SELF.$aidlink."&amp;action=edit&amp;mod_cat_id=".$_GET['mod_cat_id'];			
			}
		} else {
			redirect(FUSION_SELF.$aidlink."&amp;error=3");
		}
	} else {
		redirect(FUSION_SELF.$aidlink."&amp;error=4");
	}
} elseif (isset($_POST['btn_save'])) {
	$mod_cat_name = stripinput($_POST['mod_cat_name']);
	$mod_cat_description = stripinput($_POST['mod_cat_description']);
	$mod_cat_access = stripinput($_POST['mod_cat_access']);
	if (empty($mod_cat_name)) {
		redirect(FUSION_SELF.$aidlink."&amp;error=1");
	} elseif (dbcount("(*)", DB_MOD_CATS, "mod_cat_name='$mod_cat_name'") != 0) {
		redirect(FUSION_SELF.$aidlink."&amp;error=2");
	} else {
		$mod_cat_order = dbresult(dbquery("SELECT MAX(mod_cat_order) FROM ".DB_MOD_CATS),0) + 1;
		$result = dbquery(
			"INSERT INTO ".DB_MOD_CATS." 
			VALUES('','".$mod_cat_name."','".$mod_cat_description."','".$mod_cat_access."','".$mod_cat_order."')"
		);
		redirect(FUSION_SELF.$aidlink."&amp;insert=ok");
	}
} else {
	$mod_cat_name = "";
	$mod_cat_description = "";
	$mod_cat_access = "";
	opentable($locale['moddb436']);
	$cat_formaction = FUSION_SELF.$aidlink;			
}

$user_groups = getusergroups(); $access_opts = ""; $sel = "";
while (list($key, $user_group) = each($user_groups)) {
	$sel = ($mod_cat_access == $user_group['0'] ? " selected" : "");
	$access_opts .= "<option value='".$user_group['0']."'$sel>".$user_group['1']."</option>\n";
}
echo "<form name='add_cat' method='post' action='$cat_formaction'>";
echo "<table align='center' cellpadding='0' cellspacing='0' class='tbl-border'>".(isset($error) ? "<tr><td class='tbl1 error' align='center' colspan='3'>".$error."</td></tr>" : "")."
<tr>
<td class='tbl1' nowrap>".$locale['moddb402']."<strong><span style='color:red'>*</span></strong>:</td>
<td class='tbl1'><input type='text' class='textbox' name='mod_cat_name' value='".$mod_cat_name."' style='width:250px;'></td>
</tr>
<tr>
<td class='tbl1' nowrap valign='top'>".$locale['moddb404'].":</td>
<td class='tbl1'><textarea class='textbox' name='mod_cat_description' style='width:250px; height:40px;'>".$mod_cat_description."</textarea></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['moddb405'].":</td>
<td class='tbl1'><select class='textbox' name='mod_cat_access' style='width:250px;'>".$access_opts."</select></td>
</tr>
<tr>
<td class='tbl1' nowrap colspan='2' align='center'>".$locale['moddb437']."</td>
</tr>
<tr>
<td class='tbl1' nowrap colspan='2' align='center'><input type='submit' class='button' name='btn_save' value='".$locale['moddb438']."'>".(isset($_GET['action']) && $_GET['action'] == "edit" || isset($error) ? "&nbsp;<input type='submit' class='button' name='btn_cancel' value='".$locale['moddb428']."'>" : "")."</td>
</tr>
</table>
</form>";
closetable();

opentable($locale['moddb401']);
$q_mod_cats = dbquery(
	"SELECT tc.*, COUNT(tm.mod_id) AS mod_count
	FROM ".DB_MOD_CATS." tc LEFT JOIN ".DB_MODS." tm USING(mod_cat_id)
	GROUP BY mod_cat_id ORDER BY mod_cat_order"
);
$rows = dbrows($q_mod_cats);
if ($rows != 0) {
	echo "<table width='100%' align='center' cellpadding='0' cellspacing='1' class='tbl-border'>
	<tr>
	<td class='forum-caption'>".$locale['moddb402']." - ".$locale['moddb441']."</td>
	<td class='forum-caption'>".$locale['moddb405']."</td>
	<td class='forum-caption' align='center'>".$locale['moddb433']."</td>
	<td class='forum-caption' align='center' colspan='2'>".$locale['moddb432']."</td>
	<td class='forum-caption' align='right'>".$locale['moddb420']."</td>
	</tr>";
	$r = 0;
	while ($d_mod_cats = dbarray($q_mod_cats)) {
		$up_down = "";
		if ($rows != 1) {
			$mod_cat_id = $d_mod_cats['mod_cat_id'];
			$up = $d_mod_cats['mod_cat_order'] - 1;
			$down = $d_mod_cats['mod_cat_order'] + 1;
			if ($d_mod_cats['mod_cat_order'] == 1) {
				$up_down = "<a href='".FUSION_SELF.$aidlink."&amp;action=move_down&order=".$down."&mod_cat_id=".$mod_cat_id."' title='".$locale['moddb503']."'><img src='".THEME."images/down.gif' border='0' /></a>";
			} elseif ($d_mod_cats['mod_cat_order'] < $rows) {
				$up_down = "<a href='".FUSION_SELF.$aidlink."&amp;action=move_up&order=".$up."&mod_cat_id=".$mod_cat_id."' title='".$locale['moddb502']."'><img src='".THEME."images/up.gif' border='0' /></a>&nbsp;";
				$up_down .= "<a href='".FUSION_SELF.$aidlink."&amp;action=move_down&order=".$down."&mod_cat_id=".$mod_cat_id."' title='".$locale['moddb503']."'><img src='".THEME."images/down.gif' border='0' /></a>";
			} else {
				$up_down="<a href='".FUSION_SELF.$aidlink."&amp;action=move_up&order=".$up."&mod_cat_id=".$mod_cat_id."' title='".$locale['moddb502']."'><img src='".THEME."images/up.gif' border='0' /></a>";
			}
		}
		$cls = ($r++%2 == 0 ? "tbl1" : "tbl2");
		echo " <tr>
		<td class='".$cls."'><a href='".FUSION_SELF.$aidlink."&amp;action=edit&mod_cat_id=".$d_mod_cats['mod_cat_id']."' title='".$locale['moddb500']."'>".$d_mod_cats['mod_cat_name']."</a></td>
		<td class='".$cls."'><span class='small'>".getgroupname($d_mod_cats['mod_cat_access'])."</span></td>
		<td class='".$cls."' align='center'><span class='small'>".$d_mod_cats['mod_count']."</span></td>
		<td class='".$cls."' align='center'><span class='small'>".$d_mod_cats['mod_cat_order']."</span></td>
		<td class='".$cls."' align='center'>".$up_down."</td>
		<td class='".$cls."' align='right'><span class='small'>".($d_mod_cats['mod_count'] == 0 ? "<a href='".FUSION_SELF.$aidlink."&amp;action=delete&mod_cat_id=".$d_mod_cats['mod_cat_id']."' onClick=\"return confirmDeleteMODCat('".$d_mod_cats['mod_cat_name']."')\" title='".$locale['moddb501']."'>".$locale['moddb422']."</a>" : "-")."</span></td>
		</tr>\n";
	}
	echo "</table>";
	echo "<script language='JavaScript'>
	function confirmDeleteMODCat(mod_cat_name) {
		return confirm('".$locale['moddb439']."\''+mod_cat_name+'\'');
	}
	</script>\n";
} else {
	echo "<center><br />".$locale['moddb434']."<br /><br /></center>\n";
}
closetable();

require_once THEMES."templates/footer.php";
?>