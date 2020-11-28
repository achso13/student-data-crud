<?php 
    session_start();
    if(!isset($_SESSION["login"])){
        header("Location: login.php");
    }
    
    require 'functions.php';
    $id = $_GET["id"];
    $result = delete($id);
    if ($result > 0){
        echo header("Location: index.php");
    } else {
        echo
        "<script>
            alert('Delete data failed!');
            document.location.href = 'index.php';
        </script>";
    }
?>