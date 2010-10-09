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

if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) { $_GET['rowstart'] = 0; }

$db_opts = "addon_status='0'";
$get_vars = "";
$get_prefix = "";
$db_count = "";
$addon_type_list = "";
$addon_cat_id = "";
$type = "";
$version = "";
$addon_orderby_list = "";
$addon_orderby_dir_list = "";
$orderby = "";
$sort = "";

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

if (isset($_GET['type']) && isnum($_GET['type'])) {
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."type=".$_GET['type'];
	if ($_GET['type'] != 0) {
		$type = $_GET['type'];
		$db_opts .= " AND tm.addon_type='".$_GET['type']."'";
		$db_count .= " AND tm.addon_type='".$_GET['type']."'";
	} else {
		$type = 0;
	}
} else {
	$type = 0;
}
//This should work now
if (isset($_GET['version']) && isnum($_GET['version'])) {
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."version=".$_GET['version'];
	if ($_GET['version'] != 0) {
		$version = $_GET['version'];
		$db_opts .= " AND tv.version_id='".$_GET['version']."'";
		$db_count .= " AND tv.version_id='".$_GET['version']."'";
	}
} else {
	$version = 0;
	#$db_opts .= " AND tv.version_id='$version'";
	#$db_count .= " AND tv.version_id='$version'";
	#$get_vars .= (empty($get_vars) ? "?" : "&amp;")."version=$version";
}

if (isset($_GET['orderby']) && in_array($_GET['orderby'], $check_order_val)) {
	$orderby = stripinput($_GET['orderby']);
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."orderby=".$orderby;
}else{
$orderby = "addon_name";
}
if (isset($_GET['sort']) && in_array($_GET['sort'], $check_order_dir)) {
	$sort = stripinput($_GET['sort']);
	$get_vars .= (empty($get_vars) ? "?" : "&amp;")."sort=".$sort;
}else{
$sort = "ASC";
}

if ($settings_global['set_addondb_onf'] == '1' && iADMIN) { echo "<div class ='admin-message'><center><b>".$locale['addondb605']."</b></div>\n"; }
if ($settings_global['set_addondb_sub'] == '1' && iADMIN) { echo "<div class ='admin-message'><center><b>".$locale['addondb608']."</b></div>\n"; }
if ($settings_global['set_addondb_sub'] == '1' && iMEMBER) { echo "<div class ='admin-message'><center><b>".$locale['addondb609']." ".$locale['addondb607']."</b></div>\n"; }

opentable($locale['addondb400']);

$versel = $locale['addondb429'];
$ver_list = "<li class='0'>".$locale['addondb429']."</li>".buildversionlilist($version);
$addon_type_list = "<li class='0'>".$locale['addondb429']."</li>";
$add = $locale['addondb429'];
foreach ($addon_types as $k=>$addon_typ) {
	$addon_type_list .= "<li class='".$k."'>".$addon_typ."</li>\n";
	$type == $k ? $add = $addon_typ : "";
}
$aob = $locale['func016'];
foreach ($addon_orderby as $k=>$addon_orderby) {
	$addon_orderby_list .= "<li class='".$k."'>".$addon_orderby."</li>\n";
	$orderby == $k ? $aob = $addon_orderby : "";
}
$aobl = $locale['func023'];
foreach ($addon_orderby_dir as $k=>$addon_orderby_dir) {
	$addon_orderby_dir_list .= "<li class='".$k."'>".$addon_orderby_dir."</li>\n";
	$sort == $k ? $aobl = $addon_orderby_dir  : "";
}
$rows = dbresult(dbquery("SELECT COUNT(*) FROM ".DB_ADDON_CATS." tc LEFT JOIN ".DB_ADDONS." tm USING(addon_cat_id) LEFT JOIN ".DB_ADDON_VERSIONS." tv USING(version_id) WHERE ".groupaccess('tc.addon_cat_access')." AND ".$db_opts." AND addon_status='0'"),0);
if ($rows != 0) {
	$result = dbquery("
		SELECT tc.*,tm.*,tv.*
		FROM ".DB_ADDON_CATS." tc
		LEFT JOIN ".DB_ADDONS." tm USING(addon_cat_id)
		LEFT JOIN ".DB_ADDON_VERSIONS." tv USING(version_id)
		WHERE ".$db_opts." AND ".groupaccess('tc.addon_cat_access')."
		GROUP BY addon_id, tc.addon_cat_id
		ORDER BY addon_cat_order, ".$orderby." ".$sort."
		LIMIT ".$_GET['rowstart'].",".$settings_global['addons_per_page']
	);
} ?>
<form name="filterform" method="get" action="<?php echo FUSION_SELF; ?>">
	<div class="dropselect grid_5">
		<?php echo $locale['addondb432']; ?>
		<p class="field"><?php echo $add; ?></p>
		<input type="hidden" name="type" value="<?php echo $type; ?>" class="field-h" />
		<ul class="list">
			<?php echo $addon_type_list; ?>
		</ul>
	</div>
	<div class="dropselect grid_5">
		<?php echo $locale['addondb433']; ?>
		<p class="field"><?php echo $versel; ?></p>
		<input type="hidden" name="version" value="<?php echo $version; ?>" class="field-h" />
		<ul class="list">
			<?php echo $ver_list; ?>
		</ul>
	</div>
	<div class="dropselect grid_5">
		<?php echo $locale['addondb434']; ?>
		<p class="field"><?php echo $aob; ?></p>
		<input type="hidden" name="orderby" value="<?php echo $orderby; ?>" class="field-h" />
		<ul class="list">
			<?php echo $addon_orderby_list; ?>
		</ul>
	</div>
	<div class="dropselect grid_5">
		Sort	
		<p class="field"><?php echo $aobl; ?></p>
		<input type="hidden" name="sort" value="<?php echo $sort; ?>" class="field-h" />
		<ul class="list">
			<?php echo $addon_orderby_dir_list; ?>
		</ul>
	</div>
	<div class="dropselect grid_4"><br />
		<button type="submit" class="button"><span>Apply changes</span></button>
	</div>
