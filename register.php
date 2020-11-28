<?php 
    session_start();
    if(isset($_SESSION["login"])){
        header("Location: index.php");
    }

    require 'functions.php';
    if(isset($_POST["register"])){
        if (register($_POST) > 0){
            echo 
            "<script>
                alert('Register success');
                document.location.href = 'index.php';
            </script>";
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
    <title>Register Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-5 p-5 border rounded narrow">
        <h2>Make Your Account</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username: </label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="password2">Confirm Password: </label>
                <input type="password" class="form-control" name="password2" id="password2" placeholder="Confirm your password">
            </div>
            <button type="submit" name="register" class="btn btn-primary mt-2">Register</button>
        </ul>
    </form>
    </div>

    
    
</body>
</html>