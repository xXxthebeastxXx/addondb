<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: submissions.php
| Author: Nick Jones (Digitanium)
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

if (!checkrights("SU") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

require_once INFUSIONS."moddb/infusion_db.php";
require_once INFUSIONS."moddb/inc/inc.functions.php";
require_once INFUSIONS."moddb/inc/inc.nav.php";

if (file_exists(INFUSIONS."moddb/locale/".LOCALESET."admin/admin.php")) {
	include INFUSIONS."moddb/locale/".LOCALESET."admin/admin.php";
} else {
	include INFUSIONS."moddb/locale/English/admin/admin.php";
}

$mods = "";
$trans = "";

if (!isset($_GET['action']) || $_GET['action'] == "1") {
    
    if(isset($_GET['tran']) && isnum($_GET['tran'])){
    $result1 = dbquery("SELECT * FROM ".DB_MOD_TRANS." WHERE trans_mod='".$_GET['tran']."' ORDER BY trans_datestamp DESC");
    }else{
    		$result = dbquery("SELECT * FROM ".DB_SUBMISSIONS." WHERE submit_type='m' ORDER BY submit_datestamp DESC");
		if (dbrows($result)) {
			while ($data = dbarray($result)) {
				$submit_criteria = unserialize($data['submit_criteria']);
				$mods .= "<tr>\n<td class='tbl1'>".$submit_criteria['mod_name']."</td>\n";
				$mods .= "<td align='right' width='1%' class='tbl1' style='white-space:nowrap'><span class='small'><a href='".FUSION_SELF.$aidlink."&amp;action=2&amp;t=m&amp;submit_id=".$data['submit_id']."'>".$locale['417']."</a></span>\n";
				$mods .= "</td>\n</tr>\n";
			}
		} else {
			$mods = "<tr>\n<td colspan='2' class='tbl1'>".$locale['414']."</td>\n</tr>\n";
		}
				opentable($locale['410']);
		echo "<table cellpadding='0' cellspacing='1' width='400' class='tbl-border center'>\n<tr>\n";
		echo "<td colspan='2' class='tbl2'><a id='link_submissions' name='link_submissions'></a>\nMods</td>\n";
		echo "</tr>\n".$mods."</table>\n";
		closetable();
		$result1 = dbquery("SELECT * FROM ".DB_MOD_TRANS." WHERE trans_active='1' ORDER BY trans_datestamp DESC");  
    }
    
    if (dbrows($result1)) {
			while ($data1 = dbarray($result1)) {
				$trans .= "<tr>\n<td class='tbl1'>".$data1['trans_modname']."::".get_mod_language($data1['trans_type'])."</td>\n";
				$trans .= "<td align='right' width='1%' class='tbl1' style='white-space:nowrap'><span class='small'><a href='".FUSION_SELF.$aidlink."&amp;action=2&amp;t=t&amp;trans_id=".$data1['trans_id']."'>".$locale['417']."</a></span>\n";
				$trans .= "</td>\n</tr>\n";
			}
		} else {
			$trans = "<tr>\n<td colspan='2' class='tbl1'>".$locale['moddb454']."</td>\n</tr>\n";
		}
		
		opentable($locale['moddb449']);
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
    
		   $result1 = dbquery("SELECT * FROM ".DB_MOD_TRANS." WHERE trans_mod='".$_GET['trans_id']."'");
      if (dbrows($result1)) {
			while ($data1 = dbarray($result1)) {
			@unlink($trans_upload_dir.$data1['trans_file']);
			$result = dbquery("DELETE FROM ".DB_MOD_TRANS." WHERE trans_id='".$data1['trans_id']."'");
			
			}
			}

			notify($_POST['trans_name'], $_POST['mod_name'].$locale['moddb460'].get_mod_status_mail(4), $_POST['mod_name'].$locale['moddb460'].get_mod_status_mail(4).$locale['moddb461'].$_POST['trans_approved_comment']);
									
			opentable($locale['400']);
			echo "<br /><div style='text-align:center'>".$locale['401']."<br /><br />\n";
			echo "<a href='".FUSION_SELF.$aidlink."'>".$locale['402']."</a><br /><br />\n";
			echo "<a href='index.php".$aidlink."'>".$locale['403']."</a></div><br />\n";
			closetable();
			
    }else{
    
              $result = dbquery("UPDATE ".DB_MOD_TRANS." SET
              trans_active = '".stripinput($_POST['trans_status'])."',
              trans_type = '".stripinput($_POST['lang'])."',
              trans_approved_user = '".stripinput($_POST['trans_approved_user'])."',
              trans_approved_comment = '".stripinput($_POST['trans_approved_comment'])."' 
              WHERE trans_id = '".$_GET['trans_id']."'
              ");
          
           notify($_POST['trans_name'], $_POST['mod_name'].$locale['moddb460'].get_mod_status_mail($_POST['trans_status']), $_POST['mod_name'].$locale['moddb460'].get_mod_status_mail($_POST['trans_status']).$locale['moddb461'].$_POST['trans_approved_comment']);
   
    }
   
   }elseif(isset($_GET['trans_id']) && isnum($_GET['trans_id'])){
          	

   		$result = dbquery("SELECT * FROM ".DB_MOD_TRANS." WHERE trans_id='".$_GET['trans_id']."' ");
      while ($data = dbarray($result)) {
      
      $trans_approved_user_list = builduseroptionlist("");
      $lang = "";
			for ($i=1;$i <= get_mod_language(0);$i++) {
				$lang .= "<option value='".$i."'".($data['trans_type'] == $i ? " selected" : "").">".get_mod_language($i)."</option>\n";
			}
			
				$trans_status_list = "";
			foreach ($mod_status as $k=>$trans_status_name) {
				$trans_status_list .= "<option value='".$k."'".($data['trans_active'] == $k ? " selected" : "").">".$trans_status_name."</option>\n";
			}
      
   		opentable($locale['moddb449']);
			echo "<form name='publish' method='post' action='".FUSION_SELF.$aidlink."&amp;action=2&amp;t=t&amp;trans_id=".$_GET['trans_id']."' enctype='multipart/form-data'>\n";
			echo "<table cellpadding='0' cellspacing='0' class='center'>\n<tr>\n";
			echo "<td class='tbl1' nowrap>".$locale['moddb402'].":</td>
			
			<td class='tbl1'><input type='text' class='textbox' name='mod_name' value='".$data['trans_modname']."' style='width:300px;' READONLY></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb456'].":</td>
		
			<td class='tbl1'><select class='textbox' name='lang' style='width:300px;'>".$lang."</select></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb412'].":</td>
			
			<td class='tbl1'><span class='small'><a href='".$trans_upload_dir.$data['trans_file']."' target='_BLANK'>".substr($trans_upload_dir.$data['trans_file'],6)."</a></span></td>
			</tr>
			
			
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb413'].":</td>
			<td class='tbl1'><span class='small'>
			<input type='hidden' class='textbox' name='trans_name' value='".$data['trans_user']."'>
			<a href='".BASEDIR."profile.php?lookup=".$data['trans_user']."' target='_BLANK'>".$data['trans_user']."</a></span></td>
			</tr>
			
			
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb442'].":</td>
			
			<td class='tbl1'><select class='textbox' name='trans_status' style='width:300px;'>".$trans_status_list."</select></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb417'].":</td>

			<td class='tbl1'><select class='textbox' name='trans_approved_user' style='width:300px;'>".$trans_approved_user_list."</select></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap valign='top'>".$locale['moddb419'].":</td>

			<td class='tbl1'><textarea class='textbox' name='trans_approved_comment' style='width:300px; height:48px;'></textarea></td>";
			echo "</tr>\n</table>\n";
			echo "<div style='text-align:center'><br />\n";
			echo "<input type='submit' name='add' value='".$locale['moddb455']."' class='button' />\n";
			echo "</div></form>\n";
			closetable();
			}
   
   }


}elseif ((isset($_GET['action']) && $_GET['action'] == "2") && (isset($_GET['t']) && $_GET['t'] == "m")) {
	if (isset($_POST['add']) && (isset($_GET['submit_id']) && isnum($_GET['submit_id']))) {

    if($_POST['mod_status'] == 1){
    // do nothing
    }elseif ($_POST['mod_status'] == 4){
    
			@unlink($mod_upload_dir.$_POST['mod_download_list']);
			@unlink($mod_upload_dir_img."t_".$_POST['mod_screenshot']);
			@unlink($mod_upload_dir_img.$_POST['mod_screenshot']);

			notify($_POST['mod_submitter_name'], $_POST['mod_name'].$locale['moddb460'].get_mod_status_mail(4), $_POST['mod_name'].$locale['moddb460'].get_mod_status_mail(4).$locale['moddb461'].$_POST['mod_approved_comment']);
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
        
        // MOD info
        $submit_info['mod_name'] = stripinput($_POST['mod_name']);
        $submit_info['mod_cat_id'] = stripinput($_POST['mod_cat_id']);
        $submit_info['mod_modtype'] = stripinput($_POST['mod_modtype']);
        $submit_info['mod_description'] = stripinput($_POST['mod_description']);
        $submit_info['mod_copyright'] = stripinput($_POST['mod_copyright']);
        $submit_info['mod_version'] = stripinput($_POST['mod_version']);
        $submit_info['version_id'] = stripinput($_POST['version_id']);
    
        // Download
        $submit_info['mod_download_list'] = stripinput($_POST['mod_download_list']);
        $submit_info['mod_screenshot'] = stripinput($_POST['mod_screenshot']);
        
        // Author
        $submit_info['mod_author_name'] = stripinput($_POST['mod_author_name']);
        $submit_info['mod_co_author_name'] = stripinput($_POST['mod_co_author_name']);
        $submit_info['mod_author_email'] = stripinput($_POST['mod_author_email']);
        $submit_info['mod_author_www'] = stripinput($_POST['mod_author_www']);
        $submit_info['mod_submitter_name'] = stripinput($_POST['mod_submitter_name']);
        $submit_info['mod_submitter_id'] = stripinput($_POST['mod_submitter_id']);
        $submit_info['mod_forum_status'] = stripinput($_POST['mod_forum_status']);
        $submit_info['mod_valid_xhtml'] = stripinput($_POST['mod_valid_xhtml']);
        $submit_info['mod_valid_css'] = stripinput($_POST['mod_valid_css']);
        $submit_info['mod_date'] = time();
    
        // Approve
        $submit_info['mod_status'] = stripinput($_POST['mod_status']);
        $submit_info['mod_approved_user'] = stripinput($_POST['mod_approved_user']);
        $submit_info['mod_approved_rating'] = stripinput($_POST['mod_approved_rating']);
        $submit_info['mod_approved_comment'] = stripinput($_POST['mod_approved_comment']);
        

          if (is_uploaded_file($_FILES['mod_download']['tmp_name'])) {
            if ($_FILES['mod_download']['size'] > $mod_upload_maxsize) {
              $error = sprintf($locale['moddb486'], $mod_upload_maxsize);
            }
            foreach (array_keys($mod_upload_exts) as $mod_upload_ext) {
              if (stristr($_FILES['mod_download']['name'], $mod_upload_ext) == $mod_upload_ext) $mod_ext = $mod_upload_ext;
            }
            if ($mod_ext != "") {
              $mod_ext = ".".$mod_ext;
            } else {
              $error = sprintf($locale['moddb487'],implode(", ",array_keys($mod_upload_exts)));
            }
            if ($error == "") {
            
            $upload_name = $submit_info['mod_download_list'];
            
            foreach (array_keys($mod_upload_exts) as $mod_upload_ext) {
              $upload_name = rtrim($upload_name, $mod_upload_ext);
            }

              @unlink($mod_upload_dir.$submit_info['mod_download_list']);
              move_uploaded_file($_FILES['mod_download']['tmp_name'], $mod_upload_dir.$upload_name.$mod_ext);

              $submit_info['mod_download_list'] = $upload_name.$mod_ext;
              

            }
          }
          
          if (is_uploaded_file($_FILES['mod_screen']['tmp_name'])) {
          
                  if ($_FILES['mod_screen']['size'] > $mod_upload_maxsize_img) {
                    $error = sprintf($locale['moddb488'], $mod_upload_maxsize_img);
                  }
                  foreach (array_keys($mod_upload_exts_img) as $mod_upload_ext_img) {
                    if (stristr($_FILES['mod_screen']['name'], $mod_upload_ext_img) == $mod_upload_ext_img) $mod_ext_img = $mod_upload_ext_img;
                  }
                  if ($mod_ext_img != "") {
                    $mod_ext_img = ".".$mod_ext_img;
                  } else {
                    $error = sprintf($locale['moddb489'],implode(", ",array_keys($mod_upload_exts_img)));
                  }
                  
        
               if ($error == "") {
                  
                  $upload_name = $submit_info['mod_screenshot'];
                  foreach (array_keys($mod_upload_exts_img) as $mod_upload_ext_img) {
                  $upload_name = rtrim($upload_name, $mod_upload_ext_img);
                  }

                  @unlink($mod_upload_dir_img.$submit_info['mod_screenshot']);
                  @unlink($mod_upload_dir_img."t_".$submit_info['mod_screenshot']);
                  move_uploaded_file($_FILES['mod_screen']['tmp_name'], $mod_upload_dir_img.$upload_name.$mod_ext_img);

                                  
                  require_once INCLUDES."photo_functions_include.php";
                  $fileext = $mod_ext_img;
                  if ($fileext == ".gif") { $filetype = 1;
                   } elseif ($fileext == ".jpg") { $filetype = 2;
                   } elseif ($fileext == ".png") { $filetype = 3;
                   } else { $filetype = false; }
                  createthumbnail($filetype , $mod_upload_dir_img.$upload_name.$mod_ext_img, $mod_upload_dir_img."t_".$upload_name.$mod_ext_img, 200, 150);
                  
                  $submit_info['mod_screenshot'] = $upload_name.$mod_ext_img;
                  }
          }
        
        
        if ($error == "") {
          // Insert
          $result = dbquery("INSERT INTO ".DB_MODS." VALUES(
            '',
            '".$submit_info['mod_cat_id']."',
            '".$submit_info['mod_modtype']."',
            '".$submit_info['mod_status']."',
            '".$submit_info['mod_name']."',
            '".$submit_info['mod_description']."',
            '".$submit_info['mod_copyright']."',
            '".$submit_info['mod_version']."',
            '".$submit_info['version_id']."',
            '".$submit_info['mod_submitter_name']."',
            '".$submit_info['mod_submitter_id']."',
            '".$submit_info['mod_forum_status']."',
            '".$submit_info['mod_valid_xhtml']."',
            '".$submit_info['mod_valid_css']."',
            '".$submit_info['mod_author_name']."',
            '".$submit_info['mod_co_author_name']."',
            '".$submit_info['mod_author_email']."',
            '".$submit_info['mod_author_www']."',
            '".$submit_info['mod_date']."',
            '".$submit_info['mod_download_list']."',
            '0',
            '".$submit_info['mod_approved_user']."',
            '".$submit_info['mod_approved_rating']."',
            '".$submit_info['mod_approved_comment']."',
            '0',
            '".$submit_info['mod_screenshot']."'
          )");

          // Delete submission
          $desult = dbquery("DELETE FROM ".DB_SUBMISSIONS." WHERE submit_id='".$_GET['submit_id']."' LIMIT 1");
          
          notify($_POST['mod_submitter_name'], $_POST['mod_name'].$locale['moddb460'].get_mod_status_mail($_POST['mod_status']), $_POST['mod_name'].$locale['moddb460'].get_mod_status_mail($_POST['mod_status']).$locale['moddb461'].$_POST['mod_approved_comment']);
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
			$mod_name = $submit_criteria['mod_name'];
			$mod_cat_id = $submit_criteria['mod_cat_id'];
			$mod_modtype = $submit_criteria['mod_type'];
			$mod_status_value = $submit_criteria['mod_status'];
			$mod_description = $submit_criteria['mod_description'];
			$mod_copyright = $submit_criteria['mod_copyright'];
			$mod_version = $submit_criteria['mod_version'];
			$version_id = $submit_criteria['mod_version_id'];
			$mod_submitter_name = $submit_criteria['mod_submitter_name'];
			$mod_submitter_id = $submit_criteria['mod_submitter_id'];
			$mod_forum_status = $submit_criteria['mod_forum_status'];
			$mod_valid_css = $submit_criteria['mod_valid_css'];
			$mod_valid_xhtml = $submit_criteria['mod_valid_xhtml'];
			$mod_author_name = $submit_criteria['mod_author_name'];
			$mod_co_author_name = $submit_criteria['mod_co_author_name'];
			$mod_author_email = $submit_criteria['mod_author_email'];
			$mod_author_www = $submit_criteria['mod_author_www'];
			$mod_download = $submit_criteria['mod_download'];
			$mod_screen = $submit_criteria['mod_screen'];
			$mod_approved_user = "";
			$mod_approved_rating = "";
			$mod_approved_comment = "";
			$mod_date = explode("-",date("d-m-Y",$submit_criteria['mod_date']+($settings['timeoffset']*3600)));
			$mod_date_d = $mod_date['0'];
			$mod_date_m = $mod_date['1'];
			$mod_date_y = $mod_date['2'];
			$mod_date_t = date("H:i:s",$submit_criteria['mod_date']+($settings['timeoffset']*3600));
			// VARIABLES END

			// GET RIGHT CONTENT START
			$cat_list = "";
			$q_mod_cats = dbquery("SELECT * FROM ".DB_MOD_CATS." ORDER BY mod_cat_order");
			while ($d_mod_cats = dbarray($q_mod_cats)) $cat_list .= "<option value='".$d_mod_cats['mod_cat_id']."' ".((isset($mod_cat_id) ? $mod_cat_id : 0) == $d_mod_cats['mod_cat_id'] ? "selected" : "").">".$d_mod_cats['mod_cat_name']."</option>\n";
			dbseek($q_mod_cats, 0);
			$mod_approved_user_list = builduseroptionlist($mod_approved_user);
			foreach (array_reverse($mod_ratings,true) as $k=>$mod_rating) {
				if (!isset($mod_approved_rating_list)) { $mod_approved_rating_list = ""; }
				$mod_approved_rating_list .= "<option value='".$k."'".($mod_approved_rating == $k ? " selected" : "").">".$mod_rating."</option>\n";
			}
			$mod_type_list = "";
			foreach ($mod_types as $k=>$mod_type) {
				$mod_type_list .= "<option value='".$k."'".($mod_modtype == $k ? " selected" : "").">".$mod_type."</option>\n";
			}
			$months = explode("|",$locale['months']);
			$month_list = "";
			for ($i=1; $i<count($months); $i++) $month_list .= "<option value='".$i."'".($i == $mod_date_m ? " selected" : "").">".$months[$i]."</option>\n";
			$day_list = "";
			for ($i=1; $i<32; $i++) $day_list .= "<option value='".$i."'".($i == $mod_date_d ? " selected" : "").">".$i."</option>\n";
			$dld_list = makefilelist($mod_upload_dir, ".|..|index.php", true);
			$mod_download_list = makefileopts($dld_list, $mod_download);
			$mod_status_list = "";
			foreach ($mod_status as $k=>$mod_status_name) {
				$mod_status_list .= "<option value='".$k."'".($mod_status_value == $k ? " selected" : "").">".$mod_status_name."</option>\n";
			}
			// GET RIGHT CONTENT END

			opentable($locale['440']);
			echo "<form name='publish' method='post' action='".FUSION_SELF.$aidlink."&amp;action=2&amp;t=m&amp;submit_id=".$_GET['submit_id']."' enctype='multipart/form-data'>\n";
			echo "<table cellpadding='0' cellspacing='0' class='center'>\n<tr>\n";
			echo "<td class='tbl1' nowrap>".$locale['moddb402'].":</td>
			<td class='tbl1' nowrap><span class='error'>*</span></td>
			<td class='tbl1'><input type='text' class='textbox' name='mod_name' value='".$mod_name."' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb403'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><select class='textbox' name='mod_cat_id' style='width:300px;'>".$cat_list."</select></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb416'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><select class='textbox' name='mod_modtype' style='width:300px;'>".$mod_type_list."</select></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap valign='top'>".$locale['moddb404'].":</td>
			<td class='tbl1' nowrap valign='top'><span class='error'>*</span></td>
			<td class='tbl1'><textarea class='textbox' name='mod_description' style='width:300px; height:100px;'>".$mod_description."</textarea></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap valign='top'>".$locale['moddb406'].":</td>
			<td class='tbl1' nowrap valign='top'>&nbsp;</td>
			<td class='tbl1'><textarea class='textbox' name='mod_copyright' style='width:300px; height:40px;'>".$mod_copyright."</textarea></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb408'].":</td>
			<td class='tbl1' nowrap><span class='error'>*</span></td>
			<td class='tbl1'><input type='text' class='textbox' name='mod_version' value='".$mod_version."' style='width:150px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb409'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><select class='textbox' name='version_id' style='width:150px;'>".buildversionoptionlist($version_id)."</td>
			</tr>
			<tr>
			<td class='tbl1' nowrap colspan='3'><hr></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb410'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><select class='textbox' name='mod_download_list' style='width:300px;'>".$mod_download_list."</select></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb411'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><input type='file' class='textbox' name='mod_download' size='43' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb412'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><span class='small'><a href='".INFUSIONS."moddb/files/$mod_download' target='_BLANK'>".substr($mod_upload_dir.$mod_download,6)."</a></span></td>
			</tr>";
			echo'
      <script type="text/javascript" src="../lightbox/prototype.js"></script>
      <script type="text/javascript" src="../lightbox/scriptaculous.js?load=effects,builder"></script>
      <script type="text/javascript" src="../lightbox/lightbox.js"></script>
      <link rel="stylesheet" href="../lightbox/lightbox.css" type="text/css" media="screen" />
      ';
			echo"
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb447'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><input type='hidden' name='mod_screenshot' value='".$mod_screen."' ><input type='file' class='textbox' name='mod_screen' size='43' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb448'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><span class='small'><a href='".INFUSIONS."moddb/img/screenshots/$mod_screen' rel='lightbox'>".substr($mod_upload_dir_img.$mod_screen,6)."</a></span></td>
			</tr>
			\n";
				if (isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['mod_id']) && isnum($_GET['mod_id'])) {
					echo "<tr>
			<td class='tbl1' nowrap>".$locale['moddb440'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><span class='small'><a href='".FUSION_SELF.$aidlink."&amp;action=download&mod_id=".$_GET['mod_id']."'>".$mod_download."</a></span>
			</tr>\n";
				}
				echo " <tr>
			<td class='tbl1' nowrap colspan='3'><hr></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb413'].":</td>
			<td class='tbl1' nowrap><span class='error'>*</span></td>
			<td class='tbl1'><input type='text' class='textbox' name='mod_author_name' value='".$mod_author_name."' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb413c'].":</td>
			<td class='tbl1' nowrap><span class='error'>&nbsp;</span></td>
			<td class='tbl1'><input type='text' class='textbox' name='mod_co_author_name' value='".$mod_co_author_name."' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb414'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><input type='text' class='textbox' name='mod_author_email' value='".$mod_author_email."' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb415'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><input type='text' class='textbox' name='mod_author_www' value='".$mod_author_www."' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb458'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><input type='hidden' class='textbox' name='mod_submitter_name' value='".$mod_submitter_name."' style='width:300px;'>
			<a href='".BASEDIR."profile.php?lookup=$mod_submitter_id'>".$mod_submitter_name."<input type='hidden' class='textbox' name='mod_submitter_id' value='".$mod_submitter_id."'></td>
			</tr>
			<tr>";
			
			if ($mod_forum_status == 0) { $thread_create = "".$locale['moddb459y'].""; } 
			elseif ($mod_forum_status == 1) { $thread_create = "".$locale['moddb459n'].""; } 
			elseif ($mod_forum_status == 2) { $thread_create = "".$locale['moddb459x'].""; }
			
			echo "<td class='tbl1' nowrap>".$locale['moddb459']."</td>
			<td class='tbl1' nowrap>&nbsp;</td><td class='tbl1'><input type='hidden' class='textbox' name='mod_forum_status' value='".$mod_forum_status."'>".$thread_create."</td>
			</tr>";

			echo "<tr>
			<td class='tbl1' nowrap>".$locale['moddb459v'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td><td class='tbl1'><input type='hidden' class='textbox' name='mod_valid_xhtml' value='".$mod_valid_xhtml."'>";
			if ($mod_valid_xhtml) { echo $locale['moddb459y']; } else { echo $locale['moddb459n']; }
			echo "</td>
			</tr><tr>
			<td class='tbl1' nowrap>".$locale['moddb459c'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td><td class='tbl1'><input type='hidden' class='textbox' name='mod_valid_css' value='".$mod_valid_css."'>";
			if ($mod_valid_css) { echo $locale['moddb459y']; } else { echo $locale['moddb459n']; }
			echo "</td>
			</tr>
			
			<tr>
			<td class='tbl1' nowrap colspan='3'><hr></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb442'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><select class='textbox' name='mod_status' style='width:300px;'>".$mod_status_list."</select></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb417'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><input type='hidden' class='textbox' value='".$userdata['user_id']."' name='mod_approved_user'>".$userdata['user_name']."</td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb418'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><select class='textbox' name='mod_approved_rating' style='width:300px;'>".$mod_approved_rating_list."</select></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap valign='top'>".$locale['moddb419'].":</td>
			<td class='tbl1' nowrap valign='top'>&nbsp;</td>
			<td class='tbl1'><textarea class='textbox' name='mod_approved_comment' style='width:300px; height:48px;'>".$mod_approved_comment."</textarea></td>";
			echo "</tr>\n</table>\n";
			echo "<div style='text-align:center'><br />\n";
			echo "<input type='submit' name='add' onClick=\"return confirm('".$locale['moddb444']."')\" value='".$locale['moddb427']."' class='button' />\n";
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