</form>
<?php
if ($rows != 0) {
	echo "<table cellpadding='0' cellspacing='0' width='100%' class='tbl-border'>\n";
	$addon_cat_old = -1;
	while ($data = dbarray($result)) {
		if ($data['addon_cat_id'] <> $addon_cat_old) {
			echo "<tr>
			<td class='forum-caption'>".stripslashes($data['addon_cat_name'])." [".get_addon_type($data['addon_cat_type'])."]</td>
			<td class='forum-caption' width='1%' style='white-space:nowrap'>".$locale['addondb405']."</td>
	<td class='forum-caption' width='1%' style='white-space:nowrap'>".$locale['addondb402']."</td>
	<td class='forum-caption' width='1%' style='white-space:nowrap'>".$locale['addondb403']."</td>
	<td class='forum-caption' width='1%' style='white-space:nowrap'>".$locale['addondb404']."</td>
			</tr>\n";
		}
		if ($data['addon_id']) {
			$ver = "v".$data['version_h'].".".$data['version_l'].($data['version_s'] != "" ? " ".$data['version_s'] : "");
			$addon_author = ($data['addon_author_name'] == "" ? $locale['addondb409'] : $data['addon_author_name']);

			if ($data['addon_date'] + 604800 > time() + ($settings['timeoffset'] * 3600)) {
				$time = nicetime(showdate("%Y-%m-%d %H:%M:%S",$data['addon_date']));
			} else {
				$time = showdate("%d. %B",$data['addon_date']);
			 }

			echo "<tr>
			<td class='tbl1' style='white-space:nowrap'><a href='view.php?addon_id=".$data['addon_id']."'>".trimlink($data['addon_name'], 30)."</a></td>
			<td class='tbl2' width='1%' style='white-space:nowrap'>".$time."</td>
			<td class='tbl2' width='1%' style='white-space:nowrap'><span title='".$addon_author."'>".trimlink($addon_author, 20)."</span></td>
			<td class='tbl2' width='1%' style='white-space:nowrap'>".$data['addon_version']."</td>
			<td class='tbl1' width='1%' style='white-space:nowrap'>".$ver."</td>
			</tr>\n";
			$addon_cat_old = $data['addon_cat_id'];
		} else {
			echo "<tr>
			<td class='tbl2' width='3%' align='center'>-</td>
			<td class='tbl1' colspan='7'>".(isset($addon_cat_id) || isset($version) || isset($type) ? $locale['addondb424'] : $locale['addondb422'])."</td>
			</tr>\n";
		}
	}
	echo "</table>\n";
} else {
	if (iMEMBER) {
		echo "<center><br />".(isset($addon_cat_id) || isset($version) || isset($type) ? $locale['addondb424'] : $locale['addondb421'])."<br /><br /></center>\n";
	} else {
		echo "<br /><br /><div style='text-align:center;margin-top:2em;margin-bottom:2em;'>".$locale['addondb425']." <a href='".BASEDIR."register.php' title='".$locale['addondb428']."'>".$locale['addondb426']."</a> ".$locale['addondb427']."</div>";
	}
}
if ($rows > $settings_global['addons_per_page']) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($_GET['rowstart'], $settings_global['addons_per_page'], $rows, 3, ($get_vars ? FUSION_SELF."".$get_vars."&amp;" : ""))."\n</div>\n";
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
        echo "<table class='tbl-border' align='center' width='100%'><tr>\n";
        if (iMEMBER) {
        echo "<td class='tbl2' align='center'><a href='".ADDON."dashboard.php' title=''>".$locale['addondb509']."</a></td>\n"; }
        echo "<td class='tbl2'>".sprintf($locale['addondb508'], $total_trans)."</td>\n";
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

add_to_title ($locale['addondb435'].$locale['addondb400']);
require_once THEMES."templates/footer.php";
?>