<html>
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="stylesheets/normalize.css" media="screen">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css" media="screen">
    <link rel="stylesheet" type="text/css" href="stylesheets/github-light.css" media="screen">
  </head>

<body>
	<section class="page-header">
      	<h1 class="project-name">TISSUE OF ORIGIN RESULTS</h1>
      	<a href="index.html" class="btn">Home</a>
        <a href="database.html" class="btn">Database</a>
	<a href="patient.html" class="btn">Patient Query</a>
	<a href="rna.html" class="btn">RNA analysis</a>
        </section>
	<br>
	<center>
	<?php
	$rna_file = $_POST["rna_file"];
	$string = '/var/www/html/scripts/TOG.pl uploads/patient_rna';
	$command = escapeshellcmd($string);
	$output = shell_exec($command);
	echo $output;
	$myfile = fopen("newfile.txt","w") or die("Unable to open file!");
	fwrite($myfile,$output);
	fclose($myfile);
	?>
	<br>
	<br>
	<iframe sandbox="allow-scripts allow-forms allow-same-origin" src="rnad3.php" width="850" height = "450" scrolling="yes"></iframe>
	</center>
</body>
</html>

