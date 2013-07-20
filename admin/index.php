<?php if ( ! defined('ROOT')) exit('Access forbidden');

	require_once LIB_PATH . 'framework/application.php';
	require_once APP_PATH . 'base_controller.php';
	include_once APP_PATH . 'functions.php';

	$APP = new Application(APP_PATH);	
	$APP->initDB($DBCFG);	
	$APP->run();
	
?>
