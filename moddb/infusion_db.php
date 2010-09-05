<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion_db.php
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

if (!defined("DB_MOD_CATS")) {
	define("DB_MOD_CATS", DB_PREFIX."moddb_cats");
}
if (!defined("DB_MODS")) {
	define("DB_MODS", DB_PREFIX."moddb_mods");
}
if (!defined("DB_MOD_VERSIONS")) {
	define("DB_MOD_VERSIONS", DB_PREFIX."moddb_versions");
}
if (!defined("DB_MOD_LOCALES")) {
	define("DB_MOD_LOCALES", DB_PREFIX."moddb_locales");
}
if (!defined("DB_MOD_ERRORS")) {
	define("DB_MOD_ERRORS", DB_PREFIX."moddb_errors");
}
if (!defined("DB_MOD_TRANS")) {
	define("DB_MOD_TRANS", DB_PREFIX."moddb_translations");
}

?>