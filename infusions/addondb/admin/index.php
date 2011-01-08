<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: index.php
| Author: PHP-Fusion Addons Team
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

if (!checkrights("ADNX") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { die("Access Denied"); }

require_once INFUSIONS."addondb/infusion_db.php";
require_once INFUSIONS."addondb/inc/inc.functions.php";
require_once INFUSIONS."addondb/inc/inc.nav.php";

if (file_exists(INFUSIONS."addondb/locale/".LOCALESET."admin/admin.php")) {
	include INFUSIONS."addondb/locale/".LOCALESET."admin/admin.php";
} else {
	include INFUSIONS."addondb/locale/English/admin/admin.php";
}

$settings['addon_ratings_manage'] = 0;

$q_addon_cats = dbquery("SELECT * FROM ".DB_ADDON_CATS." ORDER BY addon_cat_order");
if (dbrows($q_addon_cats) == 0) {
	opentable($locale['addondb400']);
	echo "<center>";
	echo $locale['addondb450']."<br />".$locale['addondb451']."<br /><br /><a href='".ADDON_ADMIN."cats.php".$aidlink."'>".$locale['addondb452']."</a>".$locale['addondb453'];
	echo "</center>\n";
	closetable();
} elseif (isset($_POST['btn_cancel'])) {
	redirect(FUSION_SELF.$aidlink);
} elseif (isset($_GET['action']) && $_GET['action'] == "download" && isset($_GET['addon_id']) && isnum($_GET['addon_id'])) {
	$data = dbquery("SELECT addon_download FROM ".DB_ADDONS." WHERE addon_id='".$_GET['addon_id']."'");
	if (dbrows($result)) {
		require_once INCLUDES."class.httpdownload.php";
		ob_end_clean();
		$data = dbarray($result);
		$object = new httpdownload;
		$object->set_byfile(BASEDIR.$addon_upload_dir.$data['addon_download']);
		$object->use_resume = true;
		$object->download();
		exit;
	}
} elseif (isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['addon_id']) && isnum($_GET['addon_id'])) {

  $data = dbarray(dbquery("SELECT * FROM ".DB_ADDONS." WHERE addon_id='".$_GET['addon_id']."'"));
  
  @unlink($addon_upload_dir.$data['addon_download']);
  @unlink($addon_upload_dir_img.$data['addon_screenshot']);
  @unlink($addon_upload_dir_img."t_".$data['addon_screenshot']);
  $result1 = dbquery("SELECT * FROM ".DB_ADDON_TRANS." WHERE trans_mod='".$_GET['addon_id']."'");
   if (dbrows($result1)) {
			while ($data1 = dbarray($result1)) {
			@unlink($trans_upload_dir.$data1['trans_file']);
			$result = dbquery("DELETE FROM ".DB_ADDON_TRANS." WHERE trans_id='".$data1['trans_id']."'");
			
			}
			}
  
  $result = dbquery("DELETE FROM ".DB_ADDONS." WHERE addon_id='".$_GET['addon_id']."'");
	$result = dbquery("DELETE FROM ".DB_COMMENTS." WHERE comment_type='M' AND comment_item_id='".$_GET['addon_id']."'");
	$result = dbquery("DELETE FROM ".DB_RATINGS." WHERE rating_type='M' AND rating_item_id='".$_GET['addon_id']."'");
	
	
	redirect(FUSION_SELF.$aidlink);
} elseif (isset($_GET['action']) && $_GET['action'] == "suspend" && isset($_GET['addon_id']) && isnum($_GET['addon_id'])) {
	$result = dbquery("UPDATE ".DB_ADDONS." SET addon_status='3' WHERE addon_id='".$_GET['addon_id']."'");
	redirect("../addon_view.php?addon_id=".$_GET['addon_id']);
} else {
	if (isset($_POST['btn_save'])) {
		$addon_name = stripinput($_POST['addon_name']);
		$addon_cat_id = stripinput($_POST['addon_cat_id']);
		$addon_modtype = stripinput($_POST['addon_modtype']);
		$addon_status_value = stripinput($_POST['addon_status']);
		$addon_description = stripinput($_POST['addon_description']);
		$addon_demo_url = stripinput($_POST['addon_demo_url']);
		$addon_copyright = stripinput($_POST['addon_copyright']);
		$addon_version = stripinput($_POST['addon_version']);
		$version_id = stripinput($_POST['version_id']);
		$addon_submitter_name = stripinput($_POST['addon_submitter_name']);
		$addon_submitter_id = stripinput($_POST['addon_submitter_id']);
		$addon_forum_status = stripinput($_POST['addon_forum_status']);
		$addon_share_status = stripinput($_POST['addon_share_status']);
		$addon_author_name = stripinput($_POST['addon_author_name']);
		$addon_author_status = stripinput($_POST['addon_author_status']);
		$addon_co_author_name = stripinput($_POST['addon_co_author_name']);
		$addon_author_email = stripinput($_POST['addon_author_email']);
		$addon_author_www = stripinput($_POST['addon_author_www']);
		$addon_download_list = (isset($_POST['addon_download_list']) ? stripinput($_POST['addon_download_list']) : "");
		$addon_approved_user = stripinput($_POST['addon_approved_user']);
		$addon_approved_rating = stripinput($_POST['addon_approved_rating']);
		$addon_approved_comment = stripinput($_POST['addon_approved_comment']);
		$addon_date_t = explode(":",stripinput($_POST['addon_date_t']));
		$addon_date_hrs = $addon_date_t['0'];
		$addon_date_min = $addon_date_t['1'];
		$addon_date_sec = $addon_date_t['2'];
		$addon_screenshot = stripinput($_POST['addon_screenshot']);
		$addon_date = mktime($addon_date_hrs, $addon_date_min, $addon_date_sec, stripinput($_POST['addon_date_m']), stripinput($_POST['addon_date_d']), stripinput($_POST['addon_date_y']));
		if ($addon_name == "" || $addon_description == "" || $addon_version == "" || $addon_author_name == "") {
			$error = $locale['addondb482'];
		} elseif ($addon_author_email <> "" && !preg_match("/^[-0-9A-Z_\.]+@([-0-9A-Z_\.]+\.)+([0-9A-Z]){2,4}$/i", $addon_author_email)) {
			$error = $locale['addondb485'];
		} elseif (!empty($_POST['addon_id']) && isnum($_POST['addon_id']) && dbresult(dbquery("SELECT COUNT(*) FROM ".DB_ADDONS." WHERE addon_name='".$addon_name."' AND addon_version='".$addon_version."' AND addon_id<>'".$_POST['addon_id']."'"),0) != 0) {
			$error = $locale['addondb600'];
		} else {
			$addon_download_old = dbresult(dbquery("SELECT addon_download,addon_status FROM ".DB_ADDONS." WHERE addon_id='".$addon_id."'"),0);
			$addon_download = $addon_download_list;
			
			if ($_POST['action'] == "edit" && isnum($_POST['addon_id'])) {
				$result = dbquery(
					"UPDATE ".DB_ADDONS." SET 
						addon_cat_id='".$addon_cat_id."',
						addon_type='".$addon_modtype."',
						addon_status='".$addon_status_value."',
						addon_name='".$addon_name."',
						addon_description='".$addon_description."',
						addon_demo_url='".$addon_demo_url."',
						addon_copyright='".$addon_copyright."',
						addon_version='".$addon_version."',
						version_id='".$version_id."',
						addon_forum_status='".$addon_forum_status."',
						addon_share_status='".$addon_share_status."',
						addon_author_name='".$addon_author_name."',
						addon_author_status='".$addon_author_status."',
						addon_co_author_name='".$addon_co_author_name."',
						addon_author_email='".$addon_author_email."',
						addon_author_www='".$addon_author_www."',
						addon_date='".$addon_date."',
						addon_download='".$addon_download."',
						addon_approved_user='".$addon_approved_user."',
						addon_approved_rating='".$addon_approved_rating."',
						addon_approved_comment='".$addon_approved_comment."',
						addon_img='".$addon_screenshot."'
					WHERE addon_id='".$_POST['addon_id']."'"
				);
				$addon_id = $_POST['addon_id'];
				$addon_ed = 1;
				if($addon_download_old  != $addon_status_value){
          
          $pm_user = dbarray(dbquery("SELECT user_id FROM ".DB_USERS." WHERE user_name='".$addon_submitter_name."'"));
		  $sendpm = send_pm($pm_user['user_id'], $userdata['user_id'], $locale['addondb500'], $addon_approved_comment);
          
        }
			} else {
				$result = dbquery(
					"INSERT INTO ".DB_ADDONS." VALUES(
						'',
						'".$addon_cat_id."',
						'".$addon_modtype."',
						'".$addon_status_value."',
						'".$addon_name."',
						'".$addon_description."',
						'".$addon_demo_url."',
						'".$addon_copyright."',
						'".$addon_version."',
						'".$version_id."',
						'".$addon_submitter_name."',
						'".$addon_submitter_id."',
						'".$addon_forum_status."',
						'".$addon_share_status."',
						'".$addon_author_status."',
						'".$addon_co_author_name."',
						'".$addon_author_email."',
						'".$addon_author_www."',
						'".$addon_date."',
						'".$addon_download."',
						'0',
						'".$addon_approved_user."',
						'".$addon_approved_rating."',
						'".$addon_approved_comment."',
						'0',
						'".$addon_screenshot."',
					)"
				);
				$addon_id = mysql_insert_id();
				$addon_ed = 0;
			}
			if (is_uploaded_file($_FILES['addon_download']['tmp_name'])) {
				if ($_FILES['addon_download']['size'] > $addon_upload_maxsize) {
					$error = sprintf($locale['addondb486'], $addon_upload_maxsize);
				}
				$ext_ok = false;
				foreach (array_keys($addon_upload_exts) as $addon_upload_ext) {
					if (stristr($_FILES['addon_download']['name'], $addon_upload_ext) == $addon_upload_ext) $ext_ok = true;
				}
				if ($ext_ok != true) {
					$error = sprintf($locale['addondb487'],implode(", ",array_keys($addon_upload_exts)));
				}
				if ($error == "") {
					if ($addon_ed  == 1) {

						@unlink($addon_upload_dir.$addon_download_old);
					}
					move_uploaded_file($_FILES['addon_download']['tmp_name'], $addon_upload_dir.$addon_download_old);
					chmod($addon_upload_dir.$addon_download_old, 0755);
					$result = dbquery(
						"UPDATE ".DB_ADDONS." SET 
							addon_download='".$addon_upload_dir.$addon_download_old."' 
						WHERE addon_id='".$addon_id."'
					");
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
                
               	if($addon_screenshot == ""){
                $upload_name = $addon_id;
                }else{
               	$upload_name = $addon_screenshot;
               	}
					      foreach (array_keys($addon_upload_exts_img) as $addon_upload_ext_img) {
                $upload_name = rtrim($upload_name, ".".$addon_upload_ext_img);
                }
                
                if ($addon_ed  == 1) {

							  @unlink($addon_upload_dir_img.$addon_screenshot);
                @unlink($addon_upload_dir_img."t_".$addon_screenshot);
                }
                move_uploaded_file($_FILES['addon_screen']['tmp_name'], $addon_upload_dir_img.$upload_name.$addon_ext_img);
     
                                
                require_once INCLUDES."photo_functions_include.php";
                $fileext = $addon_ext_img;
                if ($fileext == ".gif") { $filetype = 1;
                 } elseif ($fileext == ".jpg") { $filetype = 2;
                 } elseif ($fileext == ".png") { $filetype = 3;
                 } else { $filetype = false; }
                createthumbnail($filetype , $addon_upload_dir_img.$upload_name.$addon_ext_img, $addon_upload_dir_img."t_".$upload_name.$addon_ext_img, 200, 150);
                
                $result = dbquery("UPDATE ".DB_ADDONS." SET addon_img='".$upload_name.$addon_ext_img."' WHERE addon_id='".$addon_id."'");
                }
        }
			if ($error == "") redirect(FUSION_SELF.$aidlink."&amp;addon_cat_id=".$addon_cat_id);
		}
	}
	$addon_date_y = getdate();
	$addon_date_y = $addon_date_y['year'];
	if (isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['addon_id']) && isnum($_GET['addon_id'])) {
		$data = dbarray(dbquery("SELECT * FROM ".DB_ADDONS." WHERE addon_id='".$_GET['addon_id']."'"));
		$addon_id = $data['addon_id'];
		$addon_name = $data['addon_name'];
		$addon_cat_id = $data['addon_cat_id'];
		$addon_modtype = $data['addon_type'];
		$addon_status_value = $data['addon_status'];
		$addon_description = $data['addon_description'];
		$addon_demo_url = $data['addon_demo_url'];
		$addon_copyright = $data['addon_copyright'];
		$addon_version = $data['addon_version'];
		$version_id = $data['version_id'];
		$addon_submitter_name = $data['addon_submitter_name'];
		$addon_submitter_id = $data['addon_submitter_id'];
		$addon_forum_status = $data['addon_forum_status'];
		$addon_share_status = $data['addon_share_status'];
		$addon_author_name = $data['addon_author_name'];
		$addon_author_status = $data['addon_author_status'];
		$addon_co_author_name = $data['addon_co_author_name'];
		$addon_author_email = $data['addon_author_email'];
		$addon_author_www = $data['addon_author_www'];
		$addon_download = $data['addon_download'];
		$addon_approved_user = $data['addon_approved_user'];
		$addon_approved_rating = $data['addon_approved_rating'];
		$addon_approved_comment = $data['addon_approved_comment'];
		$addon_screenshots  = $data['addon_img'];
		$addon_date = explode("-",date("d-m-Y",$data['addon_date']+($settings['timeoffset']*3600)));
		$addon_date_d = $addon_date['0'];
		$addon_date_m = $addon_date['1'];
		$addon_date_y = $addon_date['2'];
		$addon_date_t = date("H:i:s",$data['addon_date']+($settings['timeoffset']*3600));
		$addon_comments_count = dbresult(dbquery(
			"SELECT COUNT(*) 
			FROM ".DB_ADDONS." 
			JOIN ".DB_COMMENTS." ON addon_id = comment_item_id AND comment_type='M' 
			WHERE addon_id='".$_GET['addon_id']."'"
		),0);
		$addon_ratings_count = dbresult(dbquery(
			"SELECT COUNT(*) 
			FROM ".DB_ADDONS." 
			JOIN ".DB_RATINGS." ON addon_id = rating_item_id AND rating_type='M' 
			WHERE addon_id='".$_GET['addon_id']."'"
		),0);
	} elseif (!isset($error) || empty($error)) {
		$addon_id = 0;
		$addon_name = "";
		$addon_cat_id = "";
		$addon_modtype = 0;
		$addon_status_value = 0;
		$addon_description = "";
		$addon_demo_url = "";
		$addon_copyright = "";
		$addon_version = "";
		$version_id = 0;
		$addon_submitter_name = "";
		$addon_submitter_id = "";
		$addon_forum_status = "";
		$addon_share_status = "";
		$addon_author_name = $userdata['user_name'];
		$addon_author_status = "0";
		$addon_co_author_name = "";
		$addon_author_email = $userdata['user_email'];
		$addon_author_www = $userdata['user_web'];
		$addon_download = "";
		$addon_approved_user = 0;
		$addon_approved_rating = 3;
		$addon_approved_comment = "";
		$addon_date_d = 0;
		$addon_date_m = 0;
		$addon_date_t = "00:00:00";
		$addon_comments_count = 0;
		$addon_ratings_count = 0;
		$addon_downloads_count = 0;
		$addon_screenshots = "";
	} else {
		$addon_date_t = stripinput($_POST['addon_date_t']);
		$addon_date_d = stripinput($_POST['addon_date_d']);
	}
	$cat_list = "";
	while ($d_addon_cats = dbarray($q_addon_cats)) {
		$sel = ($addon_cat_id == $d_addon_cats['addon_cat_id'] ? " selected='selected'" : "");
		$cat_list .= "<option value='".$d_addon_cats['addon_cat_id']."'$sel>".$d_addon_cats['addon_cat_name']."</option>\n";
	}
	dbseek($q_addon_cats, 0);
	$addon_approved_user_list = builduseroptionlist($addon_approved_user);
	foreach (array_reverse($addon_ratings,true) as $k=>$addon_rating) {
		if (!isset($addon_approved_rating_list)) { $addon_approved_rating_list = ""; }
		$addon_approved_rating_list .= "<option value='".$k."'".($addon_approved_rating == $k ? " selected" : "").">".$addon_rating."</option>\n";
	}
	$addon_type_list = "";
	foreach ($addon_types as $k=>$addon_type) {
		$addon_type_list .= "<option value='".$k."'".($addon_modtype == $k ? " selected" : "").">".$addon_type."</option>\n";
	}
	$months = explode("|",$locale['months']);
	$month_list = "";
	for ($i=1; $i<count($months); $i++) {
		$month_list .= "<option value='".$i."'".($i == $addon_date_m ? " selected" : "").">".$months[$i]."</option>\n";
	}
	$day_list = "";
	for ($i=1; $i<32; $i++) {
		$day_list .= "<option value='".$i."'".($i == $addon_date_d ? " selected" : "").">".$i."</option>\n";
	}
	$dld_list = makefilelist($addon_upload_dir, ".|..|index.php", true);
	$addon_download_list = makefileopts($dld_list, $addon_download);
	$addon_status_list = "";
	foreach ($addon_status as $k=>$addon_status_name) {
		$addon_status_list .= "<option value='".$k."'".($addon_status_value == $k ? " selected='selected'" : "").">".$addon_status_name."</option>\n";
	}
	opentable(isset($_GER['action']) && $_GET['action'] == "edit" ? $locale['addondb426'] : $locale['addondb425']);
	echo "<form name='add_mod' method='post' action='".FUSION_SELF.$aidlink."' enctype='multipart/form-data'>\n";
	echo "<input type='hidden' name='action' value='".(isset($_GET['action']) ? $_GET['action'] : "")."'>\n";
	echo "<input type='hidden' name='addon_id' value='".(isset($_GET['addon_id']) ? $_GET['addon_id'] : "")."'>\n";
	echo "<table align='center' cellpadding='0' cellspacing='0' class='body'>\n";
	echo "".(isset($error) ? "<tr><td class='tbl1 error' align='center' colspan='3'>".$error."</td></tr>" : "")."\n";
	echo "<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb402'].":</td>\n";
	echo "<td class='tbl1' nowrap><span class='error'>*</span></td>\n";
	echo "<td class='tbl1'><input type='text' class='textbox' name='addon_name' value='".$addon_name."' style='width:300px;'></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb403'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><select class='textbox' name='addon_cat_id' style='width:300px;'>".$cat_list."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb416'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><select class='textbox' name='addon_modtype' style='width:300px;'>".$addon_type_list."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap valign='top'>".$locale['addondb404'].":</td>\n";
	echo "<td class='tbl1' nowrap valign='top'><span class='error'>*</span></td>\n";
	echo "<td class='tbl1'><textarea class='textbox' name='addon_description' style='width:300px; height:100px;'>".$addon_description."</textarea></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap valign='top'>".$locale['addondb406'].":</td>\n";
	echo "<td class='tbl1' nowrap valign='top'>&nbsp;</td>\n";
	echo "<td class='tbl1'><textarea class='textbox' name='addon_copyright' style='width:300px; height:40px;'>".$addon_copyright."</textarea></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb407']."</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'>\n";
	echo "<select name='addon_date_d' class='textbox'>$day_list</select>&nbsp;\n";
	echo "<select name='addon_date_m' class='textbox'>$month_list</select>&nbsp;\n";
	echo "<input type='text' class='textbox' name='addon_date_y' value='".$addon_date_y."' style='width:40px;' />&nbsp;\n";
	echo "<input type='text' class='textbox' name='addon_date_t' value='".$addon_date_t."' style='width:63px;' />\n";
	echo "</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb408'].":</td>\n";
	echo "<td class='tbl1' nowrap><span class='error'>*</span></td>\n";
	echo "<td class='tbl1'><input type='text' class='textbox' name='addon_version' value='".$addon_version."' style='width:150px;'></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb409'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><select class='textbox' name='version_id' style='width:150px;'>".buildversionoptionlist($version_id)."</td>\n";
	echo "</tr>\n";
	if ($addon_comments_count > 0) {
		echo "<tr>\n";
		echo "<td class='tbl1' nowrap>".$locale['addondb429'].":</td>\n";
		echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
		echo "<td class='tbl1'>(".$addon_comments_count.") <a href='".ADMIN."comments.php".$aidlink."&ctype=M&amp;cid=".$addon_id."' target='_blank' title='".$locale['addondb431']."'>".$locale['addondb431']."</a></td>\n";
		echo "</tr>\n";
	}
	if (($addon_ratings_count > 0) && ($settings['addon_ratings_manage'] == 1)) {
		echo "<tr>\n";
		echo "<td class='tbl1' nowrap>".$locale['addondb430'].":</td>\n";
		echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
		echo "<td class='tbl1'>(".$addon_ratings_count.") <a href='ratings.php?addon_id=".$addon_id."' target='_blank' title='".$locale['addondb508']."'>".$locale['addondb431']."</a></td>\n";
		echo "</tr>\n";
	}
	echo "<tr>\n";
	echo "<td class='tbl1' nowrap colspan='3'><hr></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb410'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><select class='textbox' name='addon_download_list' style='width:300px;'>".$addon_download_list."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb411'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><input type='file' class='textbox' name='addon_download' size='43' style='width:300px;'></td>\n";
	echo "</tr>\n<tr>\n";
		echo "<td class='tbl1' nowrap>".$locale['addondb412'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><span class='small'>".substr($addon_upload_dir.$addon_download,6)."</span></td>\n";
	echo "</tr>\n";
			echo"
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb447'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><input type='hidden' name='addon_screenshot' value='".$addon_screenshots."' ><input type='file' class='textbox' name='addon_screen' size='43' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['addondb448'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><span class='small'><a href='".INFUSIONS."addondb/img/screenshots/$addon_screenshots' rel='lightbox'>".substr($addon_upload_dir_img.$addon_screenshots,6)."</a></span></td>
			</tr>
			\n";

	if (isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['addon_id']) && isnum($_GET['addon_id'])) {
		echo "</tr>\n<tr>\n";
	}
	echo "<tr><td class='tbl1' nowrap colspan='3'><hr></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb413'].":</td>\n";
	echo "<td class='tbl1' nowrap><span class='error'>*</span></td>\n";
	echo "<td class='tbl1'><input type='text' class='textbox' name='addon_author_name' value='".$addon_author_name."' style='width:300px;'></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb413c'].":</td>\n";
	echo "<td class='tbl1' nowrap><span class='error'>&nbsp;</span></td>\n";
	echo "<td class='tbl1'><input type='text' class='textbox' name='addon_co_author_name' value='".$addon_co_author_name."' style='width:300px;'></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb414'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><input type='text' class='textbox' name='addon_author_email' value='".$addon_author_email."' style='width:300px;'></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb415'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><input type='text' class='textbox' name='addon_author_www' value='".$addon_author_www."' style='width:300px;'></td>\n";
	echo "</tr>\n<tr>\n";
    echo "<td class='tbl1' nowrap>".$locale['addondb458'].":</td>";
	echo "<td class='tbl1' nowrap>&nbsp;</td>";
    if ($addon_submitter_name) {
	echo "<td class='tbl1'><input type='hidden' class='textbox' name='addon_submitter_name' value='".$addon_submitter_name."' style='width:300px;'><a href='".BASEDIR."profile.php?lookup=$addon_submitter_id'>".$addon_submitter_name."<input type='hidden' class='textbox' name='addon_submitter_id' value='".$addon_submitter_id."'></td>"; } else {
	echo "<td class='tbl1'><input type='hidden' class='textbox' name='addon_submitter_name' value='".$userdata['user_name']."' style='width:300px;'><a href='".BASEDIR."profile.php?lookup=".$userdata['user_id']."'>".$userdata['user_name']."<input type='hidden' class='textbox' name='addon_submitter_id' value='".$userdata['user_id']."'></td>"; }
	echo "</tr>\n<tr>\n";

