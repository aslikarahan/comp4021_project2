<?php
$char = file_get_contents("char.json");
$char = json_decode($char, true);
$last_id = max(array_keys($char));
$valid_char=true;
$name = $_POST['name'];
for ($x = 1; $x < max(array_keys($char)); $x++) {
  if(strcasecmp($char[$x]['name'], $name) == 0){
		$valid_char=false;
  }
}

if($valid_char){
	$id = $last_id + 1;

$char[$id]["name"] = $_POST["name"];
	$char[$id]["house"] = $_POST["house"];


	$char[$id]["status"] = $_POST["status"];
	$char[$id]["patronus"] =$_POST["patronus"];
	$char[$id]["image"] = $_POST["image"];
	$char[$id]["description"] = $_POST["description"];
		print json_encode("success");
}else{
	print json_encode("fail");

}
	file_put_contents("char.json", json_encode($char, JSON_PRETTY_PRINT));


?>
