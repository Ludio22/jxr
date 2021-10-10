<?php
require "db.php";
session_start();
if (!@$_SESSION['islogged']) header("Location: /");

$messages = R::getAll("SELECT users.login, messages.text FROM users JOIN messages ON messages.UserId = users.id ORDER BY messages.created");
$full = "";
for ($i = 0; $i < count($messages); $i++) {
    if ($messages[$i]['login'] == $_SESSION['login']) {
        $full = $full."<p class='mine'>" . $messages[$i]['text'] . "</p>\n";
    } else {
        $full = $full."<p>" . $messages[$i]['text'] . "</p>\n";
    }
}

echo $full;
