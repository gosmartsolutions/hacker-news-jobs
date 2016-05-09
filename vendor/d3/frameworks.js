var width = 450,
    height = 300,
    radius = Math.min(width, height) / 2;

var color = d3.scale.ordinal()
    .range(["#727272", "#f1595f", "#79c36a", "#599ad3", "#f9a65a", "#9e66ab", "#cd7058", "#d77fb3"]);

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

d3.tsv("data.php?type=framework", type, function(error, data) {
    if (error) throw error;

    var g = chartFrameworks.selectAll(".arc")
        .data(pie(data))
        .enter().append("g")
        .attr("class", "arc");

    g.append("path")
        .attr("d", arc)
        .style("fill", function(d) { return color(d.data.title); });

    g.append("text")
        .attr("transform", function(d) { return "translate(" + labelArc.centroid(d) + ")"; })
        .attr("dy", ".35em")
        .text(function(d) { return d.data.title; });
});

function type(d) {
    d.frequency = +d.frequency;
    return d;
}