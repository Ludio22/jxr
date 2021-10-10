<?php
require 'db.php';
session_start();
if (!isset($_SESSION['islogged']) || !isset($_SESSION['quser']) || $_SESSION['quser'] = "")
    header('Location: /');

if (!empty($_FILES) && ($_SESSION['quser'] == "")) {
    $files = scandir("users/$_SESSION[login]");
    for ($i = 0; $i < count($files); $i++) {
        unlink("users/$_SESSION[login]/$files[$i]");
    }
    move_uploaded_file($_FILES['avatar']['tmp_name'], "users/$_SESSION[login]/" . $_FILES['avatar']['name']);
    $avatarName = $_FILES["avatar"]["name"];
    R::exec("UPDATE users SET avatar='$avatarName' WHERE login='$_SESSION[login]'");
    header("Location: user-page.php");
} else {
    header("Location: user-page.php");
}
