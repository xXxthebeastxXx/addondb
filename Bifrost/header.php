<?php

if (!defined("IN_FUSION")) { die("Access Denied"); }

function theme_head_output($output) {
	$search = array(
		"@<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>@si",
		"@<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>@si",
		"@<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />@si",
		"@<body>@si",
		"@<link rel='stylesheet' href='(.*?)themes/Bifrost/styles.css' type='text/css' media='screen' />\n@si",
		"@<link rel='shortcut icon' href='(.*?)images/favicon.ico' type='image/x-icon' />\n@si",
		"@<script type='text/javascript' src='(.*?)includes/jscript.js'></script>\n@si",
		"@<script type='text/javascript' src='(.*?)includes/jquery.js'></script>\n@si",
		"@<a id='content' name='content'></a>\n@si",
		"@<!--news_prepost_(.*?)-->\n@si"
	);
	$replace = array(
		'<!DOCTYPE html>',
		'<html lang="en">',
		'<meta charset="utf-8" />',
		'<!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <body class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body> <!--<![endif]-->',
		'',
		'',
		'',
		'',
		'',
		''
	);
	$output = preg_replace($search, $replace, $output);
	return $output;
}

function get_head_tags(){ ?>
<!--[if IE]><![endif]-->

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
<link rel="stylesheet" href="http://phpfusion.sytes.net/themes/Bifrost/styles.css?v=1" />
<script defer src="<?php echo static_content(); ?>js/modernizr-1.5.min.js"></script>
<?php
}