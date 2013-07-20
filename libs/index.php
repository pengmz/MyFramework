<?php
	define('DEBUG_MODE', true);
	
	date_default_timezone_set('PRC');
	
	$start = microtime(true);
	
	include_once dirname(__FILE__) . '/app.php';
	
	function hello() {
		echo 'Hello world!';
	}
	
//	$CONTEXT = new Context();
//	$CONTEXT->setParameter('do', 'hello');
//	$CONTEXT->setParameter('c', 'abc');
	
	$APP = new App();	
	$APP->action('hello', 'hello');
//	$APP->addAction(array('do' => 'hello', 'c' => 'abc'), 'hello');
	$APP->run();

	echo microtime(true) - $start;
?>