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
    //echo var_dump($params);
    $query= $client->search($params);
    //echo var_dump($query);
    //echo var_dump($query);
    if ($query ['hits']['total']>=1) {
        $results = $query['hits']['hits'];
    //echo var_dump($results);
    }

//$result=$client->info();
//echo var_dump($result);
//echo var_dump($client);
//echo var_dump($q);
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
//echo var_dump($params);
    $query= $client->search($params);
    //echo var_dump($query);
    if ($query ['hits']['total']>=1) {
        $results = $query['hits']['hits'];
    //echo var_dump($results);
    }

}



//print_r($query);
?>
<html>
<head>
    <h2> Search Page </h2>
</head>

<body>

<form action = "searchM.php" method = "get">
    <label>
        Go for Elasticsearch
        <input type="text" name="q">
    </label>
    <input type="submit" value="Search">
    
</form>

<?php


if(isset($results)){
    
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
                <th>number of steps</th>
                <th>steps</th>
                <th>ingredients</th>
                <th>num of ingredients</th>
                <th>Save or Rate</th>  
                </tr>";
    
    
    
    $initiateCounter=0;
    //echo 'TOTAL RECIPIES FETCHED: '; echo($query ['hits']['total']['value']);
    // foreach($results as $r){


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
            echo "<td>" . $row[8] . "</td>";	// ingredients
            echo "<td>" . $row[7] . "</td>";	// instructions
            echo "<td>" . $row[3] . "</td>";	// minutes
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

    // }       
}
?>
<body>
</html>