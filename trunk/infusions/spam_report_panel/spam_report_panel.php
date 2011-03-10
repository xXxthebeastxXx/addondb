<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: spam_report_panel.php  - Main Site Version
| Author: Philip Daly (HobbyMan)
| Web: http://www.phpnuclear.com/
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
include INFUSIONS."spam_report_panel/infusion_db.php";
if (file_exists(INFUSIONS."spam_report_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."spam_report_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."spam_report_panel/locale/English.php";
}

if (!function_exists("fetch_url")) {
   function fetch_url() {
      $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
      return $url;
   }
}

$url = fetch_url();
$spam_reported = dbcount("(spr_id)", DB_SPAM_REPORT, "spr_page='".$url."' && spr_status='1'");
$admin_notify = dbcount("(spr_id)", DB_SPAM_REPORT, "spr_status='1'");

$dont_display = array("index.php", "contact.php", "coc.php", "downloads.php", "edit_profile.php", "faq.php", "forum_index.php", "login.php", "lostpassword.php",  "members.php", "messages.php",  "news_cats.php", "profile.php", "search.php", "submit.php", "submit_addon.php", "weblinks.php");

if (!in_array(FUSION_SELF, $dont_display, true)) {
  
  if ($spam_reported > '0') { 
 echo "<center><strong><span style='color:#FF0000;'>".$locale['spr_003']."</span></strong>";
 
 if (iADMIN) {
 echo "<br /><a href='".INFUSIONS."spam_report_panel/spam_reports.php' title=''>".$locale['spr_006']."</a></center>\n";  
 } else {
 echo "<br />".$locale['spr_006']."</center>\n";
   }
      } else {

 if (iMEMBER && isset($_POST['spr_status'])) {
   
        $spr_status = stripinput(trim($_POST['spr_status']));
        $time = time();
        $result = dbquery("INSERT INTO ".DB_SPAM_REPORT." VALUES(
                                                               '', 
                                                               '".stripinput($userdata['user_id'])."', 
                                                               '".stripinput($url)."', 
                                                               '".$spr_status."', 
                                                               '".stripinput($time)."')
                                                               ");
                                                                      
     { redirect($url); }
     
       } elseif (iMEMBER) {
       
     echo "<form name='spam_report' method='post' action='".$url."' >\n";
     echo "<center>\n";
     echo "<input type='hidden' name='spr_status' value='1' />\n";
     echo "<input type='submit' name='spam_report' class='button' value='".$locale['spr_002']."' />\n";
     echo "</form>\n</center><br />\n";
     
     }
     
   if (iADMIN && $admin_notify > 0) {
   echo "<center>\n<a href='".INFUSIONS."spam_report_panel/spam_reports.php' title=''><span style='color:#FF0000;'><strong>".$locale['spr_003']."</strong></span></a>\n</center>\n";
           }
        }
     } elseif (iADMIN && $admin_notify > 0) {
   echo "<center>\n<a href='".INFUSIONS."spam_report_panel/spam_reports.php' title=''><span style='color:#FF0000;'><strong>".$locale['spr_003']."</strong></span></a>\n</center>\n";
 }

?>