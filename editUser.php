<?php
$char = file_get_contents("users.json");
$char = json_decode($char, true);
$id = $_POST['username'];
$char[$id]["name"] = $_POST["name"];
$char[$id]["email"] = $_POST["email"];
$char[$id]["gender"] = $_POST["gender"];
$char[$id]["birthday"] =$_POST["birthday"];
$char[$id]["password"] = $_POST["password"];


file_put_contents("users.json", json_encode($char, JSON_PRETTY_PRINT));
print  json_encode("success", JSON_PRETTY_PRINT);
