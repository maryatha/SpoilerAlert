<?php
require_once "config.php";
session_start();
?>
<!-- TODO: Refactor file, don't need to show random records anymore -->
<style>
<?php include "main.css"?>
</style>

<html>
<head>
	<h2>Welcome to Spoiler Alert!</h2>

	<h4>Are you tired of throwing out your spoiled groceries and spending money on takeout? Spoiler Alert helps reduce food waste by matching you with recipes that accomodate your dietary restrictions while using ingredients you have on hand! There are over 200,000 recipes available, and you can even add your own recipes, and rate/save recipes too!</h4>

</head>
<body>
	<?php
	if (isset($_SESSION["username"]) && isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true && $_SESSION["logged_in"] == true) {
		echo '<div align="center">Welcome ' . $_SESSION["username"] . "</div><br/>";

	}
	else {
		header('Location: login.php');
	}
	
	?>
	<form action="create_recipe.php" method="post">
        <input type = "hidden" name = "email" value = "<?php echo $_SESSION["username"];?>"/>
	<button type = "submit" name = "submit"> Create recipe</button>
    </form>
	<form action="search.php" method="post">
        <input type="submit" name="list_recipes" value="Search Recipes"/>
    </form>
	<form action = "modify.php" method = "post">
		<input type = "hidden" name = "email" value = "<?php echo $_SESSION["username"];?>"/>
		<button name = submit>View my recipes</button>
	</form>
	<form action = "view_pantry.php" method = "post">
		<button name = submit>Go to pantry</button>
	</form>
	<form action="logout.php" method="post">
        <input type="submit" name="log_out" value="Log out"/>
    </form>


	<a href="save_recipe.php">View my saved recipes</a>
	<br/>
	<a href="search.php">Search recipes</a>
	
	<br/>
	<a href="searchMongo.php">Go for Elastic</a>
	
	<br/>
	<a href="viewTopDessert.php">Go to Top Rated Desserts</a>
	<br/>

	<br/>
	<a href="viewTopLowCarb.php">Go to Top Rated Low-Carb Recipes</a>
	<br/>

	<br/>
	<a href="viewTopLowSodium.php">Go to Top Rated Low-Sodium Recipes</a>
	<br/>

	<br/>
	<a href="viewTopVegan.php">Go to Top Rated Vegan Recipes</a>
	<br/>

	<br/>
	<a href="viewTopVegetarian.php">Go to Top Rated Vegetarian Recipes</a>
	<br/>



	<?php
	
	?>
</body>
</html>

