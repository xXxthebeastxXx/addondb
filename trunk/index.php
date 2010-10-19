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
?>

<h1>PHP-Fusion Content Management System</h1>
<div id="accordion">
  <dl>
    <dt>Welcome To</dt>
    <dd><span style="float:right;"><img src="images/forum_splash_2.png" width="249" alt="Main Splash" /></span>
      <h2>PHP-Fusion</h2>
      <p>Welcome to the official site of PHP-Fusion, a light-weight open-source content management system (CMS). PHP-Fusion is written in PHP and MySQL and includes a simple, comprehensive administration system as well as Forum, Photogallery, Articles, FAQ and much more.<br />
        <a href="#" class="more">Read more</a></p>
    </dd>
    <dt>Getting Started</dt>
    <dd><span style="float:right;"><img src="images/admin_splash.png" width="277" alt="Admin Splash" /></span>
      <h2>Getting Started</h2>
      <p>We'll show you how to find your way around your newly installed PHP-Fusion site with pointers and ideas on how to get the best out of it. PHP-Fusion is a highly customizable Content Management System [CMS] and can be configured to suit most website owners needs.<br />
        <a href="#" class="more">Read more</a></p>
    </dd>
    <dt>Requirements</dt>
    <dd><span style="float:right;"><img src="images/member_splash.png" width="312" alt="Admin Splash" /></span>
      <h2>Requirements</h2>
      <p>All you need is some web space that supports PHP and access to a MySQL database. We'll show you can easily set up your own site in minutes as well as how best to configure your site to suit your individual needs.<br />
        <a href="#" class="more">Read more</a></p>
    </dd>
    <dt>Handbook</dt>
    <dd><span style="float:right;"><img src="images/search_splash.png" width="263" alt="Admin Splash" /></span>
      <h2>Handbook</h2>
      <p>As well as extensive documents onsite, you can also download the comprehensive handbook which step by step demonstrates how to install and set up your site. It also details how to configure each section to suit your needs. <br />
        <a href="#" class="more">Read more</a></p>
    </dd>
  </dl>
</div>
<br />
<div class="clearfix">&nbsp;</div>
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
<br />
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
	SELECT user_id, user_name, user_status, user_testimonial, user_avatar 
	FROM ".DB_USERS." 
	WHERE user_status = '0' 
	AND user_testimonial !='' 
	AND user_approve !='1'
	ORDER BY RAND() LIMIT 5
");

if (dbrows($result)): ?>
<div class="grid_12 omega">
  <h2>Testimonials</h2>
  <ul id="testimonials" class="tbl-border">
    <?php while($data = dbarray($result)): ?>
    <li>
      <?php $text = nl2br(censorwords($data['user_testimonial'])); ?>
      <blockquote>
        <p>
          <?php if(!empty($data['user_avatar'])): ?>
          <img src="/images/avatars/<?php echo $data['user_avatar']; ?>" alt="<?php echo $data['user_name']; ?>" title="<?php echo $data['user_name']; ?>" />
          <?php endif ?>
          <?php echo $text ?></p>
        <br />
        <cite>&mdash; <?php echo profile_link($data['user_id'], $data['user_name'], $data['user_status']); ?></cite> </blockquote>
    </li>
    <?php endwhile ?>
  </ul>
</div>
<?php endif ?>
<?php require_once THEMES."templates/footer.php";
