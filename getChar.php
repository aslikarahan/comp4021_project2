<?php

$char = file_get_contents("char.json");
$char = json_decode($char, true);
$name = $_GET['name'];
for ($x = 1; $x < max(array_keys($char)); $x++) {
  if($char[$x]['name']==$name){
    $result=$char[$x];
    $result['id'] = $x;
  }
}


print json_encode($result, JSON_PRETTY_PRINT);
