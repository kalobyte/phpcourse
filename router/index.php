<?php
require_once "Router.php";
echo $_SERVER["QUERY_STRING"];

Router::add('/', function (){
    echo "index";
});

Router::add("/about", function (){
    echo "about";
});

Router::add("/(user)/(\w+)/(\d+)", function ($controller, $action, $id){
    echo "{$controller} - {$action} - {$id}";
});

Router::start();