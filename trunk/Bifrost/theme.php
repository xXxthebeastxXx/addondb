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

function render_page() {
	global $aidlink, $locale, $settings;
	add_handler("theme_head_output"); ?>
<div id="header">
	<div id="logo" class="grid_6 push_1">
		<?php echo showbanners(); ?>
	</div><!-- /logo -->
	<div id="nav" class="grid_15 push_2">
		<?php echo preg_replace("^(li)( class='(first-link)')*(><a href='(/)*".preg_quote(START_PAGE)."')^i", "\\1 class='active \\3'\\4", navigation()); ?>
	</div><!-- /nav -->
</div><!-- /header -->
<div id="content">
	<div id="main" class="<?php echo in_forum() || in_addon() ? 'grid_22' : 'grid_15'; ?> push_1">
		<?php echo U_CENTER; ?>
		<?php echo CONTENT; ?>
		<?php echo L_CENTER."\n"; ?>
	</div><!-- /main -->
	<?php echo in_forum() || in_addon() ? "" : (LEFT || RIGHT ? '<div id="aside" class="grid_6 push_2"><!-- aside -->' : ''); ?>
		<?php echo in_forum() || in_addon() ? "" : (LEFT ? LEFT : '').(RIGHT ? RIGHT : ''); ?>
	<?php echo in_forum() || in_addon() ? "" : (LEFT || RIGHT ? '</div><!-- /aside -->' : ''); ?>
</div><!-- /content -->
<div id="footer">
	<?php echo navigation(false); ?>
	<div class="grid_9 push_2">
		<h4>Lorem Ipsum</h4>
		<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when a unknown printer took galley of type and make.</p>
	</div>
	<div class="grid_7 push_3">
		<h4>Connect with the community</h4>
		<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when a unknown printer took galley of type and make.</p>
		<h5>Follow us</h5>
		<ul class="footer_connect">
			<li class="twitter"><a href="">Follow us on Twitter</a></li>
			<li class="facebook"><a href="">Be a fan on Facebook</a></li>
			<li class="rss"><a href="">RSS Feed</a></li>
			<li class="contact"><a href="">Contact us</a></li>
		</ul>
	</div>
	<div class="clearfix"></div>
</div><!-- /footer -->
<div id="subfooter">
	<?php echo "<small>".showcopyright()."\t</small>\n"; ?>
</div><!-- /subfooter -->
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