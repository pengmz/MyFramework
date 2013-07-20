<?php

require_once LIB_PATH . 'app.php';

if (! defined('FRAMEWORK_PATH')) {
	define('FRAMEWORK_PATH', LIB_PATH . DS . 'framework' . DS);
}
if (! defined('CONTROLLER_PATH')) {
	define('CONTROLLER_PATH', APP_PATH . 'controllers' . DS);
}
if (! defined('MODEL_PATH')) {
	define('MODEL_PATH', APP_PATH . 'models' . DS);
}
if (! defined('VIEW_PATH')) {
	define('VIEW_PATH', APP_PATH . 'views' . DS);
}
if (! defined('THEME_PATH')) {
	define('THEME_PATH', APP_PATH . 'themes' . DS);
}
	
require_once FRAMEWORK_PATH . 'functions.php';
require_once FRAMEWORK_PATH . 'dispatcher.php';
require_once FRAMEWORK_PATH . 'controller/controller.php';
require_once FRAMEWORK_PATH . 'model/model.php';
require_once FRAMEWORK_PATH . 'model/form.php';
require_once FRAMEWORK_PATH . 'view/view.php';
require_once FRAMEWORK_PATH . 'helper/html.php';
require_once FRAMEWORK_PATH . 'helper/validation.php';
require_once LIB_PATH . 'theme.php';


/**
 * @author pengmz
 */
class Application extends App {
	
	public function __construct($path = APP_PATH) {
		parent::__construct($path);
	}
	
	public function init() {
		parent::init();
		$component_config_file = $this->path . 'configs/component_config.php';
		if (is_file($component_config_file)) {
			$component_config = include_once $component_config_file;
			$this->initComponent($component_config);
		}		
	}
	
	public function run() {
		parent::run();
		$dispatcher = new Dispatcher();
		$dispatcher->dispatch();
	}
	
	public function initComponent($component_config) {
		if (isset($component_config['path'])) {
			$component_paths = implode(PS, $component_config['path']);
			set_include_path($component_paths . PS . get_include_path());			
		}
		if (isset($component_config['class'])) {
			$component_classes = $component_config['class'];
			foreach ($component_classes as $component_name => $component_alias) {
				ComponentLoader::registerComponent($component_name, $component_alias);
			}
		}
	}	

}
?>