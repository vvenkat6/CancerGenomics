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
        <h1 class="project-name">Supplementary Data</h1>
        <a href="index.html" class="btn">Home</a>
        <a href="database.html" class="btn">Database</a>
        <a href="patient.html" class="btn">Patient Query</a>
	<a href="rna.html" class="btn">RNA Analysis</a>
        </section>
	<?php
	$string = "/usr/bin/Rscript report.Rscript";
	$command = escapeshellcmd($string);
	$output = shell_exec($command);
	$string = "python reporteshwar.py";
	echo $string;
	$command = escapeshellcmd($string);
	$output = shell_exec($command);


	echo "<script>window.location = 'report_v1.pdf';</script>";	
	?>

	<img src = "testeshwar.png" style="width:800px;height:800px;">
        <br><br><br>

	<img src = "resulteshwar.png" style="width:800px;height:800px;">
        <br><br><br>
</body>
</html>
