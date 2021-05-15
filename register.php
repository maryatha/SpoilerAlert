<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";
    $prepped_user = $prepped_pass = "";
    // Valid username check. Make sure it's valid and not already in the database
    if (isset($_POST["username"]) && strlen($_POST["username"]) > 0) {
        if (!preg_match('/^\w/', $_POST["username"])) {
            $username_err = "Valid usernames are: letters and digits only and not empty";
        }
        else {
            $searched_val = "";
            $prepped_user = $sql_conn->real_escape_string($_POST["username"]);
            $user_query = "SELECT userID FROM users WHERE username=?";
            
            // Prepare and execute sql query
            $stmt = $sql_conn->prepare($user_query);
            $stmt->bind_param("s", $prepped_user);
            $stmt->execute();
            $stmt->bind_result($searched_val);
            $stmt->fetch();
            if ($searched_val != "") {
                $username_err = "Username already exists in database, please try a different one";
                echo $searched_val;
            }
        }
    } else {
        $username_err = "Please add a username";
    }

    if (!isset($_POST["password"]) || $_POST["password"] == "") {
        $password_err = "Please add a password";
    } else {
        if (strlen($_POST["password"]) < 4) {
            $password_err = "Please have a password longer than 4 characters";
        }
    }

    if ($username_err == "" && $password_err == "") {
        // Register user into the database
        $prepped_pass = $sql_conn->real_escape_string($_POST["password"]);
        $insert_query = "INSERT INTO users (username, password_hash) VALUES(?, ?)";
        $stmt = $sql_conn->prepare($insert_query);
        $stmt->bind_param("ss", $prepped_user, password_hash($prepped_pass, PASSWORD_DEFAULT));
        $result = $stmt->execute();
        if ($result) {
            echo "Successfully registered, please login now<br/>";
        } else {
            echo "Failed to register new user<br/>";
        }
    } else {
        if ($username_err != "") {
            echo '<div align="center">' . $username_err . "</div><br/>";
        }
        if ($password_err != "") {
            echo '<div align="center">' . $password_err . "</div><br/>";
        }
    }
    $sql_conn->close();
    echo "Redirecting to login/register page...";
    header('Refresh: 2; url=login.php');
}
?>