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
        <h2 class="project-tagline"><?php echo strtoupper($_GET["gene"]); ?> Gene Expression</h2>
        <a href="index.html" class="btn">Home</a>
        <a href="database.html" class="btn">Database</a>
        <a href="patient.html" class="btn">Patient Query</a>
        <a href="rna.html" class="btn">RNA Analysis</a>
        </section>
        <?php
        $gene = "images/".strtoupper($_GET["gene"]).'.png';
	echo '<center><img src = '.$gene.' style="width:800px;height:600px;"></center>';
	?>

</body>
