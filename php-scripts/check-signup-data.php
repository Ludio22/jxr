<?php
if (isset($_REQUEST['regged']) && !isset($_SESSION['mailcheck'])) {
    //Если пароли одинаковые то на почту придёт код для подтверждения аккаунта
    $errors = [];
    if (R::count('users', 'login = ?', array($_REQUEST['login'])) != 0)
        $errors[] = 'Логин занят!'; 

    if (R::count('users', 'mail = ?', array($_REQUEST['mail'])) != 0) 
        $errors[] = 'На данный mail уже зарегистрирована учётная запись!';
    
    if ($_REQUEST['password'] != $_REQUEST['password_2'])
        $errors[] = 'Пароли не совпадают!'; 
    
    if (count($errors) == 0) { 
        $_SESSION['mailcheck'] = rand(10000, 99999);
        $_SESSION['login'] = $_REQUEST['login'];
        $_SESSION['mail'] = $_REQUEST['mail'];
        $_SESSION['password'] = $_REQUEST['password'];
        mail($_REQUEST['mail'], 'Подтверждение почты и данные', "Код подтверждения: $_SESSION[mailcheck]\n" . "Логин: " . $_REQUEST['login'] . "\nПароль: " . $_REQUEST['password']);
    } else {
        echo '<h2 style="text-align: center; color: #b50000;">'.$errors[0].'</h2>';
    }
    unset($_REQUEST['password'], $_REQUEST['password_2'], $_REQUEST['login'], $_REQUEST['mail']);
} elseif (isset($_REQUEST['mailaccept']) && $_REQUEST['code'] == $_SESSION['mailcheck']) {
    //ЕСЛИ ЧЕЛИК НАЖАЛ НА ПРОВЕРКУ ПОЧТЫ И КОДЫ ЧТО ОН ВВЁЛ СОВПАЛИ ТО ЕГО ДОБАВЯТ В СЕМЬЮ
    R::exec('INSERT INTO users SET login=?, mail=?, password=?, created=?, avatar=?', [
        $_SESSION['login'],
        $_SESSION['mail'],
        password_hash($_SESSION['password'], PASSWORD_DEFAULT),
        date(DATE_RFC822),
        ''
    ]);
    mkdir("./users/$_SESSION[login]");//коталог для данных пользователя
    session_unset();//очистка данных сессии 
    header('Location: /');//перенаправление на главную
} elseif (isset($_REQUEST['code'])) {
    echo '<h2 style="text-align: center; color: #b50000;">Код Введён не верно!</h2>';
}
