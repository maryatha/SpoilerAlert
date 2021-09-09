<?php
define("DB_SERVER", "localhost");
define("DB_USERNAME", "root"); 
define("DB_PASSWORD", "1!Passpass");
define("DB_NAME", "spoileralert");
define("MONGO_URL", "mongodb://localhost");

$sql_conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($sql_conn->connect_error) {
    die("ERROR: Failed to connect " . $conn->connect_error);
}
$mongo_conn = new MongoDB\Driver\Manager(MONGO_URL);

class RecipeHelper  {
        
    function getRandomRecipes() {
        global $sql_conn;

        $sql = "select * from recipes order by rand() limit 10";
	    $result = $sql_conn->query($sql);
        return $result;
    }
    function getElasticRecipes($recipeid) {
        global $sql_conn;

        $sql = "SELECT * FROM recipes WHERE recipeID=?";
        $stmt = $sql_conn->prepare($sql);
		$stmt->bind_param("s", $recipeid);
        if (!$stmt->execute()) {
            return "Error fetching rating for that ID.";
        }
	    $result = $stmt->get_result();
        return $result;
    }

    function getTopRatedRecipes() { //returns rated recipes > 4 stars avg
        global $sql_conn;
        $sql = "Select * from topRatedRecipes";   
        $result = $sql_conn->query($sql);
        return $result;
    }

    function getTopDessertRecipes() { //returns top dessert recipes > 4 stars avg
        global $sql_conn;
        $sql = "Select * from topDesserts";   
        $result = $sql_conn->query($sql);
        return $result;
    }

    function getTopLowCarbRecipes() { //returns top low-carb recipes > 4 stars avg
        global $sql_conn;
        $sql = "Select * from toplowcarb";   
        $result = $sql_conn->query($sql);
        return $result;
    }

    function getTopLowSodiumRecipes() { //returns top low-sodium recipes > 4 stars avg
        global $sql_conn;
        $sql = "Select * from toplowsodium";   
        $result = $sql_conn->query($sql);
        return $result;
    }

    function getTopVeganRecipes() { //returns top vegan recipes > 4 stars avg
        global $sql_conn;
        $sql = "Select * from topVegan";   
        $result = $sql_conn->query($sql);
        return $result;
    }

    function getTopVegetarianRecipes() { //returns top vegetarian recipes > 4 stars avg
        global $sql_conn;
        $sql = "Select * from topVegetarian";   
        $result = $sql_conn->query($sql);
        return $result;
    }


    function getRatingForRecipeByUser($recipeid, $userid) {
        global $sql_conn;
        
        $ratingQuery = "SELECT ratingStars FROM ratings WHERE recipeID=? AND userid=?";
		$stmt = $sql_conn->prepare($ratingQuery);
		$stmt->bind_param("ss", $recipeid, $userid);

        if (!$stmt->execute()) {
            return "Error fetching rating for that ID.";
        }

        $result = $stmt->get_result();
        $rating_arr = $result->fetch_row();
        $rating = $rating_arr[0];

        return $rating;
    }

    function getAverageRatingForRecipe($recipeid) {
        global $sql_conn;
        
        $ratingQuery = "SELECT AVG(ratingStars) FROM ratings WHERE recipeID=?";
		$stmt = $sql_conn->prepare($ratingQuery);
		$stmt->bind_param("s", $recipeid);

        if (!$stmt->execute()) {
            return "Error fetching average rating for that ID.";
        }

        $result = $stmt->get_result();
        $rating_arr = $result->fetch_row();
        $avgrating = $rating_arr[0];

        return $avgrating;
    }

    function getRatingCount($recipeid) {
        global $sql_conn;
        
        $ratingQuery = "SELECT COUNT(userID) FROM ratings WHERE recipeID=?";
		$stmt = $sql_conn->prepare($ratingQuery);
		$stmt->bind_param("s", $recipeid);

        if (!$stmt->execute()) {
            return "Error fetching average rating for that ID.";
        }

        $result = $stmt->get_result();
        $rating_arr = $result->fetch_row();
        $ratingCount = $rating_arr[0];

        return $ratingCount;
    }





    function rateRecipe($recipeid, $userid, $stars) {
        global $sql_conn;

        $rating = $this->getRatingForRecipeByUser($recipeid, $userid);

        if ($rating > 0) {
            //update the rating
            $rateQuery = "UPDATE ratings SET ratingStars=? WHERE recipeID=? AND userid=?";
            $stmt = $sql_conn->prepare($rateQuery);
            $stmt->bind_param("sss", $stars, $recipeid, $userid);
            $stmt->execute();
            if (!$stmt->execute()) {
                return false;
            }

            return true;
        } else {
            // insert the rating
            $rateQuery = "INSERT INTO ratings (recipeID, userid, ratingStars) VALUES (?, ?, ?)";
            $stmt = $sql_conn->prepare($rateQuery);
            $stmt->bind_param("sss", $recipeid, $userid, $stars);
            $stmt->execute();
            if (!$stmt->execute()) {
                return false;
            }

            return true;
        }
    }

