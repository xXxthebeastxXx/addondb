<?php

if (!defined("IN_FUSION")) { die("Access Denied"); }

define("DEBUG", true);

/*
 * Host for static content.
 */
define("STATIC_HOST", true);
define("STATIC_DOMAIN", "http://cdn.php-fusion.co.uk/");

/*
 * Analytics settings.
 * 1. Analytics on or off.
 * 2. Account trackcode.
 * 3. Turn multi subdomain on or off.
 * 4. Analytics Domain name.
 */
define("ANALYTICS", false);
define("ANALYTICS_ACCOUNT", "UA-XXXXXXXX-X");
define("ANALYTICS_MULTI", false);
define("ANALYTICS_DOMAIN", ".php-fusion.co.uk");

/*
 * Set custom images
 */
define("THEME_BULLET", "");
set_image("up", THEME."images/up.png");
set_image("down", THEME."images/down.png");
set_image("left", THEME."images/left.png");
set_image("right", THEME."images/right.png");
set_image("pollbar", THEME."images/navbg.jpg");
set_image("folder", THEME."images/forum/folder.png");
set_image("foldernew", THEME."images/forum/foldernew.png");
set_image("folderlock", THEME."images/forum/folderlock.png");
set_image("stickythread", THEME."images/forum/stickythread.png");
set_image("reply", "reply");
set_image("newthread", "newthread");
set_image("web", "web");
set_image("pm", "pm");
set_image("quote", "quote");
set_image("forum_edit", "forum_edit");