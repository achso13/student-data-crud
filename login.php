<?php 
    session_start();
    require 'functions.php';
    if(isset($_COOKIE['id']) && isset($_COOKIE['key'])){
        $id = $_COOKIE['id'];
        $key = $_COOKIE['key'];

        if($key === hash('sha256', $id)){
            $_SESSION["login"] = true;
        }
    }

    if(isset($_SESSION["login"])){
        header("Location: index.php");
    }

    if(isset($_POST["login"])){
        if (login($_POST) > 0){
            header("Location: index.php");
        } else {
            echo mysqli_error($conn);
        }
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-5 p-5 border rounded narrow">
        <h2>Sign in to Your Account</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username: </label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="rememberme" id="rememberme">
                <label class="form-check-label" for="rememberme">Remember Me: </label>
            </div>
            <div class="mt-2">
                <button type="submit" name="login" class="btn btn-primary mr-2">Login</button>
                <a href="register.php" class="btn btn-outline-primary">Register</a>
            </div>
        </form>
    </div>
</body>
</html>