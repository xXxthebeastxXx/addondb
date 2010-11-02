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

if (!function_exists("add_to_head")) {
function add_to_head($tag=""){
	global $fusion_page_head_tags;
	if(!stristr($fusion_page_head_tags, $tag)){
		$fusion_page_head_tags .= $tag."\n";
	}
  }
}

if (preg_match("/\/forum\//i", FUSION_REQUEST)) global $data;

add_to_head('<link type="text/css" rel="stylesheet" href="'.INCLUDES.'bbcodes/syntaxhighlighter/styles/shCoreDefault.css" />
<script type="text/javascript" src="'.INCLUDES.'bbcodes/syntaxhighlighter/scripts/shCore.js"></script>
<script type="text/javascript" src="'.INCLUDES.'bbcodes/syntaxhighlighter/scripts/shBrushJScript.js"></script>
<script type="text/javascript" src="'.INCLUDES.'bbcodes/syntaxhighlighter/scripts/shBrushPhp.js"></script>
<script type="text/javascript" src="'.INCLUDES.'bbcodes/syntaxhighlighter/scripts/shBrushCss.js"></script>
<script type="text/javascript" src="'.INCLUDES.'bbcodes/syntaxhighlighter/scripts/shBrushXml.js"></script>
<script type="text/javascript" src="'.INCLUDES.'bbcodes/syntaxhighlighter/scripts/shBrushSql.js"></script>
<script type="text/javascript" src="'.INCLUDES.'bbcodes/syntaxhighlighter/scripts/shBrushPlain.js"></script>
<script type="text/javascript">
SyntaxHighlighter.config.stripBrs = true;
SyntaxHighlighter.defaults["toolbar"] = true;
SyntaxHighlighter.all();
</script>');
preg_match_all("#\[syntaxhighlighter brush=(.*?)\](.*?)\[/syntaxhighlighter\]#si",$text,$matches,PREG_PATTERN_ORDER);
for($i=0; $i<count($matches[1]); $i++) {
	$text = preg_replace("#\[syntaxhighlighter brush=(.*?),first-line=(.*?),highlight=(.*?),collapse=(.*?),html-script=(.*?)\](.*?)\[/syntaxhighlighter\]#si", "<pre class='brush:$1;first-line:$2;highlight:$3;collapse:$4;html-script:$5;'>$6</pre>", $text, 1);
}
preg_match_all("#\[geshi=(.*?)\](.*?)\[/geshi\]#si",$text,$matches,PREG_PATTERN_ORDER);
for($i=0; $i<count($matches[1]); $i++) {
	$text = preg_replace("#\[geshi=(.*?)\](.*?)\[/geshi\]#si", "<pre class='brush:plain;first-line:1;highlight:0;collapse:false;html-script:false;'>$2</pre>", $text, 1);
}
$code_count = substr_count($text, "[code]");
for ($i=0; $i < $code_count; $i++) {
	$text = preg_replace("#\[code\](.*?)\[/code\]#si", "<pre class='brush:plain;first-line:1;highlight:0;collapse:false;html-script:false;'>$1</pre>", $text, 1);
}
?>