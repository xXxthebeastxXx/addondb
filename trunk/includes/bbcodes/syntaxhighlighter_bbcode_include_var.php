<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: syntaxhighlighter_bbcode_include.php
| Author: Johan Wilson (Barspin)
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

if (!function_exists("generate_brush")) {
	function generate_brush($textarea_name, $inputform_name) {
	   $generated = "";
	   $brush = array("html", "php", "javascript", "css", "sql", "plain");
	   for ($i=0;$i<count($brush);$i++) {
	      $generated .= "<input type='button' value='".$brush[$i]."' class='button' style='width:100px' onclick=\"addText('".$textarea_name."', '[syntaxhighlighter brush=".$brush[$i].",first-line=1,highlight=0,collapse=false,html-script=false]', '[/syntaxhighlighter]', '".$inputform_name."');return false;\" /><br />";
	   }
	   return $generated;
	}
}

$__BBCODE__[] = 
array(
'description'		=>	"Code highlighter ",
'value'			=>	"syntaxhighlighter",
'bbcode_start'		=>	"[syntaxhighlighter options]",
'bbcode_end'		=>	"[/syntaxhighlighter]",
'usage'			=>	"[syntaxhighlighter options]Text code to highlight[/syntaxhighlighter]",
'onclick'		=>	"return overlay(this, 'syntaxhighlighter_".$textarea_name."', 'leftbottom');",
'html_start'		=>	"<div id='syntaxhighlighter_".$textarea_name."' class='tbl1 bbcode-popup' style='padding0; display: none; border:1px solid black; position: absolute; width: auto; height: auto; text-align: center' onclick=\"overlayclose('syntaxhighlighter_".$textarea_name."');\">",
'phpfunction'		=>	"echo generate_brush('".$textarea_name."', '".$inputform_name."');",
'html_end'		=>	"</div>"
);
?>