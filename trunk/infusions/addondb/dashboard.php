<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: my_addons.php
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

require_once INFUSIONS."addondb/infusion_db.php";
require_once INFUSIONS."addondb/inc/inc.functions.php";

include ADDON_LOCALE.LOCALESET."addon_view.php";
add_to_title ($locale['addondb517'].$locale['addondb_600'].$locale['addondb517'].$locale['addondb_608']);

if (!iMEMBER) { redirect(BASEDIR."index.php"); }

      $result=dbquery("SELECT 
                              addon_id, 
                              addon_name, 
                              addon_version, 
                              addon_download_count, 
                              addon_approved_rating FROM ".DB_ADDONS." 
                              WHERE addon_status = '0' 
                              AND addon_submitter_name = '".$userdata['user_name']."' 
                              ORDER BY addon_download_count DESC
                              ");

  if(dbrows($result) != 0) {
  
opentable($locale['addondb_600']);

     echo "<table width='100%' class='tbl-border' cellpadding='0' cellspacing='0'>\n<tr>\n";
     echo "<th class='forum-caption'>".$locale['addondb_602']."</th>";
     echo "<th class='forum-caption' align='center'>".$locale['addondb_603']."</th>";
     echo "<th class='forum-caption' align='center'>".$locale['addondb_601']."</th>";
     echo "<th class='forum-caption'>".$locale['addondb_604']."</th>";
     
     echo "</tr>\n";
	
	    while($data = dbarray($result)) {
		  echo "<tr>\n<td class='tbl1'>";
		  echo "<a href='".ADDON."view.php?addon_id=$data[addon_id]' class='side' title='".$data['addon_name']."'>".trimlink($data['addon_name'], 22)."</a></td>\n";
		  echo "<td class='tbl1' align='center'>".$data['addon_version']."</td>";
		  echo "<td class='tbl1' align='center'>".$data['addon_download_count']."</td>";
		  $staff_rating = str_repeat("<img src='".ADDON_IMG."star.png' alt='".$locale['addondb_604']."' />",$data['addon_approved_rating']);
		  echo "<td class='tbl1'>".$staff_rating."</td>";
		  echo "</tr>\n";
		  }
		  echo "<tr>\n";

		  $total = dbarray(dbquery("SELECT SUM(addon_download_count) download_count, COUNT(addon_ID) FROM ".DB_ADDONS." WHERE addon_submitter_name='".$userdata['user_name']."'"));
		  $total_count = $total['download_count'];
		  
		  echo "<td class='tbl1' align='right' colspan='4'>".$locale['addondb_605']." ".number_format(dbcount("(addon_id)", DB_ADDONS, "addon_author_name='".$userdata['user_name']."'"))." ".$locale['addondb_606']." ".$total_count." ".$locale['addondb_607']."</td>\n";
	echo "</tr>\n</table>\n"; 

closetable();

	    } else { 
	    opentable($locale['addondb_600']);
	    echo "<br />";
	    echo "<div align='center'>".$locale['addondb_700']."<br />\n";
	    echo "<br /><a href='".ADDON."index.php' class='side'>".$locale['addondb514']."</a><br /><br /><a href='".ADDON."submit_addon.php' class='side'>".$locale['addondb515']."</a><br /></div>\n";
	    echo "<br />";
	    closetable();
	  }
                     $db_check = dbarray(dbquery("SELECT 
				                                         a.assign_id, 
				                                         a.assign_addon, 
				                                         a.assign_user, 
				                                         u.user_id, 
				                                         u.user_name, 
				                                         u.user_status 
				                                         FROM ".DB_ADDON_ASSIGN." a
				                                         LEFT JOIN ".DB_USERS." u 
				                                         ON a.assign_user=u.user_id 
				                                         WHERE a.assign_author = '".$userdata['user_id']."'
				                                         "));

           $total_subs = dbcount("(submit_id)", DB_SUBMISSIONS, "submit_user = '".$userdata['user_id']."'");
           $total_appr = dbcount("(assign_id)", DB_ADDON_ASSIGN, "assign_author = '".$userdata['user_id']."'");
           $total_rev = ($total_subs - $total_appr);

          opentable($locale['addondb_608']);
 
       echo "<table width='100%' class='tbl-border' cellpadding='0' cellspacing='0'>\n<tr>\n";
       echo "<th class='forum-caption' colspan='2'>".$locale['addondb_609']."</th>\n";
       echo "</tr>\n<tr>\n";
       echo "<td class='tbl1' align='right' width='50%'>".$locale['addondb_610']."</td><td class='tbl1'>".( $total_rev == '' ? $locale['addondb_614'] : $total_rev)."</td>\n";
       echo "</tr>\n<tr>\n";
       echo "<td class='tbl1' align='right' width='50%'>".$locale['addondb_611']."</td><td class='tbl1'>".( $total_appr == '' ? $locale['addondb_614'] : $total_appr)."</td>\n";
       echo "</tr>\n<tr>\n";
       echo "<td class='tbl1' align='right' width='50%'>".$locale['addondb_612']."</td><td class='tbl1'>";
       if (isset($db_check['assign_id'])) { echo profile_link($db_check['assign_user'], $db_check['user_name'], $db_check['user_status']); } else { echo "---"; }
       echo "</td>\n";
       echo "</tr>\n</table>\n";
closetable();
		
		

require_once THEMES."templates/footer.php";
?>