<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: spam_reports.php
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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

if (!iADMIN) { redirect("../../index.php"); }

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

 if (isset($_GET['action']) && ($_GET['action'] == 1)) {
     $result = dbquery("DELETE FROM ".DB_SPAM_REPORT." WHERE spr_id='".$_GET['action_id']."'");
  }

opentable($locale['spr_001']);

 $result = dbquery(
            "SELECT a.spr_id, a.spr_user, a.spr_page, a.spr_status, a.spr_datestamp, u.user_id, u.user_name, u.user_status
			FROM ".DB_SPAM_REPORT." a
			LEFT JOIN ".DB_USERS." u ON u.user_id=a.spr_user 
			WHERE a.spr_status = '1'
			ORDER BY spr_datestamp
			DESC
			");
 
  if (dbrows($result)) {
  
  echo "<table width='100%' cellpadding='0' cellspacing='1' class='tbl-border'>\n<tr>\n";
  echo "<td class='tbl2' colspan='4'>".$locale['spr_012']."</td>\n</tr>\n<tr>";
  echo "<td class='tbl2'>".$locale['spr_007']."</td>\n";
  echo "<td class='tbl2'>".$locale['spr_008']."</td>\n";
  echo "<td class='tbl2'>".$locale['spr_009']."</td>\n\n";
  echo "<td class='tbl2'>".$locale['spr_010']."</td>\n</tr>\n";
  
  while($data = dbarray($result)) {
  
   echo "<tr>\n<td class='tbl1' align='center'><a href='".$data['spr_page']."'>".$locale['spr_004']."</a></td>\n";
   echo "<td class='tbl1'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."</td>\n";
   echo "<td class='tbl1'>".strftime('%d/%m/%Y %H:%M', $data['spr_datestamp']+($settings['timeoffset']*3600))."</td>\n";
   echo "<td class='tbl1'><a href='".FUSION_SELF.$aidlink."&action=1&action_id=".$data['spr_id']."'>".$locale['spr_011']."</a></td>\n</tr>\n";
 
           }
   echo "</table>\n";        
        }  else { echo "<br />\n<div align='center'>".$locale['spr_050']."<br />\n</div>\n"; }
   closetable();
        
require_once THEMES."templates/footer.php";
?>