<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: submitted_mods_panel.php
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
if (!defined("IN_FUSION")) { die("Access Denied"); }
require_once INFUSIONS."moddb/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."moddb/locale/".$settings['locale']."/submitted_mods_panel.php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."moddb/locale/".$settings['locale']."/submitted_mods_panel.php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."moddb/locale/English/submitted_mods_panel.php";
}

openside($locale['moddbp400']);
$modsq = dbquery("SELECT * FROM ".DB_SUBMISSIONS." WHERE submit_type='m' ORDER BY submit_id DESC");
$errosq = dbquery("SELECT * FROM ".DB_MOD_ERRORS." WHERE error_active ='1'");
$transq = dbquery("SELECT * FROM ".DB_MOD_TRANS." WHERE trans_active='1'");
$totalmq = dbquery("SELECT * FROM ".DB_MODS." WHERE mod_status='0'");
$totaltq = dbquery("SELECT * FROM ".DB_MOD_TRANS." WHERE trans_active='0'");
$subm_tutorials = dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='a'");

$mods = dbrows($modsq);
$errors = dbrows($errosq);
$trans = dbrows($transq);
$totalm = dbrows($totalmq);
$totalt = dbrows($totaltq);

echo "<div style='text-align:left;'>
<a href='".INFUSIONS."moddb/admin/submissions.php".$aidlink."'>".$mods.$locale['moddbp405'].$locale['moddbp401']."</a><br />
<a href='".INFUSIONS."moddb/admin/submissions.php".$aidlink."'>".$trans.$locale['moddbp405'].$locale['moddbp403']."</a><br />
<a href='".INFUSIONS."moddb/admin/error.php".$aidlink."'>".$errors.$locale['moddbp405'].$locale['moddbp407']."</a><br />";
if ($subm_tutorials != 0) {
echo "<a href='".BASEDIR."administration/submissions.php".$aidlink."' class='side'>".$subm_tutorials." Submitted Tutorials</a><br />";	}
echo "</div>
<div style='text-align:center;'><br />".$totalm." ".$locale['moddbp401'].$locale['moddbp406'].$totalt.$locale['moddbp403']."<br />".$locale['moddbp404']."<br /><br />
<a href='".INFUSIONS."moddb/mods_admin.php".$aidlink."'>".$locale['moddbp402']."</a></div>";
closeside();
?>