<?php
$char = file_get_contents("users.json");
$char = json_decode($char, true);
if (isset($_GET["username"])){
	$uname = $_GET["username"];
}
$temp=$char[$uname]["image"];
$temp= json_encode($temp, JSON_PRETTY_PRINT);
print ($temp);



?>
