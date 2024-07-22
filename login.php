<?php
require('function.php');
session_start();
$error = '';

if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $pass = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = $result->fetch_assoc();

    if($data == NULL) {
        $error .= "Wrong username ";
    }else {
        if(password_verify($pass, $data['password']) == FALSE) {
            $error .= "Wrong password";
        }
    }

    if($data && password_verify($pass, $data['password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['login'] = true;


        //cookie
        setcookie('id', $data['id'], time() + 24*60*60);
        setcookie('key', hash('sha256', $data['username']), time() + 24*60*60);

        header("Location: index.php");
        exit();
    }

    if($error) {
        echo "<script>
            alert('$error');
            window.location.href = 'login.php';
        </script>";
    }
}

if(isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];
    

    $sql = "SELECT username FROM user WHERE id=$id";
    $result = $conn->query($sql);

    $row = $result->fetch_assoc();


    if($key === hash('sha256', $row['username'])) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['login'] = true;
    }
    
}

if(isset($_SESSION["login"])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="login-header">
        <form action="" class="login-form" method="POST" autocomplete="off">
            <h1>Login</h1>
            <input type="text" name="username" id="username" placeholder="username" required><br>
            <input type="password" name="password" id="password" placeholder="password" required><br>
            <input type="submit" value="Login" name="submit">
        </form>
    </header>
</body>
</html>