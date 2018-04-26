<?php
$char = file_get_contents("char.json");
$char = json_decode($char, true);
$house = $_GET["house"];
$status = $_GET["status"];
$temp;
$count=1;
if($house!=null && $status!=null){
  for ($x = 1; $x < max(array_keys($char)); $x++) {
    if($char[$x]["house"]==$house && $char[$x]["status"]==$status){
      $temp[$count]=$char[$x];
      $count++;
    }
  }
}else if($house!=null && $status==null){
  for ($x = 1; $x < max(array_keys($char)); $x++) {
    if($char[$x]["house"]==$house){
      $temp[$count]=$char[$x];
      $count++;
    }
  }
}else if($house==null && $status!=null){
  for ($x = 1; $x < max(array_keys($char)); $x++) {
    if($char[$x]["status"]==$status){
      $temp[$count]=$char[$x];
      $count++;
    }
  }
}else{
  $temp= $char;
}


$temp= json_encode($temp, JSON_PRETTY_PRINT);
print ($temp);

?>
