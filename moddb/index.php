<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: mods.php
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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

require_once INFUSIONS."moddb/infusion_db.php";
require_once INFUSIONS."moddb/inc/inc.functions.php";

include INFUSIONS."moddb/locale/".LOCALESET."mods.php";

$settings['mods_per_page'] = 30;

if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) { $_GET['rowstart'] = 0; }

$db_opts = "mod_status='0'";
$get_vars = "";
$get_prefix = "";
$db_count = "";
$mod_type_list = "";
$mod_cat_id = "";
$mod_modtype = "";
$mod_ver_id = "";
$mod_orderby_list = "";
$mod_orderby_dir_list = "";
$mod_orderby_value = "";
$mod_orderby_dir_value = "";

$check_order_val = array("mod_name", "mod_author_name", "mod_date");
$check_order_dir = array("ASC", "DESC");

if (isset($_GET['mod_cat_id']) && isnum($_GET['mod_cat_id'])) {
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."mod_cat_id=".$_GET['mod_cat_id'];
	if ($_GET['mod_cat_id'] != 0) {
		$mod_cat_id = $_GET['mod_cat_id'];
		$db_opts .= " AND tc.mod_cat_id='".$_GET['mod_cat_id']."'";
		$db_count .= " AND tc.mod_cat_id='".$_GET['mod_cat_id']."'";
	}
}

if (isset($_GET['mod_modtype']) && isnum($_GET['mod_modtype'])) {
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."mod_modtype=".$_GET['mod_modtype'];
	if ($_GET['mod_modtype'] != 0) {
		$mod_modtype = $_GET['mod_modtype'];
		$db_opts .= " AND tm.mod_type='".$_GET['mod_modtype']."'";
		$db_count .= " AND tm.mod_type='".$_GET['mod_modtype']."'";
	}
}
//This should work now
if (isset($_GET['mod_ver_id']) && isnum($_GET['mod_ver_id'])) {
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."mod_ver_id=".$_GET['mod_ver_id'];
	if ($_GET['mod_ver_id'] != 0) {
		$mod_ver_id = $_GET['mod_ver_id'];
		$db_opts .= " AND tv.version_id='".$_GET['mod_ver_id']."'";
		$db_count .= " AND tv.version_id='".$_GET['mod_ver_id']."'";
	}
} elseif (!isset($_GET['mod_ver_id']) && get_newest_version_id()) {
	$mod_ver_id = get_newest_version_id();
	$db_opts .= " AND tv.version_id='$mod_ver_id'";
	$db_count .= " AND tv.version_id='$mod_ver_id'";
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."mod_ver_id=$mod_ver_id";
}

if (isset($_GET['mod_orderby_value']) && in_array($_GET['mod_orderby_value'], $check_order_val)) {
	$mod_orderby_value = stripinput($_GET['mod_orderby_value']);
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."mod_orderby_value=".$mod_orderby_value;
}else{
$mod_orderby_value = "mod_name";
}

if (isset($_GET['mod_orderby_dir_value']) && in_array($_GET['mod_orderby_dir_value'], $check_order_dir)) {
	$mod_orderby_dir_value = stripinput($_GET['mod_orderby_dir_value']);
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."mod_orderby_dir_value=".$mod_orderby_dir_value;
}else{
$mod_orderby_dir_value = "ASC";
}

