<?php
require "db.php";
require "DAL.php";
session_start();
if (!@$_SESSION['islogged']) header("Location: /");
?>

<div class="user__chat">
    <div class="user__messages">
        <?php
        $messages = R::getAll("SELECT users.login, messages.text FROM users JOIN messages ON messages.UserId = users.id");
        for ($i = 0; $i < count($messages); $i++) {
            if ($messages[$i]['login'] == $_SESSION['login']) {
                echo "<p class='mine'>".$messages[$i]['text']."</p>";
            } else {
                echo "<p>".$messages[$i]['text']."</p>";
            }
        }
        ?>
    </div>
    <div class="user__write-box">
        <textarea id="message-box" cols="30" rows="10"></textarea>
        <input class="message-sender" type="button" value="Отправить">
    </div>
</div>