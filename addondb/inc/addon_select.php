<?php 

include ADDON_INC."check.js";
    
    if (iMEMBER) {
    echo "<br />".$locale['msg030']."<br /><br />";
    echo "<label for='coauthor'>".$locale['msg032']."</label><input id='checkcoauth' type='checkbox' />";
    echo "<div id='showcoauth'><label><br />";
    echo "<form name='select' method='post' action='submit.php'>\n";
    echo "<br /><table cellpadding='0' cellspacing='1' width='80%' class='center tbl-border' align='center'><tr>";
    echo "<td class='tbl1'>".$locale['msg103']."</td>";
    echo "<td class='tbl1' nowrap valign='top'>";
  
    	    $addon_type_list = "";
			foreach ($addon_types as $k=>$addon_type) {
				$addon_type_list .= "<option value='$addon_type'>".$addon_type."</option>\n";
			}
				 
	echo "<select class='textbox' name='addon_type' style='width:300px;' onChange='submit()'><option value='0'>".$locale['msg104']."</option>".$addon_type_list."</select>\n</td>\n";
	echo "</tr>\n</table>\n";
	echo "</form>\n</div>\n";
	
    } else { echo "<br /><span class='small'>".$locale['msg101']."</span>\n"; }
    
?>