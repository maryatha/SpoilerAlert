<style type="text/css">
#filterableTable {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#filterableTable td, #recipeTableStyle th {
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

<?php
session_start();
require_once 'config.php';
//require_once '/var/www/init.php';
use Elasticsearch\ClientBuilder;
require '../vendor/autoload.php';

$client = ClientBuilder::create()
->setHosts(['localhost:9200'])
->build();

   $user_id = $_SESSION['userid'];
   //echo var_dump($user_id);
   $pantry_helper = new PantryHelper;
   $pantryIngredients=$pantry_helper-> getPantry($user_id);
   //echo var_dump($pantryIngredients);
    //echo $pantryIngredients[0];
    $params=[
        'index' => 'project_mongodata_recepie_ingredients',
        "size" => 100,
        'body'=>[
            
            "query" => [
                "terms_set" => [
                    "ingredients" => [
                        "terms" => $pantryIngredients,
                        "minimum_should_match_field" => "n_ingredients"
                    ]
                ]
            ]
        ]
    ];  

    $query= $client->search($params);

    if ($query ['hits']['total']>=1) {
        $results = $query['hits']['hits'];

    }

if(isset($_GET['q'])){
    $q=$_GET['q'];
$params=[
    'index' => 'project_mongodata_recepie_ingredients',
    'body'=>[

        'query'=>[
            'bool'=>[
                'should'=> [
                    'match'=>['ingredients'=>$q],
                    'match'=>['tags'=>$q],
                    'match'=>['recipeName'=>$q]
                ]
            ]
        ]
    ]
]; 

    $query= $client->search($params);

    if ($query ['hits']['total']>=1) {
        $results = $query['hits']['hits'];

    }

}

?>
<html>
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
    <title>Your Pantry Matches </title>
    <h2>Your Pantry Matches</h2>
    <h3>Here are recipes you can make with ingredients in your pantry! Filter by dietary preference to find the right recipe for you!</h3>
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

<body>

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

<?php

if(isset($results)){
    echo "<table id = filterableTable>";
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
    
    $initiateCounter=0;
    //echo 'TOTAL RECIPIES FETCHED: '; echo($query ['hits']['total']['value']);
    foreach($results as $r){
        $recipeid=$r['_source']['recipeID'];
        //echo var_dump($recipeid);

        $recipeHelper= new RecipeHelper;
        $recipe = $recipeHelper->getElasticRecipes($recipeid);
        //echo var_dump($recipe);


        while ($row = $recipe->fetch_row()) {
            echo "<tr>";
            echo "<td>" . $row[0] . "</td>";	// id
            echo "<td>" . "<a href=\"" . $row[10] . "\" target=_blank>" . $row[1] . "</a>" . "</td>";	// name
            echo "<td>" . $row[2] . "</td>";	// description
            $ingredients = str_replace("'", '',$row[8]);
            echo "<td>" . $ingredients . "</td>";	// ingredients
            $instructions = str_replace("'", '',$row[7]);
            echo "<td>" . $instructions . "</td>";	// instructions
            echo "<td>" . $row[3] . "</td>";	// minutes
            $tags = str_replace("'", '',$row[4]);
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

    }     
    echo "</table>";  
}
?>
<body>
</html>