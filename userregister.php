<?php
session_start();
$users = file_get_contents("users.json");
$users = json_decode($users, true);
$response = $_POST['g-recaptcha-response'];
$secret = "6Ld5qFYUAAAAAOkCx7jXPV6yVDOVHbeRTa27v3fs";
$url = "https://www.google.com/recaptcha/api/siteverify";

$verify = file_get_contents($url."?secret=".$secret."&response=".$response);
$verify = json_decode($verify, true);
if (!$verify['success']){
	$output["status"] = "error";
	$output["message"] = "reCAPTCHA verification error!";
}else{
	if(!array_key_exists($_POST['username'] , $users)){
		$users[$_POST['username']]["name"] = $_POST["name"];
		$users[$_POST['username']]["email"] = $_POST["email"];
		$users[$_POST['username']]["gender"] = $_POST["gender"];
		$users[$_POST['username']]["birthday"] =$_POST["birthday"];
		$users[$_POST['username']]["password"] = $_POST["password"];
		file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));
		$output["status"] = "success";
		$output["message"] = "register success";
		$_SESSION['username'] = $_POST['username'];
	}else{
		$output["status"] = "error";
		$output["message"] = "Duplicate username!";
	}
}
print json_encode($output);
?>