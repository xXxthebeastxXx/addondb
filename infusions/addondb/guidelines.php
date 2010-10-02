<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2009 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: guidelines.php
| CVS Version: 1.00
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

if (file_exists(ADDON_LOCALE.$settings['locale']."/guidelines.php")) {
	include ADDON_LOCALE.$settings['locale']."/guidelines.php";
} else {
	include ADDON_LOCALE."English/guidelines.php";
}

if (isset($_REQUEST['trans'])) {

add_to_title($locale['global_200'].$locale['tsg001']);

opentable($locale['tsg001']);

echo "<div align='left'><img src='".ADDON_IMG."logo.png' width='200' align='left' alt ='' />\n";
echo "<br />";
echo $locale['tsg002'];
echo "<br /><br />";
echo "<div class='small'>".$locale['tsg003']."</div>";
echo "<br /><br />";
echo "<div align='right'><a href='".FUSION_SELF."?sub' title=''>".$locale['tsg030']."</a></div><br /><br /><hr /></div>";
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
    echo "<img src='".ADDON_IMG."header_info_trans.jpg' width='462' alt ='' /><br /><br />\n";
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
	echo "<td align='center'><img src='".ADDON_IMG."folder_tree1.jpg' width=216' alt ='' /></td><td align='center'><img src='".ADDON_IMG."folder_tree2.jpg' width=207' alt ='' /></td>";
	echo "</tr><tr>";
	echo "<td class='tbl1' align='center'><b>".$locale['tsg025']."</b></td><td class='tbl1' align='center'><b>".$locale['tsg026']."</b></td>";
	echo "</tr><tr>";
	echo "<td align='center'><img src='".ADDON_IMG."t_user_field_tree.jpg' width=238' alt ='' /></td><td align='center'><img src='".ADDON_IMG."t_bbcode_tree.jpg' width=245' alt ='' /></td>";
	echo "</tr>\n</table>\n";
	
	echo "<br /><br />\n";
	
	echo "<div class='tbl2'><b>".$locale['tsg027']."</b><br />";
	echo "".$locale['tsg028']."<br />\n";
	echo "".$locale['tsg029']."</div>\n";
	echo "<br />\n";
    echo "".$locale['tsg029']." <img src='".ADDON_IMG."translate.png' width='37' alt ='' />\n";
    if (iMEMBER) {
    if (file_exists(INFUSIONS."sf_staff_list/index.php")) {
         echo "<br />".$locale['msg030']."<br />"; }
       } else { 
         echo "<br />".$locale['tsg033']."<br />";
       }
    echo "<br /><div align='right' class='small'>".$locale['tsg200']."</div>\n";

closetable();


} else {

add_to_title($locale['global_200'].$locale['msg001']);

opentable($locale['msg001']);

echo "<div align='left'><img src='".ADDON_IMG."logo.png' width='200' align='left' alt ='' />\n";
echo "<br />";
echo $locale['msg002'];
echo "<br /><br />";
echo "<div class='small'>".$locale['msg003']."</div>";
echo "<br /><br />";
echo "<div align='right'><a href='".FUSION_SELF."?trans' title=''>".$locale['msg031']."</a></div><br /><br /><hr /></div>";
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
    echo "<img src='".ADDON_IMG."header_info.jpg' width='416' alt ='' /><br /><br />\n";
	echo "<li>".$locale['msg012']."</li>";
	echo "<li>".$locale['msg013']."</li>";
echo "</ul>";
echo "<b>".$locale['msg014']."</b>";
echo "<br />";
echo "<ul>";
    echo "<li>".$locale['msg034']."<br/>";
    echo "<a target='_blank' title='W3C Markup Validation' href='http://validator.w3.org/'><img src='".ADDON_IMG."valid_xhtml.png' alt='W3C Markup Validation' /></a>\n";
    echo "<a target='_blank' title='W3C CSS Validation' href='http://jigsaw.w3.org/css-validator/'><img src='".ADDON_IMG."valid_css.png' alt='W3C CSS Validation' /></a></li>\n";
    echo "<li>".$locale['msg035']."<br/>";
    echo "<a target='_blank' title='RSS Feed Validator' href='http://feedvalidator.org/'><img src='".ADDON_IMG."valid-rss.png' alt='RSS Feed Validator' /></a></li>\n";
    echo "<li>".$locale['msg036']."</li>";
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
	echo "<td align='center'><img src='".ADDON_IMG."folder_tree.jpg' width='230' alt ='' /></td><td align='center'><img src='".ADDON_IMG."user_field_tree.jpg' width='266' alt ='' /></td>";
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

include ADDON_INC."addon_select.php";
    
    echo "<br /><div align='right' class='small'>".$locale['msg200']."</div>\n";

closetable();

}
            
require_once THEMES."templates/footer.php";
?>