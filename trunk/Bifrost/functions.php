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
		$i = 0; echo "<ul>\n";
		foreach($link as $data) :
			if (checkgroup($data['link_visibility'])) :
				$link_target = $data['link_window'] == "1" ? " target='_blank'" : "";
				$li_class = ($i == 0 ? " class='first-link'" : "");
				if (strstr($data['link_name'], "%submenu% ")) {
					echo "\t\t\t<li".$li_class."><a href='".$data['link_url']."'$link_target><span>".parseubb(str_replace("%submenu% ", "",$data['link_name']), "b|i|u|color")."</span></a><ul class='children'>\n";
				} elseif (strstr($data['link_name'], "%endmenu% ")) {
					echo "\t\t\t<li".$li_class."><a href='/".$data['link_url']."'$link_target><span>".parseubb(str_replace("%endmenu% ", "",$data['link_name']), "b|i|u|color")."</span></a></li>\n</ul></li>\n";
				} elseif (strstr($data['link_url'], "http://") || strstr($data['link_url'], "https://")) {
					echo "\t\t\t<li".$li_class."><a href='".$data['link_url']."'$link_target><span>".parseubb($data['link_name'], "b|i|u|color")."</span></a></li>\n";
				} else {
					echo "\t\t\t<li".$li_class."><a href='/".$data['link_url']."'$link_target><span>".parseubb($data['link_name'], "b|i|u|color")."</span></a></li>\n";
				}
				$i++;
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
						echo "\t\t\t<li><a href='".$data['link_url']."'".$link_target.">".THEME_BULLET." <span>".parseubb($data['link_name'], "b|i|u|color")."</span></a></li>\n";
					} else {
						echo "\t\t\t<li><a href='/".$data['link_url']."'".$link_target.">".THEME_BULLET." <span>".parseubb($data['link_name'], "b|i|u|color")."</span></a></li>\n";
					}
				endif;
			endif;
		endforeach;
		if ($list_open) { echo "\t\t</ul>\n\t</div>\n"; }
	}
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

if (iADMIN && isset($_POST['savelink']) || isset($_GET['action']) && FUSION_SELF == "site_links.php") { $cache = new Cache(); Cache::delete('navigation'); Cache::delete('footer'); }



