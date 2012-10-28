<?php
$filename = $_REQUEST['filename'];

require_once("helpermethods.php");
$images = getImagesInCurrentDirectory();

//make sure they are just downloading an image in the current directory and there's no funny business
if (in_array($filename, $images) === FALSE) {
  die();
}

header("Content-type: image/jpeg");
header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
readfile($filename);
?>