<?php

     echo "<table width='100%' class='tbl-border'>\n<tr>\n";
     echo "<th class='forum-caption' colspan='4'>".$locale['pla_100']."</th>\n";
     echo "</tr>\n<tr>\n";
     if (FUSION_SELF != "licenses.php") {
     echo "<td class='tbl1'><a class='button' href='".INFUSIONS."license_admin/licenses.php'><span>".$locale['pla_002']."</span></a></td>\n"; $colspan='1'; } 
     else { $colspan='2'; }
     echo "<td class='tbl1' colspan='".$colspan."'></td>\n";
     if (FUSION_SELF != "license_apply.php") {
     echo "<td class='tbl1' align='right'><a class='button' href='".INFUSIONS."license_admin/license_apply.php'><span>".$locale['pla_003']."</span></a></td>\n"; }
     else { echo "<td class='tbl1'>&nbsp;</td>\n"; }
     echo "</tr>\n<tr>\n";
     if (FUSION_SELF != "crl.php") {
     echo "<td class='tbl1' width='33%' align='center'><a class='button' title='".$locale['pla_106']."' href='".INFUSIONS."license_admin/crl.php'><span>".$locale['pla_102']."</span></a></td>\n"; }
     else { echo "<td class='tbl1' width='33%' align='center'><b>".$locale['pla_102']."</b></td>\n"; }
     if (FUSION_SELF != "ccl.php") {
     echo "<td class='tbl1' width='33%' align='center'><a class='button' title='".$locale['pla_107']."' href='".INFUSIONS."license_admin/ccl.php'><span>".$locale['pla_103']."</span></a></td>\n"; }
     else { echo "<td class='tbl1' width='33%' align='center'><b>".$locale['pla_103']."</b></td>\n"; }
     if (FUSION_SELF != "epal.php") {
     echo "<td class='tbl1' width='33%' align='center'><a class='button' title='".$locale['pla_108']."' href='".INFUSIONS."license_admin/epal.php'><span>".$locale['pla_104']."</span></a></td>\n"; }
     else { echo "<td class='tbl1' width='33%' align='center'><b>".$locale['pla_104']."</b></td>\n"; }
     echo "</tr>\n</table>\n";

?>