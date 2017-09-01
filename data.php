<?php

require 'application/Common.php';
$allCats = new GetData();
$parent_id = n($_GET['id']);
if (empty($parent_id)) {
    $parent_id = 11814828;
}

if (!empty($_GET['type'])) {
    $type = e($_GET['type']);
    echo "title"."\t"."frequency"."\r\n";
    $catCounts = $allCats->categoryCounts($type,$parent_id);
    foreach ($catCounts as $cat):
        $cat_count = $cat['total_count'];
        $category = $cat['category'];
        echo $category."\t".(int)$cat_count."\r\n";
    endforeach;
}
