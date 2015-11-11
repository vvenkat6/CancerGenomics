<!DOCTYPE html>
<meta charset="utf-8">
<style>

body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}

.box {
  font: 10px sans-serif;
}

.box line,
.box rect,
.box circle {
  fill: steelblue;
  stroke: #000;
  stroke-width: 1px;
}

.box .center {
  stroke-dasharray: 3,3;
}

.box .outlier {
  fill: none;
  stroke: #000;
}

.axis {
  font: 12px sans-serif;
}
 
.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}
 
.x.axis path { 
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.tooltip {
  position: absolute;
  width: 200px;
  height: 28px;
  pointer-events: none;
}


</style>
<body>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="box.js"></script>
<script>
var labels = true; // show the text labels beside individual boxplots?

var margin = {top: 30, right: 50, bottom: 70, left: 50};
var  width = 800 - margin.left - margin.right;
var height = 400 - margin.top - margin.bottom;
	
var min = Infinity,
    max = -Infinity;
	
//add tootip area
var tooltip = d3.select("body").append("div")
    .attr("class", "tooltip")
    .style("opacity", 0);

// parse in the data	
d3.tsv("rnaDatabase/database.tsv", function(error, tsv) {
	var data = [];
	data[0] = [];
	data[1] = [];
	data[2] = [];
	data[3] = [];
	data[4] = [];
	data[5] = [];

	// add here the header of the csv file
	data[0][0] = "ARX";
	data[1][0] = "FOXL2";
	data[2][0] = "KLHDC8A";
	data[3][0] = "NRK";
	data[4][0] = "SIGLEC11";
	data[5][0] = "WFIKKN2";

	data[0][1] = [];
	data[1][1] = [];
	data[2][1] = [];
	data[3][1] = [];
	data[4][1] = [];
	data[5][1] = [];
  
	tsv.forEach(function(x) {
		var v1 = Math.floor(x.ARX),
			v2 = Math.floor(x.FOXL2),
			v3 = Math.floor(x.KLHDC8A),
			v4 = Math.floor(x.NRK);
			v5 = Math.floor(x.SIGLEC11);
			v6 = Math.floor(x.WFIKKN2);
			
		var rowMax = Math.max(v1, Math.max(v2, Math.max(v3,v4)));
		var rowMin = Math.min(v1, Math.min(v2, Math.min(v3,v4)));

		data[0][1].push(v1);
		data[1][1].push(v2);
		data[2][1].push(v3);
		data[3][1].push(v4);
		data[4][1].push(v5);
		data[5][1].push(v6);
		 
		if (rowMax > max) max = rowMax;
		if (rowMin < min) min = rowMin;
	});
  
	var chart = d3.box()
		.whiskers(iqr(1.5))
		.height(height)	
		.domain([min, max])
		.showLabels(labels);

	var svg = d3.select("body").append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
		.attr("class", "box")    
		.append("g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
	
	// the x-axis
	var x = d3.scale.ordinal()	   
		.domain( data.map(function(d) { console.log(d); return d[0] } ) )	    
		.rangeRoundBands([0 , width], 0.7, 0.3); 		

	var xAxis = d3.svg.axis()
		.scale(x)
		.orient("bottom");

	// the y-axis
	var y = d3.scale.linear()
		.domain([min, max])
		.range([height + margin.top, 0 + margin.top]);
	
	var yAxis = d3.svg.axis()
    		.scale(y)
    		.orient("left");

	// draw the boxplots	
	svg.selectAll(".box")	   
      		.data(data)
	  	.enter().append("g")
		.attr("transform", function(d) { return "translate(" +  x(d[0])  + "," + margin.top + ")"; } )
      		.call(chart.width(x.rangeBand())); 
	
	      
	// add a title
	svg.append("text")
        .attr("x", (width / 2))             
        .attr("y", 0 + (margin.top / 2))
        .attr("text-anchor", "middle")  
        .style("font-size", "18px")  
        .text("GENE EXPRESSION");
 
	 // draw y axis
	svg.append("g")
        	.attr("class", "y axis")
        	.call(yAxis)
		.append("text") // and text1
		.attr("transform", "rotate(-90)")
		.attr("y", 6)
		.attr("dy", ".71em")
		.style("text-anchor", "end")
		.style("font-size", "12px") 
		.text("RPKM");		
	
	// draw x axis	
	svg.append("g")
      		.attr("class", "x axis")
      		.attr("transform", "translate(0," + (height  + margin.top + 10) + ")")
      		.call(xAxis)
	  	.append("text")             // text label for the x axis
        	.attr("x", width+2)
        	.attr("y",  -6 )
        	.style("text-anchor", "middle")
		.style("font-size", "12px") 
        	.text("GENE PANEL");

var originalData = data;
var patientData;
d3.tsv("rna_output.txt",function(error,data){
        data.forEach(function(d){
                data.map(function(d){return d.x;});
                d.y = +d.y;
        //console.log(d);
        });
	console.log("origData");
	console.log(originalData);
	console.log(data);
	var xCircle = [0,1,2,3,4,5]
	var circle = svg.selectAll("circle")
		.data(data);

        var xScale = d3.scale.ordinal().rangeRoundBands([0, width],0.7,0.3);
        var xValue = function(d) { return d.x;};
        var xMap = function(d) { return xScale(xValue(d))+17;};
	xScale.domain(data.map(function(d) { return d.x; }));

	var yValue = function(d) { return d.y;},
    	    yScale = d3.scale.linear().range([min,max]),
            yMap = function(d) { return yScale(-(yValue(d)));};


	yScale.domain([min,max]);

	circle.enter().insert("circle")
		.attr("class","dot")
		.attr("r",3)
	 	.attr("transform", "translate(0," + (height  + margin.top + 10) + ")")
		.style("fill","pink")
		.attr("cx",xMap)
		//.attr("cy",yMap)
		.attr("cy",function(d){console.log("y");console.log(d.y);return -(d.y-(d.y*0.35));})
		.on("mouseover", function(d) {
          		tooltip.transition()
               		.duration(200)
               		.style("opacity", .9);
          			tooltip.html("<br/> (" + (xValue(d)) 
                			+ ", " + (yValue(d)) + ")")
               		.style("left", (d3.event.pageX + 5) + "px")
               		.style("top", (d3.event.pageY - 28) + "px");})
		 .on("mouseout", function(d) {
          		tooltip.transition()
               		.duration(500)
               		.style("opacity", 0);});


		

	});
});


// Returns a function to compute the interquartile range.
function iqr(k) {
  return function(d, i) {
    var q1 = d.quartiles[0],
        q3 = d.quartiles[2],
        iqr = (q3 - q1) * k,
        i = -1,
        j = d.length;
    while (d[++i] < q1 - iqr);
    while (d[--j] > q3 + iqr);
    return [i, j];
  };
}

</script>
