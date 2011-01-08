<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: addondb_core.php
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
if (!defined("IN_FUSION")) { die("Access Denied"); }

require_once INFUSIONS."addondb/infusion_db.php";
$settings_global = dbarray(dbquery("SELECT * FROM ".DB_ADDON_STGS));

if ($settings_global['set_addondb_onf'] == '0') {
define("ADDON_MAINTENANCE", false);
} elseif ($settings_global['set_addondb_onf'] == '1') {
define("ADDON_MAINTENANCE", true);
}

if ($settings_global['set_addondb_sub'] == '0') {
define("ADDON_SUBMISSIONS", false);
} elseif ($settings_global['set_addondb_sub'] == '1') {
define("ADDON_SUBMISSIONS", true);
}

if (ADDON_MAINTENANCE == true && !iADMIN && FUSION_SELF != "maintenance.php") { redirect(INFUSIONS."addondb/maintenance.php"); }
if (ADDON_SUBMISSIONS == true && !iADMIN && FUSION_SELF != "index.php") { redirect(INFUSIONS."addondb/index.php"); }

define("ADDON", INFUSIONS."addondb/");
define("ADDON_IMG", INFUSIONS."addondb/img/");
define("ADDON_SCRN", INFUSIONS."addondb/img/screenshots/");
define("ADDON_LOCALE", INFUSIONS."addondb/locale/");
define("ADDON_INC", INFUSIONS."addondb/inc/");
define("ADDON_ADMIN", INFUSIONS."addondb/admin/");

// Screen Shots
$addon_upload_dir_img = ADDON_SCRN;
$addon_upload_exts_img = array(
	"png" => "image/png",
	"jpg" => "image/jpg",
	"gif" => "image/gif"
);
$addon_upload_maxsize_img = 2000000;
///////////////

// Translations
$trans_upload_dir = ADDON."files/trans/";
$trans_upload_exts = array(
	"zip" => "application/zip",
	"rar" => "application/zip",
	"tar" => "application/x-tar",
	"tar.gz" => "application/x-gzip"
);
$trans_upload_maxsize = 2000000;
///////////////

// Addon Files
$addon_upload_dir = ADDON."files/";
$addon_upload_prefix = "submitted_addon_";
$addon_list_dateformat = "%d/%m-%Y";
$addon_upload_exts = array(
	"zip" => "application/zip",
	"rar" => "application/zip",
	"tar" => "application/x-tar",
	"tar.gz" => "application/x-gzip"
);
$addon_upload_maxsize = 2000000;
///////////////

include ADDON_LOCALE.LOCALESET."inc.functions.php";
$get_type = array(
	  $locale['func006'] => 1, 
	  $locale['func007'] => 2, 
	  $locale['func008'] => 3,
	  $locale['func010'] => 4
);
////////////////

include ADDON_LOCALE.LOCALESET."inc.functions.php";
$addon_ratings = array(1 => $locale['func001'], $locale['func002'], $locale['func003'], $locale['func004'], $locale['func005']);
  $addon_types = array(1 => $locale['func006'], $locale['func007'], $locale['func008'], $locale['func010']);
 $addon_status = array($locale['func011'], $locale['func012'], $locale['func013'], $locale['func014'], $locale['func015']);
$addon_orderby = array(
	"addon_name" => $locale['func016'],
	"addon_author_name" => $locale['func017'],
	"addon_date" => $locale['func018']
);
$addon_orderby_dir = array(
	"ASC" => $locale['func023'],
	"DESC" => $locale['func024']
);

function get_addon_status($status_id) {
include ADDON_LOCALE.LOCALESET."inc.functions.php";
	if ($status_id == 0) { return $locale['func011']; }
	elseif ($status_id == 1) { return $locale['func012']; }
	elseif ($status_id == 2) { return $locale['func013']; }
	elseif ($status_id == 3) { return $locale['func014']; }
	elseif ($status_id == 4) { return $locale['func015']; }
	else { return $locale['func019']; }
}

function get_addon_type($type) {
include ADDON_LOCALE.LOCALESET."inc.functions.php";
	    if ($type == 1) { return $locale['func006']; }
	elseif ($type == 2) { return $locale['func007']; }
	elseif ($type == 3) { return $locale['func008']; }
	elseif ($type == 4) { return $locale['func010']; }
	else { return $locale['func020']; }
}

