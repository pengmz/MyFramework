<?php
if (! defined('ROOT')) {
	define('ROOT', dirname(dirname(__FILE__)));
}
if (! defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}
if (! defined('PS')) {
	define('PS', PATH_SEPARATOR);
}
if (! defined('EXT')) {
	define('EXT', '.php');	
}
if (! defined('LANGUAGE')) {
	define('LANGUAGE', 'EN');
}
if (! defined('CHARSET')) {
	define('CHARSET', 'UTF-8');
}
if (! defined('DEBUG_MODE')) {
	define('DEBUG_MODE', FALSE);	
}
if (! defined('LIB_PATH')) {
	define('LIB_PATH', dirname(__FILE__) . DS);
}

require_once LIB_PATH . 'core.php';
require_once LIB_PATH . 'exception.php';
require_once LIB_PATH . 'functions.php';
require_once LIB_PATH . 'logger.php';
require_once LIB_PATH . 'url.php';


/**
 * @author pengmz
 */
class App {
	
	protected static $instance;	
	
	protected $context;
	
	protected $path;
	
	protected $db;
	
	public function __construct($path = null) {
		$this->path = $path;
		$this->init();
	}
	
	public function init() {
		if (DEBUG_MODE) {
			ini_set('display_errors', TRUE);
			//error_reporting(E_ALL);
			error_reporting(E_ALL & ~ E_NOTICE);
		} else {
			ini_set('display_errors', FALSE);
			//error_reporting(0);
			error_reporting(E_ERROR | E_PARSE | E_USER_ERROR);
		}
		ini_set('magic_quotes_runtime', 0);

		global $CONTEXT;
		if (! $CONTEXT) {
			$this->context = new Context();
			$CONTEXT = $this->context;
		} else {
			$this->context = & $CONTEXT;		
		}		
	}
	
	public function run() {
		$this->execAction();
	}
	
	public function action($action_name, $added_function) {
		$this->addAction(array('do' => $action_name), $added_function);
	}
	
	public function addAction($action, $added_function, $method = 'any') {
		URL::addAction($action, $added_function, $method);
	}
		
	public function initDB($db_config) {
		$this->db = ComponentLoader::getDB($db_config);	
		return $this->db;
	}
	
	public function getComponent($name, $paths = null) {
		return ClassLoader::getComponent($name, $paths);
	}
		
	public function execAction($added_param = array()) {
		URL::execAction($added_param);
	}
	
	public static function &getInstance() {
		global $APP;
		if ($APP) {
			return $APP;
		}
		if (self::$instance) {
			return self::$instance;
		}
		self::$instance = & $this;
		return self::$instance;
	}
		
	public final function &getContext() {
		return $this->context;
	}
	
	public final function &getDB() {
		return $this->db;
	}
		
	public function __destruct() {
		if ($this->db) {
			$this->db->__destruct();
		}
	}

}
?>