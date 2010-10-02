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

opentable("AddonDB maintenance");
echo "<p>The Addon Database is currently closed due to technical errors, we apologize for the inconvenience.</p>";
echo "<p><center><img src='".INFUSIONS."addondb/img/addondb_add_3.gif' alt='' /></center></p>";
closetable();

require_once THEMES."templates/footer.php";
?>