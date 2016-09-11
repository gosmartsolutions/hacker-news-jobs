var width = 450,
    height = 300,
    radius = Math.min(width, height) / 2;

var fcolor = d3.scale.ordinal()
    .range(colors);

var arc = d3.svg.arc()
    .outerRadius(radius - 10)
    .innerRadius(0);

var labelArc = d3.svg.arc()
    .outerRadius(radius - 40)
    .innerRadius(radius - 40);

var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) { return d.frequency; });

var chartFrameworks = d3.select("frameworkschart").append("svg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 3 + "," + height / 2 + ")");

d3.tsv("data.php?type=framework&id=" + getQueryVariable("id"), type, function(error, data) {
    if (error) throw error;

    var g = chartFrameworks.selectAll(".arc")
        .data(pie(data))
        .enter().append("g")
        .attr("class", "arc");

    g.append("path")
        .attr("d", arc)
        .style("fill", function(d) { return fcolor(d.data.title); });
});

function type(d) {
    d.frequency = +d.frequency;
    return d;
}

function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}