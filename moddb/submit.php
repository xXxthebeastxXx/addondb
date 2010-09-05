<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: submit_mod.php
| Author: Christian Damsgaard Jørgensen (PMM)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

require_once INFUSIONS."moddb/infusion_db.php";
require_once INFUSIONS."moddb/inc/inc.functions.php";

include INFUSIONS."moddb/locale/".LOCALESET."submit_mod.php";
include INFUSIONS."moddb/check.js";
//add_to_head("<Body style='overflow:hidden'>");

if (!iMEMBER) {
	opentable($locale['moddb430']);
	echo "<center><br />".$locale['moddb445']."<br /><br /></center>\n";
	closetable();
} elseif (isset($_POST['btn_submit'])) {
	$error = "";
	$mod_ext = "";
	$mod_ext_img = "";
	$upload_id = "";
	$submit_info['mod_name'] = stripinput($_POST['mod_name']);
	$submit_info['mod_cat_id'] = stripinput($_POST['mod_cat_id']);
	$submit_info['mod_type'] = stripinput($_POST['mod_type']);
	$submit_info['mod_status'] = 1;
	$submit_info['mod_description'] = stripinput($_POST['mod_description']);
	$submit_info['mod_copyright'] = stripinput($_POST['mod_copyright']);
	$submit_info['mod_version'] = stripinput($_POST['mod_version']);
	$submit_info['mod_version_id'] = stripinput($_POST['mod_version_id']);
	$submit_info['mod_submitter_name'] = stripinput($_POST['mod_submitter_name']);
	$submit_info['mod_submitter_id'] = stripinput($_POST['mod_submitter_id']);
	$submit_info['mod_forum_status'] = stripinput($_POST['mod_forum_status']);	

	
	$submit_info['mod_valid_css'] = isset($_POST['mod_valid_css']) ? "1" : "0";
	$submit_info['mod_valid_xhtml'] = isset($_POST['mod_valid_xhtml']) ? "1" : "0";
	

	
	$submit_info['mod_author_name'] = stripinput($_POST['mod_author_name']);
	$submit_info['mod_co_author_name'] = stripinput($_POST['mod_co_author_name']);
	$submit_info['mod_author_email'] = stripinput($_POST['mod_author_email']);
	$submit_info['mod_author_www'] = stripinput($_POST['mod_author_www']);
	$submit_info['mod_date'] = time();
	if ($submit_info['mod_name'] == "" || $submit_info['mod_description'] == "" || $submit_info['mod_version'] == "" || $submit_info['mod_author_name'] == "") {
		$error = $locale['moddb440'];
	} elseif ($submit_info['mod_author_email']<>"" && !preg_match("/^[-0-9A-Z_\.]+@([-0-9A-Z_\.]+\.)+([0-9A-Z]){2,4}$/i", $submit_info['mod_author_email'])) {
		$error = $locale['moddb444'];
	} else {
		$sql = dbquery("INSERT INTO ".DB_SUBMISSIONS." VALUES('', 'm', '".$userdata['user_id']."', '".time()."', '".addslashes(serialize($submit_info))."')");
		$upload_id = dbinsert_id();
		if (is_uploaded_file($_FILES['mod_download']['tmp_name'])) {
			if ($_FILES['mod_download']['size'] > $mod_upload_maxsize) {
				$error = sprintf($locale['moddb441'], $mod_upload_maxsize);
			}
			foreach (array_keys($mod_upload_exts) as $mod_upload_ext) {
				if (stristr($_FILES['mod_download']['name'], $mod_upload_ext) == $mod_upload_ext) $mod_ext = $mod_upload_ext;
			}
			if ($mod_ext != "") {
				$mod_ext = ".".$mod_ext;
			} else {
				$error = sprintf($locale['moddb442'],implode(", ",array_keys($mod_upload_exts)));
			}
						
			if ($error == "") {
			
        		if (is_uploaded_file($_FILES['mod_screen']['tmp_name'])) {
                if ($_FILES['mod_screen']['size'] > $mod_upload_maxsize_img) {
                  $error = sprintf($locale['moddb446'], $mod_upload_maxsize_img);
                }
                foreach (array_keys($mod_upload_exts_img) as $mod_upload_ext_img) {
                  if (stristr($_FILES['mod_screen']['name'], $mod_upload_ext_img) == $mod_upload_ext_img) $mod_ext_img = $mod_upload_ext_img;
                }
                if ($mod_ext_img != "") {
                  $mod_ext_img = ".".$mod_ext_img;
                } else {
                  $error = sprintf($locale['moddb447'],implode(", ",array_keys($mod_upload_exts_img)));
                }
                }
			
             if ($error == "") {
                move_uploaded_file($_FILES['mod_download']['tmp_name'], $mod_upload_dir.$mod_upload_prefix.$upload_id.$mod_ext);
               
                $submit_info['mod_download'] = $mod_upload_prefix.$upload_id.$mod_ext;
                                
                if (is_uploaded_file($_FILES['mod_screen']['tmp_name'])) {
                    move_uploaded_file($_FILES['mod_screen']['tmp_name'], $mod_upload_dir_img.$upload_id.$mod_ext_img);
                    
                    $submit_info['mod_screen'] = $upload_id.$mod_ext_img;
                    
                    require_once INCLUDES."photo_functions_include.php";
                    $fileext = $mod_ext_img;
                    if ($fileext == ".gif") { $filetype = 1;
                     } elseif ($fileext == ".jpg") { $filetype = 2;
                     } elseif ($fileext == ".png") { $filetype = 3;
                     } else { $filetype = false; }
                    createthumbnail($filetype , $mod_upload_dir_img.$upload_id.$mod_ext_img, $mod_upload_dir_img."t_".$upload_id.$mod_ext_img, 200, 150);
                 
                }else{
                    $submit_info['mod_screen'] = "";
                }
                $sql = dbquery("UPDATE ".DB_SUBMISSIONS." SET submit_criteria='".addslashes(serialize($submit_info))."' WHERE submit_id='".$upload_id."'");
            }
      }
			
		} else {
			$error = $locale['moddb443'];
		}
		
	}
	if ($error != "") {
		opentable($locale['moddb430']);
		if (isNum($upload_id)) {
			if (file_exists($mod_upload_dir.$mod_upload_prefix.$upload_id.$mod_ext)) unlink($mod_upload_dir.$mod_upload_prefix.$upload_id.$mod_ext);
			$rm = dbquery("DELETE FROM ".DB_SUBMISSIONS." WHERE submit_id='".$upload_id."'");
		}
		echo "<center><br />".$locale['moddb431']."<br /><br />
		<span class='error'>".$error."</span><br /><br />
		<a href='javascript:history.back(-1);'>".$locale['moddb432']."</a><br /><br /></center>\n";
		closetable();
	} else {
		opentable($locale['moddb400']);
		echo "<center><br />
		".$locale['moddb420']."<br /><br />
		".$locale['moddb421']."<br /><br />
		<a href='".FUSION_SELF."'>".$locale['moddb422']."</a> | <a href='".BASEDIR."index.php'>".$locale['moddb423']."</a><br /><br />".(iADMIN ? "<a href='".BASEDIR."/infusions/moddb/admin/submissions.php".$aidlink."'>".$locale['moddb424']."</a><br /><br />" : "")."
		</center>\n";
		closetable();
	}
} else {
	opentable($locale['moddb400']);
	$mod_type_list = ""; $cat_list = "";
	foreach ($mod_types as $k=>$mod_type) $mod_type_list .= "<option value='".$k."'>".$mod_type."</option>\n";
	$q_mod_cats = dbquery("SELECT mod_cat_id,mod_cat_name FROM ".DB_MOD_CATS." ORDER BY mod_cat_order");
	if (dbrows($q_mod_cats) != 0) {
		while ($d_mod_cats = dbarray($q_mod_cats)) $cat_list .= "<option value='".$d_mod_cats['mod_cat_id']."'>".$d_mod_cats['mod_cat_name']."</option>\n";
		echo $locale['moddb401']."<br /><br />
<form name='add_mod' method='post' action='".FUSION_SELF."' enctype='multipart/form-data'>
<table align='center' cellpadding='0' cellspacing='0' class='tbl-border'>
<tr>
<td class='tbl1' nowrap>".$locale['moddb402'].":</td>
<td class='tbl1' nowrap><span class='error'>*</span></td>
<td class='tbl1' nowrap><input type='text' class='textbox' name='mod_name' style='width:300px;'></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['moddb403'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><select class='textbox' name='mod_cat_id' style='width:300px;'>".$cat_list."</select></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['moddb413'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><select class='textbox' name='mod_type' style='width:300px;'>".$mod_type_list."</select></td>
</tr>
<tr>
<td class='tbl1' nowrap valign='top'>".$locale['moddb404'].":</td>
<td class='tbl1' nowrap valign='top'><span class='error'>*</span></td>
<td class='tbl1'><textarea id='mod_description' class='textbox' name='mod_description' style='width:300px; height:200px;'></textarea>
</tr>
<tr>
<td class='tbl1' nowrap valign='top'>".$locale['moddb405'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><textarea class='textbox' name='mod_copyright' style='width:300px; height:80px;'></textarea></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['moddb406'].":</td>
<td class='tbl1' nowrap><span class='error'>*</span></td>
<td class='tbl1'><input type='text' class='textbox' name='mod_version' style='width:150px;'></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['moddb407'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><select class='textbox' name='mod_version_id' style='width:150px;'>".buildversionoptionlist(-1)."</td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['moddb411'].":</td>
<td class='tbl1' nowrap><span class='error'>*</span></td>
<td class='tbl1'><input type='file' class='textbox' name='mod_download' size='43' style='width:300px;'></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['moddb415'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><input type='file' class='textbox' name='mod_screen' size='43' style='width:300px;'></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['moddb408'].":</td>
<td class='tbl1' nowrap><span class='error'>*</span></td>
<td class='tbl1'><input type='text' class='textbox' name='mod_author_name' style='width:300px;' value='".$userdata['user_name']."'></td>
</tr>
<tr>
<td class='tbl1' nowrap><label for='coauthor'>".$locale['moddb452'].":</label><label for='checkbox'></label>&nbsp;<input id='checkcoauth' type='checkbox' /></td>
<td class='tbl1' nowrap><span class='error'>&nbsp;</span></td>
<td class='tbl1'><div id='showcoauth'><label><input type='text' class='textbox' name='mod_co_author_name' style='width:300px;'></label></div></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['moddb409'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><input type='text' class='textbox' name='mod_author_email' style='width:300px;' value='".$userdata['user_email']."'></td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['moddb410'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><input type='text' class='textbox' name='' style='width:42px;' value='http://' READONLY><input type='text' class='textbox' name='mod_author_www' style='width:250px;' value='".$userdata['user_web']."'></td>
</tr><tr>
<td class='tbl1' valign='top' height='80' nowrap><label for='valid'>".$locale['moddb419v'].":</label><label for='checkbox'></label>&nbsp;<input id='checkvalid' type='checkbox' /></td>
<td class='tbl1' height='80' nowrap>&nbsp;</td>
<td class='tbl1' height='80' valign='top'><img src='".INFUSIONS."moddb/img/huh.png' alt='' />
			<a target='_blank' title='W3C Markup Validation' href='http://validator.w3.org/'><img src='".INFUSIONS."moddb/img/valid_xhtml.png' alt='W3C Markup Validation' /></a>
			<a target='_blank' title='W3C CSS Validation' href='http://jigsaw.w3.org/css-validator/'><img src='".INFUSIONS."moddb/img/valid_css.png' alt='W3C CSS Validation' /></a>
			<div id='showvalid'>
			".$locale['moddb419b'].": <label><input type='checkbox' name='mod_valid_xhtml' value='1' style='vertical-align:middle;'  /></label>
			<br />
			".$locale['moddb419c'].": <label><input type='checkbox' name='mod_valid_css' value='1' style='vertical-align:middle;'  /></label><br /><br />
			</div></td>
</tr><tr>
<td class='tbl1' nowrap>".$locale['moddb417'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><select name='mod_forum_status' class='textbox'>
<option value='0'>".$locale['moddb418']."</option>
<option value='1'>".$locale['moddb419']."</option>
<option value='2'>".$locale['moddb419a']."</option>
</select>
</td>
</tr>
<tr>
<td class='tbl1' nowrap>".$locale['moddb416'].":</td>
<td class='tbl1' nowrap>&nbsp;</td>
<td class='tbl1'><input type='hidden' class='textbox' name='mod_submitter_name' style='width:300px;' value='".$userdata['user_name']."'><b>".$userdata['user_name']."</b><input type='hidden' class='textbox' name='mod_submitter_id' style='width:300px;' value='".$userdata['user_id']."'></td>
</tr>
<tr>
<td class='tbl1' nowrap colspan='3' align='center'><hr>".$locale['moddb414']."</td>
</tr>
<tr>
<td class='tbl1' nowrap colspan='3' align='center'><input type='submit' class='button' name='btn_submit' value='".$locale['moddb412']."'></td>
</tr>
</table>
</form>\n";
	} else {
		echo "<center><br />".$locale['moddb450']."<br /><br />".$locale['moddb451']."<br /><br /></center>\n";
	}
	closetable();
}

require_once THEMES."templates/footer.php";
?>