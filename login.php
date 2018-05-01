<?php
session_start();

$users = file_get_contents("users.json");
$users = json_decode($users, true);

if (array_key_exists($_POST["username"], $users))  {
	if ($users[$_POST["username"]]["password"] == $_POST["password"]){	
		$output["status"] = "success";
		$output["message"] = "Login Success";
		$_SESSION["username"] = $_POST["username"];
		if (isset($_POST['rmbme']) && $_POST['rmbme'] == 'on'){
			setcookie ("username",$_POST["username"],time()+ (60 * 60));
		}
		
	} else {
		$output["status"] = "error";
		$output["message"] = "Password is incorrect!";

	}
} else {
	$output["status"] = "error";
	$output["message"] = "Username/password is not correct!";
}
print json_encode($output);	