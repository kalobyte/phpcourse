<?php
require_once "init.php";

$user = new User;

var_dump($user->data());

Session::flash("success");
if($user->isLoggedIn())
{
    if($user->hasPermissions("admin"))
        echo "<p>you are admin</p>";

    echo "hi, <a href='#'>{$user->data()->name}</a>";
    echo "<p><a href='logout.php'>logout</a></p>";
    echo "<p><a href='update.php'>update</a></p>";
    echo "<p><a href='changepassword.php'>change password</a></p>";
}
else
{
    echo "<p><a href='login.php'>login</a> or <a href='register.php'>register</a></p>";
}

?>