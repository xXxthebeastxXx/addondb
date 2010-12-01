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
			<h4>National Support Network</h4>
			<p id="profile"></p>
		</div><!-- /nss -->
		<div class="grid_6 push_1 hinfo">
			<h4>Search the site</h4>
			<form action="/search.php" id="search" method="get" role="search">
				<div>
					<label for="s" class="screen-reader-text">Search for:</label>
					<input type="text" id="s" name="stext" value="">
					<input type="submit" value="Search" id="searchsubmit">
				</div>
			</form>
		</div><!-- /search -->
		<div class="grid_6 push_2 userinfo hinfo">
			<?php userinfo(); ?>
		</div><!-- /userinfo --> 
	</div><!-- /header -->
	<div id="main" class="grid_24">
	<?php echo U_CENTER; ?> <?php echo CONTENT; ?> <?php echo L_CENTER; ?>
	</div><!-- /main --> 
</div>
<!-- /content -->
<div id="footer">
	<div class="container_24" style="padding-bottom:20px;">
		<?php navigation(false); ?>
		<div class="grid_6 push_1">
			<h3>Partners</h3>
			<h4>Hosting provided by:</h4>
			<a target="_blank" href="http://www.xlshosting.nl/"><img style="height:50px;position:relative;top:3px;" src="http://cdn.php-fusion.co.uk/images/xls.png" alt="xls" /></a>
		</div>
		<div id="subfooter" class="grid_24">
			<small style="padding:10px 0">Powered by PHP-Fusion copyright &copy; 2002 - <?php echo date("Y"); ?> by Nick Jones. Released as free software without warranties under <a href='http://www.fsf.org/licensing/licenses/agpl-3.0.html' target="_blank" rel="nofollow">GNU Affero GPL</a> v3.</small>
		</div><!-- /subfooter --> 
		<div class="clearfix"></div>
	</div>
</div><!-- /footer -->
<?php if(iGUEST) : ?>
<div id="modal-content" style="display:none">
	<div id="modal-title">Welcome! Please login below.</div>
	<div class="close"><a href="#" class="simplemodal-close">x</a></div>
	<div id="modal-data">
		<form action="<?php echo FUSION_SELF; ?>" method="post" name="loginform">
			<fieldset>
				<legend>Your Login details</legend>
				<label for="user_name"><strong>Username:</strong></label>
				<input type="text" name="user_name" id="user_name" size="30" /><br />
				<label for="user_pass"><strong>Password:</strong></label>
				<input type="password" name="user_pass" id="user_pass" size="30" /><br />
				<label for="remember_me"><strong>Remember Me:</strong></label>
				<input type="checkbox" value="y" name="remember_me" id="remember_me" /><br />
			</fieldset>
			<h3>Forgotten your password?</h3>
			<p>Request a new one <a href="/lostpassword.php">here</a>.</p>
			<p><button type="submit" name="login" class="button"><span>Login</span></button> <a href="#" class="simplemodal-close" style="margin-left:10px">Cancel</a> <span>(or press ESC)</span></p>
		</form>
	</div>
</div>
<?php endif ?>
<?php get_footer_tags(); ?>
<?php echo (DEBUG ? "<div id='debug'><strong>Debug is on </strong>" : "<!-- ").showrendertime().(DEBUG ? "</div><!-- /debug -->": " -->")."\n";
}

function render_news($subject, $news, $info) {
	global $locale,$data,$settings; 
		echo !isset($_GET['readmore']) && $info['news_ext'] == "y" ? "<h2 class='posttitle'><a href='/news.php?readmore=".$info['news_id']."'>".strip_tags($subject)."</a></h2>\n" : opentable($subject); ?>
<div class="postmeta"> <span><?php echo showdate("%B %d, %Y", $info['news_date']); ?></span> <span class="i-cat">in <?php echo substr(newscat($info), 18); ?> </span> <span class="i-aur">by <?php echo profile_link($info['user_id'], $info['user_name'], $info['user_status']); ?></span> <span class="i-com"> <?php echo $info['news_allow_comments'] && $settings['comments_enabled'] == "1" ? "<a href='news.php?readmore=".$info['news_id']."#comments'>".($info['news_comments'] != 0 ? $info['news_comments'] : "").($info['news_comments'] == 1 || $info['news_comments'] == 0  ? $locale['global_073b'] : $locale['global_073'])."</a>": ""; ?></span> </div>
<div class="post"> <?php echo "$news\n"; ?> </div>
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