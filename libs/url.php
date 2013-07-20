<?php
class URL {

	private static $actions;
	
	public static function get($action, $added_function) {
		self::addAction($action, $added_function, 'GET');
	}
	
	public static function post($action, $added_function) {
		self::addAction($action, $added_function, 'POST');
	}
	
	public static function put($action, $added_function) {
		self::addAction($action, $added_function, 'PUT');
	}
	
	public static function delete($action, $added_function) {
		self::addAction($action, $added_function, 'DELETE');
	}
	
	public static function addAction($action, $added_function, $method = 'any') {
		$request = get_request();
		if (($method == 'any') || ($method == $request->method())) {
			self::$actions[] = array('action' => $action, 'function' => $added_function);		
		}
	}
	
	public static function execAction($added_params = array()) {
		if (empty(self::$actions)) {
			return;
		}		
		
		$request = get_request();
		$params = $request->data();
		if (! empty($added_params)) {
			$params = array_merge($params, $added_params);
		}
							
		$actions = self::$actions;
		foreach($actions as $action) {
			if (self::matchAction($action['action'], $params)) {
				try {
					call_user_func_array($action['function'], $params);
				} catch (Exception $ex) {
					throw new CoreException($ex->getMessage());
				}
			}			
		}
	}
	
	public static function matchAction($action_params, $params) {
		 //$match = array_intersect_assoc($action_params, $params);
		 //return ! empty($match);
		 
		if (empty($action_params)) {
			return false;
		}
		if (empty($params)) {
			return false;
		}

		$match = true;
		foreach ($action_params as $key => $value) {
			if (! isset($params[$key])) {
	            $match = false;
	            break;
	        }			
	        if ($params[$key] != $value) {
	            $match = false;
	            break;	        	
	        }
		}
		return $match;
	}
}

class HOOK {

	private static $filters;
	
	public static function addFilter($hooks = array(), $added_function, $filter = 'before', $priority = 10) {
		if (! empty($hooks)) {
			foreach ($hooks as $hook_name) {
				self::$filters[] = array('hook' => $hook_name, 'function' => $added_function, 'filter' => $filter, 'priority' => $priority);
			}
		}
	}

	public static function afterFilter($hooks) {
		self::execFilter($hooks, 'after');
	}
	
	public static function beforeFilter($hooks) {
		self::execFilter($hooks, 'before');
	}
	
	public static function execFilter($hooks, $filter = 'before') {
		if (empty(self::$filters)) {
			return;
		}		
		$filters = self::$filters;
		foreach($filters as $hook) {
			if (($hook['filter'] == $filter) && in_array($hook['hook'], $hooks)) {
				try {
					call_user_func($hook['function']);
				} catch (Exception $ex) {
					throw new CoreException($ex->getMessage());
				}
			}
		}
	}	
	
}
?>