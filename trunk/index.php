<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: index.php
| Author: Nick Jones (Digitanium)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "maincore.php";
require_once THEMES."templates/header.php";
require_once INFUSIONS."addondb/infusion_db.php"; ?>
<h1>PHP-Fusion Content Management System</h1>
<div class="tbl-border" style="position: relative; height: 150px; width: 730px; margin: 20px 0pt;">
<p style="width:600px; padding:10px">Welcome to the official site of PHP-Fusion, a light-weight open-source content management system (CMS). PHP-Fusion is written in PHP and MySQL and includes a simple, comprehensive administration system as well as Forum, Photogallery, Articles, FAQ and much more.</p>
<img style="border-color:#DDDDDD;
	border-style:solid;
	border-width:1px 0 0 1px;-moz-box-shadow:1px 1px 0 #bbb;
	-webkit-box-shadow:1px 1px 0 #bbb;
	box-shadow:1px 1px 0 #bbb;-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;	position: absolute; padding: 10px; background:#fff; right: -200px; top: -10px;" src="http://cdn.php-fusion.co.uk/images/php-fusion-tmpl.png" alt="php-fusion" />
</div>
<!--
<table width="950" class="tbl-border">
	<tr>
		<th colspan="15" class="forum-caption">Features</th>
	</tr>
	<tr>
		<td colspan="15">&nbsp;</td>
	</tr>
	<tr>
		<td width="80" align="center"><img src="images/news.png" width="72" alt="" /></td>
		<td width="1%">&nbsp;</td>
		<td valign="top" width="155"><p>PHP-Fusion comes with a built in news system for keeping your members up to date.</td>
		<td width="1%">&nbsp;</td>
		<td width="80" align="center"><img src="images/members.png" width="64" alt="" /></td>
		<td width="1%">&nbsp;</td>
		<td valign="top" width="155"><p>It is a permissions based CMS giving you full control over access.</td>
		<td width="1%">&nbsp;</td>
		<td width="80" align="center"><img src="images/theme.png" width="80" alt="" /></td>
		<td width="1%">&nbsp;</td>
		<td valign="top" width="155"><p>There are hundreds of colour schemes or &quot;themes&quot; to choose from.</td>
		<td width="1%">&nbsp;</td>
		<td width="80" align="center"><img src="images/developer.png" width="80" alt="" /></td>
		<td width="1%">&nbsp;</td>
		<td valign="top" width="155"><p>PHP-Fusion has a small but dedicated team of developers, join in on our Dev site.</td>
	</tr>
	<tr>
		<td align="center" colspan="3"><a class="button" href="news.php"><span>more</span></a></td>
		<td width="1%">&nbsp;</td>
		<td align="center" colspan="3"><a class="button" href="news.php"><span>more</span></a></td>
		<td width="1%">&nbsp;</td>
		<td align="center" colspan="3"><a class="button" href="infusions/addondb/addons.php"><span>more</span></a></td>
		<td width="1%">&nbsp;</td>
		<td align="center" colspan="3"><a class="button" target="_blank" href="http://dev.php-fusion.co.uk/"><span>more</span></a></td>
	</tr>
</table>
<br />-->
<div class="grid_12 alpha">
<?php $result = dbquery("
	SELECT news_id as id, news_subject as title, news_news as news, news_datestamp as date, tu.user_name as author
	FROM ".DB_NEWS." 
	LEFT JOIN ".DB_USERS." tu ON news_name=tu.user_id
	WHERE ".groupaccess('news_visibility')." AND (news_start='0'||news_start<=".time().") AND (news_end='0'||news_end>=".time().") AND news_draft='0'
	ORDER BY news_sticky DESC, news_datestamp DESC 
	LIMIT 5
"); $i = 0; ?>
	<h2>Latest News</h2>
	<div class="tbl-border latestnews">
		<?php while ($data = dbarray($result)): $i++ ?>
		<div class="item<?php echo $i == 1 ? " first" : ""; ?>">
			<h4 class="title"><a title="<?php echo $data['title']; ?>" href="/news.php?readmore=<?php echo $data['id']; ?>"><?php echo trimlink($data['title'], 60); ?></a></h4>
			<p class="meta"> by <span class="author"><?php echo $data['author']; ?></span> on <span class="date"><?php echo showdate("%B %d, %Y", $data['date']); ?></span> with <span class="comments"> <a title="Comment on <?php echo $data['title']; ?>" href="/news.php?readmore=<?php echo $data['id']; ?>#comments"><?php echo dbcount("(comment_id)", DB_COMMENTS, "comment_type='N' AND comment_item_id='".$data['id']."' AND comment_hidden='0'"); ?> Comments</a></span> </p>
			<?php if ($i == 1): ?>
			<p class="excerpt"><?php echo limit_words($data['news'], 75); ?></p>
			<?php endif ?>
		</div>
		<?php endwhile ?>
	</div>
</div>
<?php
$result=dbquery("
	SELECT user_id, user_name, user_status, user_testimonial  
	FROM ".DB_USERS." 
	WHERE user_status = '0' 
	AND user_testimonial !='' 
	AND user_approve !='1'
	ORDER BY RAND() LIMIT 10
");

if (dbrows($result)): ?>
<div id="testimonials" class="grid_12 omega">
	<h2>Testimonials</h2>
	<?php while($data = dbarray($result)): ?>
	<?php $text = nl2br(censorwords($data['user_testimonial'])); ?>
	<blockquote>
		<p><?php echo $text ?></p>
		<cite>&ndash; <?php echo profile_link($data['user_id'], $data['user_name'], $data['user_status']); ?></cite>
	</blockquote>
	<?php endwhile ?>
</div>
<?php endif ?>
<?php
$result=dbquery("
	SELECT addon_id, addon_status, addon_name, addon_description, addon_date, addon_download_count  
	FROM ".DB_ADDONS." 
	WHERE addon_status = '0' 
	ORDER BY addon_date DESC LIMIT 5
");

if (dbrows($result)): ?>

<div id="addons" class="grid_12 omega">
	<h2>Latest Addons</h2>
	<ul class="tbl-border" style="list-style:none">
	<?php while($data = dbarray($result)): ?>
	<li>
		<small><?php echo "<a href='".INFUSIONS."addondb/view.php?addon_id=".$data['addon_id']."'>".$data['addon_name']."</a>"; ?></small>
		<p><?php echo trimlink($data['addon_description'],120); ?></p>
	</li>
<?php endwhile ?>
</div>

<?php endif ?>
<?php require_once THEMES."templates/footer.php"; ?>