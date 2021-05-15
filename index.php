<?php
require_once "config.php";
session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.82.0">
    <title>Spoiler Alert Home</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

    <!-- Bootstrap core CSS -->
<link href=".bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">SpoilerAlert</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="#">Sign out</a>
    </li>
  </ul>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Recipes</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
            <a class="nav-link active" aria-current="page" href="save_recipe.php">
              <span data-feather="home"></span>
              View my saved recipes
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="search.php">
              <span data-feather="file"></span>
              Search recipes
            </a>
          </li>
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Go to</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
          <li class="nav-item">
            <a class="nav-link" href="searchMongo.php">
              <span data-feather="shopping-cart"></span>
              Elastic Search
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="viewTopDessert.php">
              <span data-feather="bar-chart-2"></span>
              Top Rated Desserts
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="viewTopLowCarb.php">
              <span data-feather="layers"></span>
              Top Rated Low-Carb Recipes
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="viewTopLowSodium.php">
              <span data-feather="layers"></span>
              Top Rated Low-Sodium Recipes
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="viewTopVegan.php">
              <span data-feather="layers"></span>
              Top Rated Vegan Recipes
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="viewTopVegetarian.php">
              <span data-feather="layers"></span>
              Top Rated Vegetarian Recipes
            </a>
          </li>
        </ul>

         
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
         
      <h1>Home</h1>
       
      </div>
      <?php
	    if (isset($_SESSION["username"]) && isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true && $_SESSION["logged_in"] == true) {
		    echo '<div align="center">Welcome ' . $_SESSION["username"] . "</div><br/>";

	    }
	    else {
		    header('Location: login.php');
        }
        ?>
      <p>Are you tired of throwing out your spoiled groceries and spending money on takeout? Spoiler Alert helps reduce food waste by matching you with recipes that accomodate your dietary restrictions while using ingredients you have on hand! There are over 200,000 recipes available, and you can even add your own recipes, and rate/save recipes too!</p>
       
    <div align="center">
        <form action="create_recipe.php" method="post">
        <input type = "hidden" name = "email" value = "<?php echo $_SESSION["username"];?>"/>
         
        <button name = "submit" class="btn btn-outline-primary">Create recipe</button>
        

    </form>
     
    <br>
	<form action="search.php" method="post">
      
        <button style = "text-align: center" name="list_recipes" class="btn btn-outline-primary">Search Recipes</button>
        

    </form>
    <br>
	<form action = "modify.php" method = "post">
		<input type = "hidden" name = "email" value = "<?php echo $_SESSION["username"];?>"/>
       
        <button name = submit class="btn btn-outline-primary">View my recipes</button>

    </form>
    <br>
	<form action = "view_pantry.php" method = "post">
        
        <button name = submit class="btn btn-outline-primary">Go to pantry</button>

    </form>
    <br>
	<form action="logout.php" method="post">
        
        <button name="log_out" class="btn btn-outline-primary">Log out</button>

    </form>
    </div>
    <br>
      <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
      <?php
	if (isset($_SESSION["username"]) && isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true && $_SESSION["logged_in"] == true) {
		echo '<div align="center">Welcome ' . $_SESSION["username"] . "</div><br/>";

	}
	else {
		header('Location: login.php');
	}
	
	?>
	 
     
       
    </main>
  </div>
</div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>
