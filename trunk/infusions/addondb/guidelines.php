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

if (!isset($_REQUEST['addon_type'])) { redirect("index.php"); }

$guideline_footer = "<table border='0' width='100%' align='center' cellspacing='0' cellpadding='0'><tr>\n
                     <thead>\n
                     <th class='forum-caption' colspan='4'>".$locale['msg044']."</th>\n
                     </tr>\n</thead>\n<tbody>\n<tr>\n
                     <td class='tbl2' colspan='4'>".THEME_BULLET.$locale['msg038']."<br />".THEME_BULLET.$locale['msg039']."</td>\n
                     </tr>\n<tr>\n
                     <td class='tbl2' align='center'><a target='_blank' title='".$locale['msg045']."' href='http://validator.w3.org/'><img src='".ADDON_IMG."html_valid.png' alt='".$locale['msg045']."' /></a></td>
                     <td class='tbl2' align='center'><a target='_blank' title='".$locale['msg046']."' href='http://validator.w3.org/'><img src='".ADDON_IMG."xhtml_valid.png' alt='".$locale['msg046']."' /></a></td>
                     <td class='tbl2' align='center'><a target='_blank' title='".$locale['msg047']."' href='http://jigsaw.w3.org/css-validator/'><img src='".ADDON_IMG."css_valid.png' alt='".$locale['msg047']."' /></a></td>
                     <td class='tbl2' align='center'><a target='_blank' title='".$locale['msg048']."' href='http://feedvalidator.org/'><img src='".ADDON_IMG."rss_valid.png' alt='".$locale['msg048']."' /></a></td>\n
                     </tr>\n</tbody>\n</table>\n<br />\n";

