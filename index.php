<?php
require 'application/Common.php';
$jobData = new GetData();
$parent_id = n($_GET['id']);
if ($parent_id == "") {
    $parent_id = 11814828;
}
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
    </head>
    <body>
        <div class="jumbotron">
            <div class="container">
                <h1>Hacker News: Who Is Hiring?</h1>
                <p>
                    Stats from the latest Hacker News <a href="https://news.ycombinator.com/item?id=<?=$parent_id?>" target="_blank">Who is Hiring</a> post. Pulls in counts for
                    programming languages, databases, frameworks and job types. Also displays results and allows you to search the results.
                </p>
            </div>
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Programming Languages</div>
                        <div class="panel-body">
                            <div class="col-sm-4">
                                <ul class="list-unstyled">
                                    <?php
                                    $type = 'language';
                                    $catCounts = $jobData->categoryCounts($type,$parent_id);
                                    foreach ($catCounts as $cat):
                                        echo "<li>".e($cat['category']).": <span class='badge'>".e($cat['total_count'])."</span></li>";
                                    endforeach;
                                    ?>
                                </ul>
                            </div>
                            <div class="col-sm-8">
                                <languageschart></languageschart>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Job Types</div>
                        <div class="panel-body">
                            <div class="col-sm-4">
                                <ul class="list-unstyled">
                                    <?php
                                    $type = 'job_type';
                                    $catCounts = $jobData->categoryCounts($type,$parent_id);
                                    foreach ($catCounts as $cat):
                                        echo "<li>".e($cat['category']).": <span class='badge'>".e($cat['total_count'])."</span></li>";
                                    endforeach;
                                    ?>
                                </ul>
                            </div>
                            <div class="col-sm-8">
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
                            <div class="col-sm-4">
                                <ul class="list-unstyled">
                                    <?php
                                    $type = 'framework';
                                    $catCounts = $jobData->categoryCounts($type,$parent_id);
                                    foreach ($catCounts as $cat):
                                        echo "<li>".e($cat['category']).": <span class='badge'>".e($cat['total_count'])."</span></li>";
                                    endforeach;
                                    ?>
                                </ul>
                            </div>
                            <div class="col-sm-8">
                                <frameworkschart></frameworkschart>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Databases</div>
                        <div class="panel-body">
                            <div class="col-sm-4">
                                <ul class="list-unstyled ">
                                    <?php
                                    $type = 'database';
                                    $catCounts = $jobData->categoryCounts($type,$parent_id);
                                    foreach ($catCounts as $cat):
                                        echo "<li>".e($cat['category']).": <span class='badge'>".e($cat['total_count'])."</span></li>";
                                    endforeach;
                                    ?>
                                </ul>
                            </div>
                            <div class="col-sm-8">
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
        
        <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
        <script src="vendor/d3/frameworks.js?id=<?=$parent_id?>" charset="utf-8"></script>
        <script src="vendor/d3/program_languages.js?id=<?=$parent_id?>" charset="utf-8"></script>
        <script src="vendor/d3/jobtypes.js?id=<?=$parent_id?>" charset="utf-8"></script>
        <script src="vendor/d3/databases.js?id=<?=$parent_id?>" charset="utf-8"></script>
    </body>
</html>
