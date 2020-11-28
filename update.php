<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
}

require 'functions.php';
$id = $_GET["id"];
$student = query("SELECT * FROM student WHERE id = '$id'")[0];

if (isset($_POST["submit"])) {
    if (update($_POST, $id) > 0) {
        echo
            "<script>
            alert('Data has been updated.');
            document.location.href = 'index.php';
        </script>";
    } 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-5 p-5 border rounded narrow">
        <h2 class="text-center mb-5">Edit Data</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="studentid">Student ID:</label>
                <input type="text" id="studentid" name="studentid" value="<?= $student['studentid'] ?>" required class="form-control">
            </div>
            <div class="form-group">
                <label for="name">Name: </label>
                <input type="text" id="name" name="name" value="<?= $student['name'] ?>" required class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="text" id="email" name="email" value="<?= $student['email'] ?>" required class="form-control">
            </div>
            <div class="form-group">
                <label for="major">Major: </label>
                <input type="text" id="major" name="major" value="<?= $student['major'] ?>" required class="form-control">
            </div>
            <div class="form-group">
                <input type="hidden" name="oldPhoto" value="<?= $student['photo'] ?>">
                <label for="photo">Photo: </label>
                <img src="img/<?= $student['photo'] ?>" class="upload-picture">
                <input type="file" id="photo" name="photo">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Update data</button>
        </form>

    </div>

</body>

</html>