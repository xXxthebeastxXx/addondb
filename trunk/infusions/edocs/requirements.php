<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: requirements.php
| Adapted as edoc: Philip Daly (HobbyMan)
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

define("EDOC", INFUSIONS."edocs/");
define("EDOC_IMGS", EDOC."imgs/");
define("EDOC_INC", EDOC."inc/");
define("EDOC_LOC", EDOC."locale/");
require EDOC_INC."functions.php";

if (file_exists(EDOC_LOC."/".$settings['locale']."/requirements.php")) {
	include EDOC_LOC."/".$settings['locale']."/requirements.php";
	include EDOC_LOC."/".$settings['locale']."/header.php";
} else {
	include EDOC_LOC."English/requirements.php";
	include EDOC_LOC."English/header.php";
}

$author = "PHP-Fusion Management Team";
$version = "v1.00";
include EDOC."edoc_nav.php";
echo "<h1>".$locale['edoc500']."</h1><span style='float:right;'>".$img_req."</span>";
echo "<ul>\n";
echo "<li>".$locale['edoc501']."</li><br />\n";
echo "<li>".$locale['edoc502']."</li><br />\n";
echo "<li>".$locale['edoc503']."</li><br />\n";
echo "<li>".$locale['edoc504']."</li><br />\n";
echo "<li>".$locale['edoc505']."</li><br />\n";
echo "<li>".$locale['edoc506']."</li><br />\n";
echo "<li>".$locale['edoc507']."</li><br />\n";
echo "<li>".$locale['edoc508']."</li><br />\n";
echo "<li>".$locale['edoc509']."</li><br />\n";
echo "</ul>\n";
echo "<p>".$locale['edoc510']." <a href='".BASEDIR."articles.php?article_id=31' title=''>".$locale['edoc511']."</a></p>\n";
include EDOC."footer_include.php";
require_once THEMES."templates/footer.php";
?>