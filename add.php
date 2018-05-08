<?php
$char = file_get_contents("char.json");
$char = json_decode($char, true);
$last_id = max(array_keys($char));
$id = $last_id + 1;
$char[$id]["name"] = $_POST["name"];
	$char[$id]["house"] = $_POST["house"];
	$char[$id]["status"] = $_POST["status"];
	$char[$id]["patronus"] =$_POST["patronus"];
	$char[$id]["image"] = $_POST["image"];
	$char[$id]["description"] = $_POST["description"];

	file_put_contents("char.json", json_encode($char, JSON_PRETTY_PRINT));
	print json_encode("success");

?>