// Edit Support Thread
    echo "<td class='tbl1' nowrap>".$locale['addondb459']."</td>";
	echo "<td class='tbl1' nowrap>&nbsp;</td><td class='tbl1'><select id='addon_forum_status' name='addon_forum_status' class='textbox'>";
	echo "<option value='1'".($addon_forum_status == "2" ? " selected" : "").">".$locale['addondb467']."</option>\n";
	echo "<option value='1'".($addon_forum_status == "1" ? " selected" : "").">".$locale['addondb461']."</option>\n";
	echo "<option value='0'".($addon_forum_status == "0" ? " selected" : "").">".$locale['addondb460']."</option>\n";
	echo "</select>\n";
	echo "</tr>\n<tr>\n";

// Edit Social sharing
    echo "<td class='tbl1' nowrap>".$locale['addondb462']."</td>";
	echo "<td class='tbl1' nowrap>&nbsp;</td><td class='tbl1'><select id='addon_share_status' name='addon_share_status' class='textbox'>";
	echo "<option value='1'".($addon_share_status == "1" ? " selected" : "").">".$locale['addondb460']."</option>\n";
	echo "<option value='0'".($addon_share_status == "0" ? " selected" : "").">".$locale['addondb461']."</option>\n";
	echo "</select>\n";
	echo "</tr>\n<tr>\n";	
	echo "<td class='tbl1' nowrap>".$locale['addondb464']."</td>";
	echo "<td class='tbl1' nowrap>&nbsp;</td><td class='tbl1'><select id='addon_author_status' name='addon_author_status' class='textbox'>";
	echo "<option value='2'".($addon_author_status == "2" ? " selected" : "").">".$locale['addondb460']."</option>\n";
	echo "<option value='1'".($addon_author_status == "1" ? " selected" : "").">".$locale['addondb465']."</option>\n";
	echo "<option value='0'".($addon_author_status == "0" ? " selected" : "").">".$locale['addondb461']."</option>\n";
	echo "</select>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb463']."</td>";
	echo "<td class='tbl1' nowrap>&nbsp;</td><td class='tbl1'><input type='text' class='textbox' name='addon_demo_url' value='".$addon_demo_url."' style='width:300px;'></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap colspan='3'><hr></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb442'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><select class='textbox' name='addon_status' style='width:300px;'>".$addon_status_list."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb417'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'>";
	$result = dbquery("SELECT user_id, user_name FROM ".DB_USERS." WHERE user_id =".$addon_approved_user."");
     if (dbrows($result) != 0) {
        $dataa=dbarray($result);
    echo $dataa['user_name']; }
    echo "<input type='hidden' class='textbox' name='addon_approved_user' value='".$addon_approved_user."'>";
	echo "</td>";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['addondb418'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><select class='textbox' name='addon_approved_rating' style='width:300px;'>".$addon_approved_rating_list."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap valign='top'>".$locale['addondb419'].":</td>\n";
	echo "<td class='tbl1' nowrap valign='top'>&nbsp;</td>\n";
	echo "<td class='tbl1'><textarea class='textbox' name='addon_approved_comment' style='width:300px; height:48px;'>".$addon_approved_comment."</textarea></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap colspan='3' align='center'><hr>".$locale['addondb437']."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap colspan='3' align='center'>";
	echo "<input type='submit' name='btn_save' value='".$locale['addondb427']."' class='button' />\n";
	if ((isset($_GET['action']) && $_GET['action'] == "edit") || isset($error)) {
	echo "&nbsp;<input type='submit' name='btn_cancel' value='".$locale['addondb428']."' class='button' />\n";
	}
	echo "</td>\n";
	echo "</tr>\n</table>\n</form>\n";
	closetable();
	opentable($locale['addondb400']);
	echo "<table width='400' align='center' cellpadding='0' cellspacing='1' class='tbl-border'>
	<tr>
	<td class='forum-caption'>".$locale['addondb402']."</td>
	<td class='forum-caption' align='right'>".$locale['addondb420']."</td>
	</tr>
	<tr>
	<td class='tbl1' colspan='2'></td>
	</tr>\n";
		$c = 0;
		while ($d_addon_cats = dbarray($q_addon_cats)) {
			$p_img = "on";
			$div = "";
			echo "<tr>
	<td class='tbl2'>".$d_addon_cats['addon_cat_name']." <span class='small2'>(".getgroupname($d_addon_cats['addon_cat_access'])."+)</span></td>
	<td class='tbl2' align='right'></td>
	</tr>\n";
			$q_addons = dbquery("SELECT * FROM ".DB_ADDONS." WHERE addon_cat_id='".$d_addon_cats['addon_cat_id']."' AND addon_status='0' ORDER BY addon_name");
			if (dbrows($q_addons) != 0) {
				echo "<tr>
	<td class='tbl1' colspan='2'>
	<div id='box_".$d_addon_cats['addon_cat_id']."'".$div.">
	<table width='100%' cellpadding='0' cellspacing='0' class='tbl-border'>";
				while ($d_addons = dbarray($q_addons)) {
					echo "<tr class='tbl1'>
	<td class='tbl1' width='' nowrap><a href='../addon_view.php?addon_cat_id=".$d_addon_cats['addon_cat_id']."&addon_id=".$d_addons['addon_id']."' target='_blank' title=''>".$d_addons['addon_name']."</a></td>
	<td class='tbl1' width='1%' nowrap><span class='small'><a href='submissions.php".$aidlink."&tran=".$d_addons['addon_id']."' title='".$locale['addondb449']."'>".$locale['addondb457']."</a>&nbsp;-&nbsp;<a href='".FUSION_SELF.$aidlink."&amp;action=delete&addon_cat_id=".$d_addon_cats['addon_cat_id']."&addon_id=".$d_addons['addon_id']."' onClick=\"return confirmDeleteAddon('".$d_addons['addon_name']."')\" title=''>".$locale['addondb422']."</a>&nbsp;-&nbsp;<a href='".FUSION_SELF.$aidlink."&amp;action=edit&addon_cat_id=".$d_addon_cats['addon_cat_id']."&addon_id=".$d_addons['addon_id']."'>".$locale['addondb421']."</a></span></td>
	</tr>\n";
				}
				echo "</table>
	</div>
	</td>
	</tr>\n";
			} else {
				echo "<tr>
	<td class='tbl1' colspan='2'>
	<div id='box_".$d_addon_cats['addon_cat_id']."'".$div.">
	<table width='100%' cellpadding='0' cellspacing='0'><tr><td class='tbl1'>".$locale['addondb423']."</td></tr></table>
	</div>
	</td>
	</tr>\n";
		}
		$c++;
	}
	echo "</table>\n";
	closetable();
	$inactive_addons = dbquery("SELECT * FROM ".DB_ADDONS." WHERE addon_status!='0' ORDER BY addon_name");
	if (dbrows($inactive_addons) != 0) {

		opentable($locale['addondb443']);
		echo "<table width='400' align='center' cellpadding='0' cellspacing='1' class='tbl-border'>
		<tr>
		<td class='forum-caption'>".$locale['addondb402']."</td>
		<td class='forum-caption' align='right'>".$locale['addondb420']."</td>
		</tr>
		<tr>
		<td class='tbl1' colspan='2'></td>
		</tr>\n";
		while ($addon_data = dbarray($inactive_addons)) {
			echo "<tr class='tbl1'>
			<td class='tbl1' width='*' nowrap><a href='".ADDON."view.php?addon_id=".$addon_data['addon_id']."' target='_blank' title=''>".$addon_data['addon_name']."</a></td>
			<td class='tbl1' width='1%' nowrap><span class='small'>
			<a href='".FUSION_SELF.$aidlink."&amp;action=delete&addon_id=".$addon_data['addon_id']."' onClick=\"return confirmDeleteAddon('".$addon_data['addon_name']."')\" title=''>".$locale['addondb422']."</a> - 
			<a href='".FUSION_SELF.$aidlink."&amp;action=edit&addon_id=".$addon_data['addon_id']."' title=''>".$locale['addondb421']."</a> - 
			".get_addon_status($addon_data['addon_status'])."</span></td>
			</tr>\n";
		}
		echo "</table>
		</div>
		</td>
		</tr>\n";
	}

	echo "</table>\n";
	closetable();
	echo "<script language='JavaScript'>
	function confirmDeleteAddon(addon_name) {
		return confirm('".$locale['addondb424']."\''+addon_name+'\'');
	}
	</script>\n";
}

require_once THEMES."templates/footer.php";
?>