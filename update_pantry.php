<?php
session_start();
require_once "config.php";

// POST for adding and deleting ingredients
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION["logged_in"] == true) {
	$pantry_helper = new PantryHelper;
    $user_id = $_SESSION["userid"];
	if (isset($_POST["ingredient_add"])) {
		$add_ingredient = $_POST["ingredient_add"];
		$pantry_helper->addToPantry($user_id, $add_ingredient);
	} else if (isset($_POST["ingredient_del"])) {
		$del_ingredient = $_POST["ingredient_del"];
		$pantry_helper->deleteFromPantry($user_id, $del_ingredient);
	}
}
header('Location: view_pantry.php');
?>