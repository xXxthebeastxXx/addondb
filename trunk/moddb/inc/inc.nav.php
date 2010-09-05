<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: mods_admin_nav.php
| Author: Christian Damsgaard Jørgensen (PMM)
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
opentable("Mod DB Navigation");
echo "<center>
<a href='".INFUSIONS."moddb/admin/index.php".$aidlink."'>Add/Edit Mod</a> | 
<a href='".INFUSIONS."moddb/admin/submissions.php".$aidlink."'>Submissions</a> |
<a href='".INFUSIONS."moddb/admin/thread_create.php".$aidlink."'>Mods Support Threads</a> | 
<a href='".INFUSIONS."moddb/admin/error.php".$aidlink."'>Errors</a> | 
<a href='".INFUSIONS."moddb/admin/cats.php".$aidlink."'>Mod Categories</a> | 
<a href='".INFUSIONS."moddb/admin/versions.php".$aidlink."'>PHP-Fusion Versions</a>
</center>\n";

closetable();

?>