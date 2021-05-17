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
<title>Pantry</title>
<link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<link href="dashboard.css" rel="stylesheet">   
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="index.php">SpoilerAlert</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
</header>

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