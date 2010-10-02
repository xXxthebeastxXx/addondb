<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: index.php
| Author: PHP-Fusion Addons Team
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| addonify it under the terms of this license which you
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
$addon_addon_cat_type = "";
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

if (isset($_GET['addon_addon_cat_type']) && isnum($_GET['addon_addon_cat_type'])) {
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."addon_addon_cat_type=".$_GET['addon_addon_cat_type'];
	if ($_GET['addon_addon_cat_type'] != 0) {
		$addon_addon_cat_type = $_GET['addon_addon_cat_type'];
		$db_opts .= " AND tm.addon_type='".$_GET['addon_addon_cat_type']."'";
		$db_count .= " AND tm.addon_type='".$_GET['addon_addon_cat_type']."'";
	} else {
		$addon_addon_cat_type = 0;
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

$versel = $locale['addondb429'];
$ver_list = "<li rel='0'>".$locale['addondb429']."</li>".buildversionoptionlist($addon_ver_id);
$addon_type_list = "<li rel='0'>".$locale['addondb429']."</li>";
$add = $locale['addondb429'];
foreach ($addon_types as $k=>$addon_type) {
	$addon_type_list .= "<li rel='".$k."'>".$addon_type."</li>\n";
	$addon_addon_cat_type == $k ? $add = $addon_type : "";
}
$aob = $locale['func016'];
foreach ($addon_orderby as $k=>$addon_orderby) {
	$addon_orderby_list .= "<li rel='".$k."'>".$addon_orderby."</li>\n";
	$addon_orderby_value == $k ? $aob = $addon_orderby : "";
}
$aobl = $locale['func023'];
foreach ($addon_orderby_dir as $k=>$addon_orderby_dir) {
	$addon_orderby_dir_list .= "<li rel='".$k."'>".$addon_orderby_dir."</li>\n";
	$addon_orderby_dir_value == $k ? $aobl = $addon_orderby_dir  : "";
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
<div class='dropselect grid_5'>
	".$locale['addondb432']."
	<p class='field'>".$add."</p>
	<input type='hidden' name='addon_addon_cat_type' value='".$addon_addon_cat_type."' class='field-h' readonly='readonly' />
	<ul class='list'>
		".$addon_type_list."
	</ul>
</div>
<div class='dropselect grid_5'>
	".$locale['addondb433']."
	<p class='field'>".$versel."</p>
	<input type='hidden' name='addon_ver_id' value='".$addon_ver_id."' class='field-h' readonly='readonly' />
	<ul class='list'>
		".$ver_list."
	</ul>
</div>
<div class='dropselect grid_5'>
	".$locale['addondb434']."
	<p class='field'>".$aob."</p>
	<input type='hidden' name='addon_orderby_value' value='".$addon_orderby_value."' class='field-h' readonly='readonly' />
	<ul class='list'>
		".$addon_orderby_list."
	</ul>
</div>
<div class='dropselect grid_5'>
	Sort	
	<p class='field'>".$aobl."</p>
	<input type='hidden' name='addon_orderby_dir_value' value='".$addon_orderby_dir_value."' class='field-h' readonly='readonly' />
	<ul class='list'>
		".$addon_orderby_dir_list."
	</ul>
</div>
<div class='dropselect grid_4'><br />
	<button type='submit' class='button'><span>Apply changes</span></button>
</div>
</form>\n";

if ($rows != 0) {
	echo "<table border='0' cellpadding='0' cellspacing='0' width='100%' class='tbl-border'>
	<tr>
	<td>
	<table border='0' cellpadding='0' cellspacing='1' width='100%'>\n";
	$addon_cat_old = -1;
	while ($data = dbarray($result)) {
		if ($data['addon_cat_id'] <> $addon_cat_old) {
			echo "<tr>
			<td class='forum-caption' colspan='2'>".stripslashes($data['addon_cat_name'])." [".get_addon_type($data['addon_cat_type'])."]</td>
			<td class='forum-caption' width='1%' style='white-space:nowrap'>".$locale['addondb405']."</td>
	<td class='forum-caption' width='1%' style='white-space:nowrap'>".$locale['addondb402']."</td>
	<td class='forum-caption' width='1%' style='white-space:nowrap'>".$locale['addondb403']."</td>
	<td class='forum-caption' width='1%' style='white-space:nowrap'>".$locale['addondb404']."</td>
	<td class='forum-caption' width='1%' style='white-space:nowrap'>".$locale['addondb406']."</td>
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
			<td class='tbl1' colspan='7'>".(isset($addon_cat_id) || isset($addon_ver_id) || isset($addon_addon_cat_type) ? $locale['addondb424'] : $locale['addondb422'])."</td>
			</tr>\n";
		}
	}
	echo "</table>
	</td>
	</tr>
	</table>\n";
} else {
	if (iMEMBER) {
		echo "<center><br />".(isset($addon_cat_id) || isset($addon_ver_id) || isset($addon_addon_cat_type) ? $locale['addondb424'] : $locale['addondb421'])."<br /><br /></center>\n";
	} else {
		echo "<br /><br /><div style='text-align:center;margin-top:2em;margin-bottom:2em;'>".$locale['addondb425']." <a href='".BASEDIR."register.php' title='".$locale['addondb428']."'>".$locale['addondb426']."</a> ".$locale['addondb427']."</div>";
	}
}
if ($rows > $settings['addons_per_page']) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($_GET['rowstart'], $settings['addons_per_page'], $rows, 3, ($get_vars ? FUSION_SELF."".$get_vars."&amp;" : ""))."\n</div>\n";
closetable();

echo "<br />\n";
opentable($locale['addondb500']);

   $total_addon = dbcount("(addon_id)", DB_ADDONS, "addon_status = '0'");
   $total_infus = dbcount("(addon_id)", DB_ADDONS, "addon_status = '0' && addon_type = '1'");
   $total_panel = dbcount("(addon_id)", DB_ADDONS, "addon_status = '0' && addon_type = '3'");
   $total_theme = dbcount("(addon_id)", DB_ADDONS, "addon_status = '0' && addon_type = '2'");
   $total_other = dbcount("(addon_id)", DB_ADDONS, "addon_status = '0' && addon_type = '4'");
   $total_trans = dbcount("(trans_id)", DB_ADDON_TRANS, "trans_active = '0'");
   $total = dbarray(dbquery("SELECT SUM(addon_download_count) download_count, COUNT(addon_id) FROM ".DB_ADDONS." WHERE addon_status = '0'"));
   $total_count = $total['download_count'];

echo "<table class='tbl-border' align='center' width='100%'><tr>\n
        <th class='forum-caption' width='20%'><b>".$locale['addondb501']."</b></th>
        <th class='forum-caption' width='20%'>".$locale['addondb502']."</th>
        <th class='forum-caption' width='20%'>".$locale['addondb503']."</th>
        <th class='forum-caption' width='20%'>".$locale['addondb504']."</th>
        <th class='forum-caption' width='20%'>".$locale['addondb505']."</th>\n";
        echo "<tr></tr>\n
        <td class='tbl2' align='center'>".$total_addon."</td>
        <td class='tbl2' align='center'>".$total_infus."</td>
        <td class='tbl2' align='center'>".$total_panel."</td>
        <td class='tbl2' align='center'>".$total_theme."</td>
        <td class='tbl2' align='center'>".$total_other."</td>\n
        </tr>\n<table>\n";
        echo "<table class='tbl-border' align='center' width='100%'><tr>\n
        <td class='tbl2'>".sprintf($locale['addondb508'], $total_trans)."</td>\n";
        
        if (iMEMBER) {
        $addoncount = number_format(dbcount("(addon_id)", DB_ADDONS, "addon_author_name='".$userdata['user_name']."'"));
        if ($addoncount > 0) {
        
        echo "<td class='tbl2' align='center'><a href='".ADDON."my_addons.php' title=''>".sprintf($locale['addondb509'], $addoncount)."</a></td>\n"; }
        }
        echo "<td class='tbl2' align='right'>".sprintf($locale['addondb506'], $total_addon).sprintf($locale['addondb507'], $total_count)."</td>
        </tr>\n</table>\n";
        
closetable();
echo "<br />\n";

if (iADMIN && checkrights("ADNX")) {
opentable($locale['addondb600']);

$addonsq = dbquery("SELECT * FROM ".DB_SUBMISSIONS." WHERE submit_type='m' ORDER BY submit_id DESC");
$errosq = dbquery("SELECT * FROM ".DB_ADDON_ERRORS." WHERE error_active ='1'");
$transq = dbquery("SELECT * FROM ".DB_ADDON_TRANS." WHERE trans_active='1'");

$addons = dbrows($addonsq);
$errors = dbrows($errosq);
$trans = dbrows($transq);

echo "<table class='tbl-border' align='center' width='100%'><tr>\n
        <th class='forum-caption' width='25%'>".$locale['addondb601']."</th>
        <th class='forum-caption' width='25%'>".$locale['addondb602']."</th>
        <th class='forum-caption' width='25%'>".$locale['addondb603']."</th>
        <th class='forum-caption' width='25%'>".$locale['addondb604']."</th>
        <tr></tr>\n
        <td class='tbl2' align='center'><a href='".ADDON_ADMIN."submissions.php".$aidlink."'>".$addons."</a></td>
        <td class='tbl2' align='center'><a href='".ADDON_ADMIN."submissions.php".$aidlink."'>".$trans."</a></td>
        <td class='tbl2' align='center'><a href='".ADDON_ADMIN."error.php".$aidlink."'>".$errors."</a></td>
        <td class='tbl2' align='center'><a href='".ADDON_ADMIN."index.php".$aidlink."'>".$locale['addondb604']."</a></td>
        </tr>\n</table>\n";

closetable();
  }

echo "<script type='text/javascript'>function filterMods(criteria) {\n";
echo "document.location.href='".INFUSIONS."addondb/addons.php?show='+criteria;\n}\n";
echo "</script>\n";
add_to_title ($locale['addondb435'].$locale['addondb400']);
require_once THEMES."templates/footer.php";
?>