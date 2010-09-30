<?php

if (!defined("IN_FUSION")) { die("Access Denied"); }

require_once INCLUDES."theme_functions_include.php";
require_once THEME."config.php";
require_once THEME."header.php";
require_once THEME."functions.php";
require_once THEME."footer.php";

function render_page() {
	global $aidlink, $locale, $settings, $userdata; add_handler("theme_head_output"); ?>
<div id="content" class="container_24">
<div id="header">
	<div id="logo" class="grid_6">
		<?php echo showbanners(); ?>
	</div><!-- /logo -->
	<div id="nav" class="grid_16 push_1">
		<?php navigation(); ?>
	</div><!-- /nav -->
	<div class="grid_9 hinfo">
	1</div>
	<div class="grid_6 push_1 hinfo">
	<h4>Search the site</h4>
	<form name="search" method="get" action="/search.php">
	<input type="search" name="stext" class="textsearch" />
	<button type="submit" class="forumbutton"><span>Search</span></button>
	</form>
	</div>
	<div class="grid_6 push_2 userinfo hinfo">
	<?php userinfo(); ?>
	</div>
</div><!-- /header -->
	<div id="main" class="<?php echo in_forum() || in_addon() ? 'grid_24' : 'grid_16'; ?>">
		<?php echo U_CENTER; ?>
		<?php echo CONTENT; ?>
		<?php echo L_CENTER."\n"; ?>
	</div><!-- /main -->
	<?php echo in_forum() || in_addon() ? "" : (LEFT || RIGHT ? '<div id="aside" class="grid_6 push_1"><!-- aside -->' : ''); ?>
		<?php echo in_forum() || in_addon() ? "" : (LEFT ? LEFT : '').(RIGHT ? RIGHT : ''); ?>
	<?php echo in_forum() || in_addon() ? "" : (LEFT || RIGHT ? '</div><!-- /aside -->' : ''); ?>
	<div class="clearfix"></div>
</div><!-- /content -->
<div id="footer">
	<div class="container_24">
		<?php navigation(false); ?>
		<div class="grid_6 push_1">
		<h3>some pretty content</h3>
		</div>
		<div class="clearfix"></div>
		<div id="subfooter">
			<small>Copyright © 2002 - 2010 by Nick Jones.</small>
		</div><!-- /subfooter -->
	</div>
</div><!-- /footer -->
<?php get_footer_tags(); ?>
<?php echo (DEBUG ? "<div id='debug'><strong>Debug is on </strong>" : "<!-- ").showrendertime().(DEBUG ? "</div><!-- /debug -->": " -->")."\n";
}

function render_news($subject, $news, $info) {
	global $locale,$data,$settings; 
		echo !isset($_GET['readmore']) && $info['news_ext'] == "y" ? "<h2 class='posttitle'><a href='/news.php?readmore=".$info['news_id']."'>".strip_tags($subject)."</a></h2>\n" : opentable($subject); ?>
		<div class="postmeta">
			<span><?php echo showdate("%B %d, %Y", $info['news_date']); ?></span>
			<span class="i-cat">in <?php echo substr(newscat($info), 18); ?> </span>
			<span class="i-aur">by <?php echo profile_link($info['user_id'], $info['user_name'], $info['user_status']); ?></span>
			<span class="i-com"> <?php echo $info['news_allow_comments'] && $settings['comments_enabled'] == "1" ? "<a href='news.php?readmore=".$info['news_id']."#comments'>".($info['news_comments'] != 0 ? $info['news_comments'] : "").($info['news_comments'] == 1 || $info['news_comments'] == 0  ? $locale['global_073b'] : $locale['global_073'])."</a>": ""; ?></span>
		</div>
		<div class="post">
			<?php echo "$news\n"; ?>
		</div>
<?php	closetable();
}

function render_article($subject, $article, $info) {
	global $locale;	
	opentable($subject);
	echo "<div class='floatfix'>".($info['article_breaks'] == "y" ? nl2br($article) : $article)."</div>
	<div class='news-footer'>
		".articleposter($info," &middot;").articleopts($info,"&middot;").itemoptions("A",$info['article_id']).
	"</div>\n";
	closetable();
}

$pi=0;
function opentable($title="") {
	static $pi;
	echo (!empty($title) ? ($pi==0 ? "<h1 class='title'>$title</h1>" : "<h2 class='title'>$title</h2>") : "")."\n";
	$pi++;
}

function closetable() {
	echo "\t\t<!-- /section -->\n";
}

function openside($title="", $collapse = false, $state = "on") {
	echo !empty($title) ? "<h3>$title</h3>\n" : "";
}

function closeside() {
	echo "<!-- /side -->";
}