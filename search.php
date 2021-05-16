<?php
require_once 'config.php';
?>

<html>
<head>
    <title>Recipe Search</title>
    <h2> Search for Recipes </h2>
    <link rel="stylesheet" href="table.css">
    <!-- <link rel="stylesheet" href="old_table.css"> -->
</head>
 

<body>
<div>
<form action = "#" method = "post">
    <input name = "input" placeholder = "Enter here...">
    <select name="chapter" id="chapter">
        <option name = "ingredients" value="ingredients" selected="ingredients">ingredients</option>
 	<option name = "tags" value = "tags" selected = "tags" > tags</option>
        <option name = "recipeName" value="recipeName" selected="recipe name">recipe name</option>
    </select>
    <button name = "submit" type = "submit" >Submit</buttpn>
</form>
</div>
    <?php
        if (isset($_POST["submit"]) ) {
            $value = $_POST["input"];
            $searchBy = $_POST["chapter"];
	    $sql = "select * from recipes";
	    if ($searchBy == "recipeName") {
	    	 $rest_sql = " where name like \"%{$value}%\" limit 50";
                // $rest_sql = "where name like \"%{$value}%\"";
		$sql = $sql. ' ' . $rest_sql;
	   }	
	    if($searchBy == "nutrition"){
		$rest_sql = " where nutrition like \"%{$value}%\" limit 50";
		$sql = $sql. ' ' . $rest_sql;
	    } else if($searchBy == "tags") {
		$rest_sql = " where tags  like \"%{$value}%\" limit 50";
                $sql = $sql. ' ' . $rest_sql;
	    }
	    $result = $sql_conn->query($sql);
                if($result) {
		echo "
                <table id = 'recipeTableStyle'>
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
                <th>number of steps</th>
                <th>steps</th>
                <th>ingredients</th>
                <th>num of ingredients</th>
                <th>Save or Rate</th>  
                </tr>";

                while($row = $result->fetch_row()) {
                 /*echo "<tr>"  "<td>" . $row[1]. "</td>"  "<td>" . $row[2]. "</td>" "<td>" . $row[3]. "</td>" " <td>" . $row[4]. "</td>" "<td>" . $row[5]. "</td>" "<td>" . $row[6]. "</td>" "<td>" . $row[7]. "</td>" "<td>" . $row[8]. "</td>" "<td>" . $row[9]. "</td>"  "</tr>";
                }*/
                //      echo "<tr>"  "<td>" . $row[1]. "</td>" "</tr>";
                        echo "<tr>";
                        for ($x = 1; $x <= 9; $x++) {
                                echo "<td>";
                                if($x ==4 || $x ==7||$x ==8){
                                    $results = explode(',', $row[$x]);
                                    foreach($results as $res){
                                        print_r(str_replace('\'','',$res));
                                        echo "<br />";
                                    }
                                   }   else if($x == 5){
                                    $results = explode(',', $row[$x]);
                                    $arrar_nut = array("calories: ", "fat:", "calories from fat: ", "carbs: ", "protein: ", "sugar: ", "calcium: ");

                                   $count = 0;
                                   while($count <= 7) {
                                       if($count <= 7){
                                           echo $arrar_nut[$count] . $results[$count] . "<br />";
                                       }
                                       $count += 1;
                                   }
              


                                }else{
                                    echo $row[$x];
                                }
                                
                                echo "</td>";
                        }
                         
                         /*echo "<td> $row[1] </td>";
                        echo "<td> $row[2] </td>";
                        echo  "<td> $row[3] </td>";
                        echo "<td> $row[4] </td>";
                        echo "<td> $row[5]</td>";
                        echo "<td> $row[6]</td>";
                        echo "<td> $row[7]</td>";
                        echo "<td>$row[8]<td>"; 
                        echo "<td>$row[9]<td>";*/
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
	
                } else {
			echo "failed";
		} 
       }

       ?>

    
<body>
</html>

