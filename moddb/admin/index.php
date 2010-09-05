<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: index.php
| Author: PHP-Fusion MODs & Infusions Team
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

if (!checkrights("MODS") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { die("Access Denied"); }

require_once INFUSIONS."moddb/infusion_db.php";
require_once INFUSIONS."moddb/inc/inc.functions.php";
require_once INFUSIONS."moddb/inc/inc.nav.php";

if (file_exists(INFUSIONS."moddb/locale/".LOCALESET."admin/admin.php")) {
	include INFUSIONS."moddb/locale/".LOCALESET."admin/admin.php";
} else {
	include INFUSIONS."moddb/locale/English/admin/admin.php";
}

$settings['mod_ratings_manage'] = 0;

$q_mod_cats = dbquery("SELECT * FROM ".DB_MOD_CATS." ORDER BY mod_cat_order");
if (dbrows($q_mod_cats) == 0) {
	opentable($locale['moddb400']);
	echo "<center>";
	echo $locale['moddb450']."<br />".$locale['moddb451']."<br /><br /><a href='cats.php".$aidlink."'>".$locale['moddb452']."</a>".$locale['moddb453'];
	echo "</center>\n";
	closetable();
} elseif (isset($_POST['btn_cancel'])) {
	redirect(FUSION_SELF.$aidlink);
} elseif (isset($_GET['action']) && $_GET['action'] == "download" && isset($_GET['mod_id']) && isnum($_GET['mod_id'])) {
	$data = dbquery("SELECT mod_download FROM ".DB_MODS." WHERE mod_id='".$_GET['mod_id']."'");
	if (dbrows($result)) {
		require_once INCLUDES."class.httpdownload.php";
		ob_end_clean();
		$data = dbarray($result);
		$object = new httpdownload;
		$object->set_byfile(BASEDIR.$mod_upload_dir.$data['mod_download']);
		$object->use_resume = true;
		$object->download();
		exit;
	}
} elseif (isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['mod_id']) && isnum($_GET['mod_id'])) {

  $data = dbarray(dbquery("SELECT * FROM ".DB_MODS." WHERE mod_id='".$_GET['mod_id']."'"));
  
  @unlink($mod_upload_dir.$data['mod_download']);
  @unlink($mod_upload_dir_img.$data['mod_screenshot']);
  @unlink($mod_upload_dir_img."t_".$data['mod_screenshot']);
  $result1 = dbquery("SELECT * FROM ".DB_MOD_TRANS." WHERE trans_mod='".$_GET['mod_id']."'");
   if (dbrows($result1)) {
			while ($data1 = dbarray($result1)) {
			@unlink($trans_upload_dir.$data1['trans_file']);
			$result = dbquery("DELETE FROM ".DB_MOD_TRANS." WHERE trans_id='".$data1['trans_id']."'");
			
			}
			}
  
  $result = dbquery("DELETE FROM ".DB_MODS." WHERE mod_id='".$_GET['mod_id']."'");
	$result = dbquery("DELETE FROM ".DB_COMMENTS." WHERE comment_type='M' AND comment_item_id='".$_GET['mod_id']."'");
	$result = dbquery("DELETE FROM ".DB_RATINGS." WHERE rating_type='M' AND rating_item_id='".$_GET['mod_id']."'");
	
	
	redirect(FUSION_SELF.$aidlink);
} elseif (isset($_GET['action']) && $_GET['action'] == "suspend" && isset($_GET['mod_id']) && isnum($_GET['mod_id'])) {
	$result = dbquery("UPDATE ".DB_MODS." SET mod_status='3' WHERE mod_id='".$_GET['mod_id']."'");
	redirect("..mod_view.php?mod_id=".$_GET['mod_id']);
} else {
	if (isset($_POST['btn_save'])) {
		$mod_name = stripinput($_POST['mod_name']);
		$mod_cat_id = stripinput($_POST['mod_cat_id']);
		$mod_modtype = stripinput($_POST['mod_modtype']);
		$mod_status_value = stripinput($_POST['mod_status']);
		$mod_description = stripinput($_POST['mod_description']);
		$mod_copyright = stripinput($_POST['mod_copyright']);
		$mod_version = stripinput($_POST['mod_version']);
		$version_id = stripinput($_POST['version_id']);
		$mod_submitter_name = stripinput($_POST['mod_submitter_name']);
		$mod_submitter_id = stripinput($_POST['mod_submitter_id']);
		$mod_forum_status = stripinput($_POST['mod_forum_status']);
		$mod_valid_xhtml = stripinput($_POST['mod_valid_xhtml']);
		$mod_valid_css = stripinput($_POST['mod_valid_css']);
		$mod_author_name = stripinput($_POST['mod_author_name']);
		$mod_co_author_name = stripinput($_POST['mod_co_author_name']);
		$mod_author_email = stripinput($_POST['mod_author_email']);
		$mod_author_www = stripinput($_POST['mod_author_www']);
		$mod_download_list = (isset($_POST['mod_download_list']) ? stripinput($_POST['mod_download_list']) : "");
		$mod_approved_user = stripinput($_POST['mod_approved_user']);
		$mod_approved_rating = stripinput($_POST['mod_approved_rating']);
		$mod_approved_comment = stripinput($_POST['mod_approved_comment']);
		$mod_date_t = explode(":",stripinput($_POST['mod_date_t']));
		$mod_date_hrs = $mod_date_t['0'];
		$mod_date_min = $mod_date_t['1'];
		$mod_date_sec = $mod_date_t['2'];
		$mod_screenshot = stripinput($_POST['mod_screenshot']);
		$mod_date = mktime($mod_date_hrs, $mod_date_min, $mod_date_sec, stripinput($_POST['mod_date_m']), stripinput($_POST['mod_date_d']), stripinput($_POST['mod_date_y']));
		if ($mod_name == "" || $mod_description == "" || $mod_version == "" || $mod_author_name == "") {
			$error = $locale['moddb482'];
		} elseif ($mod_author_email <> "" && !preg_match("/^[-0-9A-Z_\.]+@([-0-9A-Z_\.]+\.)+([0-9A-Z]){2,4}$/i", $mod_author_email)) {
			$error = $locale['moddb485'];
		} elseif (!empty($_POST['mod_id']) && isnum($_POST['mod_id']) && dbresult(dbquery("SELECT COUNT(*) FROM ".DB_MODS." WHERE mod_name='".$mod_name."' AND mod_version='".$mod_version."' AND mod_id<>'".$_POST['mod_id']."'"),0) != 0) {
			$error = $locale['moddb484'];
		} else {
			$mod_download_old = dbresult(dbquery("SELECT mod_download,mod_status FROM ".DB_MODS." WHERE mod_id='".$mod_id."'"),0);
			$mod_download = $mod_download_list;
			
			if ($_POST['action'] == "edit" && isnum($_POST['mod_id'])) {
				$result = dbquery(
					"UPDATE ".DB_MODS." SET 
						mod_cat_id='".$mod_cat_id."',
						mod_type='".$mod_modtype."',
						mod_status='".$mod_status_value."',
						mod_name='".$mod_name."',
						mod_description='".$mod_description."',
						mod_copyright='".$mod_copyright."',
						mod_version='".$mod_version."',
						version_id='".$version_id."',
						mod_valid_xhtml='".$mod_valid_xhtml."',
						mod_valid_css='".$mod_valid_css."',
						mod_author_name='".$mod_author_name."',
						mod_co_author_name='".$mod_co_author_name."',
						mod_author_email='".$mod_author_email."',
						mod_author_www='".$mod_author_www."',
						mod_date='".$mod_date."',
						mod_download='".$mod_download."',
						mod_approved_user='".$mod_approved_user."',
						mod_approved_rating='".$mod_approved_rating."',
						mod_approved_comment='".$mod_approved_comment."',
						mod_img='".$mod_screenshot."'
					WHERE mod_id='".$_POST['mod_id']."'"
				);
				$mod_id = $_POST['mod_id'];
				$mod_ed = 1;
				if($mod_download_old  != $mod_status_value){
          notify($mod_submitter_name, $mod_name.$locale['moddb460'].get_mod_status_mail($mod_status_value), $mod_name.$locale['moddb460'].get_mod_status_mail($mod_status_value).$locale['moddb461'].$mod_approved_comment);
        }
			} else {
				$result = dbquery(
					"INSERT INTO ".DB_MODS." VALUES(
						'',
						'".$mod_cat_id."',
						'".$mod_modtype."',
						'".$mod_status_value."',
						'".$mod_name."',
						'".$mod_description."',
						'".$mod_copyright."',
						'".$mod_version."',
						'".$version_id."',
						'".$mod_submitter_name."',
						'".$mod_submitter_id."',
						'".$mod_forum_status."',
						'".$mod_valid_xhtml."',
						'".$mod_valid_css."',
						'".$mod_author_name."',
						'".$mod_co_author_name."',
						'".$mod_author_email."',
						'".$mod_author_www."',
						'".$mod_date."',
						'".$mod_download."',
						'0',
						'".$mod_approved_user."',
						'".$mod_approved_rating."',
						'".$mod_approved_comment."',
						'0',
						'".$mod_screenshot."',
					)"
				);
				$mod_id = mysql_insert_id();
				$mod_ed = 0;
			}
			if (is_uploaded_file($_FILES['mod_download']['tmp_name'])) {
				if ($_FILES['mod_download']['size'] > $mod_upload_maxsize) {
					$error = sprintf($locale['moddb486'], $mod_upload_maxsize);
				}
				$ext_ok = false;
				foreach (array_keys($mod_upload_exts) as $mod_upload_ext) {
					if (stristr($_FILES['mod_download']['name'], $mod_upload_ext) == $mod_upload_ext) $ext_ok = true;
				}
				if ($ext_ok != true) {
					$error = sprintf($locale['moddb487'],implode(", ",array_keys($mod_upload_exts)));
				}
				if ($error == "") {
					if ($mod_ed  == 1) {

						@unlink($mod_upload_dir.$mod_download_old);
					}
					move_uploaded_file($_FILES['mod_download']['tmp_name'], $mod_upload_dir.$mod_download_old);
					chmod($mod_upload_dir.$mod_download_old, 0755);
					//chmod($mod_upload_dir.$mod_download_old, 0444); //Found the goblins! :D
					$result = dbquery(
						"UPDATE ".DB_MODS." SET 
							mod_download='".$mod_upload_dir.$mod_download_old."' 
						WHERE mod_id='".$mod_id."'
					");
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
                
               	if($mod_screenshot == ""){
                $upload_name = $mod_id;
                }else{
               	$upload_name = $mod_screenshot;
               	}
					      foreach (array_keys($mod_upload_exts_img) as $mod_upload_ext_img) {
                $upload_name = rtrim($upload_name, ".".$mod_upload_ext_img);
                }
                
                if ($mod_ed  == 1) {

							  @unlink($mod_upload_dir_img.$mod_screenshot);
                @unlink($mod_upload_dir_img."t_".$mod_screenshot);
                }
                move_uploaded_file($_FILES['mod_screen']['tmp_name'], $mod_upload_dir_img.$upload_name.$mod_ext_img);
     
                                
                require_once INCLUDES."photo_functions_include.php";
                $fileext = $mod_ext_img;
                if ($fileext == ".gif") { $filetype = 1;
                 } elseif ($fileext == ".jpg") { $filetype = 2;
                 } elseif ($fileext == ".png") { $filetype = 3;
                 } else { $filetype = false; }
                createthumbnail($filetype , $mod_upload_dir_img.$upload_name.$mod_ext_img, $mod_upload_dir_img."t_".$upload_name.$mod_ext_img, 200, 150);
                
                $result = dbquery("UPDATE ".DB_MODS." SET mod_img='".$upload_name.$mod_ext_img."' WHERE mod_id='".$mod_id."'");
                }
        }
			if ($error == "") redirect(FUSION_SELF.$aidlink."&amp;mod_cat_id=".$mod_cat_id);
		}
	}
	$mod_date_y = getdate();
	$mod_date_y = $mod_date_y['year'];
	if (isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['mod_id']) && isnum($_GET['mod_id'])) {
		$data = dbarray(dbquery("SELECT * FROM ".DB_MODS." WHERE mod_id='".$_GET['mod_id']."'"));
		$mod_id = $data['mod_id'];
		$mod_name = $data['mod_name'];
		$mod_cat_id = $data['mod_cat_id'];
		$mod_modtype = $data['mod_type'];
		$mod_status_value = $data['mod_status'];
		$mod_description = $data['mod_description'];
		$mod_copyright = $data['mod_copyright'];
		$mod_version = $data['mod_version'];
		$version_id = $data['version_id'];
		$mod_submitter_name = $data['mod_submitter_name'];
		$mod_submitter_id = $data['mod_submitter_id'];
		$mod_forum_status = $data['mod_forum_status'];
		$mod_valid_xhtml = $data['mod_valid_xhtml'];
		$mod_valid_css = $data['mod_valid_css'];
		$mod_author_name = $data['mod_author_name'];
		$mod_co_author_name = $data['mod_co_author_name'];
		$mod_author_email = $data['mod_author_email'];
		$mod_author_www = $data['mod_author_www'];
		$mod_download = $data['mod_download'];
		$mod_approved_user = $data['mod_approved_user'];
		$mod_approved_rating = $data['mod_approved_rating'];
		$mod_approved_comment = $data['mod_approved_comment'];
		$mod_screenshots  = $data['mod_img'];
		$mod_date = explode("-",date("d-m-Y",$data['mod_date']+($settings['timeoffset']*3600)));
		$mod_date_d = $mod_date['0'];
		$mod_date_m = $mod_date['1'];
		$mod_date_y = $mod_date['2'];
		$mod_date_t = date("H:i:s",$data['mod_date']+($settings['timeoffset']*3600));
		$mod_comments_count = dbresult(dbquery(
			"SELECT COUNT(*) 
			FROM ".DB_MODS." 
			JOIN ".DB_COMMENTS." ON mod_id = comment_item_id AND comment_type='M' 
			WHERE mod_id='".$_GET['mod_id']."'"
		),0);
		$mod_ratings_count = dbresult(dbquery(
			"SELECT COUNT(*) 
			FROM ".DB_MODS." 
			JOIN ".DB_RATINGS." ON mod_id = rating_item_id AND rating_type='M' 
			WHERE mod_id='".$_GET['mod_id']."'"
		),0);
	} elseif (!isset($error) || empty($error)) {
		$mod_id = 0;
		$mod_name = "";
		$mod_cat_id = "";
		$mod_modtype = 0;
		$mod_status_value = 0;
		$mod_description = "";
		$mod_copyright = "";
		$mod_version = "";
		$version_id = 0;
		$mod_submitter_name = "";
		$mod_submitter_id = "";
		$mod_forum_status = "";
		$mod_valid_xhtml = "";
		$mod_valid_css = "";
		$mod_author_name = $userdata['user_name'];
		$mod_co_author_name = "";
		$mod_author_email = $userdata['user_email'];
		$mod_author_www = $userdata['user_web'];
		$mod_download = "";
		$mod_approved_user = 0;
		$mod_approved_rating = 3;
		$mod_approved_comment = "";
		$mod_date_d = 0;
		$mod_date_m = 0;
		$mod_date_t = "00:00:00";
		$mod_comments_count = 0;
		$mod_ratings_count = 0;
		$mod_downloads_count = 0;
		$mod_screenshots = "";
	} else {
		$mod_date_t = stripinput($_POST['mod_date_t']);
		$mod_date_d = stripinput($_POST['mod_date_d']);
	}
	$cat_list = "";
	while ($d_mod_cats = dbarray($q_mod_cats)) {
		$sel = ($mod_cat_id == $d_mod_cats['mod_cat_id'] ? " selected='selected'" : "");
		$cat_list .= "<option value='".$d_mod_cats['mod_cat_id']."'$sel>".$d_mod_cats['mod_cat_name']."</option>\n";
	}
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
	for ($i=1; $i<count($months); $i++) {
		$month_list .= "<option value='".$i."'".($i == $mod_date_m ? " selected" : "").">".$months[$i]."</option>\n";
	}
	$day_list = "";
	for ($i=1; $i<32; $i++) {
		$day_list .= "<option value='".$i."'".($i == $mod_date_d ? " selected" : "").">".$i."</option>\n";
	}
	$dld_list = makefilelist($mod_upload_dir, ".|..|index.php", true);
	$mod_download_list = makefileopts($dld_list, $mod_download);
	$mod_status_list = "";
	foreach ($mod_status as $k=>$mod_status_name) {
		$mod_status_list .= "<option value='".$k."'".($mod_status_value == $k ? " selected='selected'" : "").">".$mod_status_name."</option>\n";
	}
	opentable(isset($_GER['action']) && $_GET['action'] == "edit" ? $locale['moddb426'] : $locale['moddb425']);
	echo "<form name='add_mod' method='post' action='".FUSION_SELF.$aidlink."' enctype='multipart/form-data'>\n";
	echo "<input type='hidden' name='action' value='".(isset($_GET['action']) ? $_GET['action'] : "")."'>\n";
	echo "<input type='hidden' name='mod_id' value='".(isset($_GET['mod_id']) ? $_GET['mod_id'] : "")."'>\n";
	echo "<table align='center' cellpadding='0' cellspacing='0' class='body'>\n";
	echo "".(isset($error) ? "<tr><td class='tbl1 error' align='center' colspan='3'>".$error."</td></tr>" : "")."\n";
	echo "<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb402'].":</td>\n";
	echo "<td class='tbl1' nowrap><span class='error'>*</span></td>\n";
	echo "<td class='tbl1'><input type='text' class='textbox' name='mod_name' value='".$mod_name."' style='width:300px;'></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb403'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><select class='textbox' name='mod_cat_id' style='width:300px;'>".$cat_list."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb416'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><select class='textbox' name='mod_modtype' style='width:300px;'>".$mod_type_list."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap valign='top'>".$locale['moddb404'].":</td>\n";
	echo "<td class='tbl1' nowrap valign='top'><span class='error'>*</span></td>\n";
	echo "<td class='tbl1'><textarea class='textbox' name='mod_description' style='width:300px; height:100px;'>".$mod_description."</textarea></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap valign='top'>".$locale['moddb406'].":</td>\n";
	echo "<td class='tbl1' nowrap valign='top'>&nbsp;</td>\n";
	echo "<td class='tbl1'><textarea class='textbox' name='mod_copyright' style='width:300px; height:40px;'>".$mod_copyright."</textarea></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb407']."</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'>\n";
	echo "<select name='mod_date_d' class='textbox'>$day_list</select>&nbsp;\n";
	echo "<select name='mod_date_m' class='textbox'>$month_list</select>&nbsp;\n";
	echo "<input type='text' class='textbox' name='mod_date_y' value='".$mod_date_y."' style='width:40px;' />&nbsp;\n";
	echo "<input type='text' class='textbox' name='mod_date_t' value='".$mod_date_t."' style='width:63px;' />\n";
	echo "</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb408'].":</td>\n";
	echo "<td class='tbl1' nowrap><span class='error'>*</span></td>\n";
	echo "<td class='tbl1'><input type='text' class='textbox' name='mod_version' value='".$mod_version."' style='width:150px;'></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb409'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><select class='textbox' name='version_id' style='width:150px;'>".buildversionoptionlist($version_id)."</td>\n";
	echo "</tr>\n";
	if ($mod_comments_count > 0) {
		echo "<tr>\n";
		echo "<td class='tbl1' nowrap>".$locale['moddb429'].":</td>\n";
		echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
		echo "<td class='tbl1'>(".$mod_comments_count.") <a href='".ADMIN."comments.php".$aidlink."&ctype=M&amp;cid=".$mod_id."' target='_blank' title='".$locale['moddb507']."'>".$locale['moddb431']."</a></td>\n";
		echo "</tr>\n";
	}
	if (($mod_ratings_count > 0) && ($settings['mod_ratings_manage'] == 1)) {
		echo "<tr>\n";
		echo "<td class='tbl1' nowrap>".$locale['moddb430'].":</td>\n";
		echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
		echo "<td class='tbl1'>(".$mod_ratings_count.") <a href='ratings.php?mod_id=".$mod_id."' target='_blank' title='".$locale['moddb508']."'>".$locale['moddb431']."</a></td>\n";
		echo "</tr>\n";
	}
	echo "<tr>\n";
	echo "<td class='tbl1' nowrap colspan='3'><hr></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb410'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><select class='textbox' name='mod_download_list' style='width:300px;'>".$mod_download_list."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb411'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><input type='file' class='textbox' name='mod_download' size='43' style='width:300px;'></td>\n";
	echo "</tr>\n<tr>\n";
		echo "<td class='tbl1' nowrap>".$locale['moddb412'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><span class='small'>".substr($mod_upload_dir.$mod_download,6)."</span></td>\n";
	echo "</tr>\n";
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
			<td class='tbl1'><input type='hidden' name='mod_screenshot' value='".$mod_screenshots."' ><input type='file' class='textbox' name='mod_screen' size='43' style='width:300px;'></td>
			</tr>
			<tr>
			<td class='tbl1' nowrap>".$locale['moddb448'].":</td>
			<td class='tbl1' nowrap>&nbsp;</td>
			<td class='tbl1'><span class='small'><a href='".INFUSIONS."moddb/img/screenshots/$mod_screenshots' rel='lightbox'>".substr($mod_upload_dir_img.$mod_screenshots,6)."</a></span></td>
			</tr>
			\n";

	if (isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['mod_id']) && isnum($_GET['mod_id'])) {
		echo "</tr>\n<tr>\n";
	}
	echo "<tr><td class='tbl1' nowrap colspan='3'><hr></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb413'].":</td>\n";
	echo "<td class='tbl1' nowrap><span class='error'>*</span></td>\n";
	echo "<td class='tbl1'><input type='text' class='textbox' name='mod_author_name' value='".$mod_author_name."' style='width:300px;'></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb413c'].":</td>\n";
	echo "<td class='tbl1' nowrap><span class='error'>&nbsp;</span></td>\n";
	echo "<td class='tbl1'><input type='text' class='textbox' name='mod_co_author_name' value='".$mod_co_author_name."' style='width:300px;'></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb414'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><input type='text' class='textbox' name='mod_author_email' value='".$mod_author_email."' style='width:300px;'></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb415'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><input type='text' class='textbox' name='mod_author_www' value='".$mod_author_www."' style='width:300px;'></td>\n";
	echo "</tr>\n<tr>\n";
    echo "<td class='tbl1' nowrap>".$locale['moddb458'].":</td>";
	echo "<td class='tbl1' nowrap>&nbsp;</td>";
    if ($mod_submitter_name) {
	echo "<td class='tbl1'><input type='hidden' class='textbox' name='mod_submitter_name' value='".$mod_submitter_name."' style='width:300px;'><a href='".BASEDIR."profile.php?lookup=$mod_submitter_id'>".$mod_submitter_name."<input type='hidden' class='textbox' name='mod_submitter_id' value='".$mod_submitter_id."'></td>"; } else {
	echo "<td class='tbl1'><input type='hidden' class='textbox' name='mod_submitter_name' value='".$userdata['user_name']."' style='width:300px;'><a href='".BASEDIR."profile.php?lookup=".$userdata['user_id']."'>".$userdata['user_name']."<input type='hidden' class='textbox' name='mod_submitter_id' value='".$userdata['user_id']."'></td>"; }
	echo "</tr>\n<tr>\n";

				if ($mod_forum_status == 0) { $thread_create = "".$locale['moddb459y'].""; } elseif ($mod_forum_status == 1) { $thread_create = "".$locale['moddb459n'].""; } elseif ($mod_forum_status == 2) { $thread_create = "".$locale['moddb459x'].""; }
    echo "<td class='tbl1' nowrap>".$locale['moddb459']."</td>";
	echo "<td class='tbl1' nowrap>&nbsp;</td><td class='tbl1'><input type='hidden' class='textbox' name='mod_forum_status' value='".$mod_forum_status."'>".$thread_create."</td>\n";
	echo "</tr>\n<tr>\n";
	
	echo "<td class='tbl1' nowrap>".$locale['moddb459v'].":</td>";
	echo "<td class='tbl1' nowrap>&nbsp;</td><td class='tbl1'><select name='mod_valid_xhtml' class='textbox'>\n";
	echo "<option value='0'".($mod_valid_xhtml == "0" ? " selected='selected'" : "").">".$locale['moddb459n']."</option>\n";
	echo "<option value='1'".($mod_valid_xhtml == "1" ? " selected='selected'" : "").">".$locale['moddb459y']."</option></select></td>";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb459c'].":</td>";
	echo "<td class='tbl1' nowrap>&nbsp;</td><td class='tbl1'><select name='mod_valid_css' class='textbox'>\n";
	echo "<option value='0'".($mod_valid_css == "0" ? " selected='selected'" : "").">".$locale['moddb459n']."</option>\n";
	echo "<option value='1'".($mod_valid_css == "1" ? " selected='selected'" : "").">".$locale['moddb459y']."</option></select></td>";
	
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap colspan='3'><hr></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb442'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><select class='textbox' name='mod_status' style='width:300px;'>".$mod_status_list."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb417'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'>";
	$result = dbquery("SELECT user_id, user_name FROM ".DB_USERS." WHERE user_id =".$mod_approved_user."");
     if (dbrows($result) != 0) {
        $dataa=dbarray($result);
    echo $dataa['user_name']; }
    echo "<input type='hidden' class='textbox' name='mod_approved_user' value='".$mod_approved_user."'>";
	echo "</td>";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap>".$locale['moddb418'].":</td>\n";
	echo "<td class='tbl1' nowrap>&nbsp;</td>\n";
	echo "<td class='tbl1'><select class='textbox' name='mod_approved_rating' style='width:300px;'>".$mod_approved_rating_list."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap valign='top'>".$locale['moddb419'].":</td>\n";
	echo "<td class='tbl1' nowrap valign='top'>&nbsp;</td>\n";
	echo "<td class='tbl1'><textarea class='textbox' name='mod_approved_comment' style='width:300px; height:48px;'>".$mod_approved_comment."</textarea></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap colspan='3' align='center'><hr>".$locale['moddb437']."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' nowrap colspan='3' align='center'><input type='submit' class='button' name='btn_save' value='".$locale['moddb427']."'>\n";
	if ((isset($_GET['action']) && $_GET['action'] == "edit") || isset($error)) {
		echo "&nbsp;<input type='submit' name='btn_cancel' value='".$locale['moddb428']."' class='button'>";
	}
	echo "</td>\n";
	echo "</tr>\n</table>\n</form>\n";
	closetable();

	opentable($locale['moddb400']);
	echo "<table width='400' align='center' cellpadding='0' cellspacing='1' class='tbl-border'>
	<tr>
	<td class='forum-caption'>".$locale['moddb402']."</td>
	<td class='forum-caption' align='right'>".$locale['moddb420']."</td>
	</tr>
	<tr>
	<td class='tbl1' colspan='2'></td>
	</tr>\n";
		$c = 0;
		while ($d_mod_cats = dbarray($q_mod_cats)) {
			$p_img = "on";
			$div = "style='display:none'";
			echo "<tr>
	<td class='tbl2'>".$d_mod_cats['mod_cat_name']." <span class='small2'>(".getgroupname($d_mod_cats['mod_cat_access'])."+)</span></td>
	<td class='tbl2' align='right'><img onclick=\"javascript:flipBox('".$d_mod_cats['mod_cat_id']."')\" name='b_".$d_mod_cats['mod_cat_id']."' border='0' src='".THEME."images/panel_".$p_img.".gif'></td>
	</tr>\n";
			$q_mods = dbquery("SELECT * FROM ".DB_MODS." WHERE mod_cat_id='".$d_mod_cats['mod_cat_id']."' AND mod_status='0' ORDER BY mod_name");
			if (dbrows($q_mods) != 0) {
				echo "<tr>
	<td class='tbl1' colspan='2'>
	<div id='box_".$d_mod_cats['mod_cat_id']."'".$div.">
	<table width='100%' cellpadding='0' cellspacing='0' class='tbl-border'>";
				while ($d_mods = dbarray($q_mods)) {
					echo "<tr class='tbl1'>
	<td class='tbl1' width='*' nowrap><a href='../mod_view.php?mod_cat_id=".$d_mod_cats['mod_cat_id']."&mod_id=".$d_mods['mod_id']."' target='_blank' title='".$locale['moddb506']."'>".$d_mods['mod_name']."</a></td>
	<td class='tbl1' width='1%' nowrap><span class='small'><a href='submissions.php".$aidlink."&tran=".$d_mods['mod_id']."' title='".$locale['moddb449']."'>".$locale['moddb457']."</a>&nbsp;-&nbsp;<a href='".FUSION_SELF.$aidlink."&amp;action=delete&mod_cat_id=".$d_mod_cats['mod_cat_id']."&mod_id=".$d_mods['mod_id']."' onClick=\"return confirmDeleteMOD('".$d_mods['mod_name']."')\" title='".$locale['moddb505']."'>".$locale['moddb422']."</a>&nbsp;-&nbsp;<a href='".FUSION_SELF.$aidlink."&amp;action=edit&mod_cat_id=".$d_mod_cats['mod_cat_id']."&mod_id=".$d_mods['mod_id']."' title='".$locale['moddb504']."'>".$locale['moddb421']."</a></span></td>
	</tr>\n";
				}
				echo "</table>
	</div>
	</td>
	</tr>\n";
			} else {
				echo "<tr>
	<td class='tbl1' colspan='2'>
	<div id='box_".$d_mod_cats['mod_cat_id']."'".$div.">
	<table width='100%' cellpadding='0' cellspacing='0'><tr><td class='tbl1'>".$locale['moddb423']."</td></tr></table>
	</div>
	</td>
	</tr>\n";
		}
		$c++;
	}
	echo "</table>\n";
	closetable();
	$inactive_mods = dbquery("SELECT * FROM ".DB_MODS." WHERE mod_status!='0' ORDER BY mod_name");
	if (dbrows($inactive_mods) != 0) {

		opentable($locale['moddb443']);
		echo "<table width='400' align='center' cellpadding='0' cellspacing='1' class='tbl-border'>
		<tr>
		<td class='forum-caption'>".$locale['moddb402']."</td>
		<td class='forum-caption' align='right'>".$locale['moddb420']."</td>
		</tr>
		<tr>
		<td class='tbl1' colspan='2'></td>
		</tr>\n";
		while ($mod_data = dbarray($inactive_mods)) {
			echo "<tr class='tbl1'>
			<td class='tbl1' width='*' nowrap><a href='../view.php?mod_id=".$mod_data['mod_id']."' target='_blank' title='".$locale['moddb506']."'>".$mod_data['mod_name']."</a></td>
			<td class='tbl1' width='1%' nowrap><span class='small'>
			<a href='".FUSION_SELF.$aidlink."&amp;action=delete&mod_id=".$mod_data['mod_id']."' onClick=\"return confirmDeleteMOD('".$mod_data['mod_name']."')\" title='".$locale['moddb505']."'>".$locale['moddb422']."</a> - 
			<a href='".FUSION_SELF.$aidlink."&amp;action=edit&mod_id=".$mod_data['mod_id']."' title='".$locale['moddb504']."'>".$locale['moddb421']."</a> - 
			".get_mod_status($mod_data['mod_status'])."</span></td>
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
	function confirmDeleteMOD(mod_name) {
		return confirm('".$locale['moddb424']."\''+mod_name+'\'');
	}
	</script>\n";
}

require_once THEMES."templates/footer.php";
?>