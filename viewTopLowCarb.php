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
	<h1>Top Rated Low-Carb Recipes</h1>
	<h3>Enjoy a healthy low-carb meal! Here are our users top picks for low-carb recipes!</h3>
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
	
	<br/>
	<a href ="/">Back to home</a>
	<br/><br/>
	<?php

	$recipeHelper = new RecipeHelper;
	$result = $recipeHelper->getTopLowCarbRecipes();

	if ($result) {
		//echo "Query returned results, displaying 10 random results:<br/><a href=\"view_random_recipes.php\">10 more recipes</a><br/><br/>";
	}

	echo "<table id = \"recipeTableStyle\">";
	echo "<tr>
	<th>Recipe ID</th>
	<th>Name</th>
	<th>Description</th>
	<th>Ingredients</th>
	<th>Instructions</th>
	<th>Min</th>
	<th>Save or Rate</th>
	</tr>";
	
	while ($row = $result->fetch_row()) {
		echo "<tr>";
		echo "<td>" . $row[0] . "</td>";	// id
		echo "<td>" . "<a href=\"" . $row[2] . "\" target=_blank>" . $row[1] . "</a>" . "</td>";	// name
		echo "<td>" . $row[3] . "</td>";	// description
		$ingredients = str_replace("'", '',$row[4]);
		echo "<td>" . $ingredients . "</td>";	// ingredients
		$instructions = str_replace("'", '',$row[5]);
		echo "<td>" . $instructions . "</td>";	// instructions
		echo "<td>" . $row[6] . "</td>";	// minutes
	?>
		
		<td>
			<form action="save_recipe.php" method="post">
				<input type="hidden" name="recipe_id" value="<?php echo $row[0]; ?>"/>
				<input type="submit" name="Save Recipe" value="Save Recipe"/>
			</form>

			<form action="view_recipe.php" method="get">
				<input type="hidden" name="id" value="<?php echo $row[0]; ?>"/>
				<input type="submit" name="Rate Recipe" value="Rate Recipe"/>
			</form>
		</td>

	<?php

		echo "</tr>";

	}
	echo "</table>";
	

	$sql_conn->close();
	
	?>
</body>

<?php

?>

</html>