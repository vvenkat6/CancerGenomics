<html>
<body>

	The Gene you Queried is: <?php $gene = $_GET["gene"]; echo $gene;?><br>

	<?php 
	$string = "/var/www/html/webSearch_db.py ".$gene;
	echo "Running: $string";?> <br>
	<?php
	$command = escapeshellcmd($string);
	$output = shell_exec($command);
	echo "$output";
	?>

</body>
</html>

