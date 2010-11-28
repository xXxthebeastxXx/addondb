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
					echo "        <li$li_class><a href='/".$data['link_url']."'$link_target><span>".parseubb(str_replace("%submenu% ", "",$data['link_name']), "b|i|u|color")."</span></a>\n        <ul class='children'>\n";
				} elseif (strstr($data['link_name'], "%endmenu% ")) {
					echo "        <li$li_class><a href='/".$data['link_url']."'$link_target><span>".parseubb(str_replace("%endmenu% ", "",$data['link_name']), "b|i|u|color")."</span></a></li>\n        </ul>\n        </li>\n";
				} elseif (strstr($data['link_url'], "http://") || strstr($data['link_url'], "https://")) {
					echo "        <li$li_class><a href='".$data['link_url']."'$link_target><span>".parseubb($data['link_name'], "b|i|u|color")."</span></a></li>\n";
				} else {
					echo "        <li$li_class><a href='/".$data['link_url']."'$link_target><span>".parseubb($data['link_name'], "b|i|u|color")."</span></a></li>\n";
				}
			endif;
		endforeach;
		echo "      </ul>\n";
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
					if ($list_open) { echo "			</ul>\n		</div>\n"; $list_open = false; }
					echo "		<div class='footer grid_4'>\n			<h3>".parseubb($data['link_name'], "b|i|u|color")."</h3>\n";
				elseif ($data['link_name'] == "---" && $data['link_url'] == "---") :
					echo "				<li>Method does not exist anymore</li>\n";
				else :
					if (!$list_open) { echo "			<ul>\n"; $list_open = true; }
					$link_target = ($data['link_window'] == "1" ? " target='_blank'" : "");
					if (strstr($data['link_url'], "http://") || strstr($data['link_url'], "https://")) {
						echo "				<li><a href='".$data['link_url']."'".$link_target."><span>".parseubb($data['link_name'], "b|i|u|color")."</span></a></li>\n";
					} else {
						echo "				<li><a href='/".$data['link_url']."'".$link_target."><span>".parseubb($data['link_name'], "b|i|u|color")."</span></a></li>\n";
					}
				endif;
			endif;
		endforeach;
		if ($list_open) { echo "			</ul>\n		</div>\n"; }
	}
}

function build_navigation($title,$d=false) {
	$list_open = false;
	if ($d) {
		openside($title);
		echo "<div id='navigation'>\n";
		foreach($d as $d) {
			if ($d['link_name'] != "---" && $d['link_url'] == "---") {
				if ($list_open) { echo "</ul>\n"; $list_open = false; }
				echo "<h4>".$d['link_name']."</h4>\n";
			} else if ($d['link_name'] == "---" && $d['link_url'] == "---") {
				if ($list_open) { echo "</ul>\n"; $list_open = false; }
				echo "<hr class='side-hr' />\n";
			} else {
				if (!$list_open) { echo "<ul>\n"; $list_open = true; }
				$link_target = ($d['link_window'] == "1" ? " target='_blank'" : "");
				if (strstr($d['link_url'], "http://") || strstr($d['link_url'], "https://")) {
					echo "<li><a href='".$d['link_url']."'".$link_target." class='side'><span>".$d['link_name']."</span></a></li>\n";
				} else {
					echo "<li><a href='/".$d['link_url']."'".$link_target." class='side'><span>".$d['link_name']."</span></a></li>\n";
				}
			}
		}
		if ($list_open) { echo "</ul>\n"; }
		echo "</div>\n";
	}
}

function userinfo() {
	global $userdata, $locale, $aidlink;
	if (iMEMBER): 
	$msg_count = dbcount("(message_id)", DB_MESSAGES, "message_to='".$userdata['user_id']."' AND message_read='0' AND message_folder='0'"); ?>
<h4>Logged in as <a href="/profile.php?lookup=<?php echo $userdata['user_id']; ?>"><?php echo $userdata['user_name']; ?></a></h4>
      <ul>
<?php if (iADMIN): ?>
        <li><a href="/administration/index.php<?php echo $aidlink; ?>" class="admin">Admin</a></li>
<?php else: ?>
        <li>Welcome</li>
<?php endif ?>
        <li><a href="/edit_profile.php" class="settings">Settings</a></li>
        <li><a href="/messages.php"<?php echo $msg_count ? " title='".sprintf($locale['global_125'], $msg_count).($msg_count == 1 ? $locale['global_126'] : $locale['global_127'])."'" : ""; ?>><?php echo $msg_count ? "New message" : "Messages"; ?></a></li>
        <li><a href="/setuser.php?logout=yes" class="logout">Logout</a></li>
      </ul>
<?php else: ?>
<h4>Membership</h4>
<a href="/login.php" class="button"><span>Login</span></a> <a href="/register.php" class="button"><span>Become a member</span></a>
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

function limit_words($words, $limit, $append = ' &hellip;') {    
       $limit = $limit+1;
       $words = explode(' ', $words, $limit);    
       array_pop($words);
       $words = implode(' ', $words) . $append;
       return $words;
}

function cleanInput($input) {

  $search = array(
    '@<script[^>]*?>.*?</script>@si',
    '@<[\/\!]*?[^<>]*?>@si',
    '@<style[^>]*?>.*?</style>@siU',
    '@<![\s\S]*?--[ \t\n\r]*>@'
  );

    $output = preg_replace($search, '', $input);
    return $output;
  }

if (iADMIN && isset($_POST['savelink']) || isset($_GET['action']) && FUSION_SELF == "site_links.php") { $cache = new Cache(); Cache::delete('navigation'); Cache::delete('footer'); } 