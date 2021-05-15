<?php
session_start();
require_once "config.php";
?>
<!doctype html>
<html lang="en">
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style type="text/css">
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box}
<?php include "main.css"?>
.container {
  padding: 16px;
}
 input[type=email], input[type=password] {
  width: 50%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}
p{  
    width: 50%;
  padding: 15px;
  margin: 5px 100px 22px 25%;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

</style>
<head>
    <h2>Spoiler Alert</h2>
    <hr>
    <p>Are you tired of throwing out your spoiled groceries and spending money on takeout? Spoiler Alert helps reduce food waste by matching you with recipes that accomodate your dietary restrictions while using ingredients you have on hand! There are over 200,000 recipes available, and you can even add your own recipes, and rate/save recipes too!</h4>
    <hr>
</head>
<body>
    <div class = "container">
    <form action="" method="post">
        <label for="username"><b>Username: </b></label>
        <input  type="email" class="form-control" name="username"  /><br/>
        
        <label for="password1"><b>Password: </b></label>
         
        <input  class="form-control" name="password" type="password"/><br/>
        <!-- <input type="submit" name="try_login" value="Login"/> -->
        <button name="try_login" class="btn btn-primary">Login</button>
    </form>
    
    <div align="center">
        Don't have an account? Register below.
    </div>
    <br/>
    <form action="register.php" method="post">
        <label for="username"><b>Username: </b></label>
        <input type="email" class="form-control name="username"  /><br/>

        <label for="password"><b>Password: </b></label>
        <input   class="form-control" name="password" type="password"/><br/>
        <!-- <input type="submit" name="try_register" value="Register"/> -->
        <button name="try_register"  class="btn btn-primary">Register</button>

    </form>
    <div>
</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["try_login"])) {
    if (!isset($_POST["username"]) || $_POST["username"] == "") {
        echo "<div align='center'>Please enter a username.</div>";
    }
    if (!isset($_POST["password"]) || $_POST["password"] == "") {
        echo "<div align='center'>Please enter a password.</div>";
    }
   
    $user_query = "SELECT password_hash,userID FROM users WHERE username=?";
    $db_pass = "";
    $user_id = "";
    $stmt = $sql_conn->prepare($user_query);
    $stmt->bind_param("s", $sql_conn->real_escape_string($_POST["username"]));
    $stmt->execute();
    $stmt->bind_result($db_pass, $user_id);
    $stmt->fetch();
    if ($db_pass == "" || !$db_pass || !password_verify($_POST["password"], $db_pass)) {
        echo "<div align='center'>Username or password is incorrect</div>";
    } else {
        $_SESSION["userid"] = $user_id;
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["logged_in"] = true;	
        header('Location: index.php');
    }
}
?>
