<?php

if (!function_exists("fetch_url")) {
   function fetch_url() {
      $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
      return $url;
   }
}
	echo "<br /><center>\n";
	echo "<a target='_blank' href='http://www.facebook.com/share.php?u=" . fetch_url() . "' title=''><img src='".ADDON_IMG."facebook.png' alt='Facebook' /></a>&nbsp;\n";
	echo "<a target='_blank' href='http://twitter.com/share?url=" . fetch_url() . "' title=''><img src='".ADDON_IMG."twitter.png' alt='Twitter' /></a>&nbsp;\n";
	echo "<a target='_blank' href='http://digg.com/submit?url=" . fetch_url() . "' title=''><img src='".ADDON_IMG."digg.png' alt='Digg' /></a>&nbsp;\n";
	echo "<a target='_blank' href='http://reddit.com/submit?url=" . fetch_url() . "' title=''><img src='".ADDON_IMG."reddit.png' alt='Reddit' /></a>&nbsp;\n";
	echo "<a target='_blank' href='http://del.icio.us/post?url=" . fetch_url() . "' title=''><img src='".ADDON_IMG."delicious.png' alt='Del.icio.us' /></a>&nbsp;\n";
	echo "</center>\n"; 
	
?>