<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: addondb_panel.php
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
require_once INFUSIONS."addondb/infusion_db.php";

if (file_exists(INFUSIONS."addondb/locale/".$settings['locale']."/submitted_addons_panel.php")) {
	include INFUSIONS."addondb/locale/".$settings['locale']."/submitted_addons_panel.php";
} else {
	include INFUSIONS."addondb/locale/English/submitted_addons_panel.php";
}

openside($locale['addondbp400']);
$modsq = dbquery("SELECT * FROM ".DB_SUBMISSIONS." WHERE submit_type='m' ORDER BY submit_id DESC");
$errosq = dbquery("SELECT * FROM ".DB_ADDON_ERRORS." WHERE error_active ='1'");
$transq = dbquery("SELECT * FROM ".DB_ADDON_TRANS." WHERE trans_active='1'");
$totalmq = dbquery("SELECT * FROM ".DB_ADDONS." WHERE mod_status='0'");
$totaltq = dbquery("SELECT * FROM ".DB_ADDON_TRANS." WHERE trans_active='0'");
$subm_tutorials = dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='a'");

$mods = dbrows($modsq);
$errors = dbrows($errosq);
$trans = dbrows($transq);
$totalm = dbrows($totalmq);
$totalt = dbrows($totaltq);

echo "<div style='text-align:left;'>
<a href='".INFUSIONS."addondb/admin/submissions.php".$aidlink."'>".$mods.$locale['addondbp405'].$locale['addondbp401']."</a><br />
<a href='".INFUSIONS."addondb/admin/submissions.php".$aidlink."'>".$trans.$locale['addondbp405'].$locale['addondbp403']."</a><br />
<a href='".INFUSIONS."addondb/admin/error.php".$aidlink."'>".$errors.$locale['addondbp405'].$locale['addondbp407']."</a><br />";
if ($subm_tutorials != 0) {
echo "<a href='".BASEDIR."administration/submissions.php".$aidlink."' class='side'>".$subm_tutorials." Submitted Tutorials</a><br />";	}
echo "</div>
<div style='text-align:center;'><br />".$totalm." ".$locale['addondbp401'].$locale['addondbp406'].$totalt.$locale['addondbp403']."<br />".$locale['addondbp404']."<br /><br />
<a href='".INFUSIONS."addondb/admin/index.php".$aidlink."'>".$locale['addondbp402']."</a></div>";
closeside();
?>