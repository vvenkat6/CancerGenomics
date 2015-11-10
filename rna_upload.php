<!DOCTYPE html>
<html lang="en-us">
  <head>
    <meta charset="UTF-8">
    <title>Cancer Genomics</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="stylesheets/normalize.css" media="screen">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css" media="screen">
    <link rel="stylesheet" type="text/css" href="stylesheets/github-light.css" media="screen">
  </head>
   <body bgcolor="#000">
    <section class="page-header">
      <h1 class="project-name">Cancer Genomics</h1>
      <h2 class="project-tagline">Georgia Institute of Technology</h2>

        <a href="index.html" class="btn">Home</a>
        <a href="database.html" class="btn">Database</a>
	<a href="patient.html" class="btn">Patient Query</a>
	<a href="rna.html" class="btn">RNA Analysis</a>
        </section>

	<?php
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["rna_file"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$filePath = realpath($_FILES["rna_file"]["tmp_name"]);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
    	$check = getimagesize($_FILES["rna_file"]["tmp_name"]);
   
    	if($check !== false) {
        	echo "File is an image - " . $check["mime"] . ".";
        	$uploadOk = 0;
    	} else {
        	$uploadOk = 1;
    		}
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
    		echo "Sorry, your file was not uploaded!";

	// if everything is ok, try to upload file
	} else{
    		if (move_uploaded_file($_FILES["rna_file"]["tmp_name"], "uploads/patient_rna")) {
        		echo "The file ". basename( $_FILES["vcf_file"]["name"]). " has been uploaded.";
			echo '<center><font color="white">Processing...</font><center>';
			echo '<center><img src = "images/process.gif" alt="process" style="height:200px;width:200px;opacity:0.2;image-resolution:50dpi;"></center>';
			echo "<script>window.location = 'rna_result.php';</script>";
    		} else {
        		echo "Sorry, there was an error uploading your file!";
    			}
		}
?>
</body>
</html>
