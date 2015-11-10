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
      	<h1 class="project-name">MENDELIAN GENETICS DATABASE</h1>
      	<a href="index.html" class="btn">Home</a>
	<a href="patient.html" class="btn">Patient</a>
        </section>
	<br>
	<p> Fill in description of database </p>
	<form action="database_result.php" method="get">
                Enter the Gene Name You want to Query: <input type="text" name="gene"><br>
                <input type="submit">
        </form>

	<table width="20" border="3">

	<!-- This is the code for calling a python program that queries the database and plots a graph and stores it
	<?php
	#$string = '/var/www/html/Search_db.py '.$gene;
	#$command = escapeshellcmd($string);
	#$output = shell_exec($command);
	#?>
	-->

	<!-- This is where the graph is loaded from 
	<img src = "testeshwar.png" style="width:800px;height:800px;">
	-->

	<p>MUTATION TABLE:<p>
	<?php
	#Code to print the database in a table format
	$handle = fopen("database/dcm_db.tsv","r"); #hardcoded path to database
	if($handle){
		while(($line = fgets($handle)) !== false){
			$array = preg_split('/[\t]/',trim($line));
			#echo "<tr><td height='119'>$array[0]</td><td>$array[1]</td></tr>";
			echo "<tr border='2'>";
			foreach($array as $td){
				echo "<td height='1%', width='1%'>$td</td>";
			}
			echo "</tr>";
		}
	}
	?>
	</table>
</body>
</html>