opentable($locale['moddb400']);
$q_mod_cats = dbquery("SELECT * FROM ".DB_MOD_CATS." ORDER BY mod_cat_order");
$cat_list = "<option value='0'>View All</option>";
while ($d_mod_cats = dbarray($q_mod_cats)) {
	if (checkgroup($d_mod_cats['mod_cat_access'])) {
		$cat_list .= "<option value='".$d_mod_cats['mod_cat_id']."' ".((isset($mod_cat_id) ? $mod_cat_id : 0) == $d_mod_cats['mod_cat_id'] ? "selected" : "").">".$d_mod_cats['mod_cat_name']."</option>\n";
	}
}
$ver_list = "<option value='0'>View All</option>".buildversionoptionlist($mod_ver_id);
$mod_type_list = "<option value='0'>View All</option>";
foreach ($mod_types as $k=>$mod_type) {
	$mod_type_list .= "<option value='".$k."'".($mod_modtype == $k ? " selected" : "").">".$mod_type."</option>\n";
}
foreach ($mod_orderby as $k=>$mod_orderby) {
	$mod_orderby_list .= "<option value='".$k."'".($mod_orderby_value == $k ? " selected" : "").">".$mod_orderby."</option>\n";
}
foreach ($mod_orderby_dir as $k=>$mod_orderby_dir) {
	$mod_orderby_dir_list .= "<option value='".$k."'".($mod_orderby_dir_value == $k ? " selected" : "").">".$mod_orderby_dir."</option>\n";
}
$rows = dbresult(dbquery("SELECT COUNT(*) FROM ".DB_MOD_CATS." tc LEFT JOIN ".DB_MODS." tm USING(mod_cat_id) LEFT JOIN ".DB_MOD_VERSIONS." tv USING(version_id) WHERE ".groupaccess('tc.mod_cat_access')." AND ".$db_opts." AND mod_status='0'"),0);
if ($rows != 0) {
	$result = dbquery(
		"SELECT tc.*,tm.*,tv.*,SUM(tr.rating_vote) AS sum_rating, COUNT(tr.rating_item_id) AS count_votes
		FROM ".DB_MOD_CATS." tc
		LEFT JOIN ".DB_MODS." tm USING(mod_cat_id)
		LEFT JOIN ".DB_MOD_VERSIONS." tv USING(version_id)
		LEFT JOIN ".DB_RATINGS." tr ON tr.rating_item_id = tm.mod_id AND tr.rating_type='M'
		WHERE ".$db_opts." AND ".groupaccess('tc.mod_cat_access')."
		GROUP BY mod_id, tc.mod_cat_id
		ORDER BY mod_cat_order, ".$mod_orderby_value." ".$mod_orderby_dir_value."
		LIMIT ".$_GET['rowstart'].",".$settings['mods_per_page']
	);
}
echo "<form name='filterform' method='get' action='".FUSION_SELF."'>
<table width='100%' cellpadding='0' cellspacing='0' border='0'>
<tr>
<td class='tbl1' width='*' valign='top' rowspan='4'>Welcome to the MOD database.<br />Use the controls on the right to find the MODs you want.</td>
<td class='tbl1' nowrap width='1%' valign='top' align='right'>Category</td>
<td class='tbl1' nowrap width='1%'><select name='mod_cat_id' class='textbox' style='width:200px' onchange=\"submit();\">".$cat_list."</select></td>
<tr>
<td class='tbl1' width='1%' style='white-space:nowrap' valign='top' align='right'>Type</td>
<td class='tbl1' width='1%' style='white-space:nowrap'><select name='mod_modtype' class='textbox' style='width:200px' onchange=\"submit();\">".$mod_type_list."</select></td>
</tr>
<tr>
<td class='tbl1' width='1%' style='white-space:nowrap' valign='top' align='right'>Fusion Version</td>
<td class='tbl1' width='1%' style='white-space:nowrap'><select name='mod_ver_id' class='textbox' style='width:200px' onchange=\"submit();\">".$ver_list."</select></td>
</tr>
<tr>
<td class='tbl1' width='1%' style='white-space:nowrap' valign='top' align='right'>Order By</td>
<td class='tbl1' width='1%' style='white-space:nowrap'><select name='mod_orderby_value' class='textbox' style='width:100px' onchange=\"submit();\">".$mod_orderby_list."</select><select name='mod_orderby_dir_value' class='textbox' style='width:100px' onchange=\"submit();\">".$mod_orderby_dir_list."</select></td>
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
	<td class='tbl2' colspan='2' style='white-space:nowrap'>".$locale['moddb401']."</td>
	<td class='tbl2' width='1%' style='white-space:nowrap'>".$locale['moddb405']."</td>
	<td class='tbl2' width='1%' style='white-space:nowrap'>".$locale['moddb402']."</td>
	<td class='tbl2' width='1%' style='white-space:nowrap'>".$locale['moddb403']."</td>
	<td class='tbl2' width='1%' style='white-space:nowrap'>".$locale['moddb404']."</td>
	<td class='tbl2' width='1%' style='white-space:nowrap'>".$locale['moddb406']."</td>
	</tr>\n";
	$mod_cat_old = -1;
	while ($data = dbarray($result)) {
		if ($data['mod_cat_id'] <> $mod_cat_old) {
			echo "<tr>
			<td class='forum-caption' colspan='7' nowrap>".stripslashes($data['mod_cat_name'])."</td>
			</tr>\n";
		}
		if ($data['mod_id']) {
			$ver = "v".$data['version_h'].".".$data['version_l'].($data['version_s'] != "" ? " ".$data['version_s'] : "");
			if ($data['count_votes'] > 0) {
				$rating = str_repeat("<img src='".INFUSIONS."moddb/img/star.png' alt='".$locale['moddb407']."' />", ceil($data['sum_rating'] / $data['count_votes']));
			} else {
				$rating = $locale['moddb408'];
			}
			$mod_author = ($data['mod_author_name'] == "" ? $locale['moddb409'] : $data['mod_author_name']);

			if ($data['mod_date'] + 604800 > time() + ($settings['timeoffset'] * 3600)) { $new = "<img src='".INFUSIONS."moddb/img/new.gif' border='0' alt='' />";
                } else {
              $new = "<img src='".THEME."images/blank.gif' width='20' height='1' border='0' alt='' />"; }

			echo "<tr>
			<td class='tbl2' width='3%' style='white-space:nowrap'>".$new."</td>
			<td class='tbl1' style='white-space:nowrap'><a href='view.php?mod_id=".$data['mod_id']."'>".trimlink($data['mod_name'], 30)."</a></td>
			<td class='tbl2' width='1%' style='white-space:nowrap'>".strftime("%d/%m/%Y",$data['mod_date']+($settings['timeoffset']*3600))."</td>
			<td class='tbl2' width='1%' style='white-space:nowrap'><span title='".$mod_author."'>".trimlink($mod_author, 20)."</span></td>
			<td class='tbl2' width='1%' style='white-space:nowrap'>".$data['mod_version']."</td>
			<td class='tbl1' width='1%' style='white-space:nowrap'>".$ver."</td>
			<td class='tbl1' width='1%' style='white-space:nowrap'>".$rating."</td>
			</tr>\n";
			$mod_cat_old = $data['mod_cat_id'];
		} else {
			echo "<tr>
			<td class='tbl2' width='3%' align='center'>-</td>
			<td class='tbl1' colspan='7'>".(isset($mod_cat_id) || isset($mod_ver_id) || isset($mod_modtype) ? $locale['moddb424'] : $locale['moddb422'])."</td>
			</tr>\n";
		}
	}
	echo "</table>
	</td>
	</tr>
	</table>\n";
} else {
	if (iMEMBER) {
		echo "<center><br />".(isset($mod_cat_id) || isset($mod_ver_id) || isset($mod_modtype) ? $locale['moddb424'] : $locale['moddb421'])."<br /><br /></center>\n";
	} else {
		echo "<div style='text-align:center;margin-top:2em;margin-bottom:2em;'>".$locale['moddb425']." <a href='".BASEDIR."register.php' title='".$locale['moddb428']."'>".$locale['moddb426']."</a> ".$locale['moddb427']."</div>";
	}
}
if ($rows > $settings['mods_per_page']) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($_GET['rowstart'], $settings['mods_per_page'], $rows, 3, ($get_vars ? FUSION_SELF."".$get_vars."&amp;" : ""))."\n</div>\n";
closetable();

echo "<script type='text/javascript'>function filterMods(criteria) {\n";
echo "document.location.href='".INFUSIONS."moddb/mods.php?show='+criteria;\n}\n";
echo "</script>\n";
add_to_title ($locale['moddb435'].$locale['moddb400']);
require_once THEMES."templates/footer.php";
?>