<?php

if (FUSION_SELF == "submit_addon.php") { $formaction = "guidelines.php"; } else { $formaction = "submit.php"; }
    
    if (iMEMBER && $settings_global['set_addondb_sub'] == '0') {
    echo "<form name='select' method='post' action='".$formaction."'>\n";
    echo "<br /><table cellpadding='0' cellspacing='1' width='80%' class='center tbl-border' align='center'><tr>";
    echo "<td class='tbl1' rowspan='2'><a href='".ADDON."index.php' title=''><img src='".ADDON_IMG."addon_logo.png' width='200' align='left' alt ='' /></a></td>\n";
    echo "<td class='tbl1'>".$locale['addondb426']."</td>";
    echo "</tr>\n<tr>\n";
    echo "<td class='tbl1' nowrap valign='top'>";
  
    	    $addon_type_list = "";
			foreach ($addon_types as $k=>$addon_type) {
				$addon_type_list .= "<option value='$addon_type'>".$addon_type."</option>\n";
			}
				 
	echo "<select class='textbox' name='addon_type' style='width:300px;' onChange='submit()'>\n<option value='0'>".$locale['addondb427']."</option>".$addon_type_list."</select>\n</td>\n";
	echo "</tr>\n</table>\n";
	echo "</form>\n";
	
    } elseif (iMEMBER && $settings_global['set_addondb_sub'] == '1') {
    
    echo "<br /><span class='small'>".$locale['addondb428']."</span>\n";
    
    } else { 
    
    echo "<br /><span class='small'>".$locale['addondb429']."</span>\n";
  
     }

?>