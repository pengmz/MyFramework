<?php
if (! defined('LOG_FILE')) {
	define('LOG_FILE', ROOT . DS . 'log.txt');
}

class Log {
	
	public static function debug($message) {
		if (DEBUG_MODE) {
			self::writeToFile('[DEBUG]: ' . $message . "\n");
		}
	}
	
	public static function error($message) {
		if (DEBUG_MODE) {
			echo '<div class="alert alert-error">[ERROR]' . $message . '</div>';
		} 		
		self::writeToFile('[ERROR]: ' . $message . ' ' . date('Y-m-d H:i:s'). "\n");
	}
	
	public static function writeToFile($message) {
		$fp = @fopen(LOG_FILE, "a+");
		if ($fp) {
			flock($fp, LOCK_EX);
			fwrite($fp, $message);
			flock($fp, LOCK_UN);
			fclose($fp);
		} else {
			error_log($message); 		
		}
		return TRUE;
	}
}

?>