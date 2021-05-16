<?php
require_once "config.php";
session_start();
?>

<script src="node_modules/tablefilter/dist/tablefilter/tablefilter.js"></script>

<style type="text/css">
#filterableTable {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#filterableTable td, #filterableTable th {
  border: 1px solid #ddd;
  padding: 8px;
}

#filterableTable tr:nth-child(even){background-color: #f2f2f2;}

#filterableTable tr:hover {background-color: #ddd;}

#filterableTable th {
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
	<title>Top Rated Vegan Recipes</title>
	<h1>Top Rated Vegan Recipes</h1>
	<h3>Enjoy delicious vegan foods! Here are our users' top picks!</h3>
</head>


<head>
<style> 
input[type=text] {
  width: 100%;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
  background-color: white;
  background-image: url('searchicon.png');
  background-position: 10px 10px; 
  background-repeat: no-repeat;
  padding: 12px 20px 12px 40px;
}
</style>
</head>

<input type="text" id="myInput" onkeyup="filterTable()" placeholder="Filter by dietary preference/tag" title="Type in a dietary preference">

<script>
function filterTable() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("filterableTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[6];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>

<br></br>

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
	$result = $recipeHelper->getTopVeganRecipes();

	if ($result) {
		//echo "Query returned results, displaying 10 random results:<br/><a href=\"view_random_recipes.php\">10 more recipes</a><br/><br/>";
	}

	echo "<table id = \"filterableTable\">";
	echo "<tr>
	<th>Recipe ID</th>
	<th>Name</th>
	<th>Description</th>
	<th>Ingredients</th>
	<th>Instructions</th>
	<th>Minutes</th>
	<th>Tags</th>
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
		$tags = str_replace("'", '',$row[7]);
		echo "<td>" . $tags . "</td>";	// tags

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