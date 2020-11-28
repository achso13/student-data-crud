<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
}

require 'functions.php';
$dataPerPage = 3;
$result = query("SELECT * FROM student");
$totalPage = ceil(count($result) / $dataPerPage);
$activePage = isset($_GET["page"]) ? $_GET["page"] : 1;
$firstData = ($activePage * $dataPerPage) - $dataPerPage;
$student = query("SELECT * FROM student LIMIT $firstData, $dataPerPage");

if (isset($_POST["keyword"])) {
    $keyword = $_POST["keyword"];
    header("Location: index.php?page=1&keyword=$keyword");
}

if (isset($_GET["keyword"])) {
    $keyword = $_GET["keyword"];
    $student = search($keyword);
    $totalPage = ceil(count($student) / $dataPerPage);

    $student = query("SELECT * FROM student WHERE 
                        name LIKE '%$keyword%' OR
                        studentid LIKE '%$keyword' OR
                        email LIKE '%$keyword%' OR
                        major LIKE '%$keyword%' 
                        LIMIT $firstData, $dataPerPage");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <a href="index.php" class="navbar-brand">CRUD</a>
        <a href="logout.php" class="btn btn-primary">Logout</a>
    </nav>
    <div class="container mx-auto mt-5">
        <h2 class="text-center font-weight-bold mb-5">STUDENT DATA CRUD WITH PHP AND BOOTSTRAP 4</h2>
        <form action="" method="post" class="form-inline d-flex justify-content-between my-3">
            <div class="form-group">
                <a href="insert.php" class="btn btn-primary">Insert Student Data</a>
            </div>
            <div class="form-group">
                <input type="text" name="keyword" placeholder="Search your keyword" autocomplete="off" autofocus class="form-control">
                <button type="submit" name="search" class="btn btn-dark ml-3">Search</button>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Action</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Student ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Major</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $number = $firstData + 1;
                foreach ($student as $row) :
                ?>
                    <tr>
                        <td scope="row"><?= $number ?></td>
                        <td>
                            <a href="update.php?id=<?= $row["id"] ?>"><span class="material-icons">create</span></a>
                            <a href="delete.php?id=<?= $row["id"] ?>" onclick="return confirm('Are you sure?')"><span class="material-icons">delete</span></a>
                        </td>
                        <td><img src="img/<?= $row["photo"] ?>" class="profile-picture"></td>
                        <td><?= $row["studentid"] ?></td>
                        <td><?= $row["name"] ?></td>
                        <td><?= $row["email"] ?></td>
                        <td><?= $row["major"] ?></td>
                    </tr>
                <?php
                    $number++;
                endforeach;
                ?>
            </tbody>
        </table>
        <?php if (isset($_GET["keyword"])) {
            $nextPage = "?page=" . ($activePage + 1) . "&keyword=$keyword";
            $previousPage = "?page=" . ($activePage - 1) . "&keyword=$keyword";
        } else {
            $nextPage = "?page=" . ($activePage + 1);
            $previousPage = "?page=" . ($activePage - 1);
        } ?>

        <nav class="d-flex justify-content-center mt-2">
            <ul class="pagination">
                <?php if ($activePage == 1) : ?>
                <li class="page-item disabled">
                <?php else : ?>
                <li class="page-item">
                <?php endif; ?>
                    <a href="<?= $previousPage ?>" class="page-link">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                    <?php $nowPage = isset($_GET["keyword"]) ? "?page=$i&keyword=$keyword" : "?page=$i"; ?>
                    <?php if ($i == $activePage) :  ?>
                    <li class="page-item active">
                    <?php else : ?>
                    <li class="page-item">
                    <?php endif; ?>
                        <a href="<?= $nowPage ?>" class="page-link"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($activePage != $totalPage) : ?>
                <li class="page-item">
                <?php else : ?>
                <li class="page-item disabled">
                <?php endif; ?>                   
                    <a href="<?= $nextPage ?>" class="page-link">Next</a>
                </li>
            </ul>
        </nav>
    </div>

    <script src="js/script.js"></script>     
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>

</html>