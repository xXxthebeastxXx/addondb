<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: addons.php
| Author: PHP-Fusion Addons & Infusions Team
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

require_once INFUSIONS."addondb/infusion_db.php";
require_once INFUSIONS."addondb/inc/inc.functions.php";

include INFUSIONS."addondb/locale/".LOCALESET."addons.php";

$settings['addons_per_page'] = 30;

if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) { $_GET['rowstart'] = 0; }

$db_opts = "addon_status='0'";
$get_vars = "";
$get_prefix = "";
$db_count = "";
$addon_type_list = "";
$addon_cat_id = "";
$addon_modtype = "";
$addon_ver_id = "";
$addon_orderby_list = "";
$addon_orderby_dir_list = "";
$addon_orderby_value = "";
$addon_orderby_dir_value = "";

$check_order_val = array("addon_name", "addon_author_name", "addon_date");
$check_order_dir = array("ASC", "DESC");

if (isset($_GET['addon_cat_id']) && isnum($_GET['addon_cat_id'])) {
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."addon_cat_id=".$_GET['addon_cat_id'];
	if ($_GET['addon_cat_id'] != 0) {
		$addon_cat_id = $_GET['addon_cat_id'];
		$db_opts .= " AND tc.addon_cat_id='".$_GET['addon_cat_id']."'";
		$db_count .= " AND tc.addon_cat_id='".$_GET['addon_cat_id']."'";
	}
}

if (isset($_GET['addon_modtype']) && isnum($_GET['addon_modtype'])) {
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."addon_modtype=".$_GET['addon_modtype'];
	if ($_GET['addon_modtype'] != 0) {
		$addon_modtype = $_GET['addon_modtype'];
		$db_opts .= " AND tm.addon_type='".$_GET['addon_modtype']."'";
		$db_count .= " AND tm.addon_type='".$_GET['addon_modtype']."'";
	}
}
//This should work now
if (isset($_GET['addon_ver_id']) && isnum($_GET['addon_ver_id'])) {
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."addon_ver_id=".$_GET['addon_ver_id'];
	if ($_GET['addon_ver_id'] != 0) {
		$addon_ver_id = $_GET['addon_ver_id'];
		$db_opts .= " AND tv.version_id='".$_GET['addon_ver_id']."'";
		$db_count .= " AND tv.version_id='".$_GET['addon_ver_id']."'";
	}
} elseif (!isset($_GET['addon_ver_id']) && get_newest_version_id()) {
	$addon_ver_id = get_newest_version_id();
	$db_opts .= " AND tv.version_id='$addon_ver_id'";
	$db_count .= " AND tv.version_id='$addon_ver_id'";
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."addon_ver_id=$addon_ver_id";
}

if (isset($_GET['addon_orderby_value']) && in_array($_GET['addon_orderby_value'], $check_order_val)) {
	$addon_orderby_value = stripinput($_GET['addon_orderby_value']);
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."addon_orderby_value=".$addon_orderby_value;
}else{
$addon_orderby_value = "addon_name";
}

if (isset($_GET['addon_orderby_dir_value']) && in_array($_GET['addon_orderby_dir_value'], $check_order_dir)) {
	$addon_orderby_dir_value = stripinput($_GET['addon_orderby_dir_value']);
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."addon_orderby_dir_value=".$addon_orderby_dir_value;
}else{
$addon_orderby_dir_value = "ASC";
}

