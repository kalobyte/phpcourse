<?php
session_start();
require_once "session.php";

if(!empty($_POST))
{
    Session::setFlash("form", $_POST["msg"]);
    header("Location: show.php");
    end();
}



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="index.php" method="post">

    <div>
        <lable>User:</lable>
        <input type="text" name="form_user" value="bb">
    </div>
    <div>
        <lable>Email:</lable>
        <input type="text" name="form_email" value="aaa@mail.ru">
    </div>
    <div>
        <lable>Password:</lable>
        <input type="text" name="form_pass" value="aaa">
    </div>
    <div>
        <lable>Password again:</lable>
        <input type="text" name="form_pass_2" value="aaa">
    </div>

    <br><br>
    <div>
        <lable>msg:</lable>
        <input type="text" name="msg" value="test message">
    </div>
    <button type="submit">send</button>

</form>
</body>
</html>
