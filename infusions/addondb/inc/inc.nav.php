<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: inc_nav.php
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

if (!defined("IN_FUSION")) { die("Access Denied"); }

if (file_exists(ADDON_LOCALE.LOCALESET."admin/inc.nav.php")) {
	include ADDON_LOCALE.LOCALESET."admin/inc.nav.php";
} else {
	include ADDON_LOCALE."English/admin/inc.nav.php";
}

$dot = "<img src='".ADDON_IMG."grid_dot.png' alt='' />";

opentable($locale['incnav_001']);
echo "<center>
".$dot." <a href='".ADDON_ADMIN."index.php".$aidlink."'>".$locale['incnav_002']."</a> 
".$dot." <a href='".ADDON_ADMIN."submissions.php".$aidlink."'>".$locale['incnav_003']."</a> 
".$dot." <a href='".ADDON_ADMIN."support_thread.php".$aidlink."'>".$locale['incnav_004']."</a> 
".$dot." <a href='".ADDON_ADMIN."error.php".$aidlink."'>".$locale['incnav_005']."</a> 
".$dot." <a href='".ADDON_ADMIN."cats.php".$aidlink."'>".$locale['incnav_006']."</a> 
".$dot." <a href='".ADDON_ADMIN."versions.php".$aidlink."'>".$locale['incnav_007']."</a> 
".$dot." <a href='".ADDON_ADMIN."settings.php".$aidlink."'>".$locale['incnav_008']."</a> 
".$dot."</center>\n";

closetable();

?>