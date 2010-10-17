<?php

if (!defined("IN_FUSION")) { die("Access Denied"); }

function navigation($main_menu=true){
	if ($main_menu) {
		$link = Cache::read('navigation');
		if(!$link) :
			$result = dbquery(
				"SELECT link_name, link_url, link_window, link_visibility FROM ".DB_SITE_LINKS."
				 WHERE link_position='3' ORDER BY link_order"
			 );
			$link = array();
			while ($data = dbarray($result)) :
				$link[] = $data;
			endwhile;
			Cache::write('navigation', $link);
		endif;
		echo "<ul>\n";
		foreach($link as $data) :
			if (checkgroup($data['link_visibility'])) :
				$link_target = $data['link_window'] == "1" ? " target='_blank'" : "";
				$li_class = preg_match("/^".preg_quote(START_PAGE, '/')."/i", $data['link_url']) ? " class='current'" : "";
				if (strstr($data['link_name'], "%submenu% ")) {
					echo"\t\t\t<li$li_class><a href='/".$data['link_url']."'$link_target><span>".parseubb(str_replace("%submenu% ", "",$data['link_name']), "b|i|u|color")."</span></a><ul class='children'>\n";
				} elseif (strstr($data['link_name'], "%endmenu% ")) {
					echo "\t\t\t<li$li_class><a href='/".$data['link_url']."'$link_target><span>".parseubb(str_replace("%endmenu% ", "",$data['link_name']), "b|i|u|color")."</span></a></li>\n</ul></li>\n";
				} elseif (strstr($data['link_url'], "http://") || strstr($data['link_url'], "https://")) {
					echo "\t\t\t<li$li_class><a href='".$data['link_url']."'$link_target><span>".parseubb($data['link_name'], "b|i|u|color")."</span></a></li>\n";
				} else {
					echo "\t\t\t<li$li_class><a href='/".$data['link_url']."'$link_target><span>".parseubb($data['link_name'], "b|i|u|color")."</span></a></li>\n";
				}
			endif;
		endforeach;
		echo "\t\t</ul>\n";
	} else {
		$link = Cache::read('footer');
		$list_open = false;
		if(!$link) :
			$result = dbquery(
				"SELECT link_name, link_url, link_window, link_visibility FROM ".DB_SITE_LINKS."
				 WHERE link_position='1' ORDER BY link_order"
			);
			$link = array();
			while ($data = dbarray($result)) :
				$link[] = $data;
			endwhile;
			Cache::write('footer', $link);
		endif;
		foreach($link as $data) :
			if (checkgroup($data['link_visibility'])) :
				if ($data['link_name'] != "---" && $data['link_url'] == "---") :
					if ($list_open) { echo "\t\t</ul>\n\t</div>\n"; $list_open = false; }
					echo "\n\t<div class='footer grid_4'>\n\t\t<h3>".parseubb($data['link_name'], "b|i|u|color")."</h3>\n";
				elseif ($data['link_name'] == "---" && $data['link_url'] == "---") :
					echo "\t\t\t<li>Method does not exist anymore</li>\n";
				else :
					if (!$list_open) { echo "\t\t<ul>\n"; $list_open = true; }
					$link_target = ($data['link_window'] == "1" ? " target='_blank'" : "");
					if (strstr($data['link_url'], "http://") || strstr($data['link_url'], "https://")) {
						echo "\t\t\t<li><a href='".$data['link_url']."'".$link_target."><span>".parseubb($data['link_name'], "b|i|u|color")."</span></a></li>\n";
					} else {
						echo "\t\t\t<li><a href='/".$data['link_url']."'".$link_target."><span>".parseubb($data['link_name'], "b|i|u|color")."</span></a></li>\n";
					}
				endif;
			endif;
		endforeach;
		if ($list_open) { echo "\t\t</ul>\n\t</div>\n"; }
	}
}

function userinfo() {
	global $userdata, $locale, $aidlink;
	if (iMEMBER) : 
	$msg_count = dbcount("(message_id)", DB_MESSAGES, "message_to='".$userdata['user_id']."' AND message_read='0' AND message_folder='0'"); ?>
	<h4>Logged in as <a href="/profile.php?lookup=<?php echo $userdata['user_id']; ?>"><?php echo $userdata['user_name']; ?></a></h4>
	<ul>
		<?php if (iADMIN) : ?>
		<li><a href="/administration/index.php<?php echo $aidlink; ?>" class="admin">Admin</a></li>
		<?php else : ?>
		<li>Welcome</li>
		<?php endif; ?>		
		<li><a href="/edit_profile.php" class="settings">Settings</a></li>
		<li><a href="/messages.php"<?php echo $msg_count ? " title='".sprintf($locale['global_125'], $msg_count).($msg_count == 1 ? $locale['global_126'] : $locale['global_127'])."'" : ""; ?> class="<?php echo $msg_count ? "newmessage" : "messages"; ?>">Messages</a></li>
		<li><a href="/setuser.php?logout=yes" class="logout">Logout</a></li>
	</ul>
	<?php else : ?>
	<h4>Membership</h4>
	<a href="/login.php" class="button"><span>Login</span></a> 
	<a href="/register.php" class="button"><span>Become a member</span></a>
	<?php endif;
}

function static_content(){
	STATIC_HOST ? $path=STATIC_DOMAIN : $path=THEME;
	return $path;
}

function curr_virtdir($part=false){
        $url = explode('/',$_SERVER['REQUEST_URI']);		
        $part ? $dir = (isset($url[2]) ? $url[2] : '') : $dir = $url[1] ? $url[1] : ''; 
        $dir = htmlentities(trim(strip_tags($dir)));
        return $dir;
}

function in_forum(){
	return curr_virtdir() == 'forum' ? true : false;
}

function in_addon(){
	return curr_virtdir(true) == 'addondb' ? true : false;
}

class Cache {

	public static function read($fileName) {
		$fileName = THEME.'tmp/'.sha1($fileName).'.tmp';
		if (file_exists($fileName)) {
			$handle = fopen($fileName, 'rb');
			$variable = fread($handle, filesize($fileName));
			fclose($handle);
			return unserialize($variable);
		} else {
			return NULL;
		}
	}

	public static function write($fileName,$variable) {
		$fileName = THEME.'tmp/'.sha1($fileName).'.tmp';
		$handle = fopen($fileName, 'a');
		fwrite($handle, serialize($variable));
		fclose($handle);
	}

    public static function delete($fileName) {
        $fileName = THEME.'tmp/'.sha1($fileName).'.tmp';
        @unlink($fileName);
    }

}

function getLastXTwitterStatus($userid,$x){
$url = "http://twitter.com/statuses/user_timeline/$userid.xml?count=$x";

$xml = simplexml_load_file($url) or die('could not connect');
	echo '<ul>';
       foreach($xml->status as $status){
       $text = twitterify( $status->text );
	   echo '<li>'.utf8_decode($text).'</li>';
       }
    echo '</ul>';
 }

function twitterify($ret) {
  $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" >\\2</a>", $ret);
  $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" >\\2</a>", $ret);
  $ret = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" >@\\1</a>", $ret);
  $ret = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" >#\\1</a>", $ret);
return $ret;
}


if (iADMIN && isset($_POST['savelink']) || isset($_GET['action']) && FUSION_SELF == "site_links.php") { $cache = new Cache(); Cache::delete('navigation'); Cache::delete('footer'); }



