<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
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
if (!defined("IN_FUSION") || !checkrights("I")) { die("Access Denied"); }

require_once INFUSIONS."moddb/infusion_db.php";

if (file_exists(INFUSIONS."moddb/locale/".LOCALESET."infusion.php")) {
	include INFUSIONS."moddb/locale/".LOCALESET."infusion.php";
} else {
	include INFUSIONS."moddb/locale/English/infusion.php";
}

// Infusion Information
$inf_title = $locale['moddb100'];
$inf_description = $locale['moddb101'];
$inf_version = "3.0.0";
$inf_developer = "PHP-Fusion MODs & Infusions Team";
$inf_email = "support@phpfusion-mods.com";
$inf_weburl = "http://www.phpfusion-mods.com";

$inf_folder = "moddb";

$inf_newtable[1] = DB_MOD_CATS." (
mod_cat_id smallint(5) unsigned NOT NULL auto_increment,
mod_cat_name varchar(100) NOT NULL default '',
mod_cat_description text NOT NULL,
mod_cat_access tinyint(1) unsigned NOT NULL default '0',
mod_cat_order smallint(5) unsigned NOT NULL default '0',
PRIMARY KEY (mod_cat_id)
) TYPE=MyISAM;";

$inf_newtable[2] = DB_MODS." (
mod_id smallint(5) unsigned NOT NULL auto_increment,
mod_cat_id smallint(5) unsigned NOT NULL default '0',
mod_type tinyint(1) unsigned NOT NULL default '0',
mod_status tinyint(1) unsigned NOT NULL default '0',
mod_name varchar(50) NOT NULL default '',
mod_description text NOT NULL,
mod_copyright text NOT NULL,
mod_version varchar(15) NOT NULL default '',
version_id smallint(5) unsigned NOT NULL default '0',
mod_submitter_name varchar(100) NOT NULL default '',
mod_submitter_id varchar(100) NOT NULL default '',
mod_forum_status tinyint(1) unsigned NOT NULL default '0',
mod_valid_xhtml tinyint(1) unsigned NOT NULL default '0',
mod_valid_css tinyint(1) unsigned NOT NULL default '0',
mod_author_name varchar(100) NOT NULL default '',
mod_co_author_name varchar(100) NOT NULL default '',
mod_author_email varchar(100) NOT NULL default '',
mod_author_www varchar(100) NOT NULL default '',
mod_date int(10) unsigned NOT NULL default '0',
mod_download varchar(50) NOT NULL default '',
mod_comments smallint(5) unsigned NOT NULL default '0',
mod_approved_user smallint(5) unsigned NOT NULL default '0',
mod_approved_rating tinyint(1) unsigned NOT NULL default '0',
mod_approved_comment text NOT NULL,
mod_download_count smallint(5) unsigned NOT NULL default '0',
mod_img varchar(100) NOT NULL default '',
PRIMARY KEY (mod_id)
) TYPE=MyISAM;";

$inf_newtable[3] = DB_MOD_VERSIONS." (
version_id smallint(5) unsigned NOT NULL auto_increment,
version_h varchar(5) NOT NULL default '',
version_l varchar(5) NOT NULL default '',
version_s varchar(12) NOT NULL default '',
version_description text,
version_order smallint(5) unsigned NOT NULL default '0',
PRIMARY KEY (version_id)
) TYPE=MyISAM;";

$inf_newtable[4] = DB_MOD_LOCALES." (  
file_id smallint(5) unsigned NOT NULL auto_increment,  
file_mod smallint(5) unsigned NOT NULL default '0',  
file_name varchar(200) NOT NULL default '',  
file_user smallint(5) unsigned NOT NULL default '0',  
file_language varchar(200) NOT NULL default '',  
file_translator varchar(200) NOT NULL default '',  
file_datestamp int(10) unsigned NOT NULL default '0',  
PRIMARY KEY (file_id)  
) TYPE=MyISAM;";  

$inf_newtable[5] = DB_MOD_ERRORS." (
error_id smallint(5) unsigned NOT NULL auto_increment,
error_mod smallint(5) unsigned NOT NULL default '0',
error_type tinyint(1) unsigned NOT NULL default '0',
error_active tinyint(1) unsigned NOT NULL default '0',
error_user smallint(5) unsigned NOT NULL default '0',
error_report varchar(200) NOT NULL default '',
error_datestamp int(10) unsigned NOT NULL default '0',
error_assign_user varchar(200) NOT NULL default '',
PRIMARY KEY (error_id)
) TYPE=MyISAM;";

$inf_newtable[6] = DB_MOD_TRANS." (
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

$inf_droptable[1] = DB_MOD_CATS;
$inf_droptable[2] = DB_MODS;
$inf_droptable[3] = DB_MOD_VERSIONS;
$inf_droptable[4] = DB_MOD_LOCALES;
$inf_droptable[5] = DB_MOD_ERRORS;
$inf_droptable[6] = DB_MOD_TRANS;

$inf_deldbrow[1] = "DELETE FROM ".DB_COMMENTS." WHERE comment_type='M'";
$inf_deldbrow[2] = "DELETE FROM ".DB_RATINGS." WHERE rating_type='M'";

$inf_adminpanel[1] = array(
	"title" => $locale['moddb102'],
	"image" => "",
	"panel" => "admin/index.php",
	"rights" => "MODS"
);

$inf_sitelink[1] = array(
	"title" => $locale['moddb102'],
	"url" => "mods.php",
	"visibility" => "101"
);

?>