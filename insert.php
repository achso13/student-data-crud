<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
}

require 'functions.php';
if (isset($_POST["submit"])) {
    if (insert($_POST) > 0) {
        echo
            "<script>
                alert('Data has been inserted.');
                document.location.href = 'index.php';
            </script>";
    } else {
        echo
            "<script>
                alert('Insert data failed!');
            </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Student Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-5 p-5 border rounded narrow">
        <h2 class="text-center mb-5">Insert Student Data</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="studentid">Student ID:</label>
                <input type="text" id="studentid" name="studentid" required class="form-control" placeholder="Student ID">
            </div>
            <div class="form-group">
                <label for="name">Name: </label>
                <input type="text" id="name" name="name" required class="form-control" placeholder="Name">
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="text" id="email" name="email" required class="form-control" placeholder="Email: example@email.com">
            </div>
            <div class="form-group">
                <label for="major">Major: </label>
                <input type="text" id="major" name="major" required class="form-control" placeholder="Major">
            </div>
            <div class="form-group">
                <label for="photo">Photo: </label>
                <input type="file" name="photo" id="photo" class="form-control-file">
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Insert data</button>
        </form>
    </div>

</body>

</html>