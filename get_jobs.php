<?php

set_time_limit(180); // May need to adjust this when lots of jobs
require 'application/Common.php';
$allJobs = new GetJobs();

// HN parent id of job thread (example 11611867)
if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
    $main_id = $_GET['id'];
    // Loops through json data and adds jobs to db in formatted structure 
    $jobs = $allJobs->getJobs($main_id);
} else {
    echo '<h1>Invalid id passed!</h1>';
}

