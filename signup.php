<?php
    require 'db.php';
    session_start();
    if (isset($_SESSION['islogged'])) header('Location: user-page.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="./style/style.css">
    <style>
        html {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        header {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        fieldset {
            width: fit-content;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <?php require './php-scripts/check-signup-data.php' ?>
    <?php if (R::count('users') < 20) : ?>
        <fieldset>
            <legend>Регистрация</legend>
            <?php if (!isset($_REQUEST['regged']) && !isset($_REQUEST['mailaccept'])) : ?>
                <form action="./signup.php" method="post">
                    <input type="mail" name="mail" placeholder="Мыло..." class="md" required value="<?= @$_REQUEST['mail'] ?>"><br />
                    <input type="text" name="login" placeholder="Логин..." class="md" required value="<?= @$_REQUEST['login'] ?>"><br />
                    <input type="password" name="password" placeholder="Пароль..." class="md" required><br />
                    <input type="password" name="password_2" placeholder="Повторите пароль..." class="md" required><br />
                    <input type="submit" name="regged" value="Зарегистрироваться" class="md">
                    <p>Есть аккаунт Мань? <a href="/">Войди в него!</a></p>
                </form>
            <?php else : ?>
                <form action="./signup.php" method="post">
                    <p>Введите код, который был отправлен вам на электронную почту.<br />Если письмо не пришло проверьте папку спам.</p><br />
                    <input type="text" name="code" placeholder="Введите код из письма..." class="md" required>
                    <input type="submit" name="mailaccept" value="Подтвердить почту" class="md">
                </form>
            <?php endif; ?>
        </fieldset>
    <?php else : ?>
        <h1>Простите, достигнуто максимальное число пользователей (｡•́︿•̀｡)</h1>
    <?php endif; ?>
</body>

</html>