<?php

if (!defined("IN_FUSION")) { die("Access Denied"); }

function get_footer_tags(){
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo static_content(); ?>js/jquery-1.4.3.min.js"%3E%3C/script%3E'))</script>
<?php if (DEBUG) : ?>
<script src="<?php echo static_content(); ?>js/plugins.js?v=1.1"></script>
<script src="<?php echo static_content(); ?>js/script.js?v=1.1"></script>
<?php else : ?>
<script src="<?php echo static_content(); ?>js/combined.js?v=1.4"></script>
<?php endif; ?>
<!--[if lt IE 7 ]>
	<script src="<?php echo static_content(); ?>js/dd_belatedpng.js?v=1.1"></script>
	<script>DD_belatedPNG.fix('img, .png_bg');</script>
<![endif]-->
<?php if (ANALYTICS) : ?>
<script>
var _gaq = [['_setAccount', '<?php echo ANALYTICS_ACCOUNT; ?>'], <?php echo ANALYTICS_MULTI ? "['_setDomainName', '".ANALYTICS_DOMAIN."'], " : ""; ?>['_trackPageview']];
(function(d, t) {
	var g = d.createElement(t), s = d.getElementsByTagName(t)[0];
	g.async = true; g.src = '//www.google-analytics.com/ga.js'; s.parentNode.insertBefore(g, s);
})(document, 'script');
</script>
<?php endif;
}