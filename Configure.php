<?php 

class ConfigurePage {
	
	public $totalDownloadSize = 0;
	public $totalRequest = 0;
	
	// checks for the valid url
	function is_validURL($argv){
		if(isset($argv[1]) && $argv[1] != '')
		{
			$url = $argv[1];
			
			if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			    return true;
			} 
			else{
			    echo "Please Enter the valid URL\n";
				return false;
			}
			
		}
		else
		{
			echo "Please Enter the URL\n";
			return false;
		}		
	}

	// function returns whether the url contains html file or not
	function is_HTML($url){

		/*curl is used for php,asp.net,jsp or any other server side language page 
		which will return html on hitting them
		
		Note : If there is a case of hitting only .html page then filename checking
		would do the trick
		*/
		$curl_url = curl_init($url); // init the curl

		// just want the header for content type , not the body 
		// as to get the content-type which they return after hitting
		// the url
		curl_setopt($curl_url, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($curl_url, CURLOPT_HEADER, TRUE); 
	    curl_setopt($curl_url, CURLOPT_NOBODY, TRUE);
		curl_exec($curl_url);  
	    $content_type = curl_getinfo($curl_url, CURLINFO_CONTENT_TYPE );
		curl_close($curl_url);
	     
	    // if string contains text/html,then it is HTML  
	    if (strpos($content_type,'text/html') !== false)
			return TRUE; 	// HTML
		else
		   return FALSE;
	}

}

