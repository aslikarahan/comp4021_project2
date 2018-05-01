<?php
session_start();
$users = file_get_contents("users.json");
$users = json_decode($users, true);
$users[$_POST['username']]["name"] = $_POST["name"];
	$users[$_POST['username']]["email"] = $_POST["email"];
	$users[$_POST['username']]["gender"] = $_POST["gender"];
	$users[$_POST['username']]["birthday"] =$_POST["birthday"];
	$users[$_POST['username']]["password"] = $_POST["password"];
	if(!array_key_exists($_POST['username'] , $users)){
		file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));
		$output["status"] = "success";
		$output["message"] = "register success";
		$_SESSION['username'] = $_POST['username'];
	}else{
		$output["status"] = "error";
		$output["message"] = "Duplicate username!";
	}
print json_encode($output);
?>