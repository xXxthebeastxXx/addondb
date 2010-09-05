<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: submit_mod.php
| Author: Luben Kirov (sharky)
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

require_once INFUSIONS."moddb/inc/inc.functions.php";
require_once INFUSIONS."moddb/infusion_db.php";

include INFUSIONS."moddb/locale/".LOCALESET."submit_error.php";


if (!iMEMBER) {
	opentable($locale['moddb450']);
	echo "<center><br />".$locale['moddb451']."<br /><br /></center>\n";
	closetable();
}else{
if (isset($_GET['error']) && isset($_GET['mod_id']) && isnum($_GET['mod_id'])) {
	
    If($_GET['error'] == 1){
      
      if (!isset($_POST['post_gen'])){
      
        opentable($locale['moddb420']);
        echo "<div align='center'><form name='error' method='post' action='".FUSION_SELF."?error=1&mod_id=".$_GET['mod_id']."' >
        <table cellpadding='0' cellspacing='0' class='center'>
        <tr>
        <td class='tbl1' valign='top' nowrap>".$locale['moddb421'].":</td>
        <td class='tbl1'><textarea class='textbox' name='post_gen' style='width:300px; height:100px;'></textarea></td>
        </tr>
        <tr>
        <td></td>
        <td>
        <input type='submit' name='vonra' value='".$locale['moddb413']."' class='button' />
        <td>
        </tr>
        </table>
        </form></div>
        ";
        closetable(); 
      
      }else{
        $e_inst = dbquery("INSERT INTO ".DB_MOD_ERRORS." VALUES('', '".$_GET['mod_id']."', '1', '1', '".$userdata['user_id']."', '".stripinput($_POST['post_gen'])."', '".time()."','')");
        opentable($locale['moddb420']);
        echo "<center><br />".$locale['moddb422']."<br /><br /></center>\n";
        echo "<center><br><br><a href='index.php'>".$locale['moddb455']."</a><br><br></center>";
        closetable();      
      
      }
    
    }elseif($_GET['error'] == 2){
      if (!isset($_POST['post_vun'])){
      
        opentable($locale['moddb410']);
        echo "<div align='center'><form name='error' method='post' action='".FUSION_SELF."?error=2&mod_id=".$_GET['mod_id']."' >
        <table cellpadding='0' cellspacing='0' class='center'>
        <tr>
        <td class='tbl1' valign='top' nowrap>".$locale['moddb411'].":</td>
        <td class='tbl1'><textarea class='textbox' name='post_vun' style='width:300px; height:100px;'></textarea></td>
        </tr>
        <tr>
        <td></td>
        <td>
        <input type='submit' name='vonra' value='".$locale['moddb413']."' class='button' />
        <td>
        </tr>
        </table>
        </form></div>
        ";
        closetable(); 
      
      }else{
        $e_inst = dbquery("INSERT INTO ".DB_MOD_ERRORS." VALUES('', '".$_GET['mod_id']."', '2', '1', '".$userdata['user_id']."', '".stripinput($_POST['post_vun'])."', '".time()."','')");
        opentable($locale['moddb410']);
        echo "<center><br />".$locale['moddb412']."<br /><br /></center>\n";
        echo "<center><br><br><a href='index.php'>".$locale['moddb455']."</a><br><br></center>";
        closetable();      
      
      }
    
    }elseif($_GET['error'] == 3){
      $e_mod = dbquery("SELECT * FROM ".DB_MOD_ERRORS." WHERE error_mod='".$_GET['mod_id']."' AND error_type ='3' AND error_active ='1' ");
      if (dbrows($e_mod)) {
        opentable($locale['moddb400']);
        echo "<center><br />".$locale['moddb401']."<br /><br /></center>\n";
        echo "<center><br><br><a href='index.php'>".$locale['moddb455']."</a><br><br></center>";
        closetable();
      }else{
        $e_inst = dbquery("INSERT INTO ".DB_MOD_ERRORS." VALUES('', '".$_GET['mod_id']."', '3', '1', '".$userdata['user_id']."', '', '".time()."','')");
        opentable($locale['moddb400']);
        echo "<center><br />".$locale['moddb402']."<br /><br /></center>\n";
        echo "<center><br><br><a href='index.php'>".$locale['moddb455']."</a><br><br></center>";
        closetable();
      }

    }elseif($_GET['error'] == 4){
      
        if (!isset($_POST['vonra'])){
          opentable($locale['moddb470']);
          $lang = "";
          for ($i=1;$i <= get_mod_language(0);$i++) {
            $lang .= "<option value='".$i."'".($data['trans_type'] == $i ? " selected" : "").">".get_mod_language($i)."</option>\n";
          }
          echo "<div align='center'><form name='error' method='post' action='".FUSION_SELF."?error=4&mod_id=".$_GET['mod_id']."' enctype='multipart/form-data' >
          <table cellpadding='0' cellspacing='0' class='center'>
          <tr>
          <td class='tbl1' nowrap>".$locale['moddb476'].":</td>
          <td class='tbl1'><select class='textbox' name='lang' style='width:300px;'>".$lang."</select></td>
          </tr>
          <tr>
          <td class='tbl1' valign='top' nowrap>".$locale['moddb471'].":</td>
          <td class='tbl1'><input type='file' class='textbox' name='mod_download' size='43' style='width:300px;'></td>
          </tr>
          <tr>
          <td></td>
          <td>
          <input type='submit' name='vonra' value='".$locale['moddb477']."' class='button' />
          <td>
          </tr>
          </table>
          </form></div>
          <br /><div align='center'><img src='".INFUSIONS."moddb/img/translate.png' width=37' alt ='' /> <a href='".INFUSIONS."moddb/translation_guidelines.php' title=''>".$locale['moddb478']."</a></a></div>
          ";
          closetable();
        }elseif(isnum($_POST['lang'])){
          $mod_ext = "";
          $error = "";
          $upload_name = $_GET['mod_id']."_".time();
          if (is_uploaded_file($_FILES['mod_download']['tmp_name'])) {
            if ($_FILES['mod_download']['size'] > $trans_upload_maxsize) {
              $error = sprintf($locale['moddb474'], $trans_upload_maxsize);
            }
            foreach (array_keys($trans_upload_exts) as $mod_upload_ext) {
              if (stristr($_FILES['mod_download']['name'], $mod_upload_ext) == $mod_upload_ext) $mod_ext = $mod_upload_ext;
            }
            if ($mod_ext != "") {
             $mod_ext = ".".$mod_ext;
            } else {
            $error = sprintf($locale['moddb475'],implode(", ",array_keys($trans_upload_exts)));
            }
						
            if ($error == "") {
              move_uploaded_file($_FILES['mod_download']['tmp_name'], $trans_upload_dir.$upload_name.$mod_ext);
              $result = dbquery("SELECT * FROM ".DB_MODS." WHERE mod_id='".$_GET['mod_id']."'");
              if (dbrows($result)) {
                while ($data = dbarray($result)) {
                  $e_inst = dbquery("INSERT INTO ".DB_MOD_TRANS." VALUES('', '".$_GET['mod_id']."', '".$data['mod_name']."', '1', '".$_POST['lang']."', '".$userdata['user_id']."', '".time()."', '".$upload_name.$mod_ext."', '', '')");
                }
              }
              opentable($locale['moddb470']);
              echo "<center><br />".$locale['moddb472']."<br /><br /></center>\n";
              echo "<center><br><br><a href='index.php'>".$locale['moddb455']."</a><br><br></center>";
              closetable();
			
            }else{
              opentable($locale['moddb470']);
              echo "<center><br />".$error."<br /><br /></center>\n";
              echo "<center><br><br><a href='index.php'>".$locale['moddb455']."</a><br><br></center>";
              closetable();
           
            }   
              
    
        }
      }
  
      
    }else{
    	opentable($locale['moddb450']);
      echo "<center><br />".$locale['moddb452']."<br /><br /></center>\n";
      echo "<center><br><br><a href='index.php'>".$locale['moddb455']."</a><br><br></center>";
      closetable();
    }
	
	}else{
	opentable($locale['moddb450']);
	echo "<center><br />".$locale['moddb452']."<br /><br /></center>\n";
	echo "<center><br><br><a href='index.php'>".$locale['moddb455']."</a><br><br></center>";
	closetable();
	}
}
require_once THEMES."templates/footer.php";
?>