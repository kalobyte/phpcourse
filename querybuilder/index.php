<?php
include_once "QueryBuilder.php";
    $mysql = array(
        "host" => "localhost",
        "username" => "immersion",
        "password" => "immersion",
        "database" => "immersion"
    );

    $data = array(
        "name" => "aaa",
        "email" => "aaa@aaa.aaa",
        "password" => password_hash("aaa", PASSWORD_DEFAULT),
    );

    $update = array(
        "name" => "bbb",
        "email" => "bbb@bbb.bb",
        "password" => password_hash("bbb", PASSWORD_DEFAULT),
    );

    function printList($query)
{
    $users = $query->select("users");
    foreach ($users as $user)
        echo "{$user['name']},  {$user['email']} <br>";
}


$id = null;
$query = new QueryBuilder($mysql);

echo "###### SELECT ###### <br>";
$users = $query->select("users");
foreach ($users as $user)
    echo "{$user['name']},  {$user['email']} <br>";


echo "<br><br> ###### INSERT ######<br>";
$id = $query->insert("users", $data);
printList($query);

echo "<br><br> ###### UPDATE ######<br>";
$query->update("users", $update, $id);
printList($query);

echo "<br><br> ###### DELETE ######<br>";
$query->delete("users", $id);
printList($query);