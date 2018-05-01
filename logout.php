<?php
session_start();
if (isset($_COOKIE['username'])){
	error_log("delete cookie");
	setcookie("username","", -1,"/");
	error_log($_COOKIE['username']);
}
if (isset($_SESSION['username']))
unset($_SESSION['username']);

