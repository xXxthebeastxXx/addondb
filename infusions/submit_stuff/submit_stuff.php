<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: submit_page.php
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

if (file_exists(INFUSIONS."submit_stuff/locale/".$settings['locale'].".php")) {
	include INFUSIONS."submit_stuff/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."submit_stuff/locale/English.php";
}

if (iMEMBER) {  
add_to_head("<script language='javascript' type='text/javascript'>
<!-- hide
function jumpto(x){
if (document.form1.jumpmenu.value != 'null') {
document.location.href = x
     }
   }
</script>
");  
    
opentable($locale['sub_001']);
    echo "<center><img src='".IMAGES."php-fusion-logo.png' width='200' alt ='Logo' /></center>\n";
    echo "<form name='form1'>\n";
    echo "<br /><table cellpadding='0' cellspacing='1' width='80%' class='tbl-border center'>\n<tr>\n";
    echo "<th class='tbl1' colspan='3'>".$locale['sub_002']."</th>\n";
    echo "</tr>\n<tr>\n";
    echo "<td class='tbl1'>&nbsp;</td>\n";
    echo "<td class='tbl1' align='right'>".$locale['sub_003']."</td>";
    echo "<td class='tbl1'>\n";
    echo "<select name='jumpmenu' class='textbox' onChange='jumpto(document.form1.jumpmenu.options[document.form1.jumpmenu.options.selectedIndex].value)'>\n";
    echo "<option value='".FUSION_SELF."'>".$locale['sub_004']."</option>\n";
    echo "<option value='".$settings['siteurl']."submit.php?stype=a'>".$locale['sub_005']."</option>\n";
    echo "<option value='".$settings['siteurl']."submit.php?stype=n'>".$locale['sub_006']."</option>\n";
    echo "<option value='".$settings['siteurl']."submit.php?stype=p'>".$locale['sub_007']."</option>\n";
    echo "<option value='".$settings['siteurl']."submit.php?stype=l'>".$locale['sub_008']."</option>\n";
    echo "<option value='".$settings['siteurl']."infusions/addondb/submit_addon.php'>".$locale['sub_009']."</option>\n";
    echo "</select>\n</td>\n";
	echo "</tr>\n</table>\n";
	echo "</form>\n";
		
closetable();
 }

require_once THEMES."templates/footer.php";
?>