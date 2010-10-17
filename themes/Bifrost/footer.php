<?php

if (!defined("IN_FUSION")) { die("Access Denied"); }

function get_footer_tags(){
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script>!window.jQuery && document.write('<script src="<?php echo static_content(); ?>js/jquery-1.4.2.min.js"><\/script>')</script>
<?php if (DEBUG) : ?>
<script src="<?php echo static_content(); ?>js/plugins.js?v=1"></script>
<script src="<?php echo static_content(); ?>js/script.js?v=1"></script>
<?php else : ?>
<script src="<?php echo static_content(); ?>js/combined.js?v=1"></script>
<?php endif; ?>
<script>
$(function(){
    $('#testimonials li:gt(0)').hide();
    setInterval(function(){
      $('#testimonials li:first-child').hide()
         .next('li').fadeIn()
         .end().appendTo('#testimonials');}, 

      10000);
});
</script>
<!--[if lt IE 7 ]><script src="<?php echo static_content(); ?>js/dd_belatedpng.js?v=1"></script><![endif]-->
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