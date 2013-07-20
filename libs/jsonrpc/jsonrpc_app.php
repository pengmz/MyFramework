<?php
require_once LIB_PATH . 'app.php';

/**
 * @author pengmz
 */
class JsonRpcApp extends App {
	
	private $encrypt = false;
	private $gzip = false;
	private $debug = DEBUG_MODE;
	
	public function __construct($path = APP_PATH, $rpc_config = array()) {
		parent::__construct($path);
		if ($rpc_config) {
			$this->encrypt = $rpc_config['encrypt'];
			$this->gzip = $rpc_config['gzip'];
			if ($rpc_config['debug'] == 'true') {
				$this->debug = true;
			}
		}		
	}
	
	public function init($component_paths = array()) {
		parent::init();
		if (defined('MODEL_PATH')) {
			$component_paths[] = MODEL_PATH;
		} else {		
			$component_paths[] = $this->path . 'models' . DS;
		}
		$include_paths = implode(PS, $component_paths);
		set_include_path($include_paths . PS . get_include_path());	
	}
	
	protected function encode($data) {
		$data = json_encode($data);
		$this->log('[Data]', $data);
		
		if ($this->encrypt) {
			$data = base64_encode($data);
		}
		return $data;
	}
	
	protected function decode($data) {
		if ($this->encrypt) {
			$data = base64_decode($data);
		}
		$this->log('[Data]', $data);
		$data = json_decode($data, true);
		return $data;
	}
		
	protected function handleException($exception) {
		$this->log('[Error]', $exception->getMessage());
		return array('code' => $exception->getCode(), 'message' => $exception->getMessage());
	}
	
	protected function log($operation, $message) {
		if ($this->debug) {			
			$message = $operation . ": " . $message . "\n";
			$fp = @fopen('jsonrpc.log', "a+");
			if ($fp) {
				flock($fp, LOCK_EX);
				fwrite($fp, $message);
				flock($fp, LOCK_UN);
				fclose($fp);
			}		
		}
	}
}

?>