<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: error.php
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
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";

if (!checkrights("ADNX") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { die("Access Denied"); }

require_once INFUSIONS."addondb/infusion_db.php";
require_once INFUSIONS."addondb/inc/inc.functions.php";
require_once INFUSIONS."addondb/inc/inc.nav.php";

if (file_exists(INFUSIONS."addondb/locale/".LOCALESET."submit_error.php")) {
	include INFUSIONS."addondb/locale/".LOCALESET."submit_error.php";
} else {
	include INFUSIONS."addondb/locale/English/submit_error.php";
}

function error_type($value){
  global $locale;
switch ($value) {

  case 1:
  return $locale['addondb420'];
  break;

  case 2:
  return $locale['addondb410'];
  break;

  case 3:
  return $locale['addondb400'];
  break;

}
}

if(isset($_GET['action']) && isnum($_GET['action']) && isset($_GET['error_id']) && isnum($_GET['error_id'])){

  if($_GET['action'] == 1){
  $result = dbquery("UPDATE ".DB_ADDON_ERRORS." SET error_active='0' WHERE error_id='".$_GET['error_id']."'");
  }
  
  if($_GET['action'] == 2){
  $result = dbquery("DELETE FROM ".DB_ADDON_ERRORS." WHERE error_id='".$_GET['error_id']."'");
  }

  if($_GET['action'] == 3){
  $result = dbquery("UPDATE ".DB_ADDON_ERRORS." SET error_assign_user='".$userdata['user_name']."' WHERE error_id='".$_GET['error_id']."'");
  }
}

$result = dbquery("SELECT e.error_id, e.error_addon, e.error_link, e.error_user, e.error_report, e.error_datestamp, e.error_assign_user, u.user_id, u.user_name, u.user_status    
                          FROM ".DB_ADDON_ERRORS." e 
                          LEFT JOIN ".DB_USERS." u 
                          ON e.error_user=u.user_id
                          WHERE e.error_active ='1' 
                          ORDER BY e.error_datestamp DESC
                          ");
  opentable($locale['addondb463']);
  echo"<div align='center'><table class='tbl-border' align='center' width='100%'><tr>
       <th class='forum-caption'>".$locale['addondb464']."</th>
       <th class='forum-caption'>".$locale['addondb468']."</th>
       <th class='forum-caption'>".$locale['addondb466']."</th>
       <th class='forum-caption'>".$locale['addondb400']."</th>
       <th class='forum-caption'>".$locale['addondb469']."</th>
       <th class='forum-caption'>".$locale['addondb467']."</th>
       </tr>";
  if (dbrows($result)) {
  
			while ($data = dbarray($result)) {
	  $rowcolor = $i% 2==0?"tbl1":"tbl2";
      echo "<tr>
      <td class='".$rowcolor."'><a href='".ADDON."view.php?addon_id=".$data['error_addon']."' target='_blank'>".$locale['addondb410'].": ".$data['error_addon']."</a></td>
      <td class='".$rowcolor."'>".profile_link($data['error_user'], $data['user_name'], $data['user_status'])."</td>
      <td class='".$rowcolor."' width='400'>".$data['error_report']."</td>
      <td class='".$rowcolor."' align='center'>".($data['error_link'] == 1 ? $locale['addondb401'] : $locale['addondb402'])."</td>";
      $approver = profile_link($data['user_id'], $data['error_assign_user'], $data['user_status']);
      echo "<td class='".$rowcolor."'>".($data['error_assign_user'] == '' ? $locale['addondb411'] : $approver)."</td>
      <td class='".$rowcolor."'><a href='".FUSION_SELF.$aidlink."&action=3&error_id=".$data['error_id']."'>".$locale['addondb459']."</a> | <a href='".FUSION_SELF.$aidlink."&action=1&error_id=".$data['error_id']."'>".$locale['addondb460']."</a></td>
      </tr>";
      $i++;
      }
  }
  echo"</table></div>";
  closetable();
  
$result = dbquery("SELECT e.error_id, e.error_addon, e.error_link, e.error_user, e.error_report, e.error_datestamp, e.error_assign_user, u.user_id, u.user_name, u.user_status    
                          FROM ".DB_ADDON_ERRORS." e 
                          LEFT JOIN ".DB_USERS." u 
                          ON e.error_user=u.user_id
                          WHERE e.error_active ='0' 
                          ORDER BY e.error_datestamp DESC
                          ");
  opentable($locale['addondb461']);
  echo"<div align='center'><table class='tbl-border' align='center' width='100%'><tr>
        <th class='forum-caption'>".$locale['addondb464']."</th>
        <th class='forum-caption'>".$locale['addondb468']."</th>
        <th class='forum-caption'>".$locale['addondb466']."</th>
        <th class='forum-caption'>".$locale['addondb400']."</th>
        <th class='forum-caption'>".$locale['addondb469']."</th>
        <th class='forum-caption'>".$locale['addondb467']."</th>
        </tr>";
  if (dbrows($result)) {
  
			while ($data = dbarray($result)) {
	  $rowcolor = $i% 2==0?"tbl1":"tbl2";
      echo "<tr>
      <td class='".$rowcolor."'><a href='".ADDON."view.php?addon_id=".$data['error_addon']."' target='_blank'>".$locale['addondb410'].":: ".$data['error_addon']."</a></td>
      <td class='".$rowcolor."'>".profile_link($data['error_user'], $data['user_name'], $data['user_status'])."</td>
      <td class='".$rowcolor."' width='400'>".$data['error_report']."</td>
      <td class='".$rowcolor."' align='center'>".($data['error_link'] == 1 ? $locale['addondb401'] : $locale['addondb402'])."</td>\n";
      $approver = profile_link($data['user_id'], $data['error_assign_user'], $data['user_status']);
      echo "<td class='".$rowcolor."'>".($data['error_assign_user'] == '' ? $locale['addondb411'] : $approver)."</td>
      <td class='".$rowcolor."'><a href='".FUSION_SELF.$aidlink."&action=2&error_id=".$data['error_id']."'>".$locale['addondb462']."</a></td>
      </tr>";
      $i++;
      }
  }
  echo"</table></div>";
  closetable();
require_once THEMES."templates/footer.php";
?>
