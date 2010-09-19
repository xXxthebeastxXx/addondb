<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: submit_addon.php
| Author: PHP-Fusion Addons Team
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| addonify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

require_once INFUSIONS."addondb/inc/inc.functions.php";
require_once ADDON."infusion_db.php";
include ADDON_LOCALE.LOCALESET."submit_addon.php";
include ADDON_INC."check.js";
//add_to_head("<Body style='overflow:hidden'>");

$addon_sub_type = ($_REQUEST['addon_type']);

if (!iMEMBER) {
	opentable($locale['addondb600']);
	echo "<center><br />".$locale['addondb608']."<br /><br /></center>\n";
	closetable();
} elseif (isset($_POST['btn_submit'])) {
	$error = "";
	$addon_ext = "";
	$addon_ext_img = "";
	$upload_id = "";
	$submit_info['addon_name'] = stripinput($_POST['addon_name']);
	$submit_info['addon_cat_id'] = stripinput($_POST['addon_cat_id']);
	$submit_info['addon_cat_type'] = stripinput($_POST['addon_cat_type']);
	$submit_info['addon_status'] = 1;
	$submit_info['addon_description'] = stripinput($_POST['addon_description']);
	$submit_info['addon_copyright'] = stripinput($_POST['addon_copyright']);
	$submit_info['addon_version'] = stripinput($_POST['addon_version']);
	$submit_info['addon_version_id'] = stripinput($_POST['addon_version_id']);
	$submit_info['addon_submitter_name'] = stripinput($_POST['addon_submitter_name']);
	$submit_info['addon_submitter_id'] = stripinput($_POST['addon_submitter_id']);
	$submit_info['addon_forum_status'] = stripinput($_POST['addon_forum_status']);	
	$submit_info['addon_valid_css'] = isset($_POST['addon_valid_css']) ? "1" : "0";
	$submit_info['addon_valid_xhtml'] = isset($_POST['addon_valid_xhtml']) ? "1" : "0";
	$submit_info['addon_author_name'] = stripinput($_POST['addon_author_name']);
	$submit_info['addon_co_author_name'] = stripinput($_POST['addon_co_author_name']);
	$submit_info['addon_author_email'] = stripinput($_POST['addon_author_email']);
	$submit_info['addon_author_www'] = stripinput($_POST['addon_author_www']);
	$submit_info['addon_date'] = time();
	if ($submit_info['addon_name'] == "" || $submit_info['addon_description'] == "" || $submit_info['addon_version'] == "" || $submit_info['addon_author_name'] == "") {
		$error = $locale['addondb603'];
	} elseif ($submit_info['addon_author_email']<>"" && !preg_match("/^[-0-9A-Z_\.]+@([-0-9A-Z_\.]+\.)+([0-9A-Z]){2,4}$/i", $submit_info['addon_author_email'])) {
		$error = $locale['addondb607'];
	} else {
		$sql = dbquery("INSERT INTO ".DB_SUBMISSIONS." VALUES('', 'm', '".$userdata['user_id']."', '".time()."', '".addslashes(serialize($submit_info))."')");
		$upload_id = dbinsert_id();
		if (is_uploaded_file($_FILES['addon_download']['tmp_name'])) {
			if ($_FILES['addon_download']['size'] > $addon_upload_maxsize) {
				$error = sprintf($locale['addondb604'], $addon_upload_maxsize);
			}
			foreach (array_keys($addon_upload_exts) as $addon_upload_ext) {
				if (stristr($_FILES['addon_download']['name'], $addon_upload_ext) == $addon_upload_ext) $addon_ext = $addon_upload_ext;
			}
			if ($addon_ext != "") {
				$addon_ext = ".".$addon_ext;
			} else {
				$error = sprintf($locale['addondb605'],implode(", ",array_keys($addon_upload_exts)));
			}
						
			if ($error == "") {
			
        		if (is_uploaded_file($_FILES['addon_screen']['tmp_name'])) {
                if ($_FILES['addon_screen']['size'] > $addon_upload_maxsize_img) {
                  $error = sprintf($locale['addondb609'], $addon_upload_maxsize_img);
                }
                foreach (array_keys($addon_upload_exts_img) as $addon_upload_ext_img) {
                  if (stristr($_FILES['addon_screen']['name'], $addon_upload_ext_img) == $addon_upload_ext_img) $addon_ext_img = $addon_upload_ext_img;
                }
                if ($addon_ext_img != "") {
                  $addon_ext_img = ".".$addon_ext_img;
                } else {
                  $error = sprintf($locale['addondb610'],implode(", ",array_keys($addon_upload_exts_img)));
                  }
                }
			
             if ($error == "") {
                move_uploaded_file($_FILES['addon_download']['tmp_name'], $addon_upload_dir.$addon_upload_prefix.$upload_id.$addon_ext);
               
                $submit_info['addon_download'] = $addon_upload_prefix.$upload_id.$addon_ext;
                                
                if (is_uploaded_file($_FILES['addon_screen']['tmp_name'])) {
                    move_uploaded_file($_FILES['addon_screen']['tmp_name'], $addon_upload_dir_img.$upload_id.$addon_ext_img);
                    
                    $submit_info['addon_screen'] = $upload_id.$addon_ext_img;
                    
                    require_once INCLUDES."photo_functions_include.php";
                    $fileext = $addon_ext_img;
                    if ($fileext == ".gif") { $filetype = 1;
                     } elseif ($fileext == ".jpg") { $filetype = 2;
                     } elseif ($fileext == ".png") { $filetype = 3;
                     } else { $filetype = false; }
                    createthumbnail($filetype , $addon_upload_dir_img.$upload_id.$addon_ext_img, $addon_upload_dir_img."t_".$upload_id.$addon_ext_img, 200, 150);
                 
                } elseif ($addon_sub_type == $locale['addondb425']) { $error = $locale['addondb614']; } else {
                    $submit_info['addon_screen'] = "";
                  }
                $sql = dbquery("UPDATE ".DB_SUBMISSIONS." SET submit_criteria='".addslashes(serialize($submit_info))."' WHERE submit_id='".$upload_id."'");
              }
           }
	     } else { $error = $locale['addondb606'];
	   }
    }
	if ($error != "") {
		opentable($locale['addondb600']);
		if (isNum($upload_id)) {
			if (file_exists($addon_upload_dir.$addon_upload_prefix.$upload_id.$addon_ext)) unlink($addon_upload_dir.$addon_upload_prefix.$upload_id.$addon_ext);
			$rm = dbquery("DELETE FROM ".DB_SUBMISSIONS." WHERE submit_id='".$upload_id."'");
		}
		echo "<center><br />".$locale['addondb601']."<br /><br />
		<span class='error'>".$error."</span><br /><br />
		<a href='javascript:history.back(-1);'>".$locale['addondb602']."</a><br /><br /></center>\n";
		closetable();
	} else {
		opentable($locale['addondb400'].$addon_sub_type);
		echo "<center><br />
		".$locale['addondb500']."<br /><br />
		".$locale['addondb501']."<br /><br />
		".$locale['addondb502'];
		echo "<form name='select' method='post' action='".FUSION_SELF."'>\n";
    	    $addon_type_list = "";
			foreach ($addon_types as $k=>$addon_type) {
				$addon_type_list .= "<option value='$addon_type'>".$addon_type."</option>\n";
			}
		echo "<select class='textbox' name='addon_type' style='width:300px;' onChange='submit()'><option value='0'>".$locale['addondb427']."</option>".$addon_type_list."</select>\n";
		echo "</form>\n";
		echo "<br /><br /><a href='".BASEDIR."index.php'>".$locale['addondb503']."</a><br />";
		echo "<br /><a href='".ADDON."index.php'>".$locale['addondb505']."</a><br />
		<br />".(iADMIN ? "<a href='".ADDON_ADMIN."submissions.php".$aidlink."'>".$locale['addondb504']."</a><br /><br />" : "")."
		</center>\n";
		closetable();
	}
} else {

add_to_title($locale['addondb424'].$locale['addondb400'].$addon_sub_type.$locale['addondb420']);
	opentable($locale['addondb400'].$addon_sub_type.$locale['addondb420']);
	$addon_type_list = ""; $cat_list = ""; $opt = "";
	
	foreach ($addon_types as $k=>$addon_type) $addon_type_list .= "<option value='".$k."'>".$addon_type."</option>\n";
//	foreach ($addon_types as $k=>$addon_type) $addon_type_list .= $k;

include ADDON_LOCALE.LOCALESET."inc.functions.php";
$get_type = array(
	  $locale['func006'] => 1, 
	  $locale['func007'] => 2, 
	  $locale['func008'] => 3,
	  $locale['func009'] => 4,
	  $locale['func010'] => 5
);

	$q_addon_cats = dbquery("SELECT 
	                               addon_cat_id, 
	                               addon_cat_type, 
	                               addon_cat_name 
	                               FROM ".DB_ADDON_CATS." 
	                               WHERE addon_cat_type = 
	                               ".$get_type[$addon_sub_type]." 
	                               ORDER BY addon_cat_type,
	                               addon_cat_order
	                               ");
	if (dbrows($q_addon_cats) != 0) {
		while ($d_addon_cats = dbarray($q_addon_cats)) {
			if (get_addon_type($d_addon_cats['addon_cat_type']) != $opt) {
				if ($opt != "") { $cat_list .= "</optgroup>\n"; }
				$opt = get_addon_type($d_addon_cats['addon_cat_type']);
				$cat_list .= "<optgroup label='".get_addon_type($d_addon_cats['addon_cat_type'])."'>\n";
			}
			$cat_list .= "<option value='".$d_addon_cats['addon_cat_id']."'>".$d_addon_cats['addon_cat_name']."</option>\n";		
		}
		$cat_list .= "</optgroup>\n";
		echo $locale['addondb401']."<br /><br />
<form name='add_addon' method='post' action='".FUSION_SELF."' enctype='multipart/form-data'>
<table align='center' cellpadding='0' cellspacing='0' class='tbl-border'>
<tr>
<td class='tbl1' nowrap>".$addon_sub_type.$locale['addondb402'].":</td>
<td class='tbl1' nowrap><span class='error'>*</span></td>
<td class='tbl1' nowrap><input type='text' class='textbox' name='addon_name' style='width:300px;'></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['addondb403'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><select class='textbox' name='addon_cat_id' style='width:300px;'>".$cat_list."</select>
<input type='hidden' class='textbox' name='addon_cat_type' value='".$get_type[$opt]."'>
</td>
</tr>
<tr>
<td class='tbl1' nowrap valign='top'>".$locale['addondb404'].":</td>
<td class='tbl1' nowrap valign='top'><span class='error'>*</span></td>
<td class='tbl1'><textarea id='addon_description' class='textbox' name='addon_description' style='width:300px; height:200px;'></textarea>
</tr>
<tr>
<td class='tbl1' nowrap valign='top'>".$locale['addondb405'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><textarea class='textbox' name='addon_copyright' style='width:300px; height:80px;'></textarea></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['addondb406'].":</td>
<td class='tbl1' nowrap><span class='error'>*</span></td>
<td class='tbl1'><input type='text' class='textbox' name='addon_version' style='width:150px;'></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['addondb407'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><select class='textbox' name='addon_version_id' style='width:150px;'>".buildversionoptionlist(-1)."</td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['addondb411'].":</td>
<td class='tbl1' nowrap><span class='error'>*</span></td>
<td class='tbl1'><input type='file' class='textbox' name='addon_download' size='43' style='width:300px;'></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['addondb415'].":</td>
<td class='tbl1' nowrap>";
if ($addon_sub_type == $locale['addondb425']) { echo "<span class='error'>*</span>"; } else { echo "&nbsp;"; }
echo "</td>
<td class='tbl1'><input type='file' class='textbox' name='addon_screen' size='43' style='width:300px;'></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['addondb408'].":</td>
<td class='tbl1' nowrap><span class='error'>*</span></td>
<td class='tbl1'><input type='text' class='textbox' name='addon_author_name' style='width:300px;' value='".$userdata['user_name']."'></td>
</tr>
<tr>
<td class='tbl1' nowrap><label for='coauthor'>".$locale['addondb613'].":</label><label for='checkbox'></label>&nbsp;<input id='checkcoauth' type='checkbox' /></td>
<td class='tbl1' nowrap><span class='error'>&nbsp;</span></td>
<td class='tbl1'><div id='showcoauth'><label><input type='text' class='textbox' name='addon_co_author_name' style='width:300px;'></label></div></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['addondb409'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><input type='text' class='textbox' name='addon_author_email' style='width:300px;' value='".$userdata['user_email']."'></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['addondb410'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><input type='text' class='textbox' name='' style='width:42px;' value='http://' READONLY><input type='text' class='textbox' name='addon_author_www' style='width:250px;' value='".$userdata['user_web']."'></td>
</tr><tr>
<td class='tbl1' valign='top' height='80' nowrap><label for='valid'>".$locale['addondb423'].":</label><label for='checkbox'></label>&nbsp;<input id='checkvalid' type='checkbox' /></td>
<td class='tbl1' height='80' nowrap>&nbsp;</td>
<td class='tbl1' height='80' valign='top'><img src='".INFUSIONS."addondb/img/huh.png' alt='' />
			<a target='_blank' title='W3C Markup Validation' href='http://validator.w3.org/'><img src='".INFUSIONS."addondb/img/valid_xhtml.png' alt='W3C Markup Validation' /></a>
			<a target='_blank' title='W3C CSS Validation' href='http://jigsaw.w3.org/css-validator/'><img src='".INFUSIONS."addondb/img/valid_css.png' alt='W3C CSS Validation' /></a>
			<div id='showvalid'>
			".$locale['addondb421'].": <label><input type='checkbox' name='addon_valid_xhtml' value='1' style='vertical-align:middle;'  /></label>
			<br />
			".$locale['addondb422'].": <label><input type='checkbox' name='addon_valid_css' value='1' style='vertical-align:middle;'  /></label><br /><br />
			</div></td>
</tr><tr>
<td class='tbl1' nowrap>".$locale['addondb417'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><select name='addon_forum_status' class='textbox'>
<option value='0'>".$locale['addondb418']."</option>
<option value='1'>".$locale['addondb419']."</option>
</select>
</td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['addondb416'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><input type='hidden' class='textbox' name='addon_submitter_name' value='".$userdata['user_name']."'><b>".$userdata['user_name']."</b>
<input type='hidden' class='textbox' name='addon_submitter_id' value='".$userdata['user_id']."'>
<input type='hidden' class='textbox' name='addon_type' value='0'></td>
</tr>
<tr>
<td class='tbl1' nowrap colspan='3' align='center'><hr>".$locale['addondb414']."</td>
</tr>
<tr>
<td class='tbl1' nowrap colspan='3' align='center'><input type='submit' class='button' name='btn_submit' value='".$locale['addondb412']."'></td>
</tr>
</table>
</form>\n";
	} else {
		echo "<center><br />".$locale['addondb611']."<br /><br />".$locale['addondb612']."<br /><br /></center>\n";
	}
	closetable();
}

require_once THEMES."templates/footer.php";
?>