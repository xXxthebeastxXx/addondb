<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: edoc_nav.php
| Aduthor: Philip Daly (HobbyMan)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/

echo "<table border='0' cellspacing='3' cellpadding='3' width='100%'>\n<tr>\n";
    echo "<td valign='top' align='center' width='1%' class='small'><a href='".BASEDIR."downloads.php?cat_id=23' title='".$locale['edoc209']."'>".$img_main_dl."<br />".$locale['edoc209']."</a></td>\n";
    echo "<td valign='top' align='center' width='1%' class='small'><a href='".BASEDIR."downloads.php?cat_id=15' title='".$locale['edoc204']."'>".$img_handbook."<br />".$locale['edoc204']."</a></td>\n";
    echo "<td valign='top' align='center' width='1%' class='small'><a href='http://opensourcecms.com/index.php?option=com_content&amp;task=view&amp;id=464' title='".$locale['edoc205']."' target='_blank'>".$img_demo."<br />".$locale['edoc205']."</a></td>\n";
    echo "<td valign='top' align='center' width='1%' class='small'><a href='".EDOC."getting_started.php' title='".$locale['edoc207']."'>".$img_help."<br />".$locale['edoc207']."</a></td>\n";
    echo "<td valign='top' align='center' width='1%' class='small'><a href='".EDOC."requirements.php' title='".$locale['edoc206']."'>".$img_req."<br />".$locale['edoc206']."</a></td>\n";
    echo "<td valign='top' align='center' width='1%' class='small'><a href='".EDOC."locales.php' title='".$locale['edoc208']."'>".$img_locale."<br />".$locale['edoc208']."</a></td>\n";
  echo "</tr>\n</table>\n";
  echo "<div class='item' id='top'></div>\n";
  
?>