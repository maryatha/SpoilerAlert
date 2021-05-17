<?php
require_once 'config.php';
?>

<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
 <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">
 <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
 <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
 
<link href="dashboard.css" rel="stylesheet">
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
 
    <title>Recipe Search</title>
    <h2> Search for Recipes </h2>
    <link rel="stylesheet" href="table.css">
    <!-- <link rel="stylesheet" href="old_table.css"> -->
     
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    
 
 

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
                
                <th>steps</th>
                <th>ingredients</th>
                 
                <th>Save or Rate</th>  
                </tr>";

                while($row = $result->fetch_row()) {
                 /*echo "<tr>"  "<td>" . $row[1]. "</td>"  "<td>" . $row[2]. "</td>" "<td>" . $row[3]. "</td>" " <td>" . $row[4]. "</td>" "<td>" . $row[5]. "</td>" "<td>" . $row[6]. "</td>" "<td>" . $row[7]. "</td>" "<td>" . $row[8]. "</td>" "<td>" . $row[9]. "</td>"  "</tr>";
                }*/
                //      echo "<tr>"  "<td>" . $row[1]. "</td>" "</tr>";
                        echo "<tr>";
                        for ($x = 1; $x <= 9; $x++) {
                                if($x == 6 || $x == 9) {
                                    continue;
                                }

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

