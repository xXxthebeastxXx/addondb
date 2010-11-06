<?php

// ##################### CONTENT ADMIN #####################
$locale['ca_header'] = "
<p>The Content Admin section deals with all aspects of the information you and your members post or submit to site. From news items, articles and photos to web links, polls and images.</p>";

$locale['ca_art_cats'] = "
<p>Articles Categories must be created before you can add any articles. Fill in the fields and set them to display by the order of your choosing and who will be allowed to view them.</p>
<p><b>Category Name:</b> Enter the name of the category.</p>
<p><b>Category Description:</b> Enter in the a brief description of the category, if you want.</p>
<p><b>Category Sorting:</b> Choose whether to list your articles by Article ID, Subject name or date of posting either in ascending or descending order.</p>
<p><b>Category Access:</b> Decide who gets to view your article.</p>";
  
$locale['ca_articles'] = "
<p><b>Category:</b> Choose from the dropdown which category your article is in.</p>
<p><b>Subject:</b> Enter the name of your article.</p>
<p><b>Snippet:</b> The snippet will display in the article categories list. It can be the first few lines of your article or a separate introduction. It can also be left blank if you just want the article names listed only.</p>
<p><b>Article:</b> The text for the main body of your article.</p>
<p><b>HTML Buttons:</b> The HTML buttons [if TinyMCE is disabled] allow you some minimal formatting for the text of your article.</p>
<ul>\n<li><b>Page Break</b> - You can break up large articles into seperate pages by using the \"&lt;--PAGEBREAK--&gt;\" button.</li>\n   
<li><b>b</b> - For making text <b>bold</b></li>\n
<li><b><i>i</i></b> - Put text in <i>italics</i></li>\n
<li><b><u>u</u></b> - For <u>underlinig</u> text</li>\n
<li><b>link</b> - Add a web link by highlighting web address [URL]and click the link button.</li>\n
<li><b>img</b> - Add an externally hosted image by highlighting image web address [URL] and click the img button.</li>\n
<li><b>center</b> - For centering text</li>\n
<li><b>small + small2</b> - Reduced text size.</li>\n
<li><b>alt</b> - Alternative text style, [dependent of theme].</li>\n
</ul>\n
<p><b>Select Color</b> - Alter colour of highlighted text. N.B. depending on your theme, some colors may not display. Use the Preview button to test before saving.</p>\n
<p><b>Select Image</b> - Add an image from your Article Images folder.</p>
<p><b>Save as Draft</b> - Tick this box if you wish to save the article but not publish it publicly, very useful for unfinished articles or articles awaiting review.</p>\n
<p><b>Automatic Line-Breaks</b> - Will automatically add line breaks to your text.</p>
<p><b>Enable Comments</b> - Allows members to post comments on the article, [if globally enabled - <a href='#l233x'>see also</a>].</p>\n
<p><b>Enable Ratings</b> - Allows members to rate the article, [if globally enabled - <a href='#l233x'>see also</a>].</p>\n";
  
$locale['ca_c-pages'] = "
<p>The site owner and administrators with access can create custom pages, which can be linked to the navigation box on the front page or called from a link on another page.</p>
<p><b>Page Title:</b> Enter name of custom page</p>
<p><b>Page Content:</b> Enter in the page content, this can be anything from text only to full HTML content. if you have TinyMCE enabled, you can use it to edit your Custom Pages.</p>
<p><b>Add link to navigation menu:</b> - Tick the box if you want the page link to show in your navigation menu.</p>
<p><b>Enable Comments:</b> - Allows members to post comments on the page, [if globally enabled - <a href='#l233x'>see also</a>].</p>\n
<p><b>Enable Ratings:</b> - Allows members to rate the page, [if globally enabled - <a href='#l233x'>see also</a>].</p>\n";

$locale['ca_dl_cats'] = "
<p>Before downloads can be added, categories must first be created. The categories can be edited later even if there are downloads in that category. However, you cannot delete a category containing downloads, you must first move all downloads to another category.</p>
 <p><b>Category Name:</b> Enter category name.</p>
 <p><b>Category Description:</b> Enter name of download category.</p>
 <p><b>Category Sorting:</b> Choose whether to list your adownloads by Download ID, Subject name or date of posting either in ascending or descending order.</p>
 <p><b>Category Access:</b> Decide who gets to access the category.</p>";
  
