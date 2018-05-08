<?php

$char = file_get_contents("char.json");
$char = json_decode($char, true);
$id = $_GET['id'];
$result = $char[$id];
$result['id'] = $id;
print json_encode($result, JSON_PRETTY_PRINT);
