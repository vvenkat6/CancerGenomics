<!DOCTYPE html>
<html lang="en-us">
  <head>
    <meta charset="UTF-8">
    <title>Cancer Genomics by Sungshine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="stylesheets/normalize.css" media="screen">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css" media="screen">
    <link rel="stylesheet" type="text/css" href="stylesheets/github-light.css" media="screen">
  </head>
   <body>
    <section class="page-header">
      <h1 class="project-name">Cancer Genomics</h1>
      <h2 class="project-tagline">Georgia Institute of Technology</h2>

        <a href="index.html" class="btn">Home</a>
        <a href="database.html" class="btn">Database</a>
	<a href="patient.html" class="btn">Patient Query</a>
        </section>

	<?php
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["vcf_file"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$filePath = realpath($_FILES["vcf_file"]["tmp_name"]);

	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
    	$check = getimagesize($_FILES["vcf_file"]["tmp_name"]);
   
    	if($check !== false) {
        	echo "File is an image - " . $check["mime"] . ".";
        	$uploadOk = 0;
    	} else {
        	$uploadOk = 1;
    		}
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
    		echo "Sorry, your file was not uploaded.";

	// if everything is ok, try to upload file
	} else{
    		if (move_uploaded_file($_FILES["vcf_file"]["tmp_name"], "uploads/patient_vcf")) {
        		echo "The file ". basename( $_FILES["vcf_file"]["name"]). " has been uploaded.";
    		} else {
        		echo "Sorry, there was an error uploading your file.";
    			}
		}
?>
<script>
window.location = 'd3plot.php';
</script>
<br>Processing file...<br>
</body>
</html>