$locale['ca_downloads'] = "
<p>The downloads system allows your visitors to download files, it includes a download counter which shows you how many times it has been downloaded. Each category can have it's own level of access ranging from Super Administrators to general public. See Settings - Downloads to set file typr</p>
<p><b>Title:</b> Enter download title.</p>
<p><b>Description:</b> Write in a description about the download.</p>
<p><b>URL:</b> If already uploaded to your site, you can enter in the path to the file to be downloaded, eg; /downloads/my_file.zip</p>
<p><b>Upload:</b> Use the browse button to navigate to the required file on your PC.</p>
<p><b>Category:</b> Select download category</p>
<p><b>License:</b> If applicable, enter in download license type.</p>
<p><b>O/S:</b> If applicable, enter in Operating System that your download is compatible with.</p>
<p><b>Version:</b> Download version number.</p>
<p><b>Filesize:</b> If required enter in size of file, if left blank filesize will be calculated automatically.</p>
<p><b>Current Downloads</b> List of existing downloads. Click the the down arrow to view downloads in a particular category. Edit and delete as needed.</p>";

$locale['ca_faqs'] = "
<p><b>FAQ</b> is short for <b>F</b>requently <b>A</b>sked <b>Q</b>uestions. This is a list of questions and answers that you can input to help your members get answers without having to post or otherwise contact you. You must set one or more categories before you can add the questions and answers. There are HTML buttons you can use if you wish to format the text. [These are explained in Articles <a href='#l203x'>here</a>]</p>\n
<p><b>Category Name:</b> Enter category name.</p>\n
<p><b>Category Description:</b> Enter a brief description of the category to help members find the relevant information to their query.</p>\n
<p><b>Category:</b> - Select the category of choice.</p>\n
<p><b>Question:</b> - Enter your question text.</p>\n
<p><b>Answer:</b> - Enter the answer.</p>\n
";

$locale['ca_forums'] = "
<p>You can have as many or as few forums or your site as you like. Though, too many categories may make it harder for visitors to post in the right place. Decide how many categories you really need for your sites content and then the type and subject of each forum in that category. Forums can be moved from one category to another afterwards if needed. You can set up forums here using the default settings. If you want to change them to suit go to <a href='#l211x'>Forum Settings</a></p>
<p><b>Add Forum Category</b></p>\n

<p><b>Category Name:</b> - Before you can add in forums, you need to create one or more categories. Enter in the category name and if desired a brief description.</p>\n

<b>Add Forum</b>

<p><b>Forum Name:</b> - Enter the name of the forum.</p>
<p><b>Forum Description:</b> - A brief description will make it easier for your members to know where best to post.</p>
<p><b>Forum Category:</b>  -Decide which category your forum will be in.</p>
<p><b>Order:</b> - If you have several categories, they can be moved up or down depending on the order set, top category is 1 and so on.</p>

<b>Current Forums</b>

<p><b>Category/Forum</b></p>
<p>As you create your forums, you'll see this list display them in the order that you have set. If you want to change anything, click edit. This will open the Edit Forum panel. You'll see that that the default settings are set to allow the public to view but only members can post, add attachments, create polls, etc. These can all be changed to suit your needs, you may want an Admin only forum or a forum for a particular <a href='#l225x'>user group</a>. Under Forum Moderators is a list of all user groups or Administrators who can be set as moderators. Just click on the group and will jump across to the right hand box, clicking in the right box will remove them.</p>
<p>See also - <a href='#l211x'>Forum Settings</a></p>";
 
$locale['ca_images'] = "
<p>You can upload images to your site using this form. Main Images: this folder would contain general images you use in one or more places around your site. The other destinations are Article Images, News Images and News Cat Images, each of which are specifically for Articles, News Items and News Category images.</p>
<p><b>Important:</b> Before using the browse button to navigate to the required image on your PC, click the category you want to load it to <u>first</u> and then click the \"Upload Image\" button. You then have two options to either view an image or delete it.<br /><b>Please note:</b> deleting an image removes it completley from your server. If you want to use it again, save a copy before deleting!</p>";

$locale['ca_news'] = "
<p>You can post news items which will appear on the front page of your site, they can either be categorized or not, arranged in single or double column, [See also <a href='#l235x'>News Categories</a> and <a href='#l216x'>Settings News</a>.] as well as various other settings, listed below.</p>
<p><b>Current News</b> This is a dropdown list of all your current news items, you can select one for editing or deletion.</p>
<p><b>Add News</b></p>

<p><b>Subject:</b> Enter in the name of your news item</p>
<p><b>Category:</b> If you want the item to appear in a particular category, choose from the dropdown. If not, it will appear in Uncategorized News items.</p>
<p><b>News Image:</b> Use this upload field if you want to replace the default category image with an image of your own. To edit the allowable file size, go to <a href='#l216x'>Settings News</a>.</p>
<p><b>News:</b> This is also known as a news snippet, whatever you type in here is what will appear on your front page. For small items, it is not necessary to use extended news.</p>
<p><b>Extended News:</b> If your posting a large news item, post the bulk of it here.</p>
<p><b>Start Date:</b> You can set an item to appear sometime in the future, leave blank if not needed.</p>
<p><b>End Date:</b> You can also set an item to be automatically removed from view sometime in the future, leave blank if not needed.</p>
<p><b>Visibility:</b> Set who gets to view the item.</p>
<ul>
  <li><p><b>Save as Draft:</b> If an item is not finished or not ready for publication, tick the box where it will be marked as [Draft] and will be hidden from view.</p></li>
  <li><p><b>Make this news item sticky:</b> A Sticky item will remain at the top regardless of posting date.</p></li>
  <li><p><b>Automatic Line-Breaks:</b> For large amounts of text, this will place line breaks in your item to break the text up into several pages.</p></li>
  <li><p><b>Enable Comments:</b> Allow users to comment on the item. [Global Comments must be enabled - see <a href='#l233x'>Settings Miscellaneous</a>]</p></li>
  <li><p><b>Enable Ratings:</b> Allow users to rate your item. [Global Ratings must be enabled - see <a href='#l233x'>Settings Miscellaneous</a>]</p></li>
</ul>
 ";

$locale['ca_news_cats'] = "
<p>PHP-Fusion comes preloaded with 16 news categories and their respective images, these can be edited or deleted to suit your sites requirements.</p>
<p><b>Category Name:</b> Enter News Category Name</p>
<p><b>Category Image:</b> Select respective image for that category</p>
<p><b>Click Here to upload category images:</b> Use this link to load up your own category images.</p>";

$locale['ca_news_photo_albums'] = "
<p>This form allows you to create photo albums.</p>
<p><b>Title:</b> Enter Album name</p>
<p><b>Description:</b> A brief description, if desired.</p>
<p><b>Access:</b> Set who gets to view the album images.</p>
<p><b>Order:</b> For multiple albums, use this to set the order in which they're displayed.</p>
<p><b>Thumb:</b> Upload a thumbnail image for this album.</p>
<b>Current Albums</b>
<p>To view or edit an album, click it's thumnail image.</p>

<p><b>Album X: Add Photo</b> Use this form to upload an image to this album.</p>
<p><b>Album X: Current Photos:</b> This displays all the images in the album, use the links to edit, delete or reorder your images.</p>
";
  
$locale['ca_polls'] = "
<p>You can set polls for your members to vote on about any subject you like. [Members Poll panel must be enabled in <a href='#l217x'>panels management</a>]</p>
<p><b>Poll Title:</b> Enter text of the poll subject, eg; What do think of my site?</p>
<p><b>Option 1,2, etc:</b> Enter in answers for members to choose from, eg; Like it, It's ok, Hate it and so on to a maximum of 10 answers.</p>
<p>A member will not be able to view the results from others voting until <i>after</i> he has voted. After a period of times when a new poll is created, the full results of the previous poll are then displayed in Polls Archive.</p>";

$locale['ca_weblink_cats'] = "
<p>Weblinks are a collection of website addresses that you or your members think may be interesting or of value to others. Before web links can be posted, the categories need to be created.</p>
<p><b>Category Name:</b> Enter category name</p>
<p><b>Category Description:</b> A brief description, if desired.</p>
<p><b>Category Sorting</b> Set in what way they will be listed.</p>
<p><b>Category Access</b> Set who gets to view this category.</p>
<b>Current Web Link Categories</b>

<p>You can edit or delete your current categories here.</p>
";

$locale['ca_weblinks'] = "
<p>Once the categories have been set, you can add links. Your members can also submit links using the <a href='#l223x'>submission system</a>. Admin approval is needed before they can be published.</p>
<p><b>Site Name:</b> Enter site name</p>
<p><b>Description:</b> A brief description or a few lines from the site itself, if desired.</p>
<p><b>Site URL:</b> Enter <i>full</i> site URL, it <u>must</u> include <b>http://</b>. A clicked web link will open in new browser window. </p>
<p><b>Category:</b> Choose which category the link goes into.</p>
<b>Current Web Links</b>

<p><b>Web Link [Click to Test]</b></p>
<p><b>Options</b> You can test, edit and delete exisiting web links here.</p>
";

?>