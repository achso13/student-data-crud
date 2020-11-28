<?php 

$conn = mysqli_connect("localhost", "root", "", "basicphp");

function query($query){
    global $conn;
    $rows = [];
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo mysqli_error($conn);
    } else {
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }
}

function insert($data){
    global $conn;
    $studentid = htmlspecialchars($data["studentid"]);
    $name = htmlspecialchars($data["name"]);
    $email = htmlspecialchars($data["email"]);
    $major = htmlspecialchars($data["major"]);
    $photo = upload();
    if (!$photo){
        return false;
    }
    
    $query = "INSERT INTO student VALUES 
                (NULL, 
                '$studentid', 
                '$name', 
                '$email', 
                '$major', 
                '$photo')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function delete($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM student WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function update($data, $id){
    global $conn;
    $studentid = htmlspecialchars($data["studentid"]);
    $name = htmlspecialchars($data["name"]);
    $email = htmlspecialchars($data["email"]);
    $major = htmlspecialchars($data["major"]);
    $oldPhoto = $data["oldPhoto"];

    if ($_FILES["photo"]["error"] === 4){
        $photo = $oldPhoto;
    } else {
        $photo = upload();
    }

    if ($photo){
        $query = "UPDATE student SET 
        studentid = '$studentid',
        name = '$name',
        email = '$email',
        major = '$major',
        photo = '$photo'
        WHERE id = $id";
        mysqli_query($conn, $query);
        return 1;
    }
    return 0;
}

function search($keyword){
    $query = "SELECT * FROM student WHERE 
                name LIKE '%$keyword%' OR
                studentid LIKE '%$keyword' OR
                email LIKE '%$keyword%' OR
                major LIKE '%$keyword%'
                ";

    return query($query);
}

function upload(){
    $fileName = $_FILES["photo"]["name"];
    $errorNumber = $_FILES["photo"]["error"];
    $tmpName = $_FILES["photo"]["tmp_name"];
    $fileSize = $_FILES["photo"]["size"];

    $validFileExtension = ['jpg', 'jpeg', 'png'];
    $fileExtension = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExtension));

    if ($errorNumber === 4){
        echo 
        "<script>
            alert('You havent choose your image yet.');
        </script>";
        return false;
    }
    if(!in_array($fileExtension, $validFileExtension)){
        echo 
        "<script>
            alert('Sorry, but you can only upload .jpg, .jpeg, or .png file extension.');
        </script>";
        return false;
    } else if ($fileSize > 1000000){
        echo 
        "<script>
            alert('Your file must not exceed 1MB!');
        </script>";
        return false;
    }

    $newFileName = uniqid();
    $newFileName .= '.';
    $newFileName .= $fileExtension;

    move_uploaded_file($tmpName, "img/$newFileName");

    return $newFileName;
}

function register($data){
    global $conn;
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $confirmPassword = mysqli_real_escape_string($conn, $data["password2"]);

    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)){
        echo 
        "<script>
            alert('Username is already exist!');
        </script>";
        return false;
    }

    if ($confirmPassword !== $password){
        echo 
        "<script>
            alert('Your confirmation password is not same!');
        </script>";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users VALUES
                (NULL,
                '$username',
                '$password')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function login($data){
    global $conn;
    $username = strtolower($data["username"]);
    $password = $data["password"];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])){
            $_SESSION["login"] = true;

            if (isset($data['rememberme'])){
                setcookie('id', $row['id'], time()+60);
                setcookie('key', hash('sha256', $row['id']) , time()+60);
            }
            return 1;
        } else {
            echo 
            "<script>
                alert('Password is wrong!');
            </script>";
            return false;
        }
    } else {
        echo 
        "<script>
            alert('Username is not registered');
        </script>";
        return false;
    }
}
