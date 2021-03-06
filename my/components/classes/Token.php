<?php
class Token
{
    public static function generate()
    {
        //var_dump(Config::get("session.token_name"));
        return Session::put(Config::get("session.token_name"), md5(uniqid()));
    }

    public static function check($token)
    {
        $tokenname = Config::get("session.token_name");

        if(Session::exists($tokenname) && $token == Session::get($tokenname))
        {
            Session::delete($tokenname);
            return true;
        }
        return false;
    }
}
?>