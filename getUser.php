<?php

$char = file_get_contents("users.json");
$char = json_decode($char, true);
$name = $_GET['name'];

    $result=$char[$name];



print json_encode($result, JSON_PRETTY_PRINT);
