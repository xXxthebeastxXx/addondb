<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: getting_started.php
| Author: Philip Daly (HobbyMan)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

define("EDOC", INFUSIONS."edocs/");
define("EDOC_IMGS", EDOC."imgs/");
define("EDOC_INC", EDOC."inc/");
define("EDOC_LOC", EDOC."locale/");
require EDOC_INC."functions.php";
add_to_head("
<script type='text/javascript' src='".STATIC_DOMAIN."js/scroll.js'></script>
");
include LOCALE.LOCALESET."admin/main.php";
if (file_exists(EDOC_LOC."/".$settings['locale']."/index.php")) {
	include EDOC_LOC."/".$settings['locale']."/header.php";
	include EDOC_LOC."/".$settings['locale']."/content_admin.php";
	include EDOC_LOC."/".$settings['locale']."/user_admin.php";
	include EDOC_LOC."/".$settings['locale']."/system_admin.php";
	include EDOC_LOC."/".$settings['locale']."/settings_admin.php";
} else {
	include EDOC_LOC."English/header.php";
	include EDOC_LOC."English/content_admin.php";
	include EDOC_LOC."English/user_admin.php";
	include EDOC_LOC."English/system_admin.php";
	include EDOC_LOC."English/settings_admin.php";
}

$author = " Philip Daly | Johan Wilson";
$version = "v1.1";

include EDOC."edoc_nav.php";
include EDOC."header_include.php";
include EDOC."doc_content.php";
include EDOC."footer_include.php";

require_once THEMES."templates/footer.php";
?>