<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: user_approve_include.php
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
if (!defined("IN_FUSION")) { die("Access Denied"); }

if ($profile_method == "display") {
	if (iADMIN && checkrights("M") && $user_data['user_testimonial']) {
		echo "<tr>\n";
		echo "<td width='1%' class='tbl1' style='white-space:nowrap'>".$locale['uf_approve']."</td>\n";
		$aa = "<a class='button' href='".INFUSIONS."testimonials_admin/testimonials_admin.php".$aidlink."'><span>".$locale['uf_approve_002']."</span></a>";
		echo "<td align='right' class='tbl1'>".($user_data['user_approve'] == 1 ? $aa : $locale['uf_approve_001'])."</td>\n";
		echo "<tr>\n<td class='quote' colspan='2'>".$user_data['user_testimonial']."</td>\n";
		echo "</tr>\n";
} elseif ($profile_method == "validate_insert") {
	$db_fields .= ", user_approve";
	$db_values .= ", '".(isset($_POST['user_approve']) ? stripinput(trim($_POST['user_approve'])) : "")."'";
} elseif ($profile_method == "validate_update") {
	$db_values .= ", user_approve='".(isset($_POST['user_approve']) ? stripinput(trim($_POST['user_approve'])) : "")."'";
  }
}
?>