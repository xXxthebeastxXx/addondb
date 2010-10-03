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

if ($_REQUEST['addon_type'] != '') { $addon_sub_type = ($_REQUEST['addon_type']); } else { redirect("index.php"); }

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
	
	if ($addon_sub_type !='') {
		opentable($locale['addondb400'].$addon_sub_type);
		} else {
		opentable($locale['addondb421']); }
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
echo "
<form name='add_addon' method='post' action='".FUSION_SELF."' enctype='multipart/form-data'>
<table align='center' cellpadding='0' cellspacing='0' class='tbl-border addonsubmitform' width='100%'>
<tr>
<td class='tbl1' colspan='2'><p>".$locale['addondb401']."</p></td>
</tr>
<tr>
<td class='tbl1'><label for='addon_name'>".$addon_sub_type.$locale['addondb402']."</label><input type='text' class='textbox' id='addon_name' name='addon_name' /></td>
<td class='tbl1'><label for='addon_cat_id'>".$locale['addondb403']."</label><select class='textbox' id='addon_cat_id' name='addon_cat_id'>".$cat_list."</select>
<input type='hidden' class='textbox' name='addon_cat_type' value='".$get_type[$opt]."'></td>
</tr>
<tr>
<td class='tbl1'><label for='addon_description'>".$locale['addondb404']."</label><textarea cols='63' rows='10' id='addon_description' class='textbox' id='addon_description' name='addon_description'></textarea></td>
<td class='tbl1'><label for='addon_copyright'>".$locale['addondb405']."</label><textarea cols='63' rows='5' class='textbox' id='addon_copyright' name='addon_copyright'></textarea><label for='addon_forum_status' style='margin-top:16px'>".$locale['addondb417']."</label><select id='addon_forum_status' name='addon_forum_status' class='textbox'><option value='0'>".$locale['addondb418']."</option><option value='1'>".$locale['addondb419']."</option></select></td>
</tr>
<tr>
<td class='tbl1'><label for='addon_version'>".$locale['addondb406']."</label><input type='text' class='textbox' id='addon_version' name='addon_version' /></td>
<td class='tbl1'><label for='addon_version_id'>".$locale['addondb407']."</label><select class='textbox' id='addon_version_id' name='addon_version_id'>".buildversionoptionlist(-1)."</select></td>
</tr>
<tr>
<td class='tbl1'><label for='addon_download'>".$locale['addondb411']."</label><input type='file' class='textbox' id='addon_download' name='addon_download' /></td>
<td class='tbl1'><label for='addon_screen'>".$locale['addondb415']."</label><input type='file' class='textbox' id='addon_screen' name='addon_screen' /></td>
</tr>
<tr>
<td class='tbl1'><label for='addon_author_name'>".$locale['addondb408']."</label><input type='text' class='textbox' id='addon_author_name' name='addon_author_name' value='".$userdata['user_name']."' /></td>
<td class='tbl1'><label for='addon_co_author_name'>".$locale['addondb613']."</label><input type='text' class='textbox' id='addon_co_author_name' name='addon_co_author_name' /></td>
</tr>
<tr>
<td class='tbl1'><label for='addon_author_email'>".$locale['addondb409']."</label><input type='text' class='textbox' id='addon_author_email' name='addon_author_email' value='".$userdata['user_email']."' /></td>
<td class='tbl1'><label for='addon_author_www'>".$locale['addondb410']."</label><input type='text' class='textbox' name='' style='width:42px;' value='http://' readonly='readonly' /><input type='text' class='textbox' id='addon_author_www' name='addon_author_www' style='width:372px;' value='".$userdata['user_web']."' /></td>
</tr>
<tr>
<td class='tbl1' colspan='2' align='center'><hr />
<input type='submit' class='button' name='btn_submit' value='".$locale['addondb412']."' /></td>
</tr>
</table>
<input type='hidden' class='textbox' name='addon_submitter_name' value='".$userdata['user_name']."' />
<input type='hidden' class='textbox' name='addon_submitter_id' value='".$userdata['user_id']."' />
<input type='hidden' class='textbox' name='addon_type' value='0' />
</form>\n";
	} else {
		echo "<center><br />".$locale['addondb611']."<br /><br />".$locale['addondb612']."<br /><br /></center>\n";
	}
	closetable();
}

require_once THEMES."templates/footer.php";
?>