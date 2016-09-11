<?php
require 'application/Common.php';
$jobData = new GetData();
$parent_id = n($_GET['id']);
if ($parent_id == "") {
    $parent_id = 11814828;
}
$color_count = 1;
$graph_colors = explode(',', GRAPH_COLORS);
foreach ($graph_colors as $badge_color):
    ${'badge'.$color_count} = $badge_color;
    $color_count += 1;
    $d3_colors .= '"'.$badge_color.'", ';//Format color about for D3 graphs .range
endforeach;

$d3_colors = rtrim($d3_colors, ',');
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Hacker News Who Is Hiring Data</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/bs/jq-2.2.0,dt-1.10.11,r-2.0.2,sc-1.4.1/datatables.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <style>
        .badge {color:#ffffff}
        @media (max-width: 365px) {
            .col-md-8 {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="jumbotron">
    <div class="container">
        <h1>Hacker News: Who Is Hiring?</h1>
        <p>
            Stats from the Hacker News <a href="https://news.ycombinator.com/item?id=<?=$parent_id?>" target="_blank">Who is Hiring</a> posts. Displays counts for
            top mentioned programming languages, databases, frameworks and job types. Search job posts at bottom of page.
        </p>
        
        <ul class="breadcrumb">
            <li><b>View By Month</b></li>
            <li><a href="/hn/">July 2016</a></li>
            <li><a href="?id=11814828">June 2016</a></li>
            <li><a href="?id=11611867">May 2016</a></li>
            <li><a href="?id=11405239">April 2016</a></li>
            <li><a href="?id=11202954">March 2016</a></li>
            <li><a href="?id=11012044">February 2016</a></li>
            <li><a href="?id=10822019">January 2016</a></li>
            <li><a href="?id=10655740">December 2015</a></li>
            <li><a href="?id=10492086">November 2015</a></li>
            <li><a href="?id=10311580">October 2015</a></li>
            <li><a href="?id=10152809">September 2015</a></li>
            <li><a href="?id=9996333">August 2015</a></li>
            <li><a href="?id=9812245">July 2015</a></li>
            <li><a href="?id=9639001">June 2015</a></li>
        </ul>
        * Counts & graphs only display top 10 results. Navigate to bottom of page and use the search field to search through job data.
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Programming Languages</div>
                <div class="panel-body">
                    <div class="col-md-4">
                        <ul class="list-unstyled">
                            <?php
                            $type = 'language';
                            $catCounts = $jobData->categoryCounts($type,$parent_id);
                            $color_count = 1;
                            foreach ($catCounts as $cat):
                                echo "<li>".e($cat['category']).": <span class='badge' style='background-color:".${'badge'.$color_count}."'>".e($cat['total_count'])."</span></li>";
                                $color_count += 1;
                            endforeach;
                            ?>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <languageschart></languageschart>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Job Types</div>
                <div class="panel-body">
                    <div class="col-md-4">
                        <ul class="list-unstyled">
                            <?php
                            $type = 'job_type';
                            $catCounts = $jobData->categoryCounts($type,$parent_id);
                            $color_count = 1;
                            foreach ($catCounts as $cat):
                                echo "<li>".e($cat['category']).": <span class='badge' style='background-color:".${'badge'.$color_count}."'>".e($cat['total_count'])."</span></li>";
                                $color_count += 1;
                            endforeach;
                            ?>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <typeschart></typeschart>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Frameworks/Libraries</div>
                <div class="panel-body">
                    <div class="col-md-4">
                        <ul class="list-unstyled">
                            <?php
                            $type = 'framework';
                            $catCounts = $jobData->categoryCounts($type,$parent_id);
                            $color_count = 1;
                            foreach ($catCounts as $cat):
                                echo "<li>".e($cat['category']).": <span class='badge' style='background-color:".${'badge'.$color_count}."'>".e($cat['total_count'])."</span></li>";
                                $color_count += 1;
                            endforeach;
                            ?>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <frameworkschart></frameworkschart>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Databases</div>
                <div class="panel-body">
                    <div class="col-md-4">
                        <ul class="list-unstyled ">
                            <?php
                            $type = 'database';
                            $catCounts = $jobData->categoryCounts($type,$parent_id);
                            $color_count = 1;
                            foreach ($catCounts as $cat):
                                echo "<li>".e($cat['category']).": <span class='badge' style='background-color:".${'badge'.$color_count}."'>".e($cat['total_count'])."</span></li>";
                                $color_count += 1;
                            endforeach;
                            ?>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <databaseschart></databaseschart>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <table id="jobs" class="table table-striped" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Job Type</th>
                <th>Languages</th>
                <th>Frameworks</th>
                <th>Databases</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Job Title</th>
                <th>Job Type</th>
                <th>Languages</th>
                <th>Frameworks</th>
                <th>Databases</th>
            </tr>
        </tfoot>
        <tbody>
        <?php
        $allJobs = $jobData->getAllJobs($parent_id);
        foreach ($allJobs as $job):
            //Build out title from description and clean it up
            $arr = explode('<p>', $job['job_desc'], 2);
            $job_title = $arr[0];
            $job_title = preg_replace("/\r|\n/", "", $job_title);
            $job_title = preg_replace('#<a.*?>(.*?)</a>#i', '\1', $job_title);
            $job_title = substr($job_title, 0, 70).'...';
        ?>
            <tr>
                <td><a href="https://news.ycombinator.com/item?id=<?=$job['post_id']?>" target="_blank"><?=$job_title?></a></td>
                <td><?=str_replace(',',', ',$job['job_type'])?></td>
                <td><?=str_replace(',',', ',$job['languages'])?></td>
                <td><?=str_replace(',',', ',$job['frameworks'])?></td>
                <td><?=str_replace(',',', ',$job['databases'])?></td>
            </tr>
        <?php
        endforeach;
        ?>
        </tbody>
    </table>
    <p><a class="btn btn-primary btn-sm" href="https://github.com/gosmartsolutions/hacker-news-jobs" target="_blank" role="button">Get Source Code (GitHub)</a></p>
</div>

<script type="text/javascript" src="https://cdn.datatables.net/t/bs/jq-2.2.0,dt-1.10.11,r-2.0.2,sc-1.4.1/datatables.min.js"></script>
<script>
$(document).ready(function() {
    var jobs = $('#jobs').DataTable();
} );
</script>

<script type="text/javascript">var colors = [<?=$d3_colors?>"#c0c0c0"];</script>
<script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script src="vendor/d3/frameworks.js?id=<?=$parent_id?>" charset="utf-8"></script>
<script src="vendor/d3/program_languages.js?id=<?=$parent_id?>" charset="utf-8"></script>
<script src="vendor/d3/jobtypes.js?id=<?=$parent_id?>" charset="utf-8"></script>
<script src="vendor/d3/databases.js?id=<?=$parent_id?>" charset="utf-8"></script>
</body>
</html>

