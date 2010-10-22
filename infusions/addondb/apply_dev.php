<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: apply_dev.php
| Author: PHP-Fusion Addons Team
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| addonify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

require_once INFUSIONS."addondb/inc/inc.functions.php";
require_once ADDON."infusion_db.php";
include ADDON_LOCALE.LOCALESET."apply_dev.php";

if (iMEMBER) { $addoncount = number_format(dbcount("(addon_id)", DB_ADDONS, "addon_author_name='".$userdata['user_name']."' && addon_status = '0'")); } else { $addoncount = "0"; }
if (iMEMBER) { $suspend_check = dbarray(dbquery("SELECT suspended_user, reinstate_date FROM ".DB_SUSPENDS." WHERE suspended_user = '".$userdata['user_id']."'"));
$time = time();
if (($suspend_check['reinstate_date'] + $settings_global['susp_time']) > ($time + $settings['timeoffset'] * 3600)) { define("SUSPEND_USER", true); } else { define("SUSPEND_USER", false); }
}

     if (!iMEMBER) {
	    
		opentable($locale['apdev005']);
	    echo "<center><br />".$locale['apdev006']."<br /><br /></center>\n";
	    echo "<br /><center>".$locale['global_105']."</center>\n";
	    closetable();
  
  } elseif (iMEMBER && ($addoncount < $settings_global['addons_dev_qual'])) {
        
		opentable($locale['apdev005']);
        echo "<center><br />".$locale['apdev008']."</br /></center>\n";
        echo "<center><br />".$locale['apdev011'].$settings_global['addons_dev_qual']."</br /></center>\n";
        echo "<center><br /><a href='".ADDON."dashboard.php'>".$locale['apdev013']."</a><br /><br /></center>";
        closetable();
        
        } elseif (iMEMBER && SUSPEND_USER == true) {
        
//Suspend Time

	     if ($settings_global['susp_time'] == 604800) { $date = $locale['set_time03']; }
	elseif ($settings_global['susp_time'] == 1209600) { $date = $locale['set_time04']; }
	elseif ($settings_global['susp_time'] == 2419200) { $date = $locale['set_time05']; }
	elseif ($settings_global['susp_time'] == 4838400) { $date = $locale['set_time06']; }
   elseif ($settings_global['susp_time'] == 14515200) { $date = $locale['set_time07']; }
	else { $date = ""; }
		
	    opentable($locale['apdev005']);
        echo "<center><br />".$locale['apdev005']."</br /></center>\n";
        echo "<center><br />".$locale['apdev015'].$date.$locale['apdev016']."</br /></center>\n";
        echo "<center><br /><a href='".ADDON."dashboard.php'>".$locale['apdev013']."</a><br /><br /></center>";
        closetable();

		
		} elseif (iMEMBER && !isset($_POST['post_apply'])) {
      
        opentable($locale['apdev001']);
        $status_check = dbarray(dbquery("SELECT addon_author_status FROM ".DB_ADDONS." WHERE addon_author_name = '".$userdata['user_name']."'"));
        
        if ($status_check['addon_author_status'] == '0') {

        echo "<form name='apply' method='post' action='".FUSION_SELF."' >\n";
        echo "<table cellpadding='0' align='center' cellspacing='0' class='tbl-border'>\n<tr>\n";
        echo "<th colspan='2' class='forum-caption'>".$locale['apdev002']."</th>\n";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' colspan='2'>&nbsp;</td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1'>".$locale['apdev003']."</td>";
        echo "<td claas='tbl1'>".$userdata['user_name']."</td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' valign='top'>".$locale['apdev004']."</td>";
        echo "<td class='tbl1' valign='top'><textarea class='textbox' name='apply_comment' style='width:300px; height:100px;'></textarea></td>";
        echo "</tr>\n<tr>\n";
        echo "<td colspan='2' align='center'><input type='checkbox' id='verify' name='verify' value='1' onclick='checkverify()' /><span class='small'><label for='verify'>".$locale['apdev014']."</label></span>";
        echo "<br />";
        echo "<input type='submit' name='post_apply' value='".$locale['apdev007']."' class='button'".($settings_global['set_addondb_sub'] == 0 ? " disabled='disabled'" : "")." />\n";
        echo "<td>";
        echo "</tr>\n<tr>\n";
        echo "<td class='tbl1' valign='top' align='center' colspan='2'><img src='".ADDON_IMG."approved_dev.png' width='182' alt ='' /></td>";
        echo "<input type='hidden' class='textbox' name='apply_user' value='".$userdata['user_name']."' />\n";
        echo "</tr>\n</table>\n</form>\n"; 
        } else {
        echo "<center><br />".$locale['apdev012']."</br /></center>\n"; }

        closetable(); 
      
       } else {
        $dev_apply = dbquery("INSERT INTO ".DB_ADDON_DEV_APPLY." VALUES('', '".$userdata['user_id']."', '".stripinput($_POST['apply_comment'])."')");
        $update = dbquery("UPDATE ".DB_ADDONS." SET addon_author_status='1' WHERE addon_author_name = '".$userdata['user_name']."'");
        opentable($locale['apdev009']);
        echo "<center><br />".$locale['apdev010']."<br /></center>";
        echo "<center><br /><a href='".ADDON."dashboard.php'>".$locale['apdev013']."</a><br /><br /></center>";
        closetable();      
       }
       
		echo "<script language='JavaScript' type='text/javascript'>
			function checkverify() {
				if(document.apply.verify.checked) {
					document.apply.post_apply.disabled=false;
				} else {
					document.apply.post_apply.disabled=true;
				}
			}
		</script>";


require_once THEMES."templates/footer.php";
?>