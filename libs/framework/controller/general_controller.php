<?php

/**
 * @author pengmz
 */
class GeneralController extends Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	protected function execAction($action) {
		try {			
			$this->beforeAction($action);
			
			$params = array();
			$method = new ReflectionMethod($this, $action);
			$method_params = $method->getParameters();
			if(count($method_params) > 0) {
				foreach ($method_params as $param) {
					$param_name = $param->getName();
					$params[$param_name] = $this->getParameter($param_name);
				}
			}			
			$response = $this->invokeMethod($action, $params);
			
			$response = $this->afterAction($action, $response);
			return $response;
		} catch (Exception $ex) {
			$this->handleError($ex);
		}
		return '';		
	}
	
	protected function invokeMethod($method, $params = array()) {
		switch (count($params)) {
			case 0:
				return $this->{$method}();
			case 1:
				return $this->{$method}($params[0]);
			case 2:
				return $this->{$method}($params[0], $params[1]);
			case 3:
				return $this->{$method}($params[0], $params[1], $params[2]);
			case 4:
				return $this->{$method}($params[0], $params[1], $params[2], $params[3]);
			case 5:
				return $this->{$method}($params[0], $params[1], $params[2], $params[3], $params[4]);
			default:
				return call_user_func_array(array(&$this, $method), $params);
		}
	}
	
}
?>