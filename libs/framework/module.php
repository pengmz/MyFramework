<?php

/**
 * @author pengmz
 */
class Module extends Application {
	
	public function __construct($path = MODULE_PATH) {
		parent::__construct($path);
	}
	
	public function run() {
		if (! $this->isAvailable()) {
			return FALSE;
		}
		return parent::run();
	}
	
	public final function initComponent($component_config) {
		parent::initComponent($component_config);
		if (isset($component_config['required'])) {
			$required_modules = $component_config['required'];
			foreach ($required_modules as $required_module) {
				$this->initRequiredModuleComponent($required_module);
			}
		}		
	}

	public final function initRequiredModuleComponent($module_name) {
		static $completed;
		if (!isset($completed[$module_name])) {
			$component_config_file = dirname($this->path) . DS . $module_name . DS . 'configs/component_config.php';
			if (file_exists($component_config_file)) {
				$component_config = include_once $component_config_file;
				$this->initComponent($component_config);
			}
			$completed[$module_name] = 'true';
		}		
	}

	protected final function initModuleComponent($module) {
		static $completed;
		if (!isset($completed[$module])) {
			$component_config_file = MODULE_PATH . $module . DS . 'configs' . DS . 'component_config.php';
			if (file_exists($component_config_file)) {
				$component_config = include $component_config_file;
				if (isset($component_config['required'])) {
					$required_modules = $component_config['required'];
					foreach ($required_modules as $required_module) {
						$this->initModuleComponent($required_module);
					}
				}
				$this->initComponent($component_config);				
			}
			$completed[$module] = 'true';
		}		
	}
	
	public final function isAvailable() {
		return file_exists($this->path);
	}
}

?>