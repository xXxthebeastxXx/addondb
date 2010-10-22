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
set_image("up", STATIC_DOMAIN."cssimg/up.png");
set_image("down", STATIC_DOMAIN."cssimg/down.png");
set_image("left", STATIC_DOMAIN."cssimg/left.png");
set_image("right", STATIC_DOMAIN."cssimg/right.png");
set_image("pollbar", STATIC_DOMAIN."cssimg/navbg.jpg");
set_image("folder", STATIC_DOMAIN."cssimg/forum/folder.png");
set_image("foldernew", STATIC_DOMAIN."cssimg/forum/foldernew.png");
set_image("folderlock", STATIC_DOMAIN."cssimg/forum/folderlock.png");
set_image("stickythread", STATIC_DOMAIN."cssimg/forum/stickythread.png");
set_image("printer", STATIC_DOMAIN."cssimg/forum/print.gif");
set_image("reply", "reply");
set_image("newthread", "newthread");
set_image("web", "web");
set_image("pm", "pm");
set_image("quote", "quote");
set_image("forum_edit", "forum_edit");