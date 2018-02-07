<?php
$jsonString = file_get_contents('bookmarks.json');
$data = json_decode($jsonString);

$key = $_POST["index"];

unset($data->$key);

print("<pre>".print_r($data,true)."</pre>");
 
$newJsonString = json_encode($data);

file_put_contents('bookmarks.json', $newJsonString);
?>