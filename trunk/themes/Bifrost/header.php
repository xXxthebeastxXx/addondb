<?php

if (!defined("IN_FUSION")) { die("Access Denied"); }

function theme_head_output($output) {
	$search = array(
		"@<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>@si",
		"@<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>@si",
		"@<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />@si",
		"@<link rel='stylesheet' href='(.*?)themes/Bifrost/styles.css' type='text/css' media='screen' />\n@si",
		"@<link rel='shortcut icon' href='(.*?)images/favicon.ico' type='image/x-icon' />\n@si",
		"@<script type='text/javascript' src='(.*?)includes/jquery.js'></script>\n@si",
		"@<body>@si",
		"@<a id='content' name='content'></a>\n@si",
		"@<!--news_prepost_(.*?)-->\n@si",
		"@><img src='reply' alt='(.*?)' style='border:0px' />@si",
		"@><img src='newthread' alt='(.*?)' style='border:0px;?' />@si",
		"@><img src='web' alt='(.*?)' style='border:0;vertical-align:middle' />@si",
		"@><img src='pm' alt='(.*?)' style='border:0;vertical-align:middle' />@si",
		"@><img src='quote' alt='(.*?)' style='border:0px;vertical-align:middle' />@si",
		"@><img src='forum_edit' alt='(.*?)' style='border:0px;vertical-align:middle' />@si",
		"@<input type='(submit|button)'(.*?)value='(.*?)'(.*?)/?>@si",
	);
	$page = str_replace(".php", "", FUSION_SELF);
	$replace = array(
		'<!doctype html>  ',
		'<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->',
		'<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />',
		'',
		'',
		'',
		'<body class="page-'.$page.'">',
		'',
		'',
		'class="forumbutton"><span>$1</span>',
		'class="forumbutton"><span>$1</span>',
		'class="forumbutton" rel="nofollow"><span>Web</span>',
		'class="forumbutton"><span>PM</span>',
		'class="forumbutton"><span>$1</span>',
		'class="forumbutton"><span>$1</span>',
		'<button type="$1"$2$4><span>$3</span></button>'
	);
	$output = preg_replace($search, $replace, $output);
	return $output;
}

function get_head_tags(){ ?>
<!--[if IE]><![endif]-->

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?php echo static_content(); ?>css/styles.css?v=1.2" />
<script defer src="<?php echo static_content(); ?>js/modernizr-1.6.min.js"></script>
<?php
}