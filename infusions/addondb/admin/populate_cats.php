<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: populate.php
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

  $check_installed = dbarray(dbquery("SELECT inf_version FROM ".DB_INFUSIONS." WHERE inf_folder = 'addondb'"));

require_once ADDON_INC."inc.nav.php";
opentable("Install Categories and Versions");

echo "<div style='text-align:center'><br />\n";
echo "<form name='upgradeform' method='post' action='".FUSION_SELF.$aidlink."'>\n";

if (str_replace(".", "", $check_installed['inf_version']) != "0") {
	if (!isset($_POST['stage'])) {
		echo "Populate PHP-Fusion AddonDB with default settings for Addon Categories and PHP-Fusion Versions<br /><br />\n";
		echo "<input type='hidden' name='stage' value='2'>\n";

	  // Check for already installed categories
	   $install_check = dbcount("(addon_cat_id)", DB_ADDON_CATS);
	   if ($install_check > '0')  { echo "<b>Categories are already installed.</b>"; } 
	   elseif ($install_check == '0') { 
	   echo "<input type='submit' name='upgrade' value='Populate AddonDB' class='button'><br /><br />\n"; }
	   } elseif (isset($_POST['upgrade']) && isset($_POST['stage']) && $_POST['stage'] == 2) {
	

        // Populate Cats
        // Infusions
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('1', 'Miscellaneous', '', '0', '1')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('1', 'News and Feeds', '', '0', '2')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('1', 'Admin and Site Settings', '', '0', '3')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('1', 'Photogallery &amp; Video', '', '0', '4')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('1', 'Articles', '', '0', '5')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('1', 'PM &amp; Chat', '', '0', '6')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('1', 'Forum', '', '0', '7')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('1', 'Fun &amp; Games', '', '0', '8')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('1', 'Poll &amp; Shout', '', '0', '9')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('1', 'Uploads &amp; Downloads', '', '0', '10')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('1', 'Web Links &amp; Advertising', '', '0', '11')");
        
        // Themes
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('2', 'Simple', '', '0', '1')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('2', 'Futuristic', '', '0', '2')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('2', 'Sport', '', '0', '3')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('2', 'Fantasy/Modern', '', '0', '4')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('2', 'Holiday/Events', '', '0', '5')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('2', 'Nature', '', '0', '6')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('2', 'Games', '', '0', '7')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('2', 'Movies', '', '0', '8')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('2', 'Stylish', '', '0', '9')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('2', 'Music', '', '0', '10')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('2', 'Kids', '', '0', '11')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('2', 'Abstract', '', '0', '12')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('2', 'Miscellaneous', '', '0', '13')");
        
        //Panels
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('3', 'Miscellaneous', '', '0', '1')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('3', 'News and Feeds', '', '0', '2')");       
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('3', 'Admin and Site Settings', '', '0', '3')");     
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('3', 'Photogallery &amp; Video', '', '0', '4')");              
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('3', 'Articles', '', '0', '5')");            
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('3', 'PM &amp; Chat', '', '0', '6')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('3', 'Forum', '', '0', '7')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('3', 'Fun &amp; Games', '', '0', '8')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('3', 'Poll &amp; Shout', '', '0', '9')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('3', 'Uploads &amp; Downloads', '', '0', '10')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('3', 'Web Links &amp; Advertising', '', '0', '11')");      
        
        // Other
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('4', 'Graphics', '', '0', '1')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('4', 'User Fields', '', '0', '2')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('4', 'BB Codes', '', '0', '3')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('4', 'Tutorials &amp; FAQ&#39;s', '', '0', '4')");
        $result = dbquery("INSERT INTO ".$db_prefix."addondb_cats (addon_cat_type, addon_cat_name, addon_cat_description, addon_cat_access, addon_cat_order) VALUES ('4', 'Miscellaneous', '', '0', '5')");

		// Populate Version Cats
		$result = dbquery("INSERT INTO ".$db_prefix."addondb_versions (version_h, version_l, version_s, version_description, version_order) VALUES ('7', '00', '', '', '1')");
		$result = dbquery("INSERT INTO ".$db_prefix."addondb_versions (version_h, version_l, version_s, version_description, version_order) VALUES ('7', '01', '', '', '2')");

        $cat_count = dbcount("(addon_cat_id)", DB_ADDON_CATS);
        $version_count = dbcount("(version_id)", DB_ADDON_VERSIONS);

		echo "<div class='tbl-border'><strong>AddonDB Categories and Version tables population complete.</strong><br /><br />\n";
		echo "<strong>".sprintf("Successfully installed %u categories", $cat_count).sprintf(" and %u PHP-Fusion Version categories.", $version_count)."</strong>";
		echo "<br /><br />This file can be deleted if desired.\n";
		echo "<cite>".$settings['siteurl']."infusions/addondb/admin/".FUSION_SELF."</cite>";
		echo "</br ></div>\n";
		echo "<b>Installed Categories</b>";
		echo "<br /><br />";
		
		$addon_type = array(
	       1 => "<span style='color:#ff0000'>Infusion</span>", 
	       2 => "<span style='color:#0000FF'>Theme</span>", 
	       3 => "<span style='color:#008000'>Panel</span>", 
	       4 => "<span style='color:#FF9900'>Other</span>"
	       );
		
		$result = dbquery("SELECT * FROM ".DB_ADDON_CATS." ORDER BY addon_cat_id ASC");
		if (dbrows($result)) {
		echo "<table cellpadding='0' cellspacing='1' class='tbl-border center'>\n";
			while ($data = dbarray($result)) {
		echo "<tr><td align='left' class='tbl1'>".$data['addon_cat_name']."</td><td class='tbl1'>[".$addon_type[$data['addon_cat_type']]."]</td></tr>\n";
		
		   } echo "</table>\n";
		}
	  }
    } else { echo "Error<br /><br />\n";
  }
	
echo "</form>\n</div>\n";
closetable();

require_once THEMES."templates/footer.php";
?>