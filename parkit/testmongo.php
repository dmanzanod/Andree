<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$manager = new MongoDB\Driver\Manager("mongodb://dbParkit:4xnQaoK7WzAf98fX@cluster0-shard-00-00.qw89e.mongodb.net:27017/test");

var_dump($manager);

$query = ['prodCat' => '10 oz can']; // your typical MongoDB query
$cmd = new MongoDB\Driver\Command([
    // build the 'distinct' command
    'distinct' => 'product', // specify the collection name
    'key' => 'scent', // specify the field for which we want to get the distinct values
    'query' => $query // criteria to filter documents
]);
$cursor = $manager->executeCommand('catalog', $cmd); // retrieve the results
$scents = current($cursor->toArray())->values; // get the distinct values as an array

var_dump($scents);
?>