<?php
require_once("helpermethods.php");
$images = getImagesInCurrentDirectory();
?>

<head>
<style>
	img { cursor: hand; cursor: pointer; }
	img.preview { cursor: auto; }
</style>
<script src="http://code.jquery.com/jquery-1.8.1.min.js"></script>

<script>
//all the files we are showcasing
var filenames = new Array(<?php for ($i=0; $i<count($images); $i++) { if ($i!=0) { print ", "; } print '"' . $images[$i] . '"'; } ?>);
filenames.sort();
var thumbPrefix = 'thumbs/';
var previewPrefix = 'preview/';

$(function() {
    var i;
    var filename;
    var thumb;
    for(i=0; i<filenames.length; i++) {
      filename = filenames[i];
      thumb = thumbPrefix + filename;
      //add all our thumbs to the thumbs div
      $('#thumbs').append('<img id="' + filename + '" alt="' + filename + '" src="' + thumb + '" />').append('&nbsp;');
    }

    //set up click handler
    $('img').click(function() { handleClick(this); });

    //pre-load all the previews
    preloadPreviews(filenames);

    //show the first image in the preview section
    assignPreviewImg(filenames[0]);

   //map the left and right arrow keys
   $(document).keydown(function(e){
      if (e.keyCode == 37) {
	 goLeft();
         return false;
      } else if (e.keyCode == 39) {
	 goRight();
	 return false;
     }
   });

  });

function handleClick(img) {
  if (img.id != 'previewImg') {
    assignPreviewImg(img.id);
  }
}

function assignPreviewImg(filename) {
	//put the thumb in there first just in case the preview hasn't loaded yet
	$('#previewImg').attr('src', thumbPrefix + filename);

	$('#previewImg').attr('src', previewPrefix + filename);
	$('#filename').val(filename);
	$('#downloadbutton').val('Download This High-Quality Image: ' + filename);
}

function goLeft() {
	goDirection(-1);
}

function goRight() {
	goDirection(1);
}

function goDirection(dir) {
	var currentFilename = $('#filename').val();
    var index = getArrayIndex(currentFilename, filenames);
	index = index + dir;
	if (index < 0) { index = filenames.length - 1; }
	if (index >= filenames.length) { index = 0; }
	assignPreviewImg(filenames[index]);
}

function getArrayIndex(item, arr) {
	var i;
	for(i=0; i<arr.length; i++) {
		if (arr[i] == item) {
			return i;
		}
    }
	return -1;
}

function preloadPreviews(arrayOfImages) {
  $(arrayOfImages).each(function () {
    $('<img />').attr('src',previewPrefix + this).appendTo('body').css('display','none');
  });
}

</script>

</head>
<body>

<div style="text-align:center">
  <form action="downloadimage.php" method="POST">
    <input type="submit" value="Download This Image" id="downloadbutton" />
    <input type="hidden" name="filename" id="filename" />
  </form>
  <input type="button" value="&lt;--" onclick="goLeft(); return false;" />
  &nbsp;
  <input type="button" value="--&gt;" onclick="goRight(); return false;" />
  <br />
  <img id=previewImg class=preview height="40%" />
</div>
<br />
<div style="text-align:center">
Click on a thumbnail below to "preview" the image above, then click the "Download This Image" button at the top of the screen
to download it to your hard drive.  You can use the arrow keys to cycle through pictures or use the buttons above the preview picture.
</div>
<br />
<div id=thumbs style="width: 100%; height: 40%; overflow:auto; border: 1px solid black;" />
</body>
