<?php
    
    if (iMEMBER) {
    if (file_exists(INFUSIONS."sf_staff_list/index.php")) {
    echo "<br />".$locale['msg030']."<br /><br />"; }
    echo "<form name='select' method='post' action='submit.php'>\n";
    echo "<br /><table cellpadding='0' cellspacing='1' width='80%' class='center tbl-border' align='center'><tr>";
    echo "<td class='tbl1'>".$locale['msg103']."</td>";
    echo "<td class='tbl1' nowrap valign='top'>";
  
    	    $addon_type_list = "";
			foreach ($addon_types as $k=>$addon_type) {
				$addon_type_list .= "<option value='$addon_type'>".$addon_type."</option>\n";
			}
				 
	echo "<select class='textbox' name='addon_type' style='width:300px;' onChange='submit()'>\n<option value='0'>".$locale['msg104']."</option>".$addon_type_list."</select>\n</td>\n";
	echo "</tr><tr>\n";
	echo "<td colspan='2' align='center'><br /><label for='agreement'>".$locale['msg032']."</label>\n";
	echo "<input type='checkbox' id='agreement' name='agreement' value='1' onclick='checkagreement()' /></td>\n";
	echo "</tr>\n</table>\n";
	echo "</form>\n";
	
    } else { 
    
    echo "<br /><span class='small'>".$locale['msg101']."</span>\n";
  
  }
    
	echo "<script language='JavaScript' type='text/javascript'>
			function checkagreement() {
				if(document.inputform.agreement.checked) {
					document.inputform.addon_type.disabled=false;
				} else {
					document.inputform.addon_type.disabled=true;
				}
			}
		</script>";

?>