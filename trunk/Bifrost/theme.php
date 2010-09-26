<?php

if (!defined("IN_FUSION")) { die("Access Denied"); }

define("THEME_BULLET", "");

require_once INCLUDES."theme_functions_include.php";
require_once THEME."config.php";
require_once THEME."header.php";
require_once THEME."functions.php";
require_once THEME."footer.php";

redirect_img_dir(THEME."forum", THEME."images/forum");
set_image("pollbar", THEME."images/navbg.jpg");
set_image("folder", THEME."images/forum/folder.png");
set_image("foldernew", THEME."images/forum/foldernew.png");
set_image("folderlock", THEME."images/forum/folderlock.png");
set_image("stickythread", THEME."images/forum/stickythread.png");
set_image("reply", "reply");
set_image("newthread", "newthread");
set_image("web", "web");
set_image("pm", "pm");
set_image("quote", "quote");
set_image("forum_edit", "forum_edit");

function render_page() {
	global $aidlink, $locale, $settings; add_handler("theme_head_output"); ?>
<div id="header">
<div class="container_24">
	<div id="logo" class="grid_6">
		<?php echo showbanners(); ?>
	</div><!-- /logo -->
	<div id="nav" class="grid_15">
		<?php preg_replace("^(li)( class='(first-link)')*(><a href='(/)*".preg_quote(START_PAGE)."')^i", "\\1 class='active \\3'\\4", navigation()); ?>
	</div><!-- /nav -->
	</div>
</div><!-- /header -->
<div id="content" class="container_24">
	<div id="main" class="<?php echo in_forum() || in_addon() ? 'grid_24' : 'grid_15'; ?>">
		<?php echo U_CENTER; ?>
		<?php echo CONTENT; ?>
		<?php echo L_CENTER."\n"; ?>
	</div><!-- /main -->
	<?php echo in_forum() || in_addon() ? "" : (LEFT || RIGHT ? '<div id="aside" class="grid_9"><!-- aside -->' : ''); ?>
		<?php echo in_forum() || in_addon() ? "" : (LEFT ? LEFT : '').(RIGHT ? RIGHT : ''); ?>
	<?php echo in_forum() || in_addon() ? "" : (LEFT || RIGHT ? '</div><!-- /aside -->' : ''); ?>
	<div class="clearfix"></div>
</div><!-- /content -->
<div id="footer">
<div class="container_24">
	<?php navigation(false); ?>
	<div class="clearfix"></div>
	<div id="subfooter">
	<?php echo "<small>".showcopyright()."\t</small>\n"; ?>
</div><!-- /subfooter -->
</div>
</div><!-- /footer -->
<?php get_footer_tags(); ?>
<?php echo (DEBUG ? "<div id='debug'><strong>Debug is on </strong>" : "<!-- ").showrendertime().(DEBUG ? "</div><!-- /debug -->": " -->")."\n";
}
$ni=0;
function render_news($subject, $news, $info) {
	static $ni;
	global $locale,$data,$settings; 
		echo $ni == 0 ? "\n" : "\t\t<hr />\n"; ?>
		<p class="posttime">
			<strong class="month-year"><?php echo substr(strtolower(showdate("%B", $info['news_date'])), 0, 3); ?><br /><?php echo showdate("%Y", $info['news_date']); ?></strong>
			<strong class="day"><?php echo showdate("%d", $info['news_date']); ?></strong>
		</p>	
		<?php echo !isset($_GET['readmore']) && $info['news_ext'] == "y" ? "<h2 class='posttitle'><a href='/news.php?readmore=".$info['news_id']."'>".strip_tags($subject)."</a></h2>\n" : opentable($subject); ?>
		<p class="postmetadata">
			<span class="i-cat"><?php echo substr(newscat($info), 18); ?></span>
			<span class="i-tag"><?php echo profile_link($info['user_id'], $info['user_name'], $info['user_status']); ?></span>
			<span class="i-com"><?php echo $info['news_allow_comments'] && $settings['comments_enabled'] == "1" ? "<a href='news.php?readmore=".$info['news_id']."#comments'>".($info['news_comments'] != 0 ? $info['news_comments'] : "").($info['news_comments'] == 1 || $info['news_comments'] == 0  ? $locale['global_073b'] : $locale['global_073'])."</a>": ""; ?></span>
		</p>
		<div class="post">
			<?php echo "$news\n"; ?>
		</div>
<?php	closetable().$ni++;
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
	echo !empty($title) ? "<h4>$title</h4>\n" : "";
}

function closeside() {
	echo "<!-- /side -->";
}