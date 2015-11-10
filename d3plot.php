<html>
<meta charset="utf-8">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="stylesheets/normalize.css" media="screen">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css" media="screen">
    <link rel="stylesheet" type="text/css" href="stylesheets/github-light.css" media="screen">
  </head>

<style>
body {
  font: 11px sans-serif;
}

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.dot {
  stroke: #000;
}

.tooltip {
  position: absolute;
  width: 200px;
  height: 28px;
  pointer-events: none;
}

a:link    {color:green; background-color:transparent; text-decoration:none}
a:visited {color:pink; background-color:transparent; text-decoration:none}
a:hover   {color:red; background-color:transparent; text-decoration:underline}
a:active  {color:yellow; background-color:transparent; text-decoration:underline}
</style>
<body>
<section class="page-header">
        <h1 class="project-name">PATIENT QUERY RESULTS</h1>
        <a href="index.html" class="btn">Home</a>
        <a href="database.html" class="btn">Database</a>
        <a href="patient.html" class="btn">Patient Query</a>
        </section>
        <br>
	
        <?php
        $string = '/var/www/html/vcfParser.py ';
        $command = escapeshellcmd($string);
        $output = shell_exec($command);
        
        $myfile = fopen("newfile.txt","w") or die("Unable to open file!");
        fwrite($myfile,$output);
        fclose($myfile);

	$string = '/var/www/html/query_db2.py';
        $command = escapeshellcmd($string);
        $result = shell_exec($command);

        $string = '/var/www/html/query_db.py';
        $command = escapeshellcmd($string);
        $result = shell_exec($command);
        ?>
	<br><br>	
	<a href="supple.html" class="btn">Download supplementary data</a>

<script src="http://d3js.org/d3.v3.min.js"></script>

<script>
var margin = {top: 20, right: 20, bottom: 30, left: 40},
width = 960 - margin.left - margin.right,
height = 500 - margin.top - margin.bottom; 

// setup x 
var xValue = function(d) { return d.Variant_Classification;}, // data -> value
    xScale = d3.scale.ordinal().rangeBands([0, width],1),// value -> display
    xMap = function(d) { return xScale(xValue(d));}, // data -> display
    xAxis = d3.svg.axis().scale(xScale).orient("bottom");

// setup y
var yValue = function(d) { return d.Cosmic;}, // data -> value
    yScale = d3.scale.linear().range([height, 0]), // value -> display
    yMap = function(d) { return yScale(yValue(d));}, // data -> display
    yAxis = d3.svg.axis().scale(yScale).orient("left");

// setup fill color
var cValue = function(d) { return d.Color;},
    color = d3.scale.category10();

// add the graph canvas to the body of the webpage
var svg = d3.select("body").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

// add the tooltip area to the webpage
var tooltip = d3.select("body").append("div")
    .attr("class", "tooltip")
    .style("opacity", 0);

// load data
d3.tsv("newfile.txt", function(error, data) {

  // change string (from TSV) into number format
  data.forEach(function(d) {
  	data.map(function(d) { return d.Variant_Classification; });
  	d.Cosmic = +d.Cosmic;
  	data.map(function(d) { return d.Gene; });
  });

  // don't want dots overlapping axis, so add in buffer to data domain
  xScale.domain(data.map(function(d) { return d["Variant_Classification"]; }));
  yScale.domain([d3.min(data, yValue)-1, d3.max(data, yValue)+1]);

  // x-axis
  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
      .append("text")
      .attr("class", "label")
      .attr("x", width)
      .attr("y", -6)
      .style("text-anchor", "end")
      .text("Variant_Classification");

  // y-axis
  svg.append("g")
      .attr("class", "y axis")
      .call(yAxis)
      .append("text")
      .attr("class", "label")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text("Cosmic Score");

  // draw dots
  svg.selectAll(".dot")
      .data(data)
      .enter().append("circle")
      .attr("class", "dot")
      .attr("r", 3.5)
      .attr("cx",xMap)
      .attr("cy", yMap)
      .style("fill", function(d) { return color(d.Color);}) 
      .on("mouseover", function(d) {
          tooltip.transition()
               .duration(200)
               .style("opacity", .9);
          tooltip.html(d["Gene"] + "<br/> (" + xValue(d) 
	        + ", " + yValue(d) + ")")
               .style("left", (d3.event.pageX + 5) + "px")
               .style("top", (d3.event.pageY - 28) + "px");
      })
      .on("mouseout", function(d) {
          tooltip.transition()
               .duration(500)
               .style("opacity", 0);
      });

  // draw legend
  var legend = svg.selectAll(".legend")
      .data(color.domain())
      .enter().append("g")
      .attr("class", "legend")
      .attr("transform", function(d, i) { return "translate(0," + i * 20 + ")"; });

  // draw legend colored rectangles
  legend.append("rect")
      .attr("x", width - 18)
      .attr("width", 18)
      .attr("height", 18)
      .style("fill", color);

  // draw legend text
  legend.append("text")
      .attr("x", width - 24)
      .attr("y", 9)
      .attr("dy", ".35em")
      .style("text-anchor", "end")
      .text(function(d) { return d;})
});

function type(d) {
  d.value = +d.value; // coerce to number
  return d;}

</script>

</body>
<body>
	<table width="700" border="3">
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

