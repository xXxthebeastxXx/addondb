<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright Š 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: !addon_bbcode_include.php
| Author: Johan Wilson
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

$text = preg_replace('#\[addon=(.*?)\](.*?)\[/addon\]#si', '<a class="button" href="/infusions/addondb/view.php?addon_id=$1"><span>$2</span></a>', $text);

?>