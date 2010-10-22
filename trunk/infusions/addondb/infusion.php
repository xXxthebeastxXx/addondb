<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
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
if (!defined("IN_FUSION") || !checkrights("I")) { die("Access Denied"); }

require_once INFUSIONS."addondb/infusion_db.php";

if (file_exists(INFUSIONS."addondb/locale/".LOCALESET."infusion.php")) {
	include INFUSIONS."addondb/locale/".LOCALESET."infusion.php";
} else {
	include INFUSIONS."addondb/locale/English/infusion.php";
}

// Infusion Information
$inf_title = $locale['addondb100'];
$inf_description = $locale['addondb101'];
$inf_version = "3.1.0";
$inf_developer = "PHP-Fusion Addons Team";
$inf_email = "";
$inf_weburl = "http://www.phpfusion.co.uk";

$inf_folder = "addondb";

$inf_newtable[1] = DB_ADDON_CATS." (
addon_cat_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
addon_cat_type TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
addon_cat_name VARCHAR(100) NOT NULL DEFAULT '',
addon_cat_description TEXT NOT NULL,
addon_cat_access TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
addon_cat_order SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY (addon_cat_id)
) TYPE=MyISAM;";

$inf_newtable[2] = DB_ADDONS." (
addon_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
addon_cat_id SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
addon_type TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
addon_status TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
addon_name VARCHAR(50) NOT NULL DEFAULT '',
addon_description TEXT NOT NULL,
addon_demo_url VARCHAR(100) NOT NULL DEFAULT '',
addon_copyright TEXT NOT NULL,
addon_version VARCHAR(15) NOT NULL DEFAULT '',
version_id SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
addon_submitter_name VARCHAR(100) NOT NULL DEFAULT '',
addon_submitter_id VARCHAR(100) NOT NULL DEFAULT '',
addon_forum_status TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
addon_share_status TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
addon_author_name VARCHAR(100) NOT NULL DEFAULT '',
addon_author_status TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
addon_co_author_name VARCHAR(100) NOT NULL DEFAULT '',
addon_author_email VARCHAR(100) NOT NULL DEFAULT '',
addon_author_www VARCHAR(100) NOT NULL DEFAULT '',
addon_date INT(10) UNSIGNED NOT NULL DEFAULT '0',
addon_download VARCHAR(50) NOT NULL DEFAULT '',
addon_comments SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
addon_approved_user SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
addon_approved_rating TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
addon_approved_comment TEXT NOT NULL,
addon_download_count SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
addon_img VARCHAR(100) NOT NULL DEFAULT '',
PRIMARY KEY (addon_id)
) TYPE=MyISAM;";

$inf_newtable[3] = DB_ADDON_VERSIONS." (
version_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
version_h VARCHAR(5) NOT NULL DEFAULT '',
version_l VARCHAR(5) NOT NULL DEFAULT '',
version_s VARCHAR(12) NOT NULL DEFAULT '',
version_description TEXT,
version_order SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY (version_id)
) TYPE=MyISAM;";

$inf_newtable[4] = DB_ADDON_LOCALES." (  
file_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,  
file_mod SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',  
file_name VARCHAR(200) NOT NULL DEFAULT '',  
file_user SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',  
file_language VARCHAR(200) NOT NULL DEFAULT '',  
file_translator VARCHAR(200) NOT NULL DEFAULT '',  
file_datestamp INT(10) UNSIGNED NOT NULL DEFAULT '0',  
PRIMARY KEY (file_id)  
) TYPE=MyISAM;";  

$inf_newtable[5] = DB_ADDON_ERRORS." (
error_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
error_addon SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
error_type TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
error_link TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
error_active TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
error_user SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
error_report VARCHAR(200) NOT NULL DEFAULT '',
error_datestamp INT(10) UNSIGNED NOT NULL DEFAULT '0',
error_assign_user VARCHAR(200) NOT NULL DEFAULT '',
PRIMARY KEY (error_id)
) TYPE=MyISAM;";

$inf_newtable[6] = DB_ADDON_TRANS." (
trans_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
trans_mod SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
trans_modname VARCHAR(200) NOT NULL DEFAULT '',
trans_active TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
trans_type TINYINT(2) UNSIGNED NOT NULL DEFAULT '0',
trans_user SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
trans_datestamp INT(10) UNSIGNED NOT NULL DEFAULT '0',
trans_file VARCHAR(200) NOT NULL DEFAULT '',  
trans_approved_user SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
trans_approved_comment TEXT NOT NULL,
PRIMARY KEY (trans_id)
) TYPE=MyISAM;";

$inf_newtable[7] = DB_ADDON_STGS." (
set_addondb_onf TINYINT(1) DEFAULT '0' NOT NULL,
set_addondb_comm TINYINT(1) DEFAULT '0' NOT NULL,
set_addondb_sub TINYINT(1) DEFAULT '0' NOT NULL,
addons_per_page SMALLINT(5) DEFAULT '20' NOT NULL,
addons_dev_qual SMALLINT(5) DEFAULT '20' NOT NULL,
set_new_time INT(10) UNSIGNED DEFAULT '0' NOT NULL,
susp_time INT(10) UNSIGNED DEFAULT '0' NOT NULL,
set_addon_maintmsg TEXT NOT NULL,
PRIMARY KEY (addons_per_page)
) TYPE=MyISAM;";

$inf_newtable[8] = DB_ADDON_ASSIGN." (
assign_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
assign_addon SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
assign_user SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
assign_author SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY (assign_id)
) TYPE=MyISAM;";

$inf_newtable[9] = DB_ADDON_DEV_APPLY." (
apply_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
apply_user SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
apply_comment TEXT NOT NULL,
PRIMARY KEY (apply_id)
) TYPE=MyISAM;";

$inf_insertdbrow[1] = DB_ADDON_STGS." (set_addondb_onf, set_addondb_comm, set_addondb_sub, addons_per_page, addons_dev_qual, set_new_time, susp_time) VALUES('0', '0', '0', '20', '2', '86400', '0')";

$inf_droptable[1] = DB_ADDON_CATS;
$inf_droptable[2] = DB_ADDONS;
$inf_droptable[3] = DB_ADDON_VERSIONS;
$inf_droptable[4] = DB_ADDON_LOCALES;
$inf_droptable[5] = DB_ADDON_ERRORS;
$inf_droptable[6] = DB_ADDON_TRANS;
$inf_droptable[7] = DB_ADDON_STGS;
$inf_droptable[8] = DB_ADDON_ASSIGN;
$inf_droptable[9] = DB_ADDON_DEV_APPLY;

$inf_deldbrow[1] = DB_COMMENTS." WHERE comment_type='M'";
$inf_deldbrow[2] = DB_RATINGS." WHERE rating_type='M'";
$inf_deldbrow[3] = DB_SUBMISSIONS." WHERE submit_type='m'";

$inf_adminpanel[1] = array(
	"title" => $locale['addondb100'],
	"image" => "",
	"panel" => "admin/submissions.php",
	"rights" => "ADNX"
);

?>