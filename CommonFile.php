<?php
error_reporting(~E_WARNING); // for running on local like http://localhost/index.php

class CommonClass {
	
	public function getRemoteFileSize($url) {
		$headers = get_headers($url, 1);
	    
	    if (isset($headers['Content-Length'])) 
	    return $headers['Content-Length'];
	    
	    if (isset($headers['Content-length'])) 
	    return $headers['Content-length'];

	    $c = curl_init();
	    curl_setopt_array($c, array(
	        CURLOPT_URL => $url,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_HTTPHEADER => array('User-Agent: Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; en-US; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3'),
	        ));
	    curl_exec($c);
	    
	    $size = curl_getinfo($c, CURLINFO_SIZE_DOWNLOAD);
	    
	    return $size;
	        
	    curl_close($c);

	}
}