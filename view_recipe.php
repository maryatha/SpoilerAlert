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
<title>View Recipe</title>
<link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<link href="dashboard.css" rel="stylesheet">

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="index.php">SpoilerAlert</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
   
   
   

  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
    <form action="logout.php" method="post">
        
        <button name="log_out" class="btn btn-outline-primary">Log out</button>

    </form>
    </li>
  </ul>


</header>
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