function get_addon_language($l_id) {
	if ($l_id == 0) { return "29"; } // The Number Of Languages
	elseif ($l_id == 1) { return "Arabic"; }
	elseif ($l_id == 2) { return "Azerbaijani"; }
	elseif ($l_id == 3) { return "Belarussian"; }
	elseif ($l_id == 4) { return "Bosnian"; }
	elseif ($l_id == 5) { return "Bulgarian"; }
	elseif ($l_id == 6) { return "Catalan"; }
	elseif ($l_id == 7) { return "Czech"; }
	elseif ($l_id == 8) { return "Danish"; }
	elseif ($l_id == 9) { return "Dutch"; }
	elseif ($l_id == 10) { return "French"; }
	elseif ($l_id == 11) { return "German"; }
	elseif ($l_id == 12) { return "Greek"; }
	elseif ($l_id == 13) { return "Hungarian"; }
	elseif ($l_id == 14) { return "Indonesian"; }
	elseif ($l_id == 15) { return "Irish"; }
	elseif ($l_id == 16) { return "Italian"; }
	elseif ($l_id == 17) { return "Kurdish"; }
	elseif ($l_id == 18) { return "Lithuanian"; }
	elseif ($l_id == 19) { return "Norwegian"; }
	elseif ($l_id == 20) { return "Persian"; }
	elseif ($l_id == 21) { return "Polish"; }
	elseif ($l_id == 22) { return "Portuguese"; }
	elseif ($l_id == 23) { return "Romanian"; }
	elseif ($l_id == 24) { return "Russian"; }
	elseif ($l_id == 25) { return "Slovak"; }
	elseif ($l_id == 26) { return "Spanish"; }
	elseif ($l_id == 27) { return "Swedish"; }
	elseif ($l_id == 28) { return "Turkish"; }
	elseif ($l_id == 29) { return "Ukrainian"; }
	else { return "Unknown Status"; }
}

function get_newest_version_id() {
	$result = dbquery("SELECT version_id FROM ".DB_ADDON_VERSIONS." ORDER BY version_h DESC, version_l DESC, version_s DESC LIMIT 1");
	if (dbrows($result)) {
		$data = dbarray($result);
		return $data['version_id'];
	} else {
		return false;
	}
}

function builduserclassoptionlist($min_addon_level, $max_addon_level, $sel_addon_level = 1) {
	$res = "";
	for ($level = $max_addon_level; $level >= $min_addon_level; $level--) {
		$res .= "<option ".($level == $sel_addon_level ? "selected" : "")." value='".$level."'>".getaddonlevel($level)."</option>\n";
	}
	return $res;
}

function builduseroptionlist($sel_user_id = 1, $order = "user_name") {
	$res = "";
	$result = dbquery("SELECT user_id,user_name FROM ".DB_USERS." WHERE user_level>='102' ORDER BY ".$order);
	if (dbrows($result) > 0) {
		while ($data = dbarray($result)) {
			$res .= "<option ".($data['user_id'] == $sel_user_id ? "selected" : "")." value='".$data['user_id']."'>".$data['user_name']."</option>";
		}
	}
	return $res;
}

function buildversionoptionlist($sel_ver_id = 1) {
	global $db_prefix;
	$res = "";
	$result = dbquery("SELECT * FROM ".DB_ADDON_VERSIONS." ORDER BY version_order DESC");
	if (dbrows($result) > 0) {
		while ($data = dbarray($result)) {
			$ver = "v".$data['version_h'].".".$data['version_l'].($data['version_s'] != "" ? " ".$data['version_s'] : "");
			$res .= "<option value='".$data['version_id']."'".($data['version_id'] == $sel_ver_id ? " selected" : "").">".$ver."</option>";
		}
	}
	return $res;
}

function buildversionlilist($sel_ver_id = 1) {
	global $db_prefix, $versel;
	$res = "";
	$result = dbquery("SELECT * FROM ".DB_ADDON_VERSIONS." ORDER BY version_order DESC");
	if (dbrows($result) > 0) {
		while ($data = dbarray($result)) {
			$ver = "v".$data['version_h'].".".$data['version_l'].($data['version_s'] != "" ? " ".$data['version_s'] : "");
			$res .= "<li class='".$data['version_id']."'>".$ver."</li>";
			$data['version_id'] == $sel_ver_id ? $versel = $ver : "";
		}
	}
	return $res;
}

function getaddonlevel($addonlevel) {
	global $locale;
	$levels = array($locale['user0'], $locale['user1'], $locale['user2'], $locale['user3']);
	$addonlevel = $levels[$addonlevel];
	return $addonlevel;
}

function dbseek($query, $rownum) {
	if (!$query = mysql_data_seek($query, $rownum)) echo mysql_error();
	return $query;
}

function nicetime($date)
{
    if(empty($date)) {
        return "No date provided";
    }
    
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
    
    $now             = time();
    $unix_date         = strtotime($date);
   
    if(empty($unix_date)) {    
        return "Bad date";
    }
    if($now > $unix_date) {    
        $difference     = $now - $unix_date;
        $tense         = "ago";
        
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
    
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
    
    $difference = round($difference);
    
    if($difference != 1) {
        $periods[$j].= "s";
    }
    
    return "$difference $periods[$j] {$tense}";
}

function dbinsert_id() {
	return mysql_insert_id();
}
?> 