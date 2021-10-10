<?php
    session_start();
    isset($_SESSION['islogged']) ? header('Location: user-page.php') : session_unset();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J x R</title>
    <link rel="stylesheet" href="./style/style.css">
    <style>
        header {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        h1 {
            font-size: 7em;
            font-family: cursive;
            letter-spacing: 0.5em;
        }

        fieldset {
            width: -moz-fit-content;
            width: fit-content;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <header>
        <img width="170px" height="300px" src="./media/i.webp" alt="John">
        <h1>JxR</h1>
        <img width="200px" height="300px" src="./media/ankha.webp" alt="Rin">
    </header>

    <fieldset>
        <legend>Авторизация</legend>
        <form action="login.php" method="post">
            <input type="text" name="login" placeholder="Логин..." class="md"><br />
            <input type="password" name="password" placeholder="Пароль..." class="md"><br />
            <input type="submit" name="logged" value="Войти" class="md">
            <p>Нет аккаунта Мань? <a href="signup.php">Зарегистрируйся!</a></p>
        </form>
    </fieldset>
</body>

</html>