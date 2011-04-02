<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
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
<div class="grid_9 alpha">
	<p>Welcome to the official site of PHP-Fusion, a light-weight open-source content management system (CMS). PHP-Fusion is written in PHP and MySQL and includes a simple, comprehensive administration system as well as Forum, Photogallery, Articles, FAQ and much more.</p>
	<a href="/infusions/edocs/getting_started.php" class='button'><span>Getting Started</span></a> | 
	<a href="/downloads.php?cat_id=15&amp;download_id=263" class='button'><span>The Handbook</span></a> | 
	<a href="/infusions/features/index.php" class='button'><span>Features List</span></a> | 
	<a href="/infusions/book_of_condolences/condolences.php" class='button'><span>Book of Condolences</span></a>
	
</div>
<div class="grid_7 omega"><a href="/downloads.php?cat_id=23&amp;download_id=264" target="_blank" id="downloadpf" class="ir">Download PHP-Fusion</a></div>
<div class="grid_8 alpha">
	<?php $result = dbquery("
	SELECT news_id as id, news_subject as title, news_news as news, news_datestamp as date, news_allow_comments as allow, tu.user_name as author
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
			<p class="meta"> by <span class="author"><?php echo $data['author']; ?></span> on <span class="date"><?php echo showdate("%B %d, %Y", $data['date']); ?></span> with <span class="comments">
				<?php if($data['allow']) { ?>
				<a title="Comment on <?php echo $data['title']; ?>" href="/news.php?readmore=<?php echo $data['id']; ?>#comments"> <?php echo dbcount("(comment_id)", DB_COMMENTS, "comment_type='N' AND comment_item_id='".$data['id']."' AND comment_hidden='0'"); ?> Comments</a>
				<?php } else { ?>
				<del>0 Comments</del>
				<?php } ?>
				</span> </p>
			<?php if ($i == 1): ?>
			<p class="excerpt"><?php echo cleanInput(limit_words(stripslashes($data['news']), 75)); ?></p>
			<?php endif ?>
		</div>
		<?php endwhile ?>
	</div>
</div>

<div id="testimonials" class="grid_8 omega">
	<?php
$result=dbquery("
	SELECT user_id, user_name, user_status, user_testimonial  
	FROM ".DB_USERS." 
	WHERE user_status = '0' 
	AND user_testimonial !='' 
	AND user_approve !='1'
	ORDER BY RAND() LIMIT 10
"); ?>
	<h2>Testimonials</h2>
	<?php while($data = dbarray($result)): ?>
	<?php $text = nl2br(censorwords($data['user_testimonial'])); ?>
	<blockquote>
		<p><?php echo trimlink($text, 44); ?></p>
		<cite>&ndash; <?php echo profile_link($data['user_id'], $data['user_name'], $data['user_status']); ?></cite> </blockquote>
	<?php endwhile ?>
</div>
<?php
$result=dbquery("
	SELECT addon_id, addon_status, addon_name, addon_description, addon_date, addon_download_count  
	FROM ".DB_ADDONS." 
	WHERE addon_status = '0' 
	ORDER BY addon_date DESC LIMIT 5
");

if (dbrows($result)): ?>
<div id="addons" class="grid_8 omega">
	<h2>Latest Addons</h2>
	<ul class="tbl-border latestnews" style="list-style:none; margin:0;">
		<?php while($data = dbarray($result)): ?>
		<li>
			<h5 class="title"><?php echo "<a href='".INFUSIONS."addondb/view.php?addon_id=".$data['addon_id']."'>".$data['addon_name']."</a>"; ?></h5>
			<p class="excerpt"><?php echo trimlink($data['addon_description'],120); ?></p>
		</li>
		<?php endwhile ?>
	</ul>
</div>
<?php endif ?>
<?php require_once THEMES."templates/footer.php"; ?>