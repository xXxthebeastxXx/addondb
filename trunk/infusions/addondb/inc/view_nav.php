<?php
include ADDON_LOCALE.LOCALESET."view_nav.php";

		 $nav_bullet = "&nbsp;<img src='".ADDON_IMG."nav_bullet.png' alt='' />&nbsp;";
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='tbl-border'>\n<tr>\n
	      <td class='tbl2' align='center'>".$nav_bullet."<a href='".ADDON."index.php' title ='".$locale['addondbv100']."'>".$locale['addondbv100']."</a>".$nav_bullet."
	      <a href='".ADDON."index.php?type=1&version=0&orderby=addon_name&sort=ASC' title ='".$locale['addondbv101']."'>".$locale['addondbv101']."</a>".$nav_bullet."
	      <a href='".ADDON."index.php?type=2&version=&orderby=addon_name&sort=ASC' title ='".$locale['addondbv102']."'>".$locale['addondbv102']."</a>".$nav_bullet."
	      <a href='".ADDON."index.php?type=3&version=0&orderby=addon_name&sort=ASC' title ='".$locale['addondbv103']."'>".$locale['addondbv103']."</a>".$nav_bullet."
	      <a href='".ADDON."index.php?type=4&version=&orderby=addon_name&sort=ASC' title ='".$locale['addondbv104']."'>".$locale['addondbv104']."</a>".$nav_bullet;
	      if (iMEMBER) {
	      echo "<a href='".ADDON."dashboard.php' title ='".$locale['addondbv105']."'>".$locale['addondbv105']."</a>".$nav_bullet; 
	      echo "<a href='".ADDON."submit_addon.php' title ='".$locale['addondbv106']."'>".$locale['addondbv106']."</a>".$nav_bullet;}
	      echo "</td>
	      </tr>\n</table>\n";
?>