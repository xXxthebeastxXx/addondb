<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2009 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: translation_guidelines.php
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

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."moddb/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."moddb/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."moddb/locale/English/translation_guidelines.php";
}

add_to_title($locale['global_200'].$locale['tsg001']);

opentable($locale['tsg001']);

echo "<div align='left'><img src='".INFUSIONS."moddb/img/logo.png' width=200' align='left' alt ='' />\n";
echo "<br />";
echo $locale['tsg002'];
echo "<br /><br />";
echo "<div class='small'>".$locale['tsg003']."</div>";
echo "<br /><br />";
echo "<div align='right'><a href='".INFUSIONS."moddb/submission_guidelines.php' title=''>".$locale['tsg030']."</a></div><br /><br /><hr /></div>";
echo "<b>".$locale['tsg004']."</b>";
echo "<br />";
echo "<ul>";
	  echo "<li>".$locale['tsg005']."</li>";
	  echo "<li>".$locale['tsg006']."</li>";
	  echo "<li>".$locale['tsg007']."</li>";
echo "</ul>\n";
echo "<b>".$locale['tsg009']."</b>";
echo "<br />";
echo "<ul>";
    echo "<li>".$locale['tsg010']."</li>";	      
    echo "<li>".$locale['tsg011']."</li><br />";
    echo "<img src='".INFUSIONS."moddb/img/header_info_trans.jpg' width=462' alt ='' /><br /><br />\n";
	echo "<li>".$locale['tsg012']."</li>";
	echo "<li>".$locale['tsg013']."</li>";
echo "</ul>";
echo "<b>".$locale['tsg014']."</b>";
echo "<br />";
echo "<ul>";

	echo "<li>".$locale['tsg016']."</li>";
	  echo "<ul type='circle'>";
	  echo "<li>".$locale['tsg017']."</li>";
	  echo "<li>".$locale['tsg018']."</li>";
	  echo "<li>".$locale['tsg019']."</li>";
	  echo "<li>".$locale['tsg020']."</li>";
	  echo "</ul>";
	echo "<li>".$locale['tsg021']."</li>";
	echo "<li>".$locale['tsg022']."</li><br />";
	echo "</ul>\n";
	
    echo "<table border='0' width='80%' align='center' cellspacing='0' cellpadding='0'><tr>\n";
	echo "<td class='tbl1' align='center'><b>".$locale['tsg023']."</b></td><td class='tbl1' align='center'><b>".$locale['tsg024']."</b></td>";
	echo "</tr><tr>";
	echo "<td align='center'><img src='".INFUSIONS."moddb/img/folder_tree1.jpg' width=216' alt ='' /></td><td align='center'><img src='".INFUSIONS."moddb/img/folder_tree2.jpg' width=207' alt ='' /></td>";
	echo "</tr><tr>";
	echo "<td class='tbl1' align='center'><b>".$locale['tsg025']."</b></td><td class='tbl1' align='center'><b>".$locale['tsg026']."</b></td>";
	echo "</tr><tr>";
	echo "<td align='center'><img src='".INFUSIONS."moddb/img/t_user_field_tree.jpg' width=238' alt ='' /></td><td align='center'><img src='".INFUSIONS."moddb/img/t_bbcode_tree.jpg' width=245' alt ='' /></td>";
	echo "</tr>\n</table>\n";
	
	echo "<br /><br />\n";
	
	echo "<div class='tbl2'><b>".$locale['tsg027']."</b><br />";
	echo "".$locale['tsg028']."<br />\n";
	echo "".$locale['tsg029']."</div>\n";
	echo "<br />\n";
    echo "".$locale['tsg029']." <img src='".INFUSIONS."moddb/img/translate.png' width=37' alt ='' />\n";
    if (iMEMBER) {
    echo "<br />".$locale['tsg032']."<br />"; } else { echo "<br />".$locale['tsg033']."<br />"; }

    echo "<br /><div align='right' class='small'>".$locale['tsg200']."</div>\n";

closetable();

require_once THEMES."templates/footer.php";
?>