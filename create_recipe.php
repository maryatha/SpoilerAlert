<?php
session_start();
require_once "config.php";
?>

<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box}
.container {
  padding: 16px;
}

hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}
</style>
 
        
 
<div class = "container">
<h2>Create Recipe page</h2>
<hr>
 <form class="form" action="" method="post">
 
  <div class="field">
    
    <label for="exampleInputEmail1">Recipe Name</label>
    <input type="text" name="Recipe_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Recipe Name" required>
    <!-- <input type="text" name="Recipe_name" placeholder="Recipe Name"> -->
  </div>
<br>
  <div class="field">
    <label for="exampleInputEmail1" >Minute</label>  
    <input type="number" name="Minute" class="form-control" placeholder="Minute" required>
  </div>
<br>
  <div class="field">
    <label for="exampleInputEmail1">Description</label> <br>
    <!-- <input type="text" name="Description" class="form-control" placeholder="Description", style = "height = 300px"  required> </input> -->
    <textarea name="Description" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Description" ></textarea>
  
  </div>
<br>
<div class="field">
    <label>Number Of Ingredients</label> <br>
    <input type="number" name="Num_ingre" class="form-control"  placeholder="Numbers Only" required> </input>
  </div>
<br>
 <div class="field">
    <label>Ingredients</label> <br>
    <input type="text" name="Ingredients" class="form-control"  placeholder="Ingredients" required> </input>
 </div>
<br> 
<div class="field">
    <label>Number Of Steps</label> <br>
    <input type="number" name="Num_steps" class="form-control"  placeholder="Numbers Only" required> </input>
  </div>
<br>
 <div class="field">
    <label>Steps</label> <br>
    <!-- <input type="text" name="Steps" class="form-control"  placeholder="steps"  required> </input> -->
    <textarea name="Steps" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="steps" ></textarea>
  </div>
<br>
 <div class="field">
    <label>Nutrition</label> <br>
    <input type="text" name="Nutrition" class="form-control"  placeholder="Nutrition"  required> </input>
 </div>
<br>
 <div class="field">
    <label>Tags</label> <br>
    <input type="text" name="Tags" class="form-control"  placeholder="Tags" required> </input>
 </div>
<br>
  <input type = "hidden" name = "input" value = <?php echo $_POST["email"]?>>
  <button class="btn btn-outline-success" name="create_recipe" type="submit">Submit</button>
</form>
<form action="index.php" method="post">
  <input class = "btn btn-outline-danger" type="submit" name="log_out" value="Cancel"/>
</form>
</div>
</html>

<?php

if (isset($_POST["submit"])) {
	$usermail =  $_POST["email"];
	 $sql = "select * from users where username = \"$usermail\"";
         $result = $sql_conn->query($sql);
          if ($result) {
                if ($row = $result->fetch_row()) {
                    $userID = $row[0];
                }
          } else {
                echo "failed";
          }
} else {
//	echo "redirecting to main menu\n";
//	 echo '<script type="text/JavaScript"> 
  //              window.location.href = "index.php";
    //            </script>';
}

//echo $userID;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_recipe"])) {
    $usermail =  $_POST["input"];
  //  echo $usermail;
         $sql = "select * from users where username = \"$usermail\"";
         $result = $sql_conn->query($sql);
          if ($result) {
                if ($row = $result->fetch_row()) {
                    $userID = $row[0];
                   echo $userID;
		}
          } else {
                echo "failed";
          }

    $err = false;
    if (!isset($_POST["Recipe_name"]) || $_POST["Recipe_name"] == "") {
        echo "Please enter Recipe Name<br/>";
        $err = true;
    }
    if (!isset($_POST["Minute"]) || $_POST["Minute"] == "") {
        echo "Please enter minute<br/>";
        $err = true;
    }
      
    if (!isset($_POST["Description"]) || $_POST["Description"] == "") {
        echo "Please enter Description<br/>";
    	$err = true;
    }

    if (!isset($_POST["Num_steps"]) || $_POST["Num_steps"] == "") {
        echo "Please enter NumberOfSteps<br/>";
    	$err = true;
    }

    if (!isset($_POST["Steps"]) || $_POST["Steps"] == "") {
        echo "Please enter steps<br/>";
    	$err = true;
    }

    if (!isset($_POST["Num_ingre"]) || $_POST["Num_ingre"] == "") {
        echo "Please enter NumberOfIngredients<br/>";
    	$err = true;
    }	

    if (!isset($_POST["Ingredients"]) || $_POST["Ingredients"] == "") {
        echo "Please enter Ingredients<br/>";
    	$err = true;
    }
   
    if (!isset($_POST["Nutrition"]) || $_POST["Nutrition"] == "") {
        echo "Please enter Nutrition<br/>";
        $err = true;
    }

    if (!isset($_POST["Tags"]) || $_POST["Tags"] == "") {
        echo "Please enter Tags<br/>";
        $err = true;
    }
    
    if ($err == false && $_POST["Recipe_name"] != "" ) {
	
	$sql = "select recipeID  from recipes group by recipeID order by recipeID DESC limit 1";
        $result = $sql_conn->query($sql);
	$recipeID = 0;

        if ($result) {
        	$row = $result->fetch_row();
		$recipeID = $row[0]  +  1;
	}
//	echo "$recipeID";
	
	$prepped_receiptID = (int) $recipeID;
	$prepped_receiptName = $_POST["Recipe_name"];
//	echo 'name';
//	echo $prepped_receiptName;
	$prepped_desceiption = htmlspecialchars($_POST["Description"]);
	$prepped_minutes = (int) $_POST["Minute"];
	$prepped_n_steps = (int)$_POST["Num_steps"];
	$prepped_Steps = htmlspecialchars($_POST["Steps"]);
	$prepped_n_ingredients = $_POST["Num_ingre"];
	$prepped_ingredients = $_POST["Ingredients"];
	$prepped_tags = $_POST["Tags"];
	$prepped_nutrition = $_POST["Nutrition"];
	$prepped_userID = $userID;
	 $prepped_userID = (int) $userID;
	 $insert_command = "INSERT INTO recipes (recipeID, name,description , minutes, tags, nutrition, n_steps, steps, ingredients, n_ingredients, url, userID) VALUES ($prepped_receiptID, '{$prepped_receiptName}', '{$prepped_desceiption}', $prepped_minutes, '{$prepped_tags}', '{$prepped_nutrition}', $prepped_n_steps, '{$prepped_Steps}',  '{$prepped_ingredients}', $prepped_n_ingredients,\"none\", $prepped_userID )"; 
        $insert_result = $sql_conn->query($insert_command);	
	echo $insert_command;
	if ($insert_result) {
		echo '<script type="text/JavaScript"> 
     		alert("You successfully created the recipe!\n");
		window.location.href = "index.php";
     		</script>';
	} else {
     
		echo $insert_result;
		echo "failed";
	}		  
    } 
    echo "<form action =\"\" method =\"post\">
          <input type =\"hidden\" name = \"email\" value = $usermail />  
	</form>
	";    

   

}   
?>  
