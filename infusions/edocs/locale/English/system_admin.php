<?php

// ##################### SYSTEM ADMIN #####################

$locale['sy_header'] = "
<p>This section deals with your sites functionality, configuring panels, infusions, site links, etc.</p>";

$locale['sy_banners'] = "
<p>If you want to replace your site logo with something else or you want a second banner, image or even an advert, you can use the banner manager.</p>
<p><b>Banner 1:</b> Enter in the code or image path you wish to display in the left hand side of your header, try testing with preview before putting it live.</p>
<p><b>Banner 2:</b> Enter in the code or image path you wish to display in the right hand side of your header, try testing with preview before putting it live.</p>
<p>You need to enter your Admin Password to both preview and save. </p>";

$locale['sy_bbcodes'] = "
<p>BB-codes stand for Bulletin Board Codes – it's a mark up language used to format messages primarily on bulletin boards [Forums]. They are mostly a safe way for members to format the text in their postings without being able to input harmful code that could damage or or be used to attack your site.</p>
<p>The BB Code pages shows a top list of your enable BB codes and the bottom list shows a list of loaded but not enabled bb codes. It's a simple matter of enabling or disabling whichever ones you choose. The list shows the image to denote that BB code as well as the code to use it on the site. To make use of them on your site, jusat either click the image or type in the bb code and that's it.</p>
<p>There are too many BB Codes available to list their functions here, it is best to try them out yourself and see which ones you want and which ones you don't. You do not need your admin password to enable/disable BB Codes.</p>";

$locale['sy_db_backup'] = "
<p>From time to time it is strongly recommended to back up your database. You should make sure you back it up at regular intervals depending on how busy your site is, once a week at the very least. To backup up the entire database, just enter your admin password and click the back up button.</p>";

$locale['sy_infusions'] = "
<p>Install and Uninstall Addons for your site known as Infusions here.</p>
<p><b>Infusions:</b> The names of all uploaded Infusions in your infusions folder.</p>
 <ul>
  <li><b>Not Infused:</b> These are your infusions displayed in <font color='red'>red</font> in the dropdown menu and are the infusions uploaded but not yet infused [installed].</li>
  <li><b>Infused:</b> These are displayed in <font color='green'>green</font> in the dropdown menu and are all the infusions that have been installed.</li>
  <li><b>Upgrade Available:</b> These are displayed in <font color='blue'>blue</font> in the dropdown menu and are installed infusions that have a new version uploaded but not yet updated.</li>
</ul>
<p><b>Infused Infusions:</b> This is the list of all installed Infusions with version number, Developer name, email address [if supplied], website address [if supplied] and Defuse [Uninstall] link.</p>";

$locale['sy_panels'] = "
<p>The basic layout of a PHP-Fusion web site is based on panels. There are three main panels (left, centre and right). And each panel is made up of a number of separate subpanels. You can configure these panels in Panels Management. The page will show a list of all the panels that have been added to your site.</p>
<p><b>Panel Name:</b> List of loaded panel names</p>
<p><b>Side:</b> Use the arrows to move side panels from one side of your site to the other.</p>
<p><b>Order:</b> Use the arrows to move them up or down depending on your needs.</p>
<p><b>Access:</b> Which lelel of user can access this panel.</p>
<p><b>Options:</b> Edit, enable/disable or delete your panels here.</p>

<p><b>Add New Panel:</b> Use this link to add a new panel, which can be either a pre-made panel already loaded to your infusions folder or you can enter in the code directly without the need for loaded files.</p>
<p>If it is to be a code based panel, enter the code into the Panel Content field, use the preview button to test.</p>
<p>If it's a file based panel in your infusions folder, enter in the Panel name, select it from the dropdown. Enter in your Admin password, select panel side and access level and save.</p>
<p>It it's configured as a center panel, then select either U-Ctr [Up Center] or L-Ctr [Lower Center]. Check the box if you want it to display on all pages.</p>
<p><b>Refresh Panel Order Values:</b> If you have moved a number of panels around in one go, it is recommended to refresh the order values to prevent any conflicts.</p>
";

$locale['sy_phpinfo'] = "
<p>PHP Info is a server side built-in function which will display all the information about the version of PHP installed on your server. It can used for reference as well as support issues. It is not editable.</p>";

$locale['sy_site_links'] = "
<p>For configuring all your sites links in the navigation menu. [Navigation panel must be enabled in <a href='#l217x'>panels management</a>]</p>

<p><b>Add Site Link</b></p>
<p>Use this form to add new links to your navigation menu. Enter the txt of the link and then the Link URL which sould be relative to your sites root directory. If you want to add a new line break in the link list, enter 3 dashes [ --- ] into Link URL.</p>
<p>Set link access, order and position. Admin password not required.</p>

<p><b>Current Site Links</b></p>

<p>This displays a list of all exisiting links, use the arrows to move them up or down. They can also be edited or deleted.</p>
<p><b>Refresh Link Ordering:</b> If you have moved a number of links around in one go, it is recommended to refresh the order values to prevent any conflicts.</p>
";

$locale['sy_smileys'] = "
<p>Smileys are fun face images that are common on the internet and are to used to express a particular emotion when posting. <img src='".IMAGES."smiley/smile.gif' alt='' border='0' /></p>
<p>To add new smileys, the image must first be uploaded to your images/smiley folder. This cannot be done from inside PHP-Fusion and must be done direct to your server by your FTP client.</p>
<p><b>Smiley Code:</b> Enter the code a member can input to use your smiley.</p>
<p><b>Smiley Image:</b> Choose the corresponding image from the dropdown menu.</p>
<p><b>Smiley Preview</b> Your chosen image is displayed.</p>
<p><b>Smiley Text:</b> A word to denote emotion of this smiley.</p>
<p><b>Options</b> Smileys can be edited or deleted.</p>";

$locale['sy_upgrade'] = "
<p>From time to time, PHP-Fusion issue upgrades to your sites software. Most of these upgrades will contain a file called \"upgrade.php\" which is to be placed in the administration folder. Sometimes, the database needs to be latered or it may just be a version number change. Regardless, it's good practice to always run the upgrade whenever one is released. Visiting this page will tell you whether you need to update or not.</p>";

?>