<?php

require_once "config.php";
session_start();
?>
<style type="text/css">
#recipeTableStyle {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#recipeTableStyle td, #recipeTableStyle th {
  border: 1px solid #ddd;
  padding: 8px;
}

#recipeTableStyle tr:nth-child(even){background-color: #f2f2f2;}

#recipeTableStyle tr:hover {background-color: #ddd;}

#recipeTableStyle th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}

button {
  background: none!important;
  border: none;
  padding: 0!important;
  font-family: arial, sans-serif;
  color: #069;
  text-decoration: underline;
  cursor: pointer;
}
</style>

<html>
<head>
	<h2>Spoiler Alert</h2>
</head>
<body>
	<?php
	if (isset($_SESSION["username"]) && isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true && $_SESSION["logged_in"] == true) {
		//echo 'Welcome ' . $_SESSION["username"] . "<br/>";
	}
	else {
		header('Location: login.php');
	}
	?>
	
	<?php
		// make sure we have a recipe ID before continuing
		if (!($_GET["id"] && isset($_GET["id"]))) {
			header ('Location: view_random_recipes.php');
		}

		$recipeID = $_GET["id"];
		$userID = $_SESSION["userid"];

		// get the recipe info
		$recipeHelper = new RecipeHelper;
		$recipe = $recipeHelper->getRecipeByID($recipeID);
	?>

	<h1><?php echo $recipe[1]; ?></h1>
	<a href="<?php echo $recipe[10]; ?>" target=_blank>View this recipe on Food.com</a>

	<br/><br/>
	
	<?php
		// rate the recipe if form submitted
		if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["stars"])) {
			$result = $recipeHelper->rateRecipe($recipeID, $userID, $_POST["stars"]);
			// if (!$result) {
			// 	echo "Failed to rate the recipe. Please try again later. <br><br>";
			// }
		}


		// show the average rating
		$average_rating = $recipeHelper->getAverageRatingForRecipe($recipeID);	// average rating
		echo "Average rating for recipe: " . number_format($average_rating, 1) . " star";
		if ($average_rating != 1) echo "s";
		echo "<br/><br/>";

		// show the user's rating
		$rating = $recipeHelper->getRatingForRecipeByUser($recipeID, $userID);	// previous rating
		if (!$rating) {
			echo "You have not rated this recipe before.";
		} else {
			echo "You have rated this recipe " . $rating . " star(s)!";
		}
	?>

	<form action="" method="post">
		<?php
			for ($i = 1; $i <= 5; $i++) {
		?>
			<input type="radio" name="stars" value="<?php echo $i; ?>" <?php if ($rating == $i) echo "checked=\"checked\"" ?> required>
			<label for="<?php echo $i; ?>"><?php echo $i; ?> star<?php if ($i > 1) echo "s"; ?></label>
		<?php
			}
		?>
		<input type="submit" name="rate_recipe" value="Rate Recipe"/>
	</form>
	
	<br/>
	<br/>
	<a href="index.php">Back to home</a>

	<?php

	
	?>
</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["redirect_recipe"])) {
	header("Location: create_recipe.php");
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["list_recipes"])) {
	echo "Viewing 10 random recipes<br/><br/>";
	$sql = "select * from recipes order by rand() limit 10";
	$result = $sql_conn->query($sql);
	while ($row = $result->fetch_row()) {
		// row returned has it in same order as database
		echo "<li> recipeID: " . $row[0] . "<br/>name: " . $row[1] . "<br/>description: " . $row[2] . "</li>";
	}
}
?>

</html>

