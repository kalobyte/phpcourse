<?php
require_once "init.php";

$user = new User;
$user->logOut();

Redirect::to("index.php");
?>