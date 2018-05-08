<?php
$char = file_get_contents("char.json");
$char = json_decode($char, true);

$name = $_POST['name'];

for ($x = 1; $x < max(array_keys($char)); $x++) {
  if($char[$x]['name']==$name){
    $result=$char[$x];
    $result['id'] = $x;
  }
}
$id=$result['id'];
unset($char[$id]);

foreach($char as $key=>$data){
	if($key > $id ){
		$newkey = $key--;
		$char[$key] = $char[$newkey];

	}
}
ksort($char);
if ($id<= max(array_keys($char))){
array_pop($char);
}
file_put_contents("char.json", json_encode($char, JSON_PRETTY_PRINT));
print  json_encode($char, JSON_PRETTY_PRINT);
