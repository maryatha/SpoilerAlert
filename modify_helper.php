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
 
        
 
<body>

<div class = "container">
<h2>Modify Page </h2>
<hr>
<form action = 'modify.php' method= "post">   
<?php
	if (isset($_POST['edit'])) {
	} else {
	   echo '<script type="text/JavaScript"> 
                window.location.href = "index.php";
                </script>';
	}
		$id = $_POST['id'];	
		$sql = "select * from recipes where recipeID = $id";
		$result = $sql_conn->query($sql);
		
		if($result) {
			
			if ($row = $result->fetch_row()) {
        $name = "'$row[1]'";
?>
			<div class="field">
    
    <label for="exampleInputEmail1">Recipe Name</label>
    <input value = <?php echo "'$row[1]'"?> type="text" name="Recipe_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Recipe Name" required>
    <!-- <input type="text" name="Recipe_name" placeholder="Recipe Name"> -->
  </div>
<br>
  <div class="field">
    <label for="exampleInputEmail1" >Minute</label>  
    <input  value = <?php echo "'$row[3]'"?> type="number" name="Minute" class="form-control" placeholder="Minute" required>
  </div>
<br>
  <div class="field">
    <label for="exampleInputEmail1">Description</label> <br>
    
    <textarea name="Description" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="steps" >
    <?php echo str_replace('\'', '', $row[2])?>
    </textarea>
  </div>
<br>
<div class="field">
    <label>Number Of Ingredients</label> <br>
    <input value = <?php echo "'$row[9]'"?> type="number" name="Num_ingre" class="form-control"  placeholder="Numbers Only" required> </input>
  </div>
<br>
 <div class="field">
    <label>Ingredients</label> <br>
    <input value = <?php echo "'$row[8]'"?> type="text" name="Ingredients" class="form-control"  placeholder="Ingredients" required> </input>
 </div>
<br> 
<div class="field">
    <label>Number Of Steps</label> <br>
    <input value = <?php echo "'$row[6]'"?> type="number" name="Num_steps" class="form-control"  placeholder="Numbers Only" required> </input>
  </div>
<br>
 <div class="field">
    <label>Steps</label> <br>
    <!-- <input type="text" name="Steps" class="form-control"  placeholder="steps"  required> </input> -->
    <textarea name="Steps" class="form-control" id="exampleFormControlTextarea1" rows="6" placeholder="steps" >
    <?php echo str_replace('\'', '', $row[7])?>
    </textarea>
  </div>
<br>
 <div class="field">
    <label>Nutrition</label> <br>
    <input value = <?php echo "'$row[5]'"?> type="text" name="Nutrition" class="form-control"  placeholder="Nutrition"  required> </input>
 </div>
<br>
 <div class="field">
    <label>Tags</label> <br>
    <input value = <?php echo "'$row[4]'"?>  type="text" name="Tags" class="form-control"  placeholder="Tags" required> </input>
 </div>	
 <input type ="hidden" name = "id" value = <?php echo $row[0]?> />
				<input type = "hidden", name = "userID" value = <?php echo $row[11]?> >
				<button  name = 'submit1' type = 'submit' class="btn btn-outline-success">Save</button>
				 <button  name = 'submit2' type = 'submit' class="btn btn-outline-danger">Delete</button>
				<button name = "submit1" class="btn btn-outline-warning"> cancel</button>	
		<?php }}?>
		    

</form>
<div>
</body>
</html>


<!-- echo "
  				<div class=\"field\">
    				<label>Recipe Name</label> <br>
    				<input type=\"text\" name=\"Recipe_name\" value =\"" . $row[1] . "\">
  				</div>
				                  
				 <br>
                                  <div class=\"field\">
                                    <label>Minute</label> <br>
                                    <input type=\"number\" name=\"Minute\" value =\"". $row[3] ."\">
                                  </div>
                                <br>
                                  <div class=\"field\">
                                    <label>Description</label> <br>
                                    <input type=\"text\" name=\"Description\" value =\"".$row[2] ."\" style = \"height = 300px\" > </input>
                                
                                  </div>
                                <br>
                                 <div class=\"field\">
                                    <label>Number Of Steps</label> <br>
                                    <input type=\"number\" name=\"Num_steps\" value =\"".$row[6]."\"> </input>
                                  </div>
                                <br>
                                 <div class=\"field\">
                                    <label>Steps</label> <br>
                                    <input type=\"text\" name=\"Steps\" value =\"".$row[7]."\"> </input>
                                  </div>
                                <br>
                                <div class=\"field\">
                                    <label>Number Of Ingredients</label> <br>
                                    <input type=\"number\" name=\"Num_ingre\" value =\"". $row[9]."\"> </input>
                                  </div>
                                <br>
                                 <div class=\"field\">
                                    <label>Ingredients</label> <br>
                                    <input type=\"text\" name=\"Ingredients\" value = \"" . $row[8] . "\"> </input>
                                 </div>
                                <br>
                                 <div class=\"field\">
                                    <label>Nutrition</label> <br>
                                    <input type=\"text\" name=\"Nutrition\" value =\"".$row[5]."\"> </input>
                                 </div>
                                <br>
                                 <div class=\"field\">
                                    <label>Tags</label> <br>
                                    <input type=\"text\" name=\"Tags\" value =\"".$row[4]."\"> </input>
                                    </div>
                                <br>
                                  <div class=\"field\">
                                    </div>
                                  </div>
				<input type =\"hidden\" name = \"id\" value = $row[0] />
				<input type = \"hidden\", name = \"userID\" value = $row[11]>
				<button  name = 'submit1' type = 'submit'>Save</button>
				 <button  name = 'submit2' type = 'submit'>Delete</button>
				<button name = \"submit1\"> cancel</button>	
			     "; -->