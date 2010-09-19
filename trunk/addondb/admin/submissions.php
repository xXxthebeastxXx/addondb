<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: submissions.php
| Author: PHP-Fusion Addons Team
| Lightbox 2 Copyright Lokesh Dhakar
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";
include LOCALE.LOCALESET."admin/submissions.php";

if (!checkrights("ADNX") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

require_once INFUSIONS."addondb/inc/inc.functions.php";
require_once ADDON."infusion_db.php";
require_once ADDON_INC."inc.nav.php";

if (file_exists(ADDON_LOCALE.LOCALESET."admin/admin.php")) {
	include ADDON_LOCALE.LOCALESET."admin/admin.php";
} else {
	include ADDON_LOCALE."English/admin/admin.php";
}

$addons = "";
$trans = "";

if (!isset($_GET['action']) || $_GET['action'] == "1") {
    
    if(isset($_GET['tran']) && isnum($_GET['tran'])){
    $result1 = dbquery("SELECT * FROM ".DB_ADDON_TRANS." WHERE trans_mod='".$_GET['tran']."' ORDER BY trans_datestamp DESC");
    }else{
    		$result = dbquery("SELECT * FROM ".DB_SUBMISSIONS." WHERE submit_type='m' ORDER BY submit_datestamp DESC");
		if (dbrows($result)) {
			while ($data = dbarray($result)) {
				$submit_criteria = unserialize($data['submit_criteria']);
				$addons .= "<tr>\n<td class='tbl1'>".$submit_criteria['addon_name']."</td>\n";
				$addons .= "<td align='right' width='1%' class='tbl1' style='white-space:nowrap'><span class='small'><a href='".FUSION_SELF.$aidlink."&amp;action=2&amp;t=m&amp;submit_id=".$data['submit_id']."'>".$locale['417']."</a></span>\n";
				$addons .= "</td>\n</tr>\n";
			}
		} else {
			$addons = "<tr>\n<td colspan='2' class='tbl1'>".$locale['414']."</td>\n</tr>\n";
		}
				opentable($locale['410']);
		echo "<table cellpadding='0' cellspacing='1' width='400' class='tbl-border center'>\n<tr>\n";
		echo "<td colspan='2' class='tbl2'><a id='link_submissions' name='link_submissions'></a>\nMods</td>\n";
		echo "</tr>\n".$addons."</table>\n";
		closetable();
		$result1 = dbquery("SELECT * FROM ".DB_ADDON_TRANS." WHERE trans_active='1' ORDER BY trans_datestamp DESC");  
    }
    
    if (dbrows($result1)) {
			while ($data1 = dbarray($result1)) {
				$trans .= "<tr>\n<td class='tbl1'>".$data1['trans_modname']."::".get_addon_language($data1['trans_type'])."</td>\n";
				$trans .= "<td align='right' width='1%' class='tbl1' style='white-space:nowrap'><span class='small'><a href='".FUSION_SELF.$aidlink."&amp;action=2&amp;t=t&amp;trans_id=".$data1['trans_id']."'>".$locale['417']."</a></span>\n";
				$trans .= "</td>\n</tr>\n";
			}
		} else {
			$trans = "<tr>\n<td colspan='2' class='tbl1'>".$locale['addondb454']."</td>\n</tr>\n";
		}
		
		opentable($locale['addondb449']);
		echo "<table cellpadding='0' cellspacing='1' width='400' class='tbl-border center'>\n<tr>\n";
		echo "<td colspan='2' class='tbl2'>\nTranslations</td>\n";
		echo "</tr>\n".$trans."</table>\n";
		closetable();
	
}else{
if ((isset($_GET['action']) && $_GET['action'] == "2") && (isset($_GET['t']) && $_GET['t'] == "t")) {
   if (isset($_POST['add']) && (isset($_GET['trans_id']) && isnum($_GET['trans_id']))) {
   
    if($_POST['trans_status'] == 1){
    // do nothing
    }elseif ($_POST['trans_status'] == 4){
    
		   $result1 = dbquery("SELECT * FROM ".DB_ADDON_TRANS." WHERE trans_mod='".$_GET['trans_id']."'");
      if (dbrows($result1)) {
			while ($data1 = dbarray($result1)) {
			@unlink($trans_upload_dir.$data1['trans_file']);
			$result = dbquery("DELETE FROM ".DB_ADDON_TRANS." WHERE trans_id='".$data1['trans_id']."'");
			
			}
			}

			notify($_POST['trans_name'], $_POST['addon_name'].$locale['addondb460'].get_addon_status_mail(4), $_POST['addon_name'].$locale['addondb460'].get_addon_status_mail(4).$locale['addondb461'].$_POST['trans_approved_comment']);
									
			opentable($locale['400']);
			echo "<br /><div style='text-align:center'>".$locale['401']."<br /><br />\n";
			echo "<a href='".FUSION_SELF.$aidlink."'>".$locale['402']."</a><br /><br />\n";
			echo "<a href='index.php".$aidlink."'>".$locale['403']."</a></div><br />\n";
			closetable();
			
    }else{
    
              $result = dbquery("UPDATE ".DB_ADDON_TRANS." SET
              trans_active = '".stripinput($_POST['trans_status'])."',
              trans_type = '".stripinput($_POST['lang'])."',
              trans_approved_user = '".stripinput($_POST['trans_approved_user'])."',
              trans_approved_comment = '".stripinput($_POST['trans_approved_comment'])."' 
              WHERE trans_id = '".$_GET['trans_id']."'
              ");
          
           notify($_POST['trans_name'], $_POST['addon_name'].$locale['addondb460'].get_addon_status_mail($_POST['trans_status']), $_POST['addon_name'].$locale['addondb460'].get_addon_status_mail($_POST['trans_status']).$locale['addondb461'].$_POST['trans_approved_comment']);
   
    }
   
   }elseif(isset($_GET['trans_id']) && isnum($_GET['trans_id'])){
          	

   		$result = dbquery("SELECT * FROM ".DB_ADDON_TRANS." WHERE trans_id='".$_GET['trans_id']."' ");
      while ($data = dbarray($result)) {
      
      $trans_approved_user_list = builduseroptionlist("");
      $lang = "";
			for ($i=1;$i <= get_addon_language(0);$i++) {
				$lang .= "<option value='".$i."'".($data['trans_type'] == $i ? " selected" : "").">".get_addon_language($i)."</option>\n";
			}
			
				$trans_status_list = "";
			foreach ($addon_status as $k=>$trans_status_name) {
				$trans_status_list .= "<option value='".$k."'".($data['trans_active'] == $k ? " selected" : "").">".$trans_status_name."</option>\n";
			}
      
   		opentable($locale['addondb449']);
			echo "<form name='publish' method='post' action='".FUSION_SELF.$aidlink."&amp;action=2&amp;t=t&amp;trans_id=".$_GET['trans_id']."' enctype='multipart/form-data'>\n";
			echo "<table cellpadding='0' cellspacing='0' class='center'>\n<tr>\n";
			echo "<td class='tbl1' nowrap>".$locale['addondb402'].":</td>
			<td class='tbl1'><input type='text' class='textbox' name='addon_name' value='".$data['trans_modname']."' style='width:300px;' READONLY></td>
			</tr><tr>
			<td class='tbl1' nowrap>".$locale['addondb456'].":</td>
			<td class='tbl1'><select class='textbox' name='lang' style='width:300px;'>".$lang."</select></td>
			</tr><tr>
			<td class='tbl1' nowrap>".$locale['addondb412'].":</td>
			<td class='tbl1'><span class='small'><a href='".$trans_upload_dir.$data['trans_file']."' target='_BLANK'>".substr($trans_upload_dir.$data['trans_file'],6)."</a></span></td>
			</tr><tr>
			<td class='tbl1' nowrap>".$locale['addondb413'].":</td>
			<td class='tbl1'><span class='small'>
			<input type='hidden' class='textbox' name='trans_name' value='".$data['trans_user']."'>
			<a href='".BASEDIR."profile.php?lookup=".$data['trans_user']."' target='_BLANK'>".$data['trans_user']."</a></span></td>
			</tr><tr>
			<td class='tbl1' nowrap>".$locale['addondb442'].":</td>
			<td class='tbl1'><select class='textbox' name='trans_status' style='width:300px;'>".$trans_status_list."</select></td>
			</tr><tr>
			<td class='tbl1' nowrap>".$locale['addondb417'].":</td>
			<td class='tbl1'><select class='textbox' name='trans_approved_user' style='width:300px;'>".$trans_approved_user_list."</select></td>
			</tr><tr>
			<td class='tbl1' nowrap valign='top'>".$locale['addondb419'].":</td>
			<td class='tbl1'><textarea class='textbox' name='trans_approved_comment' style='width:300px; height:48px;'></textarea></td>";
			echo "</tr>\n</table>\n";
			echo "<div style='text-align:center'><br />\n";
			echo "<input type='submit' name='add' value='".$locale['addondb455']."' class='button' />\n";
			echo "</div></form>\n";
			closetable();
			}
   
   }


}elseif ((isset($_GET['action']) && $_GET['action'] == "2") && (isset($_GET['t']) && $_GET['t'] == "m")) {
	if (isset($_POST['add']) && (isset($_GET['submit_id']) && isnum($_GET['submit_id']))) {

    if($_POST['addon_status'] == 1){
    // do nothing
    }elseif ($_POST['addon_status'] == 4){
    
			@unlink($addon_upload_dir.$_POST['addon_download_list']);
			@unlink($addon_upload_dir_img."t_".$_POST['addon_screenshot']);
			@unlink($addon_upload_dir_img.$_POST['addon_screenshot']);

			notify($_POST['addon_submitter_name'], $_POST['addon_name'].$locale['addondb460'].get_addon_status_mail(4), $_POST['addon_name'].$locale['addondb460'].get_addon_status_mail(4).$locale['addondb461'].$_POST['addon_approved_comment']);
			$result = dbquery("DELETE FROM ".DB_SUBMISSIONS." WHERE submit_id='".$_GET['submit_id']."'");
						
			opentable($locale['400']);
			echo "<br /><div style='text-align:center'>".$locale['401']."<br /><br />\n";
			echo "<a href='".FUSION_SELF.$aidlink."'>".$locale['402']."</a><br /><br />\n";
			echo "<a href='index.php".$aidlink."'>".$locale['403']."</a></div><br />\n";
			closetable();
			
    }else{
      $result = dbquery("SELECT * FROM ".DB_SUBMISSIONS." WHERE submit_id='".$_GET['submit_id']."' LIMIT 1");
      if (dbrows($result)) {
        $data = dbarray($result);
        $submit_criteria = unserialize($data['submit_criteria']);
      
        // Error
        $error = "";
        
        // Addon info
        $submit_info['addon_name'] = stripinput($_POST['addon_name']);
        $submit_info['addon_cat_id'] = stripinput($_POST['addon_cat_id']);
        $submit_info['addon_cat_type'] = stripinput($_POST['addon_cat_type']);
        $submit_info['addon_description'] = stripinput($_POST['addon_description']);
        $submit_info['addon_copyright'] = stripinput($_POST['addon_copyright']);
        $submit_info['addon_version'] = stripinput($_POST['addon_version']);
        $submit_info['version_id'] = stripinput($_POST['version_id']);
    
        // Download
        $submit_info['addon_download_list'] = stripinput($_POST['addon_download_list']);
        $submit_info['addon_screenshot'] = stripinput($_POST['addon_screenshot']);
        
        // Author
        $submit_info['addon_author_name'] = stripinput($_POST['addon_author_name']);
        $submit_info['addon_co_author_name'] = stripinput($_POST['addon_co_author_name']);
        $submit_info['addon_author_email'] = stripinput($_POST['addon_author_email']);
        $submit_info['addon_author_www'] = stripinput($_POST['addon_author_www']);
        $submit_info['addon_submitter_name'] = stripinput($_POST['addon_submitter_name']);
        $submit_info['addon_submitter_id'] = stripinput($_POST['addon_submitter_id']);
        $submit_info['addon_forum_status'] = stripinput($_POST['addon_forum_status']);
        $submit_info['addon_valid_xhtml'] = stripinput($_POST['addon_valid_xhtml']);
        $submit_info['addon_valid_css'] = stripinput($_POST['addon_valid_css']);
        $submit_info['addon_date'] = time();
    
        // Approve
        $submit_info['addon_status'] = stripinput($_POST['addon_status']);
        $submit_info['addon_approved_user'] = stripinput($_POST['addon_approved_user']);
        $submit_info['addon_approved_rating'] = stripinput($_POST['addon_approved_rating']);
        $submit_info['addon_approved_comment'] = stripinput($_POST['addon_approved_comment']);
        

          if (is_uploaded_file($_FILES['addon_download']['tmp_name'])) {
            if ($_FILES['addon_download']['size'] > $addon_upload_maxsize) {
              $error = sprintf($locale['addondb486'], $addon_upload_maxsize);
            }
            foreach (array_keys($addon_upload_exts) as $addon_upload_ext) {
              if (stristr($_FILES['addon_download']['name'], $addon_upload_ext) == $addon_upload_ext) $addon_ext = $addon_upload_ext;
            }
            if ($addon_ext != "") {
              $addon_ext = ".".$addon_ext;
            } else {
              $error = sprintf($locale['addondb487'],implode(", ",array_keys($addon_upload_exts)));
            }
            if ($error == "") {
            
            $upload_name = $submit_info['addon_download_list'];
            
            foreach (array_keys($addon_upload_exts) as $addon_upload_ext) {
              $upload_name = rtrim($upload_name, $addon_upload_ext);
            }

              @unlink($addon_upload_dir.$submit_info['addon_download_list']);
              move_uploaded_file($_FILES['addon_download']['tmp_name'], $addon_upload_dir.$upload_name.$addon_ext);

              $submit_info['addon_download_list'] = $upload_name.$addon_ext;
            }
          }
          
          if (is_uploaded_file($_FILES['addon_screen']['tmp_name'])) {
          
                  if ($_FILES['addon_screen']['size'] > $addon_upload_maxsize_img) {
                    $error = sprintf($locale['addondb488'], $addon_upload_maxsize_img);
                  }
                  foreach (array_keys($addon_upload_exts_img) as $addon_upload_ext_img) {
                    if (stristr($_FILES['addon_screen']['name'], $addon_upload_ext_img) == $addon_upload_ext_img) $addon_ext_img = $addon_upload_ext_img;
                  }
                  if ($addon_ext_img != "") {
                    $addon_ext_img = ".".$addon_ext_img;
                  } else {
                    $error = sprintf($locale['addondb489'],implode(", ",array_keys($addon_upload_exts_img)));
                  }
                  
        
               if ($error == "") {
                  
                  $upload_name = $submit_info['addon_screenshot'];
                  foreach (array_keys($addon_upload_exts_img) as $addon_upload_ext_img) {
                  $upload_name = rtrim($upload_name, $addon_upload_ext_img);
                  }

                  @unlink($addon_upload_dir_img.$submit_info['addon_screenshot']);
                  @unlink($addon_upload_dir_img."t_".$submit_info['addon_screenshot']);
                  move_uploaded_file($_FILES['addon_screen']['tmp_name'], $addon_upload_dir_img.$upload_name.$addon_ext_img);

                                  
                  require_once INCLUDES."photo_functions_include.php";
                  $fileext = $addon_ext_img;
                  if ($fileext == ".gif") { $filetype = 1;
                   } elseif ($fileext == ".jpg") { $filetype = 2;
                   } elseif ($fileext == ".png") { $filetype = 3;
                   } else { $filetype = false; }
                  createthumbnail($filetype , $addon_upload_dir_img.$upload_name.$addon_ext_img, $addon_upload_dir_img."t_".$upload_name.$addon_ext_img, 200, 150);
                  
                  $submit_info['addon_screenshot'] = $upload_name.$addon_ext_img;
                  }
          }
        
        
        if ($error == "") {
          // Insert
          $result = dbquery("INSERT INTO ".DB_ADDONS." VALUES(
            '',
            '".$submit_info['addon_cat_id']."',
            '".$submit_info['addon_cat_type']."',
            '".$submit_info['addon_status']."',
            '".$submit_info['addon_name']."',
            '".$submit_info['addon_description']."',
            '".$submit_info['addon_copyright']."',
            '".$submit_info['addon_version']."',
            '".$submit_info['version_id']."',
            '".$submit_info['addon_submitter_name']."',
            '".$submit_info['addon_submitter_id']."',
            '".$submit_info['addon_forum_status']."',
            '".$submit_info['addon_valid_xhtml']."',
            '".$submit_info['addon_valid_css']."',
            '".$submit_info['addon_author_name']."',
            '".$submit_info['addon_co_author_name']."',
            '".$submit_info['addon_author_email']."',
            '".$submit_info['addon_author_www']."',
            '".$submit_info['addon_date']."',
            '".$submit_info['addon_download_list']."',
            '0',
            '".$submit_info['addon_approved_user']."',
            '".$submit_info['addon_approved_rating']."',
            '".$submit_info['addon_approved_comment']."',
            '0',
            '".$submit_info['addon_screenshot']."'
          )");

          // Delete submission
          $desult = dbquery("DELETE FROM ".DB_SUBMISSIONS." WHERE submit_id='".$_GET['submit_id']."' LIMIT 1");
          
          notify($_POST['addon_submitter_name'], $_POST['addon_name'].$locale['addondb460'].get_addon_status_mail($_POST['addon_status']), $_POST['addon_name'].$locale['addondb460'].get_addon_status_mail($_POST['addon_status']).$locale['addondb461'].$_POST['addon_approved_comment']);
        } else {
          echo $error;
        }
    
        echo "<br /><div style='text-align:center'>".$locale['431']."<br /><br />\n";
        echo "<a href='".FUSION_SELF.$aidlink."'>".$locale['402']."</a><br /><br />\n";
        echo "<a href='index.php".$aidlink."'>".$locale['403']."</a></div><br />\n";
        closetable();
      } else {
        redirect(FUSION_SELF.$aidlink);
      }
    }
	} elseif (isset($_GET['submit_id']) && isnum($_GET['submit_id'])) {
		$result = dbquery(
			"SELECT ts.*, user_id,user_name FROM ".DB_SUBMISSIONS." ts
			LEFT JOIN ".DB_USERS." tu ON ts.submit_user=tu.user_id
			WHERE submit_id='".$_GET['submit_id']."'"
		);
		if (dbrows($result)) {
			$data = dbarray($result);
			$opts = ""; $sel = "";
			$submit_criteria = unserialize($data['submit_criteria']);

			// VARIABLES START
			$addon_name = $submit_criteria['addon_name'];
			$addon_cat_id = $submit_criteria['addon_cat_id'];
			$addon_cat_type = $submit_criteria['addon_cat_type'];
			$addon_status_value = $submit_criteria['addon_status'];
			$addon_description = $submit_criteria['addon_description'];
			$addon_copyright = $submit_criteria['addon_copyright'];
			$addon_version = $submit_criteria['addon_version'];
			$version_id = $submit_criteria['addon_version_id'];
			$addon_submitter_name = $submit_criteria['addon_submitter_name'];
			$addon_submitter_id = $submit_criteria['addon_submitter_id'];
			$addon_forum_status = $submit_criteria['addon_forum_status'];
			$addon_valid_css = $submit_criteria['addon_valid_css'];
			$addon_valid_xhtml = $submit_criteria['addon_valid_xhtml'];
			$addon_author_name = $submit_criteria['addon_author_name'];
			$addon_co_author_name = $submit_criteria['addon_co_author_name'];
			$addon_author_email = $submit_criteria['addon_author_email'];
			$addon_author_www = $submit_criteria['addon_author_www'];
			$addon_download = $submit_criteria['addon_download'];
			$addon_screen = $submit_criteria['addon_screen'];
			$addon_approved_user = "";
			$addon_approved_rating = "";
			$addon_approved_comment = "";
			$addon_date = explode("-",date("d-m-Y",$submit_criteria['addon_date']+($settings['timeoffset']*3600)));
			$addon_date_d = $addon_date['0'];
			$addon_date_m = $addon_date['1'];
			$addon_date_y = $addon_date['2'];
			$addon_date_t = date("H:i:s",$submit_criteria['addon_date']+($settings['timeoffset']*3600));
			// VARIABLES END

			// GET RIGHT CONTENT START
			$cat_list = "";
			$q_addon_cats = dbquery("SELECT * FROM ".DB_ADDON_CATS." ORDER BY addon_cat_order");
			while ($d_addon_cats = dbarray($q_addon_cats)) $cat_list .= "<option value='".$d_addon_cats['addon_cat_id']."' ".((isset($addon_cat_id) ? $addon_cat_id : 0) == $d_addon_cats['addon_cat_id'] ? "selected" : "").">".$d_addon_cats['addon_cat_name']."</option>\n";
			dbseek($q_addon_cats, 0);
			$addon_approved_user_list = builduseroptionlist($addon_approved_user);
			foreach (array_reverse($addon_ratings,true) as $k=>$addon_rating) {
				if (!isset($addon_approved_rating_list)) { $addon_approved_rating_list = ""; }
				$addon_approved_rating_list .= "<option value='".$k."'".($addon_approved_rating == $k ? " selected" : "").">".$addon_rating."</option>\n";
			}
			$months = explode("|",$locale['months']);
			$month_list = "";
			for ($i=1; $i<count($months); $i++) $month_list .= "<option value='".$i."'".($i == $addon_date_m ? " selected" : "").">".$months[$i]."</option>\n";
			$day_list = "";
			for ($i=1; $i<32; $i++) $day_list .= "<option value='".$i."'".($i == $addon_date_d ? " selected" : "").">".$i."</option>\n";
			$dld_list = makefilelist($addon_upload_dir, ".|..|index.php", true);
			$addon_download_list = makefileopts($dld_list, $addon_download);
			$addon_status_list = "";
			foreach ($addon_status as $k=>$addon_status_name) {
				$addon_status_list .= "<option value='".$k."'".($addon_status_value == $k ? " selected" : "").">".$addon_status_name."</option>\n";
			}
			// GET RIGHT CONTENT END

			opentable($locale['440']);
			echo "<form name='publish' method='post' action='".FUSION_SELF.$aidlink."&amp;action=2&amp;t=m&amp;submit_id=".$_GET['submit_id']."' enctype='multipart/form-data'>\n";
			echo "<table cellpadding='0' cellspacing='0' class='center'>\n<tr>\n";
			echo "<td class='tbl1' nowrap>".$locale['addondb402'].":</td>
			<td class='tbl1' nowrap><span class='error'>*</span></td>
			<td class='tbl1'><input type='text' class='textbox' name='addon_name' value='".$addon_name."' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb403'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><select class='textbox' name='addon_cat_id' style='width:300px;'>".$cat_list."</select>
			<input type='hidden' class='textbox' name='addon_cat_type' value='".$addon_cat_type."'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap valign='top'>".$locale['addondb404'].":</td>
			<td class='tbl1' nowrap valign='top'><span class='error'>*</span></td>
			<td class='tbl1'><textarea class='textbox' name='addon_description' style='width:300px; height:100px;'>".$addon_description."</textarea></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap valign='top'>".$locale['addondb406'].":</td>
			<td class='tbl1' nowrap valign='top'>&nbsp;</td>
			<td class='tbl1'><textarea class='textbox' name='addon_copyright' style='width:300px; height:40px;'>".$addon_copyright."</textarea></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb408'].":</td>
			<td class='tbl1' nowrap><span class='error'>*</span></td>
			<td class='tbl1'><input type='text' class='textbox' name='addon_version' value='".$addon_version."' style='width:150px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb409'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><select class='textbox' name='version_id' style='width:150px;'>".buildversionoptionlist($version_id)."</td>
			</tr>
			<tr>
			<td class='tbl1' nowrap colspan='3'><hr></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb410'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><select class='textbox' name='addon_download_list' style='width:300px;'>".$addon_download_list."</select></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb411'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><input type='file' class='textbox' name='addon_download' size='43' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb412'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><span class='small'><a href='".INFUSIONS."addondb/files/$addon_download' target='_BLANK'>".substr($addon_upload_dir.$addon_download,6)."</a></span></td>
			</tr>";
			echo'
      <script type="text/javascript" src="../lightbox/prototype.js"></script>
      <script type="text/javascript" src="../lightbox/scriptaculous.js?load=effects,builder"></script>
      <script type="text/javascript" src="../lightbox/lightbox.js"></script>
      <link rel="stylesheet" href="../lightbox/lightbox.css" type="text/css" media="screen" />
      ';
			echo"
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb447'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><input type='hidden' name='addon_screenshot' value='".$addon_screen."' ><input type='file' class='textbox' name='addon_screen' size='43' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb448'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><span class='small'><a href='".INFUSIONS."addondb/img/screenshots/$addon_screen' rel='lightbox'>".substr($addon_upload_dir_img.$addon_screen,6)."</a></span></td>
			</tr>
			\n";
				if (isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['addon_id']) && isnum($_GET['addon_id'])) {
					echo "<tr>
			<td class='tbl1' nowrap>".$locale['addondb440'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><span class='small'><a href='".FUSION_SELF.$aidlink."&amp;action=download&addon_id=".$_GET['addon_id']."'>".$addon_download."</a></span>
			</tr>\n";
				}
				echo " <tr>
			<td class='tbl1' nowrap colspan='3'><hr></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb413'].":</td>
			<td class='tbl1' nowrap><span class='error'>*</span></td>
			<td class='tbl1'><input type='text' class='textbox' name='addon_author_name' value='".$addon_author_name."' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb413c'].":</td>
			<td class='tbl1' nowrap><span class='error'>&nbsp;</span></td>
			<td class='tbl1'><input type='text' class='textbox' name='addon_co_author_name' value='".$addon_co_author_name."' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb414'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><input type='text' class='textbox' name='addon_author_email' value='".$addon_author_email."' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb415'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><input type='text' class='textbox' name='addon_author_www' value='".$addon_author_www."' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb458'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><input type='hidden' class='textbox' name='addon_submitter_name' value='".$addon_submitter_name."' style='width:300px;'>
			<a href='".BASEDIR."profile.php?lookup=$addon_submitter_id'>".$addon_submitter_name."<input type='hidden' class='textbox' name='addon_submitter_id' value='".$addon_submitter_id."'></td>
			</tr>
			<tr>";
			
			if ($addon_forum_status == 0) { $thread_create = "".$locale['addondb459y'].""; } 
			elseif ($addon_forum_status == 1) { $thread_create = "".$locale['addondb459n'].""; } 
			elseif ($addon_forum_status == 2) { $thread_create = "".$locale['addondb459x'].""; }
			
			echo "<td class='tbl1' nowrap>".$locale['addondb459']."</td>
			<td class='tbl1' nowrap>&nbsp;</td><td class='tbl1'><input type='hidden' class='textbox' name='addon_forum_status' value='".$addon_forum_status."'>".$thread_create."</td>
			</tr>";

			echo "<tr>
			<td class='tbl1' nowrap>".$locale['addondb459v'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td><td class='tbl1'><input type='hidden' class='textbox' name='addon_valid_xhtml' value='".$addon_valid_xhtml."'>";
			if ($addon_valid_xhtml) { echo $locale['addondb459y']; } else { echo $locale['addondb459n']; }
			echo "</td>
			</tr><tr>
			<td class='tbl1' nowrap>".$locale['addondb459c'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td><td class='tbl1'><input type='hidden' class='textbox' name='addon_valid_css' value='".$addon_valid_css."'>";
			if ($addon_valid_css) { echo $locale['addondb459y']; } else { echo $locale['addondb459n']; }
			echo "</td>
			</tr>
			
			<tr>
			<td class='tbl1' nowrap colspan='3'><hr></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb442'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><select class='textbox' name='addon_status' style='width:300px;'>".$addon_status_list."</select></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb417'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><input type='hidden' class='textbox' value='".$userdata['user_id']."' name='addon_approved_user'>".$userdata['user_name']."</td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb418'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><select class='textbox' name='addon_approved_rating' style='width:300px;'>".$addon_approved_rating_list."</select></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap valign='top'>".$locale['addondb419'].":</td>
			<td class='tbl1' nowrap valign='top'>&nbsp;</td>
			<td class='tbl1'><textarea class='textbox' name='addon_approved_comment' style='width:300px; height:48px;'>".$addon_approved_comment."</textarea></td>";
			echo "</tr>\n</table>\n";
			echo "<div style='text-align:center'><br />\n";
			echo "<input type='submit' name='add' onClick=\"return confirm('".$locale['addondb444']."')\" value='".$locale['addondb427']."' class='button' />\n";
			echo "</div>\n</form>\n";
			closetable();
		} else {
			redirect(FUSION_SELF.$aidlink);
		}
	 }
  }
}

require_once THEMES."templates/footer.php";
?>