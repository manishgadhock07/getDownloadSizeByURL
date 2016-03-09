<?php 

(@include_once ('Configure.php')) OR die("Missing file : Configure.php!!\n"); // include the Configure class

class InitClass {

	function __construct($argv){
		$this->conf = new ConfigurePage();
		$this->argv = $argv;
	}

	function getAllRequest(){
		
		if($this->conf->is_validURL($this->argv)){
			
			$url = $this->argv[1];
			
			if($this->conf->is_HTML($url)){
				
				(@include_once ('HTMLFile.php')) OR die("Missing file : HTMLFile.php!!\n"); // include the HTML class
				
				$html = new HTMLFile();
				
				list($totalDownloadSize, $totalRequest)  = $html->getFileSize($url, $this->conf->totalDownloadSize, $this->conf->totalRequest);
				
				$totalDownloadSize = $totalDownloadSize/1000; // converting to kb 

				echo "Total Download Size: $totalDownloadSize Kbs ";
				echo "  Total HTTP requests: $totalRequest\n" ;
			}
			else{
				
				(@include_once ('SingleResourceFile.php')) OR die("Missing file : SingleResourceFile.php!!\n"); // include the HTML class
					
				$SRFile = new SingleResourceFile();
				list($totalDownloadSize, $totalRequest)  = $SRFile->getFileSize($url, $this->conf->totalDownloadSize, $this->conf->totalRequest);	

				$totalDownloadSize = $totalDownloadSize/1000; // converting to kb

				echo "Final Total Download Size: $totalDownloadSize Kbs ";
				echo "  Final total HTTP requests: $totalRequest\n" ;
			}

		}

	}

}

$i = new InitClass($argv);
$i->getAllRequest();