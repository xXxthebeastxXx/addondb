<?php
/*---------------------------------------------------+
| PHP-Fusion 7 Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+----------------------------------------------------+
| admin_attention.php
| Author: PHP-Fusion Addons Team
+----------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+----------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

if (file_exists(INFUSIONS."admin_attention_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."admin_attention_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."admin_attention_panel/locale/English.php";
}
require_once INFUSIONS."addondb/infusion_db.php";

    $submission = dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type !='m'");
      $addonsub = dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='m'");
    $addontrans = dbcount("(trans_id)", DB_ADDON_TRANS, "trans_active='1'");
      $devapply = dbcount("(apply_id)", DB_ADDON_DEV_APPLY);
   $testimonial = dbcount("(user_id)", DB_USERS, "user_testimonial !='' && user_approve = '1'");
$support_thread = dbcount("(addon_id)", DB_ADDONS, "addon_forum_status='0'");
   $addon_error = dbcount("(error_id)", DB_ADDON_ERRORS, "error_active='1'");
         $total = ($submission + $addonsub + $addontrans + $devapply + $testimonial + $support_thread + $addon_error);

if (iADMIN && ($total != 0)) {
openside($locale['att_101']);

    if ($submission > '1') { $plural1 = $locale['att_102'].$locale['att_108']; } else { $plural1 = $locale['att_102']; }
      if ($addonsub > '1' || $addontrans > '1') { $plural2 = $locale['att_103'].$locale['att_108']; } else { $plural2 = $locale['att_103']; }
      if ($devapply > '1') { $plural3 = $locale['att_104'].$locale['att_108']; } else { $plural3 = $locale['att_104']; }
   if ($testimonial > '1') { $plural4 = $locale['att_105'].$locale['att_108']; } else { $plural4 = $locale['att_105']; }
if ($support_thread > '1') { $plural5 = $locale['att_106'].$locale['att_108']; } else { $plural5 = $locale['att_106']; }
   if ($addon_error > '1') { $plural6 = $locale['att_107'].$locale['att_108']; } else { $plural6 = $locale['att_107']; }

	if ($submission != 0 && checkrights("SU")) {
		echo "<a href='".ADMIN."submissions.php".$aidlink."' class='side'>".sprintf($plural1, $submission)."</a><br />";
	}
	if (($addonsub != 0 || $addontrans != 0) && checkrights("ADNX")) {
		echo "<a href='".INFUSIONS."addondb/admin/submissions.php".$aidlink."' class='side'>".sprintf($plural2, $addonsub+$addontrans)."</a><br />";
	}
	if ($devapply != 0 && checkrights("ADNX")) {
		echo "<a href='".INFUSIONS."addondb/admin/dev_applications.php".$aidlink."' class='side'>".sprintf($plural3, $devapply)."</a><br />";
	}
    if ($testimonial != 0 && checkrights("M")) {
		echo "<a href='".INFUSIONS."testimonials_admin/testimonials_admin.php".$aidlink."' class='side'>".sprintf($plural4, $testimonial)."</a><br />";
	}
	if (($support_thread != 0) && checkrights("ADNX")) {
		echo "<a href='".INFUSIONS."addondb/admin/support_thread.php".$aidlink."' class='side'>".sprintf($plural5, $support_thread)."</a><br />";
	}
	if (($support_thread != 0) && checkrights("ADNX")) {
		echo "<a href='".INFUSIONS."addondb/admin/error.php".$aidlink."' class='side'>".sprintf($plural6, $addon_error)."</a><br />";
	}

closeside();
   }
?>