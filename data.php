<?php
require 'application/Common.php';
$allCats = new GetData();

if (!empty($_GET['type'])) {
    $type = e($_GET['type']);
    echo "title"."\t"."frequency"."\r\n";
    $catCounts = $allCats->categoryCounts($type);
    foreach ($catCounts as $cat):
        $cat_count = $cat['total_count'];
        $category = $cat['category'];
        echo $category."\t".(int)$cat_count."\r\n";
    endforeach;
}