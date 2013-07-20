<?php

define('ROOT', dirname(__FILE__));

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('EXT', '.php');

define('SITE_PATH', ROOT . DS);
define('LIB_PATH', ROOT . DS . 'libs' . DS);

$start = microtime(true);

define('DEBUG_MODE', true);

date_default_timezone_set('PRC');

require_once LIB_PATH . '/app.php';

//	$CONTEXT = new Context();
//	$CONTEXT->setParameter('do', 'hello');
//	$CONTEXT->setParameter('c', 'abc');

$APP = new App();
$APP->action('hello', 'hello');
//	$APP->addAction(array('do' => 'hello', 'c' => 'abc'), 'hello');
$APP->run();

function hello() {
	echo 'Hello world!';
}

echo microtime(true) - $start;

?>