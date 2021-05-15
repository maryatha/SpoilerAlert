<?php
require_once "config.php";
session_start();
?>
<!-- TODO: Refactor file, don't need to show random records anymore -->
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
  /*optional*/
  font-family: arial, sans-serif;
  /*input has OS specific font-family*/
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
		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["recipe_id"])) {
			//echo "Saving recipe ID: " . $_POST["recipe_id"] . "<br/>Userid: " . $_SESSION["userid"];
		
			$recipeHelper = new RecipeHelper;
			
			if (!$recipeHelper->saveRecipe($_SESSION["userid"], $_POST["recipe_id"])) {
				echo "Error saving recipe. You probably already saved this recipe before.";
			}
			
		}
	?>

	<?php
		
		$recipeHelper = new RecipeHelper;
		
		$result = $recipeHelper->getSavedRecipesForUser($_SESSION["userid"]);
		$numRecipes = mysqli_num_rows($result);

	?>

	<h2>You have <?php echo $numRecipes; ?> saved recipe<?php if ($numRecipes!=1) echo "s";?></h2>

	<?php

		if ($numRecipes>0) {
	?>
			<table id="recipeTableStyle">
				<tr>
					<th>Recipe ID</th>
					<th>Recipe Name</th>
					<th>Date Added</th>
				</tr>
				<?php
				
					while ($row = $result->fetch_row()) {
						echo "<tr>";
						echo "<td>" . $row[0] . "</td>";
						echo "<td>" . "<a href=\"" . $row[2] . "\" target=_blank>" . $row[1] . "</a>" . "</td>";
						echo "<td>" . date("F j, Y, g:i a", strtotime($row[3])) . "</td>";
						echo "</tr>";
					}
				?>
			</table>
	<?php
		}
	?>
	
	<br/>
	<br/>
	<a href="view_random_recipes.php">View Recipes</a>
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

