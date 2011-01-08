<?php
include ADDON_LOCALE.LOCALESET."view_nav.php";

		 $nav_bullet = "&nbsp;<img src='".ADDON_IMG."nav_bullet.png' alt='' />&nbsp;";
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>\n<tr>\n
	      <td class='tbl2' align='center'>".$nav_bullet."
	      <a class='button' href='".ADDON."index.php' title ='".$locale['addondbv100']."'><span>".$locale['addondbv100']."</span></a>".$nav_bullet."
	      <a class='button' href='".ADDON."index.php?type=1&version=0&orderby=addon_name&sort=ASC' title ='".$locale['addondbv101']."'><span>".$locale['addondbv101']."</span></a>".$nav_bullet."
	      <a class='button' href='".ADDON."index.php?type=2&version=&orderby=addon_name&sort=ASC' title ='".$locale['addondbv102']."'><span>".$locale['addondbv102']."</span></a>".$nav_bullet."
	      <a class='button' href='".ADDON."index.php?type=3&version=0&orderby=addon_name&sort=ASC' title ='".$locale['addondbv103']."'><span>".$locale['addondbv103']."</span></a>".$nav_bullet."
	      <a class='button' href='".ADDON."index.php?type=4&version=&orderby=addon_name&sort=ASC' title ='".$locale['addondbv104']."'><span>".$locale['addondbv104']."</span></a>".$nav_bullet;
	      if (iMEMBER) {
	      echo "<a class='button' href='".ADDON."dashboard.php' title ='".$locale['addondbv105']."'><span>".$locale['addondbv105']."</span></a>".$nav_bullet; 
	      echo "<a class='button' href='".ADDON."submit_addon.php' title ='".$locale['addondbv106']."'><span>".$locale['addondbv106']."</span></a>".$nav_bullet;}
	      echo "</td>
	      </tr>\n</table>\n";
?>