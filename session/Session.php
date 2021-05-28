<?php


class Session
{
    public static function setFlash($name, $msg)
    {
        $_SESSION[$name] = $msg;
    }

    public static function showFlash($name)
    {
        if(isset($_SESSION[$name]))
        {
            $msg = $_SESSION[$name];
            unset($_SESSION[$name]);
            return $msg;
        }
    }
}