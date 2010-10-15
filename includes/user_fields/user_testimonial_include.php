<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: user_testimonial_include.php
| Author: PHP-Fusion Addons Team
| maxlength function by kneekoo
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

if ($profile_method == "input") {
	require_once INCLUDES."bbcode_include.php";
	
add_to_head("<style type='text/css'>
.countx {
	color: red;
}
.exceed{
	padding: 2px;
	background-color: #ffefef;
	color: #400;
	width: 295px;
	border: 1px solid #faa;
}
</style>");
	
	echo "<tr>\n";
	echo "<td valign='top' class='tbl'>".$locale['uf_testimonial']."</td>\n";
	echo "<td class='tbl'>
	<div class='small'>".$locale['uf_testimonial_002']."<strong>120</strong></div>
    <div class='small'>".$locale['uf_testimonial_003']."<strong id='counter'>0</strong></div>
	<textarea id='testim' name='user_testimonial' onkeyup='maxlength(120);' onfocus='maxlength(120);' cols='60' rows='3' style='width:295px'>".(isset($user_data['user_testimonial']) ? $user_data['user_testimonial'] : "")."</textarea>
	<div id='exceed' style='display: none' class='exceed'>".$locale['uf_testimonial_004']."</div>\n";
	echo display_bbcodes("300px", "user_testimonial", "inputform", "smiley|b|i|u||center|small|color")."</td>\n";
	echo "</tr>\n";
} elseif ($profile_method == "display") {
	// Not shown in profile
} elseif ($profile_method == "validate_insert") {

	$db_fields .= ", user_testimonial";
	$db_values .= ", '".(isset($_POST['user_testimonial']) ? stripinput(trim(censorwords($_POST['user_testimonial']))) : "")."'";
} elseif ($profile_method == "validate_update") {
	$db_values .= ", user_testimonial='".(isset($_POST['user_testimonial']) ? stripinput(trim($_POST['user_testimonial'])) : "")."'";
}
?>

<script type='text/javascript'>

function maxlength(input) {
	var length = parseInt(input);
	if (length) {
		tmplen = document.inputform.testim.value.length;
		document.getElementById("counter").innerHTML = tmplen;
		if (length < tmplen) {
			if (document.layers) {
				document.layers["counter"].className = 'countx';
				document.layers["exceed"].style.display = 'block';
			}
			else if (document.all) {
				document.all["counter"].className = 'countx';
				document.all["exceed"].style.display = 'block';
			}
			else if (document.getElementById) {
				parent.document.getElementById("counter").className = 'countx';
				parent.document.getElementById("exceed").style.display = 'block';
			}
		} else {
			if (document.layers) {
				document.layers["counter"].className = '';
				document.layers["exceed"].style.display = 'none';
			}
			else if (document.all) {
				document.all["counter"].className = '';
				document.all["exceed"].style.display = 'none';
			}
			else if (document.getElementById) {
				parent.document.getElementById("counter").className = '';
				parent.document.getElementById("exceed").style.display = 'none';
			}
		}
	}
}

</script>