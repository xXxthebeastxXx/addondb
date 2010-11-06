<?php

$img_help = "    <img src='".EDOC_IMGS."help.png' alt='' border='0' />";
$img_req = "     <img src='".EDOC_IMGS."php-sql.png' alt='' border='0' />";
$img_demo = "    <img src='".EDOC_IMGS."demo.png' alt='' border='0' />";
$img_handbook = "<img src='".EDOC_IMGS."handbook.png' alt='' border='0' />";
$img_locale = "  <img src='".EDOC_IMGS."locales.png' alt='' border='0' />";
$img_main_dl = " <img src='".EDOC_IMGS."main_download_60.png' alt='' border='0' />";

function show_int_links($page_ident) {
global $settings;
include EDOC_LOC."/".$settings['locale']."/header.php";
include LOCALE.LOCALESET."admin/main.php";
$img_doc_top = "     <img src='".EDOC_IMGS."doc_top.png' alt='".$locale['edoc001']."' border='0' />";
$img_section_top = " <img src='".EDOC_IMGS."section_top.png' alt='".$locale['edoc002']."' border='0' />";
$img_section_prev = "<img src='".EDOC_IMGS."section_prev.png' alt='".$locale['edoc004']."' border='0' />";
$img_section_next = "<img src='".EDOC_IMGS."section_next.png' alt='".$locale['edoc005']."' border='0' />";
$img_doc_bottom = "  <img src='".EDOC_IMGS."doc_bottom.png' alt='".$locale['edoc003']."' border='0' />";

$internal_links = array ( 
     1 => "#cnt",
     2 => "#usa",
     3 => "#sys",
     4 => "#sts"
);

$link_title = array ( 
     1 => $locale['ac01'],
     2 => $locale['ac02'],
     3 => $locale['ac03'],
     4 => $locale['ac04']
);

echo "<center>\n";
if (($page_ident-1) > '0') { echo "<a href='".$internal_links[$page_ident-1]."'>".$img_section_prev."</a> | \n"; }
echo "<a href='#top' class='current'>".$img_doc_top."</a> | \n";
echo "<a href='".$internal_links[$page_ident]."'>".$img_section_top."</a> | \n";
echo "<a href='#bottom' class='current'>".$img_doc_bottom."</a>\n";
if (($page_ident+1) != '5') { echo " | <a href='".$internal_links[$page_ident+1]."'>".$img_section_next."</a>"; }
echo "</center>\n";
}

function edoc_header($page_ident) {
global $settings;
$admin_images = dbquery("SELECT 
                                admin_image, 
                                admin_title 
                                FROM ".DB_ADMIN." 
                                WHERE admin_page='".$page_ident."' 
                                AND admin_link !='reserved' 
                                ORDER BY 
                                admin_title
                                ");
$rows = dbrows($admin_images);
echo "<table align='center' width='100%' class='tbl-border'>\n<tr>\n";
if ($rows != 0) {
while ($data = dbarray($admin_images)) {

if (file_exists(EDOC_IMGS.$data['admin_image']."")) {
echo "<td align='center' valign='bottom' width='100' class='small'><img src='".EDOC_IMGS.$data['admin_image']."' alt='' title='' border='0' /></td>\n";
     } else { 
echo "<td align='center' valign='bottom' width='100' class='small'><img src='".EDOC_IMGS."not_known_sm.png' alt='' title='' border='0' /></td>\n";
     }
   }
 }
echo "</tr>\n</table>\n";
$page_ident = "";
}

?>