if ($_REQUEST['addon_type'] == 'Infusion') {
$addon_type = $_REQUEST['addon_type'];
add_to_title($locale['global_200'].$locale['msg001'].$locale['msg106'].$addon_type);

opentable($locale['msg001'].$locale['msg106'].$addon_type);

echo "<a href='".ADDON."index.php' title=''><img src='".ADDON_IMG."addon_logo.png' width='200' align='left' alt ='' /></a>\n";
echo $locale['msg002'];
echo "<br /><br />";
echo "<div class='small'>".$locale['msg003']."</div>";
echo "<br /><br />";
echo "<b>".$locale['msg004']."</b>";
echo "<br />";
echo THEME_BULLET.$locale['msg005']."<br />";
echo THEME_BULLET.$locale['msg006']."<br />";
echo THEME_BULLET.$locale['msg007']."<br />";
echo THEME_BULLET.$locale['msg008']."<br />";
echo THEME_BULLET.$locale['msg009']."<br />";
echo "<b>".$locale['msg010']."</b>";
echo "<br />";
echo THEME_BULLET.$locale['msg011']."<br />";	      
echo THEME_BULLET.$locale['msg012']."</li><br />";
echo "<img src='".ADDON_IMG."header_info.jpg' width='416' alt ='' /><br /><br />\n";
echo THEME_BULLET.$locale['msg013']."<br />";
echo THEME_BULLET.$locale['msg014']."<br />";
echo "<b>".$locale['msg015']."</b>";
echo "<br />";
echo THEME_BULLET.$locale['msg040']."<br />";
echo THEME_BULLET.$locale['msg016']."<br />";
echo THEME_BULLET.$locale['msg017']."<br />";
echo THEME_BULLET.$locale['msg018']."<br />";
echo THEME_BULLET.$locale['msg031']."<br />";
echo THEME_BULLET.$locale['msg019']."<br />";
echo THEME_BULLET.$locale['msg020']."<br />";
echo THEME_BULLET.$locale['msg021']."<br />";
echo THEME_BULLET.$locale['msg022']."<br />";
echo THEME_BULLET.$locale['msg023']."<br />";
echo THEME_BULLET.$locale['msg041']."<br />";
echo THEME_BULLET.$locale['msg042']."<br />";
echo THEME_BULLET.$locale['msg024']."<br />";
echo THEME_BULLET.$locale['msg025']."<br />";
	
    echo "<table border='0' width='80%' align='center' cellspacing='0' cellpadding='0'><tr>\n";
    echo "<thead>\n";
	echo "<th class='tbl1'><b>".$locale['msg026']."</b></th><th class='tbl1'><b>".$locale['msg027']."</b></th>";
	echo "</tr>\n</thead>\n<tbody>\n<tr>\n";
	echo "<td align='center'><img src='".ADDON_IMG."infusions.png' width='250' alt ='".$locale['msg026']."' /></td><td align='center'><img src='".ADDON_IMG."userfields.png' width='250' alt ='".$locale['msg027']."' /></td>";
	echo "</tr>\n</tbody>\n</table>\n";
	
	echo "<br /><br />\n";
	echo "<b>".$locale['msg032']."</b>";
	echo sprintf($locale['msg033'], parsebytesize($settings['photo_max_b']), $settings['photo_max_w'], $settings['photo_max_h']);
	echo "<br /><br />\n";
	
	echo "<b>".$locale['msg028']."</b><br />";
	echo "".$locale['msg029']."<br />\n";
	echo "".$locale['msg030']."<br />\n<br />\n";
	
	echo $guideline_footer;
	echo "<center><b>".$locale['msg036']."</b><a class='button' href='".ADDON."submit.php?addon_type=".$addon_type."' title=''><span>".$locale['msg043'].$addon_type."</span></a></center><br />\n";

closetable();


} elseif ($_REQUEST['addon_type'] == 'Theme') {
$addon_type = $_REQUEST['addon_type'];

add_to_title($locale['global_200'].$locale['msg001'].$locale['msg106'].$addon_type);

opentable($locale['msg001'].$locale['msg106'].$addon_type);

echo "<a href='".ADDON."index.php' title=''><img src='".ADDON_IMG."addon_logo.png' width='200' align='left' alt ='' /></a>\n";
echo $locale['msg002'];
echo "<br /><br />";
echo "<div class='small'>".$locale['msg003']."</div>";
echo "<br /><br />";
echo "<b>".$locale['msg004']."</b>";
echo "<br />";
echo THEME_BULLET.$locale['msg005']."<br />";
echo THEME_BULLET.$locale['msg006']."<br />";
echo THEME_BULLET.$locale['msg007']."<br />";
echo THEME_BULLET.$locale['msg008']."<br />";
echo THEME_BULLET.$locale['msg009']."<br />";
echo "<b>".$locale['msg010']."</b>";
echo "<br />";
echo THEME_BULLET.$locale['msg011']."<br />";	      
echo THEME_BULLET.$locale['msg012']."</li><br />";
echo "<img src='".ADDON_IMG."header_info.jpg' width='416' alt ='' /><br /><br />\n";
echo THEME_BULLET.$locale['msg013']."<br />";
echo THEME_BULLET.$locale['msg014']."<br />";
echo "<b>".$locale['msg015']."</b>";
echo "<br />";
echo THEME_BULLET.$locale['msg040']."<br />";
echo THEME_BULLET.$locale['msg016']."<br />";
echo THEME_BULLET.$locale['msg017']."<br />";
echo THEME_BULLET.$locale['msg018']."<br />";
echo THEME_BULLET.$locale['msg031']."<br />";
echo THEME_BULLET.$locale['msg019']."<br />";
echo THEME_BULLET.$locale['msg020']."<br />";
echo THEME_BULLET.$locale['msg021']."<br />";
echo THEME_BULLET.$locale['msg022']."<br />";
echo THEME_BULLET.$locale['msg023']."<br />";
echo THEME_BULLET.$locale['msg041']."<br />";
echo THEME_BULLET.$locale['msg042']."<br />";
echo THEME_BULLET.$locale['msg024']."<br />";
echo THEME_BULLET.$locale['msg025']."<br />";
	
    echo "<table border='0' width='80%' align='center' cellspacing='0' cellpadding='0'><tr>\n";
    echo "<thead>\n";
	echo "<th class='tbl1'><b>".$locale['msg049']."</b></th>\n";
	echo "</tr>\n</thead>\n<tbody>\n<tr>\n";
	echo "<td align='center'><img src='".ADDON_IMG."themes.png' width='250' alt ='".$locale['msg049']."' /></td>\n";
	echo "</tr>\n</tbody>\n</table>\n";
	
	echo "<br /><br />\n";
	echo "<b>".$locale['msg032']."</b>";
	echo sprintf($locale['msg033'], parsebytesize($settings['photo_max_b']), $settings['photo_max_w'], $settings['photo_max_h']);
	echo "<br /><br />\n";
	
	echo "<b>".$locale['msg028']."</b><br />";
	echo "".$locale['msg029']."<br />\n";
	echo "".$locale['msg030']."<br />\n<br />\n";
	
	echo $guideline_footer;
	echo "<center><b>".$locale['msg036']."</b><a class='button' href='".ADDON."submit.php?addon_type=".$addon_type."' title=''><span>".$locale['msg043'].$addon_type."</span></a></center><br />\n";

closetable();

} elseif ($_REQUEST['addon_type'] == 'Panel') {
$addon_type = $_REQUEST['addon_type'];
add_to_title($locale['global_200'].$locale['msg001'].$locale['msg106'].$addon_type);


opentable($locale['msg001'].$locale['msg106'].$addon_type);

echo "<a href='".ADDON."index.php' title=''><img src='".ADDON_IMG."addon_logo.png' width='200' align='left' alt ='' /></a>\n";
echo $locale['msg002'];
echo "<br /><br />";
echo "<div class='small'>".$locale['msg003']."</div>";
echo "<br /><br />";
echo "<b>".$locale['msg004']."</b>";
echo "<br />";
echo THEME_BULLET.$locale['msg005']."<br />";
echo THEME_BULLET.$locale['msg006']."<br />";
echo THEME_BULLET.$locale['msg007']."<br />";
echo THEME_BULLET.$locale['msg008']."<br />";
echo THEME_BULLET.$locale['msg009']."<br />";
echo "<b>".$locale['msg010']."</b>";
echo "<br />";
echo THEME_BULLET.$locale['msg011']."<br />";	      
echo THEME_BULLET.$locale['msg012']."</li><br />";
echo "<img src='".ADDON_IMG."header_info.jpg' width='416' alt ='' /><br /><br />\n";
echo THEME_BULLET.$locale['msg013']."<br />";
echo THEME_BULLET.$locale['msg014']."<br />";
echo "<b>".$locale['msg015']."</b>";
echo "<br />";
echo THEME_BULLET.$locale['msg040']."<br />";
echo THEME_BULLET.$locale['msg016']."<br />";
echo THEME_BULLET.$locale['msg017']."<br />";
echo THEME_BULLET.$locale['msg018']."<br />";
echo THEME_BULLET.$locale['msg031']."<br />";
echo THEME_BULLET.$locale['msg019']."<br />";
echo THEME_BULLET.$locale['msg020']."<br />";
echo THEME_BULLET.$locale['msg021']."<br />";
echo THEME_BULLET.$locale['msg022']."<br />";
echo THEME_BULLET.$locale['msg023']."<br />";
echo THEME_BULLET.$locale['msg041']."<br />";
echo THEME_BULLET.$locale['msg042']."<br />";
echo THEME_BULLET.$locale['msg024']."<br />";
echo THEME_BULLET.$locale['msg025']."<br />";
	
    echo "<table border='0' width='80%' align='center' cellspacing='0' cellpadding='0'><tr>\n";
    echo "<thead>\n";
	echo "<th class='tbl1'><b>".$locale['msg050']."</b></th>\n";
	echo "</tr>\n</thead>\n<tbody>\n<tr>\n";
	echo "<td align='center'><img src='".ADDON_IMG."panel.png' width='250' alt ='".$locale['msg050']."' /></td>\n";
	echo "</tr>\n</tbody>\n</table>\n";
	
	echo "<br /><br />\n";
	echo "<b>".$locale['msg032']."</b>";
	echo sprintf($locale['msg033'], parsebytesize($settings['photo_max_b']), $settings['photo_max_w'], $settings['photo_max_h']);
	echo "<br /><br />\n";
	
	echo "<b>".$locale['msg028']."</b><br />";
	echo "".$locale['msg029']."<br />\n";
	echo "".$locale['msg030']."<br />\n<br />\n";
	
	echo $guideline_footer;
	echo "<center><b>".$locale['msg036']."</b><a class='button' href='".ADDON."submit.php?addon_type=".$addon_type."' title=''><span>".$locale['msg043'].$addon_type."</span></a></center><br />\n";

closetable();

} elseif ($_REQUEST['addon_type'] == 'Other') {
$addon_type = $_REQUEST['addon_type'];
add_to_title($locale['global_200'].$locale['msg001'].$locale['msg106'].$addon_type);

opentable($locale['msg001'].$locale['msg106'].$addon_type);

echo "<a href='".ADDON."index.php' title=''><img src='".ADDON_IMG."addon_logo.png' width='200' align='left' alt ='' /></a>\n";
echo $locale['msg002'];
echo "<br /><br />";
echo "<div class='small'>".$locale['msg003']."</div>";
echo "<br /><br />";
echo "<b>".$locale['msg004']."</b>";
echo "<br />";
echo THEME_BULLET.$locale['msg005']."<br />";
echo THEME_BULLET.$locale['msg006']."<br />";
echo THEME_BULLET.$locale['msg007']."<br />";
echo THEME_BULLET.$locale['msg008']."<br />";
echo THEME_BULLET.$locale['msg009']."<br />";
echo "<b>".$locale['msg010']."</b>";
echo "<br />";
echo THEME_BULLET.$locale['msg011']."<br />";	      
echo THEME_BULLET.$locale['msg012']."</li><br />";
echo "<img src='".ADDON_IMG."header_info.jpg' width='416' alt ='' /><br /><br />\n";
echo THEME_BULLET.$locale['msg013']."<br />";
echo THEME_BULLET.$locale['msg014']."<br />";
echo "<b>".$locale['msg015']."</b>";
echo "<br />";
echo THEME_BULLET.$locale['msg040']."<br />";
echo THEME_BULLET.$locale['msg016']."<br />";
echo THEME_BULLET.$locale['msg017']."<br />";
echo THEME_BULLET.$locale['msg018']."<br />";
echo THEME_BULLET.$locale['msg031']."<br />";
echo THEME_BULLET.$locale['msg019']."<br />";
echo THEME_BULLET.$locale['msg020']."<br />";
echo THEME_BULLET.$locale['msg021']."<br />";
echo THEME_BULLET.$locale['msg022']."<br />";
echo THEME_BULLET.$locale['msg023']."<br />";
echo THEME_BULLET.$locale['msg041']."<br />";
echo THEME_BULLET.$locale['msg042']."<br />";
echo THEME_BULLET.$locale['msg024']."<br />";
echo THEME_BULLET.$locale['msg025']."<br />";
	
    echo "<table border='0' width='80%' align='center' cellspacing='0' cellpadding='0'><tr>\n";
    echo "<thead>\n";
	echo "<th class='tbl1'><b>".$locale['tsg025']."</b></th><th class='tbl1'><b>".$locale['tsg026']."</b></th>\n";
	echo "</tr>\n</thead>\n<tbody>\n<tr>\n";
	echo "<td align='center'><img src='".ADDON_IMG."userfields.png' width='250' alt ='' /></td>\n";
	echo "<td align='center'><img src='".ADDON_IMG."bbcodes.png' width='250' alt ='' /></td>\n";
	echo "</tr>\n</tbody>\n</table>\n";
	
	echo "<br /><br />\n";
	echo "<b>".$locale['msg032']."</b>";
	echo sprintf($locale['msg033'], parsebytesize($settings['photo_max_b']), $settings['photo_max_w'], $settings['photo_max_h']);
	echo "<br /><br />\n";
	
	echo "<b>".$locale['msg028']."</b><br />";
	echo "".$locale['msg029']."<br />\n";
	echo "".$locale['msg030']."<br />\n<br />\n";
	
	echo $guideline_footer;
	echo "<center><b>".$locale['msg036']."</b><a class='button' href='".ADDON."submit.php?addon_type=".$addon_type."' title=''><span>".$locale['msg043'].$addon_type."</span></a></center><br />\n";

closetable();

} else { echo "Error"; }
            
require_once THEMES."templates/footer.php";
?>