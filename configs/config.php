<?php

if (! defined('SITE_URL')) {
	define('SITE_URL', '/myapp3');
}

define('DEBUG_MODE', true);
	
date_default_timezone_set('PRC');

//Session
$login_session_time_out = 60 * 60 * 24;
ini_set('session.gc_maxlifetime', $login_session_time_out);
//ini_set('session.save_path',  '/home/site/sessions/');
//ini_set('session.cookie_domain',  '.site.com');

//DB config
global $DBCFG;
$DBCFG = include dirname(__FILE__) . '/db_config.php';

?>