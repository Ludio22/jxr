<?php
    require 'db.php';//REDBEANPHP
    session_start();
    if (isset($_SESSION['islogged'])) header('Location: user-page.php');

    //ЗАПИСЫВАЮ В МАССИВ ДАННЫЕ ПОЛЬЗОВАТЕЛЯ С ВВЕДЁННЫМ ЛОГИНОМ
    $user = R::getRow('SELECT * FROM users WHERE login = ?', [$_REQUEST['login']]);
    if ($user) {
        if (password_verify($_REQUEST['password'], $user['password'])) {//СВЕРКА ХЭША С ПАРОЛЕМ
            $_SESSION['login'] = $user['login'];
            $_SESSION['islogged'] = true;
            $_SESSION['up_status'] = 'view';
            header("Location: user-page.php?$_SESSION[login]");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Try Agane</title>
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

        h2 {
            text-align: center;
        }

        fieldset {
            width: fit-content;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <h2>Ошибка! Неверный Логин или пароль, а может и то<br />и другое хз. Кароче попробуй ещё раз:</h2>
    <fieldset>
        <legend>Авторизация</legend>
        <form action="login.php" method="post">
            <input type="text" name="login" placeholder="Логин..." class="md"><br />
            <input type="password" name="password" placeholder="Пароль..." class="md"><br />
            <input type="submit" value="Войти" class="md">
            <p>Нет аккаунта Мань? <a href="signup.php">Зарегистрируйся!</a></p>
        </form>
    </fieldset>
</body>

</html>