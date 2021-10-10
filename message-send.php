<?php
    require 'db.php';
    require 'DAL.php';
    session_start();
    if (!@$_SESSION['islogged']) header("Location: /");

    //ПОЛУЧАЕМ ID АВТОРИЗОВАННОГО ПОЛЬЗОВАТЕЛЯ И НАШЕГО СОБЕСЕДНИКА
    $FirstUserId = getIdByLogin($_SESSION['login']);
    $SecondUserId = getIdByLogin($_SESSION['quser']);

    //ЕСЛИ РАНЕЕ ДВА ЭТИХ ПОЛЬЗОВАТЕЛЯ НЕ ЧАТИЛИСЬ ТО СОЗДАЁМ НОВЫЙ ЧАТ И ДОБАВЛЯЕМ СООБЩЕНИЕ
    if (!isChat($FirstUserId, $SecondUserId)) {
        R::exec('INSERT INTO chats SET FirstUserId=?, SecondUserId=?', [$FirstUserId, $SecondUserId]);
        addMail(false, $FirstUserId, $SecondUserId);
    } else {//ИНАЧЕ ПРОСТО ДОБАВЛЯЕМ СООБЩЕНИЕ
        addMail(true, $FirstUserId, $SecondUserId);
    }
?>