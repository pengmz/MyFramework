<?php
require_once dirname(__FILE__) . '/jsonrpc_app.php';

/**
 * @author pengmz
 */
class JsonRpcServer extends JsonRpcApp {
	
	protected $functions = array();
	
	public function __construct($path = APP_PATH, $rpc_config = array()) {
		parent::__construct($path, $rpc_config);
	}
	
	public function init() {
		parent::init();
		header("HTTP/1.1 200 OK");
		header('Content-Type: text/javascript');
		header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');		
	}
	
	public function run() {
		parent::run();
		try {
			$data = $this->getRequestData();
			$function = $this->getFunction($data);			
			if ($function) {
				$params = $this->getParams($data);
				$result = call_user_func($function, $params);
			} else {
				$result = array('code' => 'error', 'message' => 'api not found');
			}
		} catch (Exception $ex) {
			$result = $this->handleException($ex);
		}		
		$this->returnResult($result);
	}
	
	public function returnResult($result) {		
		echo $this->encode($result);
	}
	
	public function add($name, $function) {
		$this->functions[strtolower($name)] = $function;
	}

	public function getFunction($params = array(), $param_name = 'do') {
		if (! isset($params[$param_name])) {
			return false;
		}	
		$do = $params[$param_name];	
		if (get_magic_quotes_gpc()) {
			$do = stripslashes($do);
		}	
		$this->log('[RPC]', $do);
			
		if (array_key_exists(strtolower($do), $this->functions)) {
			return $this->functions[$do];
		}
		return false;
	}
	
	public function getParams($params = array()) {
		$added_params = $this->getPostData($params);
		if (! empty($added_params)) {
			$params = array_merge($params, $added_params);
		}
		return $params;
	}
	
	private function getPostData($params = array()) {
		if (! isset($params['jsondata'])) {
			return array();
		}
		$post_data = $params['jsondata'];
		if (get_magic_quotes_gpc()) {
			$post_data = stripslashes($post_data);
		}
		return $this->decode($post_data);
	}
	
	private function getRequestData() {
		return $this->getRequest()->data();
	}
		
	private function getRequest() {
		return $this->context->getRequest();
	}
	
	private function getPostBody() {
		if (isset($HTTP_RAW_POST_DATA)) {
			return $HTTP_RAW_POST_DATA;
		} else {
			return file_get_contents('php://input');
		}
	}	
}

?>