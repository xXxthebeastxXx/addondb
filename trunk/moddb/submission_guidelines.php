<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2009 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: submission_guidelines.php
| CVS Version: 1.00
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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

require_once INFUSIONS."moddb/infusion_db.php";
require_once INFUSIONS."moddb/inc/inc.functions.php";
include INFUSIONS."moddb/check.js";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."moddb/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."moddb/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."moddb/locale/English/submission_guidelines.php";
}

add_to_title($locale['global_200'].$locale['msg001']);

opentable($locale['msg001']);

echo "<div align='left'><img src='".INFUSIONS."moddb/img/logo.png' width='200' align='left' alt ='' />\n";
echo "<br />";
echo $locale['msg002'];
echo "<br /><br />";
echo "<div class='small'>".$locale['msg003']."</div>";
echo "<br /><br />";
echo "<div align='right'><a href='".INFUSIONS."moddb/translation_guidelines.php' title=''>".$locale['msg031']."</a></div><br /><br /><hr /></div>";
echo "<b>".$locale['msg004']."</b>";
echo "<br />";
echo "<ul>
	      <li>".$locale['msg005']."</li>
	      <li>".$locale['msg006']."</li>
	      <li>".$locale['msg007']."</li>
	      <li>".$locale['msg008']."</li>
	      <li>".$locale['msg008a']."</li>";
echo "</ul>\n";
echo "<b>".$locale['msg009']."</b>";
echo "<br />";
echo "<ul>";
    echo "<li>".$locale['msg010']."</li>";	      
    echo "<li>".$locale['msg011']."</li><br />";
    echo "<img src='".INFUSIONS."moddb/img/header_info.jpg' width='416' alt ='' /><br /><br />\n";
	echo "<li>".$locale['msg012']."</li>";
	echo "<li>".$locale['msg013']."</li>";
echo "</ul>";
echo "<b>".$locale['msg014']."</b>";
echo "<br />";
echo "<ul>";
	echo "<li>".$locale['msg015']."</li>";
	echo "<li>".$locale['msg015a']."</li>";
	echo "<li>".$locale['msg015b']."</li>";
	echo "<li>".$locale['msg028']."</li>";
	echo "<li>".$locale['msg016']."</li>";
	  echo "<ul type='circle'>";
	  echo "<li>".$locale['msg017']."</li>";
	  echo "<li>".$locale['msg018']."</li>";
	  echo "<li>".$locale['msg019']."</li>";
	  echo "<li>".$locale['msg020']."</li>";
	  echo "</ul>";
	echo "<li>".$locale['msg021']."</li>";
	echo "<li>".$locale['msg022']."</li><br />";
	echo "</ul>\n";
	
    echo "<table border='0' width='80%' align='center' cellspacing='0' cellpadding='0'><tr>\n";
	echo "<td class='tbl1' align='center'><b>".$locale['msg023']."</b></td><td class='tbl1' align='center'><b>".$locale['msg024']."</b></td>";
	echo "</tr><tr>";
	echo "<td align='center'><img src='".INFUSIONS."moddb/img/folder_tree.jpg' width='230' alt ='' /></td><td align='center'><img src='".INFUSIONS."moddb/img/user_field_tree.jpg' width='266' alt ='' /></td>";
	echo "</tr>\n</table>\n";
	
	echo "<br /><br />\n";
	echo "<ul><li>";
	echo "<b>".$locale['msg029']."</b>";
	echo sprintf($locale['msg029a'], parsebytesize($settings['photo_max_b']), $settings['photo_max_w'], $settings['photo_max_h']);
	echo "</li><ul>\n";
	echo "<br /><br />\n";
	
	echo "<div class='tbl2'><b>".$locale['msg025']."</b><br />";
	echo "".$locale['msg026']."<br />\n";
	echo "".$locale['msg027']."</div>\n";
	echo "<br />\n";

    if (iMEMBER) {
    echo "<br />".$locale['msg030']."<br /><br />";
    echo "<label for='coauthor'>".$locale['msg032']."</label><input id='checkcoauth' type='checkbox' />";
    echo "<div id='showcoauth'><label><br /><a href='".INFUSIONS."moddb/submit_mod.php' title=''>";
    echo "<img src='".INFUSIONS."moddb/img/submit.png' width='300' alt ='".$locale['msg100']."' /></a></div><br />\n";
    } else { echo "<br /><span class='small'>".$locale['msg101']."</span>\n"; }
    
    echo "<br /><div align='right' class='small'>".$locale['msg200']."</div>\n";

closetable();
            
require_once THEMES."templates/footer.php";
?>