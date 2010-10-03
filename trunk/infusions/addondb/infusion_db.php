<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion_db.php
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

if (!defined("DB_ADDON_CATS")) {
	define("DB_ADDON_CATS", DB_PREFIX."addondb_cats");
}
if (!defined("DB_ADDONS")) {
	define("DB_ADDONS", DB_PREFIX."addondb_addons");
}
if (!defined("DB_ADDON_VERSIONS")) {
	define("DB_ADDON_VERSIONS", DB_PREFIX."addondb_versions");
}
if (!defined("DB_ADDON_LOCALES")) {
	define("DB_ADDON_LOCALES", DB_PREFIX."addondb_locales");
}
if (!defined("DB_ADDON_ERRORS")) {
	define("DB_ADDON_ERRORS", DB_PREFIX."addondb_errors");
}
if (!defined("DB_ADDON_TRANS")) {
	define("DB_ADDON_TRANS", DB_PREFIX."addondb_translations");
}

if (!defined("DB_ADDON_STGS")) {
	define("DB_ADDON_STGS", DB_PREFIX."addondb_settings");
}

?>