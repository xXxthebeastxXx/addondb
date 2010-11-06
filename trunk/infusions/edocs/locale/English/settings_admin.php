<?php

// ##################### SETTINGS ADMIN #####################

$locale['st_header'] = "<p>These are the main settings for your site, it is important to understand them and adjust as necessary for your visitors to get the best from your site.</p>";

$locale['st_downloads'] = "
<p>There are only two settings in Downloads settings</p>
<p><b>Maximum size uploads:</b>This sets the size of any files uploaded to your site, either by you, your Admins or members [if allowed]. This is important as if set too high you could quickly run out of space on your sites server. The default setting is 32000 bytes [1 kilobyte = 1024 bytes]. You can increase this just by entering a multiple of 1024 to suit your needs.</p>
<p><b>Allowed file types:</b> This is an important security consideration as certain file types can be used to cause damage on your web server or contain malicious code for download to your members/visitors. The default file types of zip, rar, tar, bz2 and z7 are what's known as archive files and are the standard on the web for downloading files. Never allow files like <b>.exe</b> as they are executable files which could be used to run remotely on visitors computers without their knowledge.</p>";

$locale['st_forums'] = "
<p>If you are hosting a discussion forum on your site, you may want to alter the default settings if needed.</p>
<p><b>Number of forum threads to show:</b>This sets the number of threads that will display in the Forums Threads List Panel [if enabled - see <a href='#l217x'>Panel Management</a>] that is featured on the front page of your site. The default is set at 5 threads, you can increase it if you wish. Remember not to have too many displaying as this will push down any content that is set below it.</p>
<p><b>Show IP Publicly:</b>If you want your members IP [<a target='_blank' href='http://en.wikipedia.org/wiki/Internet_protocol'>Internet Protocol</a>] address to be visible to the public. Default setting is No. This is a personal choice, though some members may not like this information publicly available. If set at No, you as an Administrator will still be able to view IP addresses in all sections.</p>
<p><b>Attachments max size:</b> This is similar to the file upload setting above. If you allow file attachments in any of your forums, you'll need to set a limit to prevent your members from uploading overly large files. The file size is measured in bytes with the default set at 150000 which is approximately 1.14Mb.</p>
<p><b>Allowed file types:</b> Again similar to file uploads, this setting allows you you set which file types can be loaded to your server. The default file types are: gif, jpg, png, zip, rar, tar, 7z. The first three are the standard web image file types, while the other are archive file types which are used all over the internet and can be regarded as safe.</p>
<p><b>Enable forum thread notification:</b> Default set at No. If enabled, your members will have an option to be sent an email any time a reply has been posted to a particular thread. This is a very handy facility for your members, though on very large or busy sites it could increase your bandwidth more than you'd like.</p>
<p><b>Enable forum ranks:</b> This allows a ranking system to be enabled for your Admins and Moderators in your forums, [See <a href='#l239x'>User Admin - Forum Ranks</a> for more].</p>
<p><b>Lock Edit:</b> A simple Yes or No choice of whether you want to lock out your members from editing their own posts. This is a very useful for fixing errors and typos, etc. Whenever a post is edited, the time and date and name of the editor will display under the post.</p>
<p><b>Popular thread time threshold:</b> Sets how long a thread is flagged as &quot;New&quot;. Default is set at 1 week.</p>
<p><b>Recount User Posts:</b> This link performs a recount of user posts to update your database. This would not be necessary for small to medium sites.</p>
<p>To set any altered settings, you must enter your admin password.</p>";

$locale['st_ipp'] = "
<p>Set how many items to show in each section. News should be an uneven number to prevent a lopsided front page if you decide on a two column format. [See <a href='#l216x'>News Settings</a> for more]</p>";

$locale['st_main'] = "
<p>Set your site name and other site information.</p>
<ul>\n
<li><b>Site name:</b> The name of your new site.</li>
<li><b>Site URL:</b> The true url to your homepage, [web address; eg; http://www.yourwebsite.com/]</li>
<li><b>Site banner:</b> Enter the name and path to your logo. Eg; <b>images/my_logo.jpg</b></li>
<li><b>Site e-mail address:</b> This is the site e-mail used for the Contact Me page, etc.</li>
<li><b>Your name or nickname:</b> The site owners name.</li>
<li><b>Site introduction:</b> Used with the panel welcome_message_panel for a short site introduction.</li>
<li><b>Site description:</b> Used as meta tags for search engine purposes.</li>
<li><b>Site keywords:</b> Used as meta tags for search engines purposes.</li>
<li><b>Site footer</b>: Used in most themes to display a short foot note.</li>
<li><b>Site opening page:</b> Default page all visitors will be brought to when first accessing your site.</li>
<li><b>Site locale:</b> Set default language.</li>
<li><b>Site theme:</b> Change the theme for your site.</li>
<li><b>Default search location:</b> Used for search function.</li>
<li><b>Exclude Panels:</b> Exclude left/right/top/bottom panels on any given page.</li>\n</ul>";

$locale['st_misc'] = "
<p>Set up Miscellaneous settings like:</p>
<p><b>Use TinyMCE HTML editor?</b> TinyMCE is an easy to use word processor that comes included with PHP-Fusion for those who may find posting articles and news items using the HTML buttons a little off putting. If you have no experience of using HTML then we would suggest you use it.</p>
<p><b>SMTP Host, Port, Username and Password:</b> SMTP stands for Simple Mail Transfer Protocol which is the Internet standard for e-mail transmissions. You should check with your web host as to whether you need to fill in these fields or not.</p>
<p><b>Bad words filter enabled?</b> This will enable a filter to prevent users from using language that you or your visitors may find objectionable or to prevent certain spam words from being entered.</p>
<p><b>Bad words list:</b> If enabled, enter in each word you wish to block, one word per line. Enter as many as you like.</p>
<p><b>Bad word replacement:</b> This is what will display instead of the offending word.</p>
<p><b>Allow Guests to post?</b> If enabled, visitors to your site can post in comments and the shoutbox, but not in the forum. A captcha check will display to prevent automated bots from spamming your site. However, if you allow this you will have no way of controlling who posts on your site.</p>
<p><b>Enable comments system:</b> PHP-Fusion allows for members to comments on certain things like photos, news items, and other sections. If you don't want to allow this disable the setting. If enabled, comments can be turned on or off for each individual article, photo, news item, etc.</p>
<p><b>Enable ratings system:</b> Articles, News Items, Photographs and Custom pages can be rated by members if enabled. You then have the choice to allow each individual item to be rated or not.</p>
<p><b>Enable visitor counter?</b> This enables/disables the unique visitor counter in the footer of your site. It will work in all themes that have the showcounter function included.</p>";

$locale['st_news'] = "
<p>Various settings for your news items.</p>
<p><b>News style:</b> This sets your news items on the front page as either a single column, [one on top of the next] or two columns [side by side]. This is a matter of personal choice and can be switched back and forth to see how your site looks as long as you have several news items already entered.</p>
<p><b>Image link:</b> Each News category has it's own image and if selected when creating a news item will display in the item itself. When the image is clicked the default setting [Category] will take the visitor to the News Category page listing all news categories and any news items in each category. However, changing the setting to News items will then bring the visitor to the news item itself, the same as the &quot;Read More&quot; link under each item.</p>
<p><b>Image on Front-page:</b> Choice between using images you can upload for each news item or using News category images in news item. If select uploaded photo, it will display category image if no image has been uploaded for a particular news item.</p>
<p><b>Image on Read-more:</b> For all &quot;Extended News&quot; items, [see <a href='#l216y'>Add News</a>], the Read More link will open the full news item. This settings allows for the choice between uploaded image or news category image to be displayed.</p>

<p><b>Image Upload</b></p>
<p><b>Thumb Ratio:</b> When you upload an image, the system will automatically create a thumbnail image, [smaller version] to display on the front page [if enabled]. This setting allows for either the original height and width ratio to be maintained or for it to be forced into a square.</p>
<p><b>Thumb size:</b> Set the width and height of the thumbnail images. If original ratio is set, only width will be applied.</p>
<p><b>Photo size:</b> Set height and width of full image to be displayed in Read More.</p>
<p><b>Maximum photo size:</b> Setting for maximum size allowed for images to be uploaded. Images larger than this will not upload.</p>
<p><b>Maximum file size (bytes):</b> Set the maximum size [weight] of uploaded images in bytes. Default is set at 150000 which is approximately 1.14Mb.</p>
";

$locale['st_photo_gallery'] = "
<p>If you are planning on including photo galleries, these are the various settings you may need to alter.</p>
<p><b>Thumb size:</b> Set the width and height of the thumbnail images. If original ratio is set, only width will be applied.</p>
<p><b>Photo size:</b> Set height and width of the image which will display in photo album.</p>
<p><b>Maximum photo size:</b> Setting for maximum size allowed for images to be uploaded. Images larger than this will not upload.</p>
<p><b>Maximum file size (bytes):</b> Set the maximum size [weight] of uploaded images in bytes. Default is set at 150000 which is approximately 1.14Mb.</p>
<p><b>Thumb compression method:</b> This is dependant on host server settings. Default is GD2, if this doesn't work select GD1. Otherwise contact your host.</p>
<p>For reference: [see: <a target='_blank' href='http://en.wikipedia.org/wiki/GD_Graphics_Library'>http://en.wikipedia.org/wiki/GD_Graphics_Library</a>]</p>
<p><b>Thumbs per row:</b> Set the number of photo thumbs to display in each row in your album(s).</p>
<p><b>Thumbs per page:</b> Set the number of photo thumbnail images to display per page in your album(s).</p>

<h3>Watermarks</h3>
<p><b>Enable photos watermark:</b> If enabled, this will add a watermark image to your photos. You will need to make one to suit your needs. N.B. this setting is retroactive and will add watermarks to previously loaded photos.</p>
<p><b>Specify PNG watermark:</b> Set the path to your watermark image, it must be .png format.</p>
<p><b>Save generated watermark?</b> If watermarking is enabled, each time a photo is visited the server has to create the combined image. This could greatly increase the server load on a busy site. To prevent this, you can set this setting to yes which which will save the image once and not have to be created each time the photo is viewed. This will however, take up more disc space on your web server.</p>
<p><b>Enable text description on photos:</b> This will add album and photo name to your photos.</p>
<p><b>Album title colour, description colour and photo title colour:</b> Set the colours you want for the photo text descriptions. Depending on your photos, this may take some trial and error to get it to display effectively on the images.</p>
";

$locale['st_pm_options'] = "
<p>Global Private Message settings. Individual user options take precedence if they're set. If no user option is set, then the global options are applied.</p>
<p><b>Inbox message limit:</b> This sets the number of private messages a user can have in their inbox before it's full. No more messages can be received until room is made by deleting some or all messages, [also known as PM's]. This limit does not apply to admins. Enter 0 for unlimited inbox.</p>
<p><b>Outbox message limit:</b> Same as for inbox.</p>
<p><b>Archive message limit:</b> Same as for inbox.</p>
<p><b>Email notification?</b> If set to yes a member will receive an email alerting them to a new private message. Once set this choice will display in members message options.</p>
<p><b>Save sent PM's?</b> Your members may wish to keep a copy of send pm's. Once set this choice will display in members message options.</p>";

$locale['st_registration'] = "
<p>If you want to allow membership registration on your site, edit these settings.</p>
<p><b>Enable registration system?</b> Yes/No - allow member registration or not.</p>
<p><b>Use email verification for registration?</b> Yes/No - If registration is enabled, you can verify a potential member's email address by turning this setting on. The person registering will receive an email with an individual link they have to click in order to activate their account.</p>
<p><b>New members activated by admin?</b> If set to Yes, no new members accounts will be activated unless approved by an administrator.</p>
<p><b>Display validation code?</b> The validation code is displayed in the registration form, it helps prevent automatic registrations by spambots and other malicious software. It is strongly recommended you leave this turned on.</p>
<p><b>Login method:</b> Sessions are stored by the server, are more secure and can hold more data, but will be lost after the browser is closed which means the member will have to re-login the next time they visit the site. Whereas with cookies, as long as the user doesn't delete them from their PC they won't have to enter their logins each time they visit. There may be some differences depending on the users browser.</p>
<p><b>Enable terms of agreement?</b> You can insist that all new members registering on your site agree to certain terms and conditions set by you.</p>
<p><b>Terms of Agreement:</b> Enter your terms and conditions, there are text formatting buttons provided allowing you to format the text,add image(s) and links as desired.</p>";

$locale['st_security'] = "
<p><b>Flood interval (seconds):</b> This sets the time in seconds during which a member cannot post again.</p>
<p><b>Flood Auto Ban:</b> If any member or automated bot breaks the flood limit, they will be automatically banned.</p>
<p><b>Maintenance level:</b> Set the user level of who can access the site while it is in maintenance mode. [N.B.. Site owner is user id #1]</p>
<p><b>Maintenance mode:</b> Selecting On will put the site into maintenance mode which prevents guests and members [and admins, if level set] from accessing the site. They will be greeted by the maintenance page containing the message you enter. Those of sufficient level who can still access the site will see a warning at the top as a reminder that the site is locked out.</p>
<p><b>Maintenance mode message:</b> This is the message guests and members will see when visiting the site.</p>";

$locale['st_time_date'] = "
<p>Use these settings to alter how the time and/or dates display around your site. Select the format required and then click the &gt;&gt; button to set it. Once all formats are set, click Save Settings to update the database.</p>";

$locale['st_user_man'] = "
<p>Use these global settings to manage your membership.</p>
<p><b>De-activation system enabled:</b> The De-activation system depending on settings below allows for automatic handling of inactive users.</p>
<p><b>Allowed period on inactivity:</b> Number of days inactive before the de-activation is started. Default is 1 year.</p>
<p><b>Response before deactivation action:</b> Number of days to respond to deactivation notification email. Default is set at 2 weeks.</p>
<p><b>Deactivation Action:</b> Choose between user account deletion or Anonymize user. Anonymizing a user replaces their username wherever it is appears on your site with &quot;Anonymous User&quot;. N.B. Admins and above can still view the username.</p>";

?>