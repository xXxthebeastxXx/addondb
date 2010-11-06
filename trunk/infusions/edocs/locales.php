<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: locales.php
| Author: Philip Daly (HobbyMan)
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

if (file_exists(EDOC_LOC."/".$settings['locale']."/locales.php")) {
	include EDOC_LOC."/".$settings['locale']."/locales.php";
	include EDOC_LOC."/".$settings['locale']."/header.php";
} else {
	include EDOC_LOC."English/locales.php";
	include EDOC_LOC."English/header.php";
}

$author = "Philip Daly (HobbyMan)";
$version = "v1.1";

include EDOC."edoc_nav.php";
echo "<h1>".$locale['edoc600']."</h1><span style='float:right;'>".$img_locale."</span>";

echo "<ul>\n";
echo "<li>".$locale['edoc601']."</li><br />\n";
echo "<li>".$locale['edoc602']."</li><br />\n";
echo "<li>".$locale['edoc603']."</li><br />\n";
echo "<li>".$locale['edoc604']."</li><br />\n";
echo "</ul>\n";

echo "<table cellspacing='3' class='tbl-border center' width='500'>\n<tr>\n";
echo "<th class='forum-caption' colspan='3'>".$locale['edoc605']."</th>\n</tr>\n";
echo "<tr>\n";
echo "<td colspan='3'>&nbsp;</td>\n";
echo "</tr>\n<tr>\n";
echo "<td colspan='3'><b>v7.00.xx</b></td>\n";
echo "</tr>\n<tr>\n";
echo "<td valign='top'>
<img src='".EDOC_IMGS."flags/sa.png' alt='".$locale['edoc606']."' border='0' /> ".$locale['edoc606']."<br />
<img src='".EDOC_IMGS."flags/az.png' alt='".$locale['edoc607']."' border='0' /> ".$locale['edoc607']."<br />
<img src='".EDOC_IMGS."flags/by.png' alt='".$locale['edoc608']."' border='0' /> ".$locale['edoc608']."<br />
<img src='".EDOC_IMGS."flags/ba.png' alt='".$locale['edoc609']."' border='0' /> ".$locale['edoc609']."<br />
<img src='".EDOC_IMGS."flags/bg.png' alt='".$locale['edoc610']."' border='0' /> ".$locale['edoc610']."<br />
<img src='".EDOC_IMGS."flags/ct.png' alt='".$locale['edoc611']."' border='0' /> ".$locale['edoc611']."<br />
<img src='".EDOC_IMGS."flags/cz.png' alt='".$locale['edoc612']."' border='0' /> ".$locale['edoc612']."<br />
<img src='".EDOC_IMGS."flags/dk.png' alt='".$locale['edoc613']."' border='0' /> ".$locale['edoc613']."<br />
<img src='".EDOC_IMGS."flags/nl.png' alt='".$locale['edoc614']."' border='0' /> ".$locale['edoc614']."<br />
<img src='".EDOC_IMGS."flags/fr.png' alt='".$locale['edoc615']."' border='0' /> ".$locale['edoc615']."</td>\n";
echo "<td valign='top'>
<img src='".EDOC_IMGS."flags/de.png' alt='".$locale['edoc616']."' border='0' /> ".$locale['edoc616']."<br />
<img src='".EDOC_IMGS."flags/gr.png' alt='".$locale['edoc617']."' border='0' /> ".$locale['edoc617']."<br />
<img src='".EDOC_IMGS."flags/hu.png' alt='".$locale['edoc618']."' border='0' /> ".$locale['edoc618']."<br />
<img src='".EDOC_IMGS."flags/id.png' alt='".$locale['edoc619']."' border='0' /> ".$locale['edoc619']."<br />
<img src='".EDOC_IMGS."flags/ie.png' alt='".$locale['edoc620']."' border='0' /> ".$locale['edoc620']."<br />
<img src='".EDOC_IMGS."flags/it.png' alt='".$locale['edoc621']."' border='0' /> ".$locale['edoc621']."<br />
<img src='".EDOC_IMGS."flags/ku.png' alt='".$locale['edoc622']."' border='0' /> ".$locale['edoc622']."<br />
<img src='".EDOC_IMGS."flags/lt.png' alt='".$locale['edoc623']."' border='0' /> ".$locale['edoc623']."<br />
<img src='".EDOC_IMGS."flags/no.png' alt='".$locale['edoc624']."' border='0' /> ".$locale['edoc624']."<br />
<img src='".EDOC_IMGS."flags/pe.png' alt='".$locale['edoc625']."' border='0' /> ".$locale['edoc625']."</td>";
echo "<td valign='top'>
<img src='".EDOC_IMGS."flags/pl.png' alt='".$locale['edoc626']."' border='0' /> ".$locale['edoc626']."<br />
<img src='".EDOC_IMGS."flags/pt.png' alt='".$locale['edoc627']."' border='0' /> ".$locale['edoc627']."<br />
<img src='".EDOC_IMGS."flags/ro.png' alt='".$locale['edoc628']."' border='0' /> ".$locale['edoc628']."<br />
<img src='".EDOC_IMGS."flags/ru.png' alt='".$locale['edoc629']."' border='0' /> ".$locale['edoc629']."<br />
<img src='".EDOC_IMGS."flags/sk.png' alt='".$locale['edoc630']."' border='0' /> ".$locale['edoc630']."<br />
<img src='".EDOC_IMGS."flags/es.png' alt='".$locale['edoc631']."' border='0' /> ".$locale['edoc631']."<br />
<img src='".EDOC_IMGS."flags/se.png' alt='".$locale['edoc632']."' border='0' /> ".$locale['edoc632']."<br />
<img src='".EDOC_IMGS."flags/tr.png' alt='".$locale['edoc633']."' border='0' /> ".$locale['edoc633']."<br />
<img src='".EDOC_IMGS."flags/ua.png' alt='".$locale['edoc634']."' border='0' /> ".$locale['edoc634']."</td>";
echo "</tr>\n<tr>\n";
echo "<td colspan='3'><hr /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td colspan='3'><b>v7.01.xx</b></td>\n";
echo "</tr>\n<tr>\n";
echo "<td valign='top'><img src='".EDOC_IMGS."flags/tr.png' alt='".$locale['edoc633']."' border='0' /> ".$locale['edoc633']."</td>";
echo "<td valign='top'>&nbsp;</td>\n";
echo "<td valign='top'>&nbsp;</td>\n";
echo "</tr>\n</table>\n";
echo "<br />".$locale['edoc635']."<br />\n<br />\n";

include EDOC."footer_include.php";

require_once THEMES."templates/footer.php";
?>