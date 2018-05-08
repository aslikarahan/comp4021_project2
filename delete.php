<?php
$char = file_get_contents("char.json");
$char = json_decode($char, true);
unset($char[$_POST['id']]);
/*foreach($char as $key=>$data){
	if($key > $_POST['id'] ){
		$newkey = $key--;
		$char[$key] = $char[$newkey];

	}
}*/
ksort($char);
/*if ($_POST['id'] <= max(array_keys($char))){
array_pop($char);
}*/
file_put_contents("char.json", json_encode($char, JSON_PRETTY_PRINT));
print  json_encode($char, JSON_PRETTY_PRINT);