opentable($locale['addondb400']);
$q_addon_cats = dbquery("SELECT * FROM ".DB_ADDON_CATS." ORDER BY addon_cat_order");
$cat_list = "<option value='0'>View All</option>";
while ($d_addon_cats = dbarray($q_addon_cats)) {
	if (checkgroup($d_addon_cats['addon_cat_access'])) {
		$cat_list .= "<option value='".$d_addon_cats['addon_cat_id']."' ".((isset($addon_cat_id) ? $addon_cat_id : 0) == $d_addon_cats['addon_cat_id'] ? "selected" : "").">".$d_addon_cats['addon_cat_name']."</option>\n";
	}
}
$ver_list = "<option value='0'>View All</option>".buildversionoptionlist($addon_ver_id);
$addon_type_list = "<option value='0'>View All</option>";
foreach ($addon_types as $k=>$addon_type) {
	$addon_type_list .= "<option value='".$k."'".($addon_modtype == $k ? " selected" : "").">".$addon_type."</option>\n";
}
foreach ($addon_orderby as $k=>$addon_orderby) {
	$addon_orderby_list .= "<option value='".$k."'".($addon_orderby_value == $k ? " selected" : "").">".$addon_orderby."</option>\n";
}
foreach ($addon_orderby_dir as $k=>$addon_orderby_dir) {
	$addon_orderby_dir_list .= "<option value='".$k."'".($addon_orderby_dir_value == $k ? " selected" : "").">".$addon_orderby_dir."</option>\n";
}
$rows = dbresult(dbquery("SELECT COUNT(*) FROM ".DB_ADDON_CATS." tc LEFT JOIN ".DB_ADDONS." tm USING(addon_cat_id) LEFT JOIN ".DB_ADDON_VERSIONS." tv USING(version_id) WHERE ".groupaccess('tc.addon_cat_access')." AND ".$db_opts." AND addon_status='0'"),0);
if ($rows != 0) {
	$result = dbquery(
		"SELECT tc.*,tm.*,tv.*,SUM(tr.rating_vote) AS sum_rating, COUNT(tr.rating_item_id) AS count_votes
		FROM ".DB_ADDON_CATS." tc
		LEFT JOIN ".DB_ADDONS." tm USING(addon_cat_id)
		LEFT JOIN ".DB_ADDON_VERSIONS." tv USING(version_id)
		LEFT JOIN ".DB_RATINGS." tr ON tr.rating_item_id = tm.addon_id AND tr.rating_type='M'
		WHERE ".$db_opts." AND ".groupaccess('tc.addon_cat_access')."
		GROUP BY addon_id, tc.addon_cat_id
		ORDER BY addon_cat_order, ".$addon_orderby_value." ".$addon_orderby_dir_value."
		LIMIT ".$_GET['rowstart'].",".$settings['addons_per_page']
	);
}
echo "<form name='filterform' method='get' action='".FUSION_SELF."'>
<table width='100%' cellpadding='0' cellspacing='0' border='0'>
<tr>
<td class='tbl1' width='*' valign='top' rowspan='4'>Welcome to the Addon database.<br />Use the controls on the right to find the Addons you want.</td>
<td class='tbl1' nowrap width='1%' valign='top' align='right'>Category</td>
<td class='tbl1' nowrap width='1%'><select name='addon_cat_id' class='textbox' style='width:200px' onchange=\"submit();\">".$cat_list."</select></td>
<tr>
<td class='tbl1' width='1%' style='white-space:nowrap' valign='top' align='right'>Type</td>
<td class='tbl1' width='1%' style='white-space:nowrap'><select name='addon_modtype' class='textbox' style='width:200px' onchange=\"submit();\">".$addon_type_list."</select></td>
</tr>
<tr>
<td class='tbl1' width='1%' style='white-space:nowrap' valign='top' align='right'>Fusion Version</td>
<td class='tbl1' width='1%' style='white-space:nowrap'><select name='addon_ver_id' class='textbox' style='width:200px' onchange=\"submit();\">".$ver_list."</select></td>
</tr>
<tr>
<td class='tbl1' width='1%' style='white-space:nowrap' valign='top' align='right'>Order By</td>
<td class='tbl1' width='1%' style='white-space:nowrap'><select name='addon_orderby_value' class='textbox' style='width:100px' onchange=\"submit();\">".$addon_orderby_list."</select><select name='addon_orderby_dir_value' class='textbox' style='width:100px' onchange=\"submit();\">".$addon_orderby_dir_list."</select></td>
</tr>
</table>
</form>\n";
tablebreak();
if ($rows != 0) {
	echo "<table border='0' cellpadding='0' cellspacing='0' width='100%' class='tbl-border'>
	<tr>
	<td>
	<table border='0' cellpadding='0' cellspacing='1' width='100%'>
	<tr>
	<td class='tbl2' colspan='2' style='white-space:nowrap'>".$locale['addondb401']."</td>
	<td class='tbl2' width='1%' style='white-space:nowrap'>".$locale['addondb405']."</td>
	<td class='tbl2' width='1%' style='white-space:nowrap'>".$locale['addondb402']."</td>
	<td class='tbl2' width='1%' style='white-space:nowrap'>".$locale['addondb403']."</td>
	<td class='tbl2' width='1%' style='white-space:nowrap'>".$locale['addondb404']."</td>
	<td class='tbl2' width='1%' style='white-space:nowrap'>".$locale['addondb406']."</td>
	</tr>\n";
	$addon_cat_old = -1;
	while ($data = dbarray($result)) {
		if ($data['addon_cat_id'] <> $addon_cat_old) {
			echo "<tr>
			<td class='forum-caption' colspan='7' nowrap>".stripslashes($data['addon_cat_name'])."</td>
			</tr>\n";
		}
		if ($data['addon_id']) {
			$ver = "v".$data['version_h'].".".$data['version_l'].($data['version_s'] != "" ? " ".$data['version_s'] : "");
			if ($data['count_votes'] > 0) {
				$rating = str_repeat("<img src='".INFUSIONS."addondb/img/star.png' alt='".$locale['addondb407']."' />", ceil($data['sum_rating'] / $data['count_votes']));
			} else {
				$rating = $locale['addondb408'];
			}
			$addon_author = ($data['addon_author_name'] == "" ? $locale['addondb409'] : $data['addon_author_name']);

			if ($data['addon_date'] + 604800 > time() + ($settings['timeoffset'] * 3600)) { $new = "<img src='".INFUSIONS."addondb/img/new.gif' border='0' alt='' />";
                } else {
              $new = "<img src='".THEME."images/blank.gif' width='20' height='1' border='0' alt='' />"; }

			echo "<tr>
			<td class='tbl2' width='3%' style='white-space:nowrap'>".$new."</td>
			<td class='tbl1' style='white-space:nowrap'><a href='view.php?addon_id=".$data['addon_id']."'>".trimlink($data['addon_name'], 30)."</a></td>
			<td class='tbl2' width='1%' style='white-space:nowrap'>".strftime("%d/%m/%Y",$data['addon_date']+($settings['timeoffset']*3600))."</td>
			<td class='tbl2' width='1%' style='white-space:nowrap'><span title='".$addon_author."'>".trimlink($addon_author, 20)."</span></td>
			<td class='tbl2' width='1%' style='white-space:nowrap'>".$data['addon_version']."</td>
			<td class='tbl1' width='1%' style='white-space:nowrap'>".$ver."</td>
			<td class='tbl1' width='1%' style='white-space:nowrap'>".$rating."</td>
			</tr>\n";
			$addon_cat_old = $data['addon_cat_id'];
		} else {
			echo "<tr>
			<td class='tbl2' width='3%' align='center'>-</td>
			<td class='tbl1' colspan='7'>".(isset($addon_cat_id) || isset($addon_ver_id) || isset($addon_modtype) ? $locale['addondb424'] : $locale['addondb422'])."</td>
			</tr>\n";
		}
	}
	echo "</table>
	</td>
	</tr>
	</table>\n";
} else {
	if (iMEMBER) {
		echo "<center><br />".(isset($addon_cat_id) || isset($addon_ver_id) || isset($addon_modtype) ? $locale['addondb424'] : $locale['addondb421'])."<br /><br /></center>\n";
	} else {
		echo "<div style='text-align:center;margin-top:2em;margin-bottom:2em;'>".$locale['addondb425']." <a href='".BASEDIR."register.php' title='".$locale['addondb428']."'>".$locale['addondb426']."</a> ".$locale['addondb427']."</div>";
	}
}
if ($rows > $settings['addons_per_page']) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($_GET['rowstart'], $settings['addons_per_page'], $rows, 3, ($get_vars ? FUSION_SELF."".$get_vars."&amp;" : ""))."\n</div>\n";
closetable();

echo "<script type='text/javascript'>function filterMods(criteria) {\n";
echo "document.location.href='".INFUSIONS."addondb/addons.php?show='+criteria;\n}\n";
echo "</script>\n";
add_to_title ($locale['addondb435'].$locale['addondb400']);
require_once THEMES."templates/footer.php";
?>