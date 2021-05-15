<?php
require_once "config.php";
session_start();
?>

<style type="text/css">
<?php include "main.css"?>
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
</style>

<html>
<head>
	<h2>Spoileralert</h2>
</head>
<body>
	<form action="update_pantry.php" method="post">
        <label for="ingredient_add"><b>Add ingredient: </b></label>
        <input name="ingredient_add" type="text"/><br/>
		<input type="submit" name="add_ingredient" value="Add ingredient"/>
	</form>
	<form action="update_pantry.php" method="post">
        <label for="ingredient_del"><b>Delete ingredient: </b></label>
        <input name="ingredient_del" type="text"/><br/>
		<input type="submit" name="delete_ingredient" value="Delete ingredient"/>
	</form>
	<?php
		$pantry_helper = new PantryHelper;
		$pantry = $pantry_helper->getPantry($_SESSION["userid"]);
		echo "<table id = \"recipeTableStyle\">";
		echo "<tr>
		<th>Ingredient Name</th>
		</tr>";
		foreach($pantry as $ingredient) {
			echo "<tr><td>".$ingredient."</tr></td>";
		}
	?>
</body>
</html>