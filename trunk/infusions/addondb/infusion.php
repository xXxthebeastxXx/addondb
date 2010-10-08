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
addon_cat_id smallint(5) unsigned NOT NULL auto_increment,
addon_cat_type tinyint(1) unsigned NOT NULL default '0',
addon_cat_name varchar(100) NOT NULL default '',
addon_cat_description text NOT NULL,
addon_cat_access tinyint(1) unsigned NOT NULL default '0',
addon_cat_order smallint(5) unsigned NOT NULL default '0',
PRIMARY KEY (addon_cat_id)
) TYPE=MyISAM;";

$inf_newtable[2] = DB_ADDONS." (
addon_id smallint(5) unsigned NOT NULL auto_increment,
addon_cat_id smallint(5) unsigned NOT NULL default '0',
addon_type tinyint(1) unsigned NOT NULL default '0',
addon_status tinyint(1) unsigned NOT NULL default '0',
addon_name varchar(50) NOT NULL default '',
addon_description text NOT NULL,
addon_demo_url varchar(100) NOT NULL default '',
addon_copyright text NOT NULL,
addon_version varchar(15) NOT NULL default '',
version_id smallint(5) unsigned NOT NULL default '0',
addon_submitter_name varchar(100) NOT NULL default '',
addon_submitter_id varchar(100) NOT NULL default '',
addon_forum_status tinyint(1) unsigned NOT NULL default '0',
addon_share_status tinyint(1) unsigned NOT NULL default '0',
addon_author_name varchar(100) NOT NULL default '',
addon_co_author_name varchar(100) NOT NULL default '',
addon_author_email varchar(100) NOT NULL default '',
addon_author_www varchar(100) NOT NULL default '',
addon_date int(10) unsigned NOT NULL default '0',
addon_download varchar(50) NOT NULL default '',
addon_comments smallint(5) unsigned NOT NULL default '0',
addon_approved_user smallint(5) unsigned NOT NULL default '0',
addon_approved_rating tinyint(1) unsigned NOT NULL default '0',
addon_approved_comment text NOT NULL,
addon_download_count smallint(5) unsigned NOT NULL default '0',
addon_img varchar(100) NOT NULL default '',
PRIMARY KEY (addon_id)
) TYPE=MyISAM;";

$inf_newtable[3] = DB_ADDON_VERSIONS." (
version_id smallint(5) unsigned NOT NULL auto_increment,
version_h varchar(5) NOT NULL default '',
version_l varchar(5) NOT NULL default '',
version_s varchar(12) NOT NULL default '',
version_description text,
version_order smallint(5) unsigned NOT NULL default '0',
PRIMARY KEY (version_id)
) TYPE=MyISAM;";

$inf_newtable[4] = DB_ADDON_LOCALES." (  
file_id smallint(5) unsigned NOT NULL auto_increment,  
file_mod smallint(5) unsigned NOT NULL default '0',  
file_name varchar(200) NOT NULL default '',  
file_user smallint(5) unsigned NOT NULL default '0',  
file_language varchar(200) NOT NULL default '',  
file_translator varchar(200) NOT NULL default '',  
file_datestamp int(10) unsigned NOT NULL default '0',  
PRIMARY KEY (file_id)  
) TYPE=MyISAM;";  

$inf_newtable[5] = DB_ADDON_ERRORS." (
error_id smallint(5) unsigned NOT NULL auto_increment,
error_addon smallint(5) unsigned NOT NULL default '0',
error_type tinyint(1) unsigned NOT NULL default '0',
error_link tinyint(1) unsigned NOT NULL default '0',
error_active tinyint(1) unsigned NOT NULL default '0',
error_user smallint(5) unsigned NOT NULL default '0',
error_report varchar(200) NOT NULL default '',
error_datestamp int(10) unsigned NOT NULL default '0',
error_assign_user varchar(200) NOT NULL default '',
PRIMARY KEY (error_id)
) TYPE=MyISAM;";

$inf_newtable[6] = DB_ADDON_TRANS." (
trans_id smallint(5) unsigned NOT NULL auto_increment,
trans_mod smallint(5) unsigned NOT NULL default '0',
trans_modname varchar(200) NOT NULL default '',
trans_active tinyint(1) unsigned NOT NULL default '1',
trans_type tinyint(2) unsigned NOT NULL default '0',
trans_user smallint(5) unsigned NOT NULL default '0',
trans_datestamp int(10) unsigned NOT NULL default '0',
trans_file varchar(200) NOT NULL default '',  
trans_approved_user smallint(5) unsigned NOT NULL default '0',
trans_approved_comment text NOT NULL,
PRIMARY KEY (trans_id)
) TYPE=MyISAM;";

$inf_newtable[7] = DB_ADDON_STGS." (
set_addondb_onf TINYINT(1) DEFAULT '0' NOT NULL,
set_addondb_comm TINYINT(1) DEFAULT '0' NOT NULL,
set_addondb_sub TINYINT(1) DEFAULT '0' NOT NULL,
addons_per_page SMALLINT(5) DEFAULT '20' NOT NULL,
set_addon_maintmsg text NOT NULL,
PRIMARY KEY (addons_per_page)
) TYPE=MyISAM;";

$inf_newtable[8] = DB_ADDON_ASSIGN." (
assign_id smallint(5) unsigned NOT NULL auto_increment,
assign_addon smallint(5) unsigned NOT NULL default '0',
assign_user smallint(5) unsigned NOT NULL default '0',
assign_author smallint(5) unsigned NOT NULL default '0',
PRIMARY KEY (assign_id)
) TYPE=MyISAM;";

$inf_insertdbrow[1] = DB_ADDON_STGS." (set_addondb_onf, set_addondb_comm, set_addondb_sub, addons_per_page) VALUES('0', '0', '0', '20')";

$inf_droptable[1] = DB_ADDON_CATS;
$inf_droptable[2] = DB_ADDONS;
$inf_droptable[3] = DB_ADDON_VERSIONS;
$inf_droptable[4] = DB_ADDON_LOCALES;
$inf_droptable[5] = DB_ADDON_ERRORS;
$inf_droptable[6] = DB_ADDON_TRANS;
$inf_droptable[7] = DB_ADDON_STGS;
$inf_droptable[8] = DB_ADDON_ASSIGN;

$inf_deldbrow[1] = "DELETE FROM ".DB_COMMENTS." WHERE comment_type='M'";
$inf_deldbrow[2] = "DELETE FROM ".DB_RATINGS." WHERE rating_type='M'";

$inf_adminpanel[1] = array(
	"title" => $locale['addondb100'],
	"image" => "",
	"panel" => "admin/index.php",
	"rights" => "ADNX"
);

$inf_sitelink[1] = array(
	"title" => $locale['addondb100'],
	"url" => "addons.php",
	"visibility" => ""
);

$inf_sitelink[2] = array(
	"title" => $locale['addondb102'],
	"url" => "submit_addon.php",
	"visibility" => "101"
);

?>