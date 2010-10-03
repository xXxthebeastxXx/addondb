<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: submit_addon.php
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

require_once INFUSIONS."addondb/inc/inc.functions.php";
require_once ADDON."infusion_db.php";

if (file_exists(ADDON_LOCALE.$settings['locale']."/submit_addon.php")) {
	include ADDON_LOCALE.$settings['locale']."/submit_addon.php";
} else {
	include ADDON_LOCALE."English/submit_addon.php";
}

add_to_title($locale['global_200'].$locale['addondb412']);

opentable($locale['addondb412']);


include ADDON_INC."addon_select.php";

echo "<br /><b>".$locale['addondb422']."</b><br />\n";
echo "<br />".$locale['addondb423'];
echo "<br />".$locale['addondb424']."<br />\n";

closetable();
       
require_once THEMES."templates/footer.php";
?>