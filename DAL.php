<?php
//ФУНКЦИЯ ПОЛУЧЕНИЯ ID ПОЛЬЗОВАТЕЛЯ ПО ЛОГИНУ//
function getIdByLogin(string $var)
{
    return R::getCell('SELECT id FROM users WHERE login = ?', [$var]);
}

function writePre($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}

function isChat($firstId, $secondId)
{
    $firstUserId = count(R::getAll('SELECT * FROM chats WHERE FirstUserId = ? AND SecondUserId = ?', [$firstId, $secondId])) != 0;
    $secondUserId = count(R::getAll('SELECT * FROM chats WHERE FirstUserId = ? AND SecondUserId = ?', [$secondId, $firstId])) != 0;
    if ($firstUserId && $secondUserId) return false;
    else return $firstUserId ? [$firstId, $secondId] : [$secondId, $firstId];
}

function addMail($isChat, $FirstUserId, $SecondUserId)
{
    $ChatId = 0;
    if ($isChat) {
        $ChatId = R::getCell('SELECT id FROM chats WHERE FirstUserId = ? AND SecondUserId = ?', isChat($FirstUserId, $SecondUserId));
    } else
        $ChatId = R::getCell('SELECT id FROM chats WHERE FirstUserId = ? AND SecondUserId = ?', [$FirstUserId, $SecondUserId]);
    R::exec('INSERT INTO messages SET text=?, UserId=?, ChatId=?, created=?', [$_POST['text'], $FirstUserId, $ChatId, date('Y-m-d H:i:s')]);
    echo "<p class='mine'>" . $_POST['text'] . "</p>";
}
