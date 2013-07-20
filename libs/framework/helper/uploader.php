<?php

class Upload {
	
	public static function image($upload_file, $target_dir = 'uploads/', $target_name = null) {
		return Upload::file($upload_file, $target_dir, $target_name, array('gif', 'jpeg', 'jpg', 'png'));
	}
	
	public static function file($upload_file, $target_dir = 'uploads/', $target_name = null, $allowed_exts = array()) {
		if (! $upload_file) {
			return array('error' => 'File is empty.');
		}
		
		$file_name = $upload_file['name'];
		$file_size = $upload_file['size'];
		if ($file_size == 0){
            return array('error' => 'File is empty.');
        }        
	    if (! $file_name){
            return array('error' => 'File name empty.');
        }
    	$ext = strtolower(end(explode('.', $file_name)));
	    if(! empty($allowed_exts)) {
	    	if (!in_array($ext, $allowed_exts)){
	    		return array('error' => 'File has an invalid extension.');
	    	}
	    }
	    if (! is_writeable($target_dir)){
            return array('error' => 'Uploads directory isn\'t writable.');
        }	   
	    if (! $target_name){
            $target_name = $file_name;
        } else {
        	$target_name .= '.' . $ext;
        }
		$target_file = $target_dir . $target_name;
				
		if (! move_uploaded_file($upload_file['tmp_name'], $target_file)) {
			return array('error' => 'Could not save upload file.');
		}			 

		$results = array(
			'success' => true,
			//'uploaded_file' => $target_file,
			'uploaded_file' => basename($target_file)
		);

		return $results;
	}
		
}
?>