<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: error.php
| Author: PHP-Fusion Addons & Infusions Team
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

require_once INFUSIONS."addondb/inc/inc.functions.php";
require_once INFUSIONS."addondb/infusion_db.php";

include INFUSIONS."addondb/locale/".LOCALESET."submit_error.php";


if (!iMEMBER) {
	opentable($locale['addondb450']);
	echo "<center><br />".$locale['addondb451']."<br /><br /></center>\n";
	closetable();
}else{
if (isset($_GET['error']) && isset($_GET['addon_id']) && isnum($_GET['addon_id'])) {
	
    If($_GET['error'] == 1){
      
      if (!isset($_POST['post_gen'])){
      
        opentable($locale['addondb420']);
        echo "<div align='center'><form name='error' method='post' action='".FUSION_SELF."?error=1&addon_id=".$_GET['addon_id']."' >
        <table cellpadding='0' cellspacing='0' class='center'>
        <tr>
        <td class='tbl1' valign='top' nowrap>".$locale['addondb421'].":</td>
        <td class='tbl1'><textarea class='textbox' name='post_gen' style='width:300px; height:100px;'></textarea></td>
        </tr>
        <tr>
        <td></td>
        <td>
        <input type='submit' name='vonra' value='".$locale['addondb413']."' class='button' />
        <td>
        </tr>
        </table>
        </form></div>
        ";
        closetable(); 
      
      }else{
        $e_inst = dbquery("INSERT INTO ".DB_ADDON_ERRORS." VALUES('', '".$_GET['addon_id']."', '1', '1', '".$userdata['user_id']."', '".stripinput($_POST['post_gen'])."', '".time()."','')");
        opentable($locale['addondb420']);
        echo "<center><br />".$locale['addondb422']."<br /><br /></center>\n";
        echo "<center><br><br><a href='index.php'>".$locale['addondb455']."</a><br><br></center>";
        closetable();      
      
      }
    
    }elseif($_GET['error'] == 2){
      if (!isset($_POST['post_vun'])){
      
        opentable($locale['addondb410']);
        echo "<div align='center'><form name='error' method='post' action='".FUSION_SELF."?error=2&addon_id=".$_GET['addon_id']."' >
        <table cellpadding='0' cellspacing='0' class='center'>
        <tr>
        <td class='tbl1' valign='top' nowrap>".$locale['addondb411'].":</td>
        <td class='tbl1'><textarea class='textbox' name='post_vun' style='width:300px; height:100px;'></textarea></td>
        </tr>
        <tr>
        <td></td>
        <td>
        <input type='submit' name='vonra' value='".$locale['addondb413']."' class='button' />
        <td>
        </tr>
        </table>
        </form></div>
        ";
        closetable(); 
      
      }else{
        $e_inst = dbquery("INSERT INTO ".DB_ADDON_ERRORS." VALUES('', '".$_GET['addon_id']."', '2', '1', '".$userdata['user_id']."', '".stripinput($_POST['post_vun'])."', '".time()."','')");
        opentable($locale['addondb410']);
        echo "<center><br />".$locale['addondb412']."<br /><br /></center>\n";
        echo "<center><br><br><a href='index.php'>".$locale['addondb455']."</a><br><br></center>";
        closetable();      
      
      }
    
    }elseif($_GET['error'] == 3){
      $e_mod = dbquery("SELECT * FROM ".DB_ADDON_ERRORS." WHERE error_mod='".$_GET['addon_id']."' AND error_type ='3' AND error_active ='1' ");
      if (dbrows($e_mod)) {
        opentable($locale['addondb400']);
        echo "<center><br />".$locale['addondb401']."<br /><br /></center>\n";
        echo "<center><br><br><a href='index.php'>".$locale['addondb455']."</a><br><br></center>";
        closetable();
      }else{
        $e_inst = dbquery("INSERT INTO ".DB_ADDON_ERRORS." VALUES('', '".$_GET['addon_id']."', '3', '1', '".$userdata['user_id']."', '', '".time()."','')");
        opentable($locale['addondb400']);
        echo "<center><br />".$locale['addondb402']."<br /><br /></center>\n";
        echo "<center><br><br><a href='index.php'>".$locale['addondb455']."</a><br><br></center>";
        closetable();
      }

    }elseif($_GET['error'] == 4){
      
        if (!isset($_POST['vonra'])){
          opentable($locale['addondb470']);
          $lang = "";
          for ($i=1;$i <= get_addon_language(0);$i++) {
            $lang .= "<option value='".$i."'".($data['trans_type'] == $i ? " selected" : "").">".get_addon_language($i)."</option>\n";
          }
          echo "<div align='center'><form name='error' method='post' action='".FUSION_SELF."?error=4&addon_id=".$_GET['addon_id']."' enctype='multipart/form-data' >
          <table cellpadding='0' cellspacing='0' class='center'>
          <tr>
          <td class='tbl1' nowrap>".$locale['addondb476'].":</td>
          <td class='tbl1'><select class='textbox' name='lang' style='width:300px;'>".$lang."</select></td>
          </tr>
          <tr>
          <td class='tbl1' valign='top' nowrap>".$locale['addondb471'].":</td>
          <td class='tbl1'><input type='file' class='textbox' name='addon_download' size='43' style='width:300px;'></td>
          </tr>
          <tr>
          <td></td>
          <td>
          <input type='submit' name='vonra' value='".$locale['addondb477']."' class='button' />
          <td>
          </tr>
          </table>
          </form></div>
          <br /><div align='center'><img src='".INFUSIONS."addondb/img/translate.png' width='37' alt ='' /> <a href='".INFUSIONS."addondb/translation_guidelines.php' title=''>".$locale['addondb478']."</a></a></div>
          ";
          closetable();
        }elseif(isnum($_POST['lang'])){
          $addon_ext = "";
          $error = "";
          $upload_name = $_GET['addon_id']."_".time();
          if (is_uploaded_file($_FILES['addon_download']['tmp_name'])) {
            if ($_FILES['addon_download']['size'] > $trans_upload_maxsize) {
              $error = sprintf($locale['addondb474'], $trans_upload_maxsize);
            }
            foreach (array_keys($trans_upload_exts) as $addon_upload_ext) {
              if (stristr($_FILES['addon_download']['name'], $addon_upload_ext) == $addon_upload_ext) $addon_ext = $addon_upload_ext;
            }
            if ($addon_ext != "") {
             $addon_ext = ".".$addon_ext;
            } else {
            $error = sprintf($locale['addondb475'],implode(", ",array_keys($trans_upload_exts)));
            }
						
            if ($error == "") {
              move_uploaded_file($_FILES['addon_download']['tmp_name'], $trans_upload_dir.$upload_name.$addon_ext);
              $result = dbquery("SELECT * FROM ".DB_ADDONS." WHERE addon_id='".$_GET['addon_id']."'");
              if (dbrows($result)) {
                while ($data = dbarray($result)) {
                  $e_inst = dbquery("INSERT INTO ".DB_ADDON_TRANS." VALUES('', '".$_GET['addon_id']."', '".$data['addon_name']."', '1', '".$_POST['lang']."', '".$userdata['user_id']."', '".time()."', '".$upload_name.$addon_ext."', '', '')");
                }
              }
              opentable($locale['addondb470']);
              echo "<center><br />".$locale['addondb472']."<br /><br /></center>\n";
              echo "<center><br><br><a href='index.php'>".$locale['addondb455']."</a><br><br></center>";
              closetable();
			
            }else{
              opentable($locale['addondb470']);
              echo "<center><br />".$error."<br /><br /></center>\n";
              echo "<center><br><br><a href='index.php'>".$locale['addondb455']."</a><br><br></center>";
              closetable();
           
            }   
              
    
        }
      }
  
      
    }else{
    	opentable($locale['addondb450']);
      echo "<center><br />".$locale['addondb452']."<br /><br /></center>\n";
      echo "<center><br><br><a href='index.php'>".$locale['addondb455']."</a><br><br></center>";
      closetable();
    }
	
	}else{
	opentable($locale['addondb450']);
	echo "<center><br />".$locale['addondb452']."<br /><br /></center>\n";
	echo "<center><br><br><a href='index.php'>".$locale['addondb455']."</a><br><br></center>";
	closetable();
	}
}
require_once THEMES."templates/footer.php";
?>