<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: license_apply.php
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

include INFUSIONS."license_admin/infusion_db.php";
require_once INFUSIONS."addondb/infusion_db.php";
$addon_global = dbarray(dbquery("SELECT addons_dev_qual FROM ".DB_ADDON_STGS));

if (file_exists(INFUSIONS."license_admin/locale/".$settings['locale'].".php")) {
	include INFUSIONS."license_admin/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."license_admin/locale/English.php";
}
add_to_title($locale['global_200'].$locale['pla_001'].$locale['global_200'].$locale['pla_003']);

// 0 = Not Applied
// 1 = Applied
// 2 = Approved
// 3 = Denied

if (iMEMBER && !isset($_POST['licenseform'])) {

opentable($locale['pla_004']);

// Delete after testing
echo "<br /><center><b>This form is currently undergoing testing. No applications wiil be accepted!</B></center><br /><br />\n";
// Delete after testing

        echo "<form name='licenseform' method='post' action='".FUSION_SELF."' >\n";
        echo "<br />\n<table cellpadding='0' align='center' cellspacing='0' width='80%' class='tbl-border'>\n<tr>\n";
        echo "<th colspan='2' class='forum-caption'>".$locale['pla_003']."</th>\n";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' colspan='2'>&nbsp;</td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' align='right' valign='top'>".$locale['pla_112'].":</td>";
        echo "<td class='tbl1' valign='top'>".$userdata['user_name']."</td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' align='right' valign='top'>".$locale['pla_140'].":</td>";
        echo "<td class='tbl1' valign='top'><input type='textbox' class='textbox' name='app_realname' style='width:300px;'></td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' align='right' valign='top'>".$locale['pla_144'].":</td>";
        echo "<td class='tbl1' valign='top'><textarea class='textbox' name='app_address' style='width:300px; height:50px;'></textarea></td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' align='right' valign='top'>".$locale['pla_124'].":</td>";
        echo "<td class='tbl1' valign='top'>";
        include INFUSIONS."license_admin/country_include.php";
        echo "</td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' align='right' valign='top'>".$locale['pla_145'].":</td>";
        echo "<td class='tbl1' valign='top'><input type='textbox' class='textbox' name='app_phone' style='width:300px;'></td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' align='right' valign='top'>".$locale['pla_117'].":</td>";
        echo "<td class='tbl1' valign='top'><input type='textbox' class='textbox' name='app_url' style='width:300px;'></td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' align='right' valign='top'>".$locale['pla_143'].":</td>";
        echo "<td class='tbl1' valign='top'><input type='textbox' class='textbox' name='app_vat' style='width:300px;'></td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' align='right' valign='top'>".$locale['pla_109'].":</td>";
        echo "<td class='tbl1' nowrap valign='top'>";
    	echo "<select name='app_type' class='textbox' style='width:300px;'>\n";
    	echo "<option value='0'>".$locale['pla_110']."</option>\n";
    	echo "<option value='1'>".$locale['pla_crl']."</option>\n";
    	echo "<option value='2'>".$locale['pla_ccl']."</option>\n";
    	echo "<option value='3'>".$locale['pla_rsl']."</option>\n";
    	echo "</select>\n</td>\n";
	    echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' align='right' valign='top'>".$locale['pla_113'].":</td>";
        echo "<td class='tbl1' valign='top'><textarea class='textbox' name='app_text' style='width:300px; height:100px;'></textarea></td>";
        echo "</tr>\n<tr>\n"; 
        echo "<td colspan='2' align='center'>";
        echo "<input type='submit' name='licenseform' value='".$locale['pla_116']."' class='button' />\n<br />\n";
        echo "<input type='hidden' class='textbox' name='app_status' value='1' /></td>\n";
        echo "</tr>\n</table>\n</form>\n<br />\n";
        
        echo "<center><i>".$locale['pla_115']."</i></center>\n";
        echo "<center><i>".$locale['pla_146']."</i></center>\n";
        echo "<br /><br /><center>".sprintf($locale['pla_132'], $addon_global['addons_dev_qual'])."<a href='".INFUSIONS."addondb/dashboard.php'>".$locale['pla_502']."</a>.</center>\n";

closetable();

} elseif (iMEMBER && isset($_POST['licenseform'])) {
        $time = time();
        $dev_apply = dbquery("INSERT INTO ".DB_LICENSE_APPLY." VALUES(
                                                                      '', 
                                                                      '".$userdata['user_id']."', 
                                                                      '".stripinput($_POST['app_realname'])."', 
                                                                      '".stripinput($_POST['app_address'])."', 
                                                                      '".$_POST['app_country']."', 
                                                                      '".stripinput($_POST['app_phone'])."', 
                                                                      '".stripinput($_POST['app_vat'])."', 
                                                                      '".$_POST['app_type']."', 
                                                                      '".stripinput($_POST['app_url'])."', 
                                                                      '".stripinput($_POST['app_text'])."', 
                                                                      '".$_POST['app_status']."', 
                                                                      '$time', 
                                                                      '', 
                                                                      '', 
                                                                      '')
                                                                      ");
        
opentable($locale['pla_111']);
        
        echo "<table cellpadding='0' align='center' cellspacing='0' width='500' class='tbl-border'>\n<tr>\n";
        echo "<th colspan='2' class='forum-caption'>".$locale['pla_111']."</th>\n";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1'>&nbsp;</td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' align='center'>".$locale['pla_118']."</td>";
        echo "</tr>\n</tr>\n</table>\n";
        
closetable();

} elseif (!iMEMBER) {

      opentable($locale['pla_009']);
      echo "<br /><br />\n<center>".$locale['pla_141']."</center>\n<br /><br />\n";
      closetable();
}

include INFUSIONS."license_admin/footer_include.php";
require_once THEMES."templates/footer.php";
?>