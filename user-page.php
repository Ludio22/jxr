<!--ВЫХОД И ПРОВЕРКА НА ЗАЛОГИРОВАННОСТЬ-->
<?php
require 'db.php';
session_start();
if (!@$_SESSION['islogged']) header("Location: /");
if($_SESSION['login'] != $_SERVER['QUERY_STRING']){
    $_SESSION['quser'] = $_SERVER['QUERY_STRING'];
}
$_SESSION['up_status'] = "view";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/user-page.css">
    <style>
        html {
            display: block;
        }

        .logout {
            position: absolute;
            top: 8px;
            right: 8px;
        }
    </style>
</head>

<body>
    <form class="logout" action="logout.php" method="post">
        <input type="submit" value="ВЫХОД">
    </form>

    <!--ТЕЛО САЙТА-->
    <section class="user">
        <div class="user__meta">
            <div class="user__avatar">
                <form action="set-avatar.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="avatar" id="avatar-checker">
                    <input type="submit" id="put-avatar" value="">
                </form>
                <!--ЕСЛИ СЕРВАК ПУСТ ТО СТАВИМ ДЕФОЛТНУЮ ФОТКУ, ИНАЧЕ ТУ ЧТО НА СЕРВАКЕ-->
                <?php if (R::getCell("SELECT avatar FROM users WHERE login = '$_SERVER[QUERY_STRING]'") == "") : ?>
                    <img src="./media/avatar-default.png" alt="avatar">
                <?php else : ?>
                    <img src="./users/<?= $_SERVER["QUERY_STRING"] ?>/<?= R::getCell("SELECT avatar FROM users WHERE login = '$_SERVER[QUERY_STRING]'") ?>" alt="avatar">
                <?php endif; ?>
            </div>
            <!--ТИП КНОПКИ В ЗАВИСИМОСТИ ОТ ИНФЫ НА СТРАНИЦЕ-->
            <?php if (@$_SESSION['up_status'] == "view" && @$_SESSION['login'] != @$_SERVER['QUERY_STRING']) : ?>
                <input type="button" value="Пись Пись" class="user__switch-to-chat">
            <?php elseif (@$_SESSION['up_status'] == "chat" && @$_SESSION['login'] != @$_SERVER['QUERY_STRING']) : ?>
                <input type="button" value="см см" class="user__switch-to-chat">
            <?php endif; ?>
            <?php
            $users = R::getAll("SELECT * FROM users WHERE login != :login", [":login" => $_SERVER["QUERY_STRING"]]);
            echo "<br /><a href='user-page.php?" . $users[0]['login'] . "' class='user__next'>Го к " . $users[0]['login'] . "</a>"
            ?>
        </div>
        <?php if (@$_SESSION['up_status'] == "view") : ?>
            <?php require "user-info.php" ?>
        <?php elseif (@$_SESSION['up_status'] == "chat") : ?>
            <?php require "user-chat.php" ?>
        <?php endif; ?>
    </section>

    <script src="libs/jquery-3.6.0.min.js"></script>
    <script src="js/user-page.js"></script>
</body>

</html>