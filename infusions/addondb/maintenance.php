<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: maintenance.php
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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

require_once INFUSIONS."addondb/infusion_db.php";
require_once INFUSIONS."addondb/inc/inc.functions.php";

if (ADDON_MAINTENANCE == false) { redirect("index.php"); }

if (file_exists(ADDON_LOCALE.LOCALESET."addons.php")) {
	include ADDON_LOCALE.LOCALESET."addons.php";
} else {
	include ADDON_LOCALE."English/addons.php";
}

opentable($locale['addondb606']);
echo "<br/>";
echo $settings_global['set_addon_maintmsg'];
echo "<br /><br />";
echo "<p><center><img src='".ADDON_IMG."addon_logo.png' alt='' /></center></p>";
echo "<center>".$locale['addondb607']."</center>\n";
closetable();

require_once THEMES."templates/footer.php";
?>