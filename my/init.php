<?php
session_start();
require_once "components/classes/Database.php";
require_once "components/classes/Config.php";
require_once "components/classes/Validate.php";
require_once "components/classes/Input.php";
require_once "components/classes/Token.php";
require_once "components/classes/Session.php";
require_once "components/classes/User.php";
require_once "components/classes/Redirect.php";
require_once "components/classes/Coockie.php";

$GLOBALS["config"] = [
    "mysql" => [
        "host" => "localhost",
        "username" => "immersion",
        "password" => "immersion",
        "database" => "immersion"
    ],
    "session"      => [
        "token_name" => "token",
        "user_session" => "user"
    ],
    "cookie" =>[
        "cookie_name" => "hash",
        "cookie_expiry" => 604800
    ]
];

if(Cookie::exists(Config::get("cookie.cookie_name")) && !Session::exists(Config::get("session.user_session")))
{
    $hash = Cookie::get(Config::get("cookie.cookie_name"));
    $hashCheck = Database::getInstance()->get("user_sessions", ["hash", "=", $hash]);

    if($hashCheck->count())
    {
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}

?>