<?php
session_start();
require_once "config.php";
?>

<style>
table, th, td {

border: 1px solid black;

border-collapse: collapse;

}

th, td {

padding: 10px;

}

th {

background-color: #FDDF95;

}

colgroup {

width: 250px;

}
</style>


<html>
<head>
	<h2>Modify Page </h2>
	

	<br/>
        <a href ="/">Back to home</a>
        <br/><br/>
</head>
<body>
<?php
	function replace($str){

	}
?>

<?php
	$arr = array("Recipe_name", "Minute", "Description", "Num_steps", "Steps", "Num_ingre", "Ingredients", "Nutrition", "Tags" );
	if (isset($_POST["submit1"]) ) {
		$flag = false;
		for ($i = 0; $i < 9; $i++) {
			$value = $_POST[$arr[$i]];
			if ($value == "") {
				echo "warning! ";
				echo $arr[$i];
				echo " is empty\n";
				$flag = true;
			}
			
		}
	
		if ($flag == true) {
			echo "Failed to modify the table\n";
		} else {
			$recipeID = $_POST["id"];
			$a = $sql_conn->query("delete from recipes where recipeID = $recipeID");
			$prepped_receiptID = (int) $recipeID;
        		$prepped_receiptName =  $sql_conn->real_escape_string($_POST["Recipe_name"]);
        		$prepped_desceiption = $sql_conn->real_escape_string(htmlspecialchars($_POST["Description"]));
        		$prepped_minutes = (int) $_POST["Minute"];
        		$prepped_n_steps = (int)$_POST["Num_steps"];
        		$prepped_Steps = $sql_conn->real_escape_string(htmlspecialchars($_POST["Steps"]));
        		$prepped_n_ingredients = $sql_conn->real_escape_string($_POST["Num_ingre"]);
        		$prepped_ingredients = $sql_conn->real_escape_string($_POST["Ingredients"]);
        		$prepped_tags = $sql_conn->real_escape_string($_POST["Tags"]);
        		$prepped_nutrition = $sql_conn->real_escape_string($_POST["Nutrition"]);
        		$userID = $_POST["userID"];
        		$prepped_userID = $sql_conn->real_escape_string($userID);
			$insert_command = "INSERT INTO recipes (recipeID, name,description , minutes, tags, nutrition, n_steps, steps, ingredients, n_ingredients, url, userID) VALUES ($prepped_receiptID, '{$prepped_receiptName}', '{$prepped_desceiption}', $prepped_minutes, '{$prepped_tags}', '{$prepped_nutrition}', $prepped_n_steps, '{$prepped_Steps}',  '{$prepped_ingredients}', $prepped_n_ingredients, \"none\", $prepped_userID )";	
        		$insert_result = $sql_conn->query($insert_command);

        		if ($insert_result) {
                		echo "Recipe created or updated by $userID <br/><br/>";
        		}	
					
		}
	} else if (isset($_POST["submit2"])) {
		
		$recipeID = $_POST["id"];
		echo $recipeID;
		$result = $sql_conn->query("delete from recipes where recipeID = $recipeID");
	 
		// $sql_conn->query("delete from savedRecipes where recipeID = $recipeID");
		// $sql_conn->query("delete from ratings where recipeID = $recipeID");
	}
	
	$userid ="";
	if (isset($_POST["submit"])) {
	  $usermail =  $_POST["email"];
	  $sql = "select * from users where username = \"$usermail\"";
	 $result = $sql_conn->query($sql);
	  if ($result) {
	  	if ($row = $result->fetch_row()) {
	            $userid = $row[0];		
		}
	  } else {
		echo "failed";
	  }	  
	}
	if (isset($_POST["submit1"]) || isset($_POST["submit2"])) {
		$userid = $_POST["userID"];
	}
	if ($userid == "") {
	 echo '<script type="text/JavaScript"> 
                window.location.href = "index.php";
                </script>';
	}
//	echo $userid;
	$userid_query = "select * from recipes where userID = $userid ";
	
	$result = $sql_conn->query($userid_query);
	
	if($result) {
		echo "
  		<table>
		<colgroup>
		<col>
		<col>
		<col>
                <col>
		<col>
                <col>
		<col>
                <col>
		<col>
		<col style=\"width:300px\">
		</colgroup>
   		<tr> 
		<th>name</th>
	 	<th>description</th>
	 	<th>minutes</th>
		<th>tags</th>
		<th>nutrition</th>
		<th>n_steps</th>
		<th>steps</th>
		<th>ingredients</th>
		<th>n_ingredients</th>	
  		<th>actions</th>
		</tr>";

		while($row = $result->fetch_row()) {
		 /*echo "<tr>"  "<td>" . $row[1]. "</td>"  "<td>" . $row[2]. "</td>" "<td>" . $row[3]. "</td>" " <td>" . $row[4]. "</td>" "<td>" . $row[5]. "</td>" "<td>" . $row[6]. "</td>" "<td>" . $row[7]. "</td>" "<td>" . $row[8]. "</td>" "<td>" . $row[9]. "</td>"  "</tr>";
		}*/
		//	echo "<tr>"  "<td>" . $row[1]. "</td>" "</tr>";
			echo "<tr>";
			for ($x = 1; $x <= 9; $x++) {
				echo "<td>";
				echo str_replace('\'', '', $row[$x]);
				echo "</td>";
			}
			echo "<td>";
			echo "	<form action=\"modify_helper.php\" method=\"post\">
				<input type =\"hidden\" name = \"id\" value = $row[0] />
				<Button name = \"edit\"> Edit</button>";
			echo "</form>";	
			echo "</td>";
			 /*echo "<td> $row[1] </td>";
			echo "<td> $row[2] </td>";
			echo  "<td> $row[3] </td>";
			echo "<td> $row[4] </td>";
			echo "<td> $row[5]</td>";
			echo "<td> $row[6]</td>";
			echo "<td> $row[7]</td>";
			echo "<td>$row[8]<td>";	
			echo "<td>$row[9]<td>";*/
			echo "</tr>";
		}
		echo "</table>";
		
	}
	
?>

</body>
</html>	
