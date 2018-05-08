<?php
$char = file_get_contents("char.json");
$char = json_decode($char, true);
$search;
if (isset($_GET["search"])){
  $search = $_GET["search"];
}
$house;
$sort;
if (isset($_GET["house"])){
  $house = $_GET["house"];
}
if(isset($_GET["sort"])){
  $sort = $_GET["sort"];
}

$temp1;
$count=1;
if($search != NULL && isset($_GET["search"])){
  for ($x = 1; $x < max(array_keys($char)); $x++) {
    $search_exists = false;
    $s_char=array($char[$x]["name"],$char[$x]["house"],$char[$x]["status"],$char[$x]["patronus"],$char[$x]["description"]);

    for($i = 0; $i < 5; $i++) {
      if(stripos($s_char[$i], $search)!==false){
        $search_exists = true;
      }
    }
    if($search_exists){
      $temp1[$count]=$char[$x];
      $count++;
    }
  }
}else{
  $temp1=$char;
}
$count=1;
$temp2;
if(isset($house) && $house!=null){
  for ($j = 1; $j < max(array_keys($temp1)); $j++) {
    if($temp1[$j]["house"]==$house){
      $temp2[$count]=$temp1[$j];
      $count++;
    }
  }

}else{
  $temp2= $temp1;
}

$temp3;
if(isset($sort) && $sort!=null){
  if($sort=="by-name"){
    for ($j = 1; $j < max(array_keys($temp2)); $j++) {
      $temp3[$temp2[$j]["name"]]=$temp2[$j];
    }
    ksort($temp3);
  }else if($sort=="by-patronus"){
    for ($j = 1; $j < max(array_keys($temp2)); $j++) {
      $temp3[$temp2[$j]["patronus"]]=$temp2[$j];
    }
    ksort($temp3);
  }else{
    $temp3= $temp2;
  }

}else{
  $temp3= $temp2;
}


$temp3= json_encode($temp3, JSON_PRETTY_PRINT);
print ($temp3);

?>
