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
      	<h2 class="project-tagline"><?php echo strtoupper($_GET["gene"]); ?> Mutation Table</h2>
      	<a href="index.html" class="btn">Home</a>
        <a href="database.html" class="btn">Database</a>
	<a href="patient.html" class="btn">Patient</a>
        </section>
	<?php
	$gene = $_GET["gene"]; 
	?> <br>
	
	<table width="700" border="3">
	<?php
	#this is where u reference code to call python program to parse data and plot
	#$string = '/var/www/html/webSearch_db.py '.$gene;
	#$command = escapeshellcmd($string);
	#$output = shell_exec($command);
	
	#The following set of code stores ur query results into a new file and this is used
	#to display in table form
	#$myfile = fopen("newfile.txt","w") or die("Unable to open file!");
	#fwrite($myfile,$output);
	#fclose($myfile);
	#$handle = fopen("newfile.txt","r");
	?>

	<!-- This code will display ur graph for the database. Change path!
	<img src = "testeshwar.png" style="width:800px;height:800px;">
	<br><br><br>
	-->
	<p>SHASHI HAS NOT SET UP QUERY FACILITY YET! TRY AGAIN LATER :) !</p><br><br>
	<p>MUTATION TABLE:</p><br>
	<?php
	#uncomment this code to display the above result in table format
	#if($handle){
		#while(($line = fgets($handle)) !== false){
			#$array = preg_split('/[\t]/',trim($line));
			#echo "<tr border='3'>";
			#foreach($array as $td){
				#echo "<td height='40'>$td</td>";
			#}
			#echo "</tr>";
		#}
	#}
	?>
	</table>
</body>
</html>

