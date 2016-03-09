<?php

(@include_once ('CommonFile.php')) OR die("File Missing 'Common.php'\n");

class SingleResourceFile extends CommonClass {
	
	function __construct(){
		$this->totalSize = 0;
		$this->totalNumResources = 0;		
	}

	function getFileSize($URL,$totalSize,$totalNumResources){
		$totalSize = parent::getRemoteFileSize($URL);
		$totalNumResources += 1;
		return array($totalSize,$totalNumResources);
	}
}