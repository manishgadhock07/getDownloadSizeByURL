<?php

(@include_once ('CommonFile.php')) OR die("File Missing 'Common.php'\n");

class HTMLFile extends CommonClass {

	public function __construct(){
		(@include_once ('simplehtmldom/simple_html_dom.php')) OR die("Please Include the Simple HTML Parser\n");
	}

	function getFileSize($URL,$totalSize,$totalNumResources){
			
			$totalSize = parent::getRemoteFileSize($URL);
			$totalNumResources = 1;
			
			$htmlObject = file_get_html($URL);
			// image count
			list($imgSize, $imgNumResources) = $this->getImgCount($htmlObject,$totalSize,$totalNumResources);
			
			// css count
			list($cssSize, $cssNumResources) = $this->getCssCount($htmlObject,$totalSize,$totalNumResources);
			
			// js count
			list($jsSize, $jsNumResources) = $this->getJSCount($htmlObject,$totalSize,$totalNumResources);
			
			// total of the elements
			$totalSize = $imgSize + $cssSize + $jsSize + $totalSize;
			$totalNumResources = $imgNumResources + $cssNumResources + $jsNumResources + $totalNumResources;
			// Find all iframe elements which are again HTML 
			// so the need to calculate the all resources by Recursion
			foreach($htmlObject->find('iframe') as $element)
			{
			    list($totalSize, $totalNumResources)  = 
		        $this->getFileSize($element->src, $totalSize, $totalNumResources);
			}

		return array($totalSize, $totalNumResources);
	}

	function getImgCount($htmlObject,$totalSize,$totalNumResources){

		$imgArray = array();
		// find all images!!
		foreach($htmlObject->find('img') as $element){

		   if(in_array($element->src, $imgArray)){
				$size = parent::getRemoteFileSize($element->src);
		   		$totalSize = $totalSize + $size;	
			}
			else{
				$size = parent::getRemoteFileSize($element->src);
			    $totalSize = $totalSize + $size; 	
			    $totalNumResources += 1;	
			}

			array_push($imgArray,$element->src);
		}
		return array($totalSize, $totalNumResources);
	}

	function getCssCount($htmlObject,$totalSize,$totalNumResources){
		// Find all css
		foreach($htmlObject->find('link') as $element)
		{

			$cssArray = array();
			if (strpos($element->href,'.css') !== false) {

				if(in_array($element->src, $cssArray)){
				    $size = parent::getRemoteFileSize($element->href);
					$totalSize = $totalSize + $size;	
				}
				else{
				    $size = parent::getRemoteFileSize($element->href);
				    $totalSize = $totalSize + $size; 	
				    $totalNumResources += 1;	
				}
				
				array_push($cssArray,$element->src);
			}

			return array($totalSize, $totalNumResources);
		}
	}

	function getJSCount($htmlObject,$totalSize,$totalNumResources){

		$jsArray = array();
		// Find all js
		foreach($htmlObject->find('script') as $element)
		{

			if (strpos($element->src,'.js') !== false) {

				if(in_array($element->src, $jsArray)){
				    $size = parent::getRemoteFileSize($element->src);
					$totalSize = $totalSize + $size;	
				}
				else{
				    $size = parent::getRemoteFileSize($element->src);
				    $totalSize = $totalSize + $size; 	
				    $totalNumResources += 1;	
				}
					array_push($jsArray,$element->src);
			}

			return array($totalSize, $totalNumResources);

		}
	}

}