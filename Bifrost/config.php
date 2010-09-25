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