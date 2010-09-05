<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: error.php
| Author: Luben Kirov (Sharky)
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

if (!checkrights("MODS") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { die("Access Denied"); }

require_once INFUSIONS."moddb/infusion_db.php";
require_once INFUSIONS."moddb/inc/inc.functions.php";
require_once INFUSIONS."moddb/inc/inc.nav.php";

if (file_exists(INFUSIONS."moddb/locale/".LOCALESET."submit_error.php")) {
	include INFUSIONS."moddb/locale/".LOCALESET."submit_error.php";
} else {
	include INFUSIONS."moddb/locale/English/submit_error.php";
}

function error_type($value){
  global $locale;
switch ($value) {

  case 1:
  return $locale['moddb420'];
  break;

  case 2:
  return $locale['moddb410'];
  break;

  case 3:
  return $locale['moddb400'];
  break;

}
}

if(isset($_GET['action']) && isnum($_GET['action']) && isset($_GET['error_id']) && isnum($_GET['error_id'])){

  if($_GET['action'] == 1){
  $result = dbquery("UPDATE ".DB_MOD_ERRORS." SET error_active='0' WHERE error_id='".$_GET['error_id']."'");
  }
  
  if($_GET['action'] == 2){
  $result = dbquery("DELETE FROM ".DB_MOD_ERRORS." WHERE error_id='".$_GET['error_id']."'");
  }

  if($_GET['action'] == 3){
  $result = dbquery("UPDATE ".DB_MOD_ERRORS." SET error_assign_user='".$userdata['user_name']."' WHERE error_id='".$_GET['error_id']."'");
  }
}

$result = dbquery("SELECT * FROM ".DB_MOD_ERRORS." WHERE error_active ='1'");
  opentable($locale['moddb463']);
  echo"<div align='center'><table width='80%'><tr><td>".$locale['moddb464']."</td><td>".$locale['moddb465']."</td><td>".$locale['moddb468']."</td><td>".$locale['moddb466']."</td><td>".$locale['moddb469']."</td><td>".$locale['moddb467']."</td></tr>";
  if (dbrows($result)) {
  
			while ($data = dbarray($result)) {
      echo "<tr>
      <td><a href='".BASEDIR."infusions/moddb/view.php?mod_id=".$data['error_mod']."' target='_blank'>Mod: ".$data['error_mod']."</a></td><td>".error_type($data['error_type'])."</td><td><a href='".BASEDIR."profile.php?lookup=".$data['error_user']."' target='_blank'>".$data['error_user']."</a></td><td>".$data['error_report']."</td><td>".$data['error_assign_user']."</td><td><a href='".FUSION_SELF.$aidlink."&action=3&error_id=".$data['error_id']."'>".$locale['moddb459']."</a> | <a href='".FUSION_SELF.$aidlink."&action=1&error_id=".$data['error_id']."'>".$locale['moddb460']."</a></td>
      </tr>";
      }
  }
  echo"</table></div>";
  closetable();
  
 $result = dbquery("SELECT * FROM ".DB_MOD_ERRORS." WHERE error_active ='0'");
  opentable($locale['moddb461']);
  echo"<div align='center'><table width='80%'><tr><td>".$locale['moddb464']."</td><td>".$locale['moddb465']."</td><td>".$locale['moddb468']."</td><td>".$locale['moddb466']."</td><td>".$locale['moddb469']."</td><td>".$locale['moddb467']."</td></tr>";
  if (dbrows($result)) {
  
			while ($data = dbarray($result)) {
      echo "<tr>
      <td><a href='".BASEDIR."infusions/moddb/view.php?mod_id=".$data['error_mod']."' target='_blank'>Mod: ".$data['error_mod']."</a></td><td>".error_type($data['error_type'])."</td><td><a href='".BASEDIR."profile.php?lookup=".$data['error_user']."' target='_blank'>".$data['error_user']."</a></td><td>".$data['error_report']."</td><td>".$data['error_assign_user']."</td><td><a href='".FUSION_SELF.$aidlink."&action=2&error_id=".$data['error_id']."'>".$locale['moddb462']."</a></td>
      </tr>";
      }
  }
  echo"</table></div>";
  closetable();
require_once THEMES."templates/footer.php";
?>
