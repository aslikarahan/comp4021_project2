<?php
$char = file_get_contents("char.json");
$char = json_decode($char, true);
if (isset($_GET["house"])){
	$house = $_GET["house"];
}
if(isset($_GET["status"])){
	$status = $_GET["status"];
}
$temp;
$count=1;
if(isset($house) && $house!=null &&isset($status) && $status!=null){
  for ($x = 1; $x < max(array_keys($char)); $x++) {
    if($char[$x]["house"]==$house && $char[$x]["status"]==$status){
      $temp[$count]=$char[$x];
      $count++;
    }
  }
}else if(isset($house) && isset($status) && $house!=null && $status==null){
  for ($x = 1; $x < max(array_keys($char)); $x++) {
    if($char[$x]["house"]==$house){
      $temp[$count]=$char[$x];
      $count++;
    }
  }
}else if(isset($house) && isset($status) && $house==null && $status!=null){
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
