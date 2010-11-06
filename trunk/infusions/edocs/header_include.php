<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: header_include.php
| Author: Philip Daly (HobbyMan)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/

echo "<h1>".$locale['edoc100']."</h1><span style='float:right;'>".$img_help."</span>";
echo $locale['edoc101'];
echo $locale['edoc102'];
echo "<table border='0' width='50%' class='tbl-border' align='center' cellspacing='2' cellpadding='2'>\n";
  echo "<tr>\n";
    echo "<td align='left' valign='top'><b><a href='#cnt' id='".preg_replace("/ /", "_",$locale['ac01'])."'>".$locale['ac01']."</a></b><br />\n";
      echo "<ul>\n";
       echo "<li><a href='#l202x' id='".preg_replace("/ /", "_",$locale['202'])."'>".$locale['202']."</a></li>\n";
       echo "<li><a href='#l203x' id='".$locale['203']."'>".$locale['203']."</a></li>\n";
       echo "<li><a href='#l206x' id='".preg_replace("/ /", "_",$locale['206'])."'>".$locale['206']."</a></li>\n";
       echo "<li><a href='#l208x' id='".preg_replace("/ /", "_",$locale['208'])."'>".$locale['208']."</a></li>\n";
       echo "<li><a href='#l209x' id='".$locale['209']."'>".$locale['209']."</a></li>\n";
       echo "<li><a href='#l210x' id='".$locale['210']."'>".$locale['210']."</a></li>\n";
       echo "<li><a href='#l211y' id='".$locale['211']."'>".$locale['211']."</a></li>\n";
       echo "<li><a href='#l212x' id='".$locale['212']."'>".$locale['212']."</a></li>\n";
       echo "<li><a href='#l216y' id='".$locale['216']."'>".$locale['216']."</a></li>\n";
       echo "<li><a href='#l235x' id='".preg_replace("/ /", "_",$locale['235'])."'>".$locale['235']."</a></li>\n";
       echo "<li><a href='#l218x' id='".preg_replace("/ /", "_",$locale['218'])."'>".$locale['218']."</a></li>\n";
       echo "<li><a href='#l220x' id='".$locale['220']."'>".$locale['220']."</a></li>\n";
       echo "<li><a href='#l226x' id='".preg_replace("/ /", "_",$locale['226'])."'>".$locale['226']."</a></li>\n";
       echo "<li><a href='#l227x' id='".preg_replace("/ /", "_",$locale['227'])."'>".$locale['227']."</a></li>\n";
      echo "</ul>\n";
   echo "</td>\n";
   echo "<td align='left' valign='top'><b><a href='#usa' id='".preg_replace("/ /", "_",$locale['ac02'])."'>".$locale['ac02']."</a></b><br />\n";
     echo "<ul>\n";
       echo "<li><a href='#l201x' id='".$locale['201']."'>".$locale['201']."</a></li>\n";
       echo "<li><a href='#l204x' id='".$locale['204']."'>".$locale['204']."</a></li>\n";
       echo "<li><a href='#l239x' id='".preg_replace("/ /", "_",$locale['239'])."'>".$locale['239']."</a></li>\n";
       echo "<li><a href='#l215x' id='".$locale['215']."'>".$locale['215']."</a></li>\n";
       echo "<li><a href='#l221x' id='".$locale['221']."'>".$locale['221']."</a></li>\n";
       echo "<li><a href='#l223x' id='".$locale['223']."'>".$locale['223']."</a></li>\n";
       echo "<li><a href='#l240x' id='".preg_replace("/ /", "_",$locale['240'])."'>".$locale['240']."</a></li>\n";
       echo "<li><a href='#l238x' id='".preg_replace("/ /", "_",$locale['238'])."'>".$locale['238']."</a></li>\n";
       echo "<li><a href='#l225x' id='".preg_replace("/ /", "_",$locale['225'])."'>".$locale['225']."</a></li>\n";
     echo "</ul>\n";
   echo "</td>\n";
echo "</tr><tr>\n";
   echo "<td align='left' valign='top'><b><a href='#sys' id='".preg_replace("/ /", "_",$locale['ac03'])."'>".$locale['ac03']."</a></b><br />\n";
     echo "<ul>\n";
       echo "<li><a href='#l245x' id='".$locale['245']."'>".$locale['245']."</a></li>\n";
       echo "<li><a href='#l236x' id='".preg_replace("/ /", "_",$locale['236'])."'>".$locale['236']."</a></li>\n";
       echo "<li><a href='#l207x' id='".preg_replace("/ /", "_",$locale['207'])."'>".$locale['207']."</a></li>\n";
       echo "<li><a href='#l213x' id='".$locale['213']."'>".$locale['213']."</a></li>\n";
       echo "<li><a href='#l217x' id='".$locale['217']."'>".$locale['217']."</a></li>\n";
       echo "<li><a href='#l210x' id='".preg_replace("/ /", "_",$locale['219'])."'>".$locale['219']."</a></li>\n";
       echo "<li><a href='#l222x' id='".preg_replace("/ /", "_",$locale['222'])."'>".$locale['222']."</a></li>\n";
       echo "<li><a href='#l237x' id='".$locale['237']."'>".$locale['237']."</a></li>\n";
       echo "<li><a href='#l224x' id='".$locale['224']."'>".$locale['224']."</a></li>\n";
     echo "</ul>\n";
   echo "</td>\n";
   echo "<td align='left' valign='top'><b><a href='#sts' id='".preg_replace("/ /", "_",$locale['ac04'])."'>".$locale['ac04']."</a></b><br />\n";
     echo "<ul>\n";
        echo "<li><a href='#edoc008x' id='".preg_replace("/ /", "_",$locale['edoc008'])."'>".$locale['edoc008']."</a></li>\n";
        echo "<li><a href='#l211x' id='".preg_replace("/ /", "_",$locale['edoc007'])."'>".$locale['edoc007']."</a></li>\n";
        echo "<li><a href='#l244x' id='".preg_replace("/ /", "_",$locale['244'])."'>".$locale['244']."</a></li>\n";
        echo "<li><a href='#l228x' id='".$locale['228']."'>".$locale['228']."</a></li>\n";
        echo "<li><a href='#l233x' id='".$locale['233']."'>".$locale['233']."</a></li>\n";
        echo "<li><a href='#l216x' id='".preg_replace("/ /", "_",$locale['edoc009'])."'>".$locale['edoc009']."</a></li>\n";
        echo "<li><a href='#l232x' id='".preg_replace("/ /", "_",$locale['232'])."'>".$locale['232']."</a></li>\n";
        echo "<li><a href='#l234x' id='".preg_replace("/ /", "_",$locale['234'])."'>".$locale['234']."</a></li>\n";
        echo "<li><a href='#l231x' id='".$locale['231']."'>".$locale['231']."</a></li>\n";
        echo "<li><a href='#l246x' id='".$locale['246']."'>".$locale['246']."</a></li>\n";
        echo "<li><a href='#l229x' id='".preg_replace("/ /", "_",$locale['229'])."'>".$locale['229']."</a></li>\n";
        echo "<li><a href='#l247x' id='".preg_replace("/ /", "_",$locale['247'])."'>".$locale['247']."</a></li>\n";
     echo "</ul>\n";
   echo "</td>\n";
echo "</tr></table>\n";
echo "<h3>".strtoupper($locale['213'])."</h3>\n";
echo $locale['edoc103'];
?>