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
      	<h1 class="project-name">OVARIAN CANCER DATABASE</h1>
      	<h2 class="project-tagline"><?php echo strtoupper($_GET["gene"]); ?> Mutation</h2>
      	<a href="index.html" class="btn">Home</a>
        <a href="database.html" class="btn">Database</a>
	<a href="patient.html" class="btn">Patient</a>
        </section>
	<?php
	$gene = $_GET["gene"]; 
	?> <br>
	
	<table width="700" border="3">
	<?php
	$string = '/var/www/html/webSearch_db.py '.$gene;
	$command = escapeshellcmd($string);
	$output = shell_exec($command);
	
	$myfile = fopen("newfile.txt","w") or die("Unable to open file!");
	fwrite($myfile,$output);
	fclose($myfile);

	$string = '/var/www/html/query_db.py';
	$command = escapeshellcmd($string);
	$result = shell_exec($command);
	?>
	
	<img src = "testeshwar.png" style="width:800px;height:800px;">
	<br><br><br>
	<p> MUTATION TABLE:<p>

	<?php
	$handle = fopen("newfile.txt","r");
	if($handle){
		while(($line = fgets($handle)) !== false){
			$array = preg_split('/[\t]/',trim($line));
			echo "<tr border='3'>";
			foreach($array as $td){
				echo "<td height='40'>$td</td>";
			}
			echo "</tr>";
		}
	}
	?>
	</table>
</body>
</html>