    function getRecipeByID($recipeid) {
        global $sql_conn;

        $viewRecipeQuery = "SELECT * FROM recipes WHERE recipeID = ?";
        $stmt = $sql_conn->prepare($viewRecipeQuery);
        $stmt->bind_param("s", $recipeid);

        if (!$stmt->execute()) {
            return "Error fetching recipe for that ID.";
        }

        $result = $stmt->get_result();
        return $result->fetch_row();
    }

    function getSavedRecipesForUser($userid) {
        global $sql_conn;
        
        $savedRecipesQuery = "SELECT recipes.recipeId, recipes.name, recipes.url, recipes.description, recipes.ingredients, savedRecipes.timeAdded, recipes.steps FROM savedRecipes, recipes WHERE savedRecipes.userid=? AND savedRecipes.recipeID=recipes.recipeID ORDER BY savedRecipes.timeAdded DESC";
        $stmt = $sql_conn->prepare($savedRecipesQuery);
        $stmt->bind_param("s", $userid);

        if (!$stmt->execute()) {
            return "Error fetching saved recipes for this user.";
        }

        return $stmt->get_result();
    }

    function saveRecipe($userid, $recipeid) {
        global $sql_conn;
        
        $saveRecipeQuery = "INSERT INTO savedRecipes (recipeID, userid) VALUES (?, ?)";
		$stmt = $sql_conn->prepare($saveRecipeQuery);
		$stmt->bind_param("ss", $recipeid, $userid);

        if (!$stmt->execute()) {
            return false;
        }

        return true;
    }
}

class PantryHelper {

    function addToPantry($userid, $ingredient) {
        global $mongo_conn;
        $bulk = new MongoDB\Driver\BulkWrite;

        $filter = ["userID" => $userid];
        $options = [];
        $query = new MongoDB\Driver\Query($filter, $options);
        $user_pantry = $mongo_conn->executeQuery("db.userPantries", $query);
        // Need to create new pantry for user
        if ($user_pantry == null || count($user_pantry) == 0 || $user_pantry->isDead() == true) {
            $doc = ["userID" => $userid, "pantryIngredients" => [$ingredient]];
            $bulk->insert($doc);
            $mongo_conn->executeBulkWrite("db.userPantries", $bulk);
        } else {
            // Ignore empty ingredients
            if ($ingredient == null || $ingredient == '') {
                return;
            }
            foreach ($user_pantry as $pantry) {
                $ingredients = $pantry->pantryIngredients;
                if ($ingredients == null) {
                    $ingredients = [];
                }
                // Don't do anything if ingredient in pantry already
                if (in_array($ingredient, $ingredients)) {
                    return;
                }
                array_push($ingredients, $ingredient);
                $bulk->update(
                    ["userID" => $userid], 
                    ['$set' => ["pantryIngredients" => $ingredients]],
                    ['upsert' => true]
                );
                $result = $mongo_conn->executeBulkWrite("db.userPantries", $bulk);
                echo($result->getInsertedCount());
                echo($result->getModifiedCount());
            }
        }
    }

    function deleteFromPantry($userid, $ingredient) {
        global $mongo_conn;
        $bulk = new MongoDB\Driver\BulkWrite;

        $filter = ["userID" => $userid];
        $options = [];
        $query = new MongoDB\Driver\Query($filter, $options);
        $user_pantry = $mongo_conn->executeQuery("db.userPantries", $query);
        if ($user_pantry == null || count($user_pantry) == 0 || $user_pantry->isDead() == true) {
            // do nothing, no ingredients to delete
        } else {
            // Ignore empty ingredients
            if ($ingredient == null || $ingredient == '') {
                return;
            }
            foreach ($user_pantry as $pantry) {
                $ingredients = $pantry->pantryIngredients;
                if ($ingredients == null || in_array($ingredient, $ingredients) == false) {
                    return;
                }
                if (count($ingredients) == 1) {
                    $updated_list = [];
                } else {
                    $key = array_search($ingredient, $ingredients);
                    $unused_list = array_splice($ingredients, $key, 1);
                    $updated_list = $ingredients;
                }
                $bulk->update(
                    ["userID" => $userid], 
                    ['$set' => ["pantryIngredients" => $updated_list]],
                    ['upsert' => false]
                );
                $result = $mongo_conn->executeBulkWrite("db.userPantries", $bulk);
            }
        }
    }

    function getPantry($userid) {
        global $mongo_conn;
        $filter = ["userID" => $userid];
        $options = $options = [
            'projection' => ['_id' => 0],
         ];
        $query = new MongoDB\Driver\Query($filter, $options);
        $user_pantry = $mongo_conn->executeQuery("db.userPantries", $query);
        foreach ($user_pantry as $doc) {
            return $doc->pantryIngredients;
        }
        // Pantry array should be returned, otherwise empty
        return [];
    }
}



?>