<?php
/*
*	!!! THIS IS JUST AN EXAMPLE !!!, PLEASE USE ImageMagick or some other quality image processing libraries
*/
    $imagePath = "temp/";
    $filepath = false;

	$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
	$temp = explode(".", $_FILES["bild"]["name"]);
	$extension = end($temp);

	if ( in_array($extension, $allowedExts))
	  {
	  if ($_FILES["bild"]["error"] > 0)
		{
			 $response = array(
				"status" => 'error',
				"message" => 'ERROR Return Code: '. $_FILES["bild"]["error"],
			);
			echo "Return Code: " . $_FILES["bild"]["error"] . "<br>";
		}
	  else
		{

		  $filename = $_FILES["bild"]["tmp_name"];
		  list($width, $height) = getimagesize( $filename );

		  move_uploaded_file($filename,  $imagePath . $_FILES["bild"]["name"]);
          $filepath = $imagePath.$_FILES["bild"]["name"];

		}
	  }
	else
	  {
	   $response = array(
			"status" => 'error',
			"message" => 'something went wrong',
		);
	  }

?>
