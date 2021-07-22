<?php
error_reporting(0);
?>
<?php
$msg = "";

// If upload button is clicked ...
if (isset($_POST['submit'])) {

	$filename = $_FILES["image"]["name"];
	$tempname = $_FILES["image"]["tmp_name"];
		$folder = "image/".$filename;
	echo $_FILES["image"]["name"];
	//$db = mysqli_connect("localhost", "root", "", "photos");

		// Get all the submitted data from the form
		//$sql = "INSERT INTO image (filename) VALUES ('$filename')";

		// Execute query
		//mysqli_query($db, $sql);
		
		// Now let's move the uploaded image into the folder: image
		/*
		if (move_uploaded_file($tempname, $folder)) {
			$msg = "Image uploaded successfully";
		}else{
			$msg = "Failed to upload image";
		
	}*/zz
}
//$result = mysqli_query($db, "SELECT * FROM image");
?>
