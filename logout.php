<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["log_out"])) {
	$_SESSION["username"] = null;
	$_SESSION["logged_in"] = null;
	header("Location: login.php");
}
?>