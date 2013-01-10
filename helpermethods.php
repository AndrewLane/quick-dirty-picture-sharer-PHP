<?php

function getImagesInCurrentDirectory() {
	$returnedData = array();
	if ($handle = opendir(".")) {
	    while (($entry = readdir($handle)) !== false) {
	    	//make sure it's a file and not a creatively-named folder
	    	if (filetype($entry) == "file") {
	    		$extension = pathinfo($entry, PATHINFO_EXTENSION);
	    		//make sure it's an image (or at least has the extension of an image)
	    		if (in_array(strtolower($extension), array("jpg", "jpeg", "gif", "bmp", "png"))) {
					$returnedData[] = $entry;
				}
	    	}
	    }
	    closedir($handle);
	}
	//sort the data before returning it
	sort($returnedData);
	return $returnedData;
}
?>
