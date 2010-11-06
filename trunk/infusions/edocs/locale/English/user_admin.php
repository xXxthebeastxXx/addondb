<?php

// ##################### USER ADMIN #####################

$locale['ua_header'] = "
<p>The User Admin section deals the various settings and facilities in regards to your sites membership.</p> ";

$locale['ua_admins'] = "
<p>You can promote any member you want to the position of Administrator, [aka; Admins]. Admins have increased access, especially in forums where they automatically have full moderator access. You can set which parts of the Administration section that they can have access to. Choose carefully, it is a good idea only to allow admins access to sections that they would need to carry out their duties. You should try to minimize the number of people who have full access for security reasons. Admins elevated to Super Administrator level have full access to all sections.</p>
<p><b>Search for users to add using the form below.</b> If you want to promote one of your members to Admin, enter either their username or user id in the form field, select correct radio button and click search. Tick the button beside the member you want to make Admin, choose whether to give them full access, if not you can go back later and edit the settings to give access to whichever sections you want. You can also choose to make the member a Super Administrator, who automatically get full access.</p>
<p><b>Edit Administrators</b></p>

<p>To edit an Administrator, just click Edit beside the name. You will then see a list of all sections of the site. Tick the boxes of the sections you want to allow access, enter your Admin password and save.<br /><b>N.B.</b> Some areas are more security related than others, so only give access to those areas to people you trust. Eg; Custom Pages, Database Backup. See Handbook for more.</p>
";

$locale['ua_blacklist'] = "
<p>The Blacklist is a list of all email addresses or domains and IP addresses you want to prevent from accessing your site.</p>
<p><b>Blacklist IP address: </b> Enter the IP address you wish to block.</p>
<p><b>Blacklist email address</b> Enter the email address [spammer@spamcity.com] or even the full domain if required [spamcity.com]</p>
<p><b>Blacklist Reason</b> For reference you can add a reason to each blacklist entry.</p>
<b>Blacklisted users</b>

<p>This is list of all blacklists you've entered. Use the edit link if you want to change any details of a particular record.</p>
";

$locale['ua_forum_ranks'] = "
<p>You can set your own rank names for your forums depending on number of posts. Moderators, Admins ans Super Admins have set ranks which are not affected by post count. Forum ranks must first be enabled. Go to the <a href='#l211x'>Forum Settings Admin Panel</a> to enable. <i>Admin Password required.</i></p>
<p><b>Add Rank</b></p>

<p><b>Rank Title:</b> Enter the rank name</p>
<p><b>Rank Image:</b> Select the image to correspond with the rank</p>
<p><b>Rank Posts</b> Set the number of posts required for the rank to be achieved</p>
<p><b>Apply to:</b> Select the user level this rank applies to.</p>

<p>This shows all the ranks and their respective levels you have chosen, to alter just click Edit.</p>";

$locale['ua_members'] = "
<p>You can view, edit, suspend, anonymize, cancel, ban or delete any members [user level 101] using this page.</p>
<p><b>View Members</b> Use the dropdown to view whichever member status you want.</p>

<p><b>Add Member</b> Use the Add Member link to manually enter a new member, you will need their email address for this.</p>
<p>Once logged in, the new member can edit their password and other settings in edit profile if they choose.</p>

<p><b>Options</b></p>

<p><b>Ban</b> This will prevent a member from logging in to the site permanently.</p>
<p><b>Security Ban</b> This is from automatically done from flood control.</p>
<p><b>Suspend</b> This will prevent a member from logging in to the site for a specified length of time</p>
<p><b>Cancel</b> Users can request their membership be deleted and all posted information by them be deleted.</p>
<p><b>Anonymize</b> Same as Cancelled, but posted information remains visible but user name changed to Anonymous</p>
<p><b>Delete</b> <i>Awaiting Clarification</i></p>
";

$locale['ua_shoutbox'] = "
<p>The Shoutbox is a simple side panel infusion that allows members or guest post short messages to a maximum of 220 characters. Guests can \"Shout\" only if \"Allow Guests to post?\" is set to Yes in <a href='#l233x'>Miscellaneous Settings</a>.</p>";

$locale['ua_submissions'] = "
<p>Members can submit articles, photos, news items and links. The submission will not be published onsite until an Admin has viewed and approved the submission. Submissions can be viewed by an Admin in the Admin Panel.</p>";

$locale['ua_uf_cats'] = "
<p>User fields are various fields which gather information about your members and are displayed in their profile, most of which can be edited by the member themselves in Edit Profile. Though, there are also some fields which cannot  be edited like Statistics. There are also user fields available which are only visible to Admins for security and other management purposes.</p>
<p><b>Add User Fields Category</b></p>

<p>You can add more categories using this simple form if needed.</p>

<p><b>Current User Fields Category</b></p>

<p>Use the options links to edit or delete existing categories.</p>
";

$locale['ua_user_fields'] = "
<p>View and configure all uploaded user fields on your site.</p>
<p><b>Enabled User Fields</b> This displays a list of all enabled user fields in each category. Use the arrows to move them up or down depending on how you want them diplayed in profiles.</p>
<p><b>Disabled User Fields</b> These are the user fields that are loaded to your site but not enabled.</p>";

$locale['ua_user_groups'] = "
<p>User groups can be created to control access to forum threads, news, custom pages, site links, links categories and article categories.</p>
<p><b>Group Name:</b> Enter the name of the group</p>
<p><b>Group Description:</b> A brief description. [not required]</p>
<p>Once you've created a group, you need to click edit to add members to it. Enter in a members name or their ID number and click search. You can search for multiple users by separating each entry with a comma. If the correct members are listed, tick the box beside the names and click \"Add selected users\". </p>";

?>