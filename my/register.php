<?php
require_once "init.php";

if (Input::exists()) {
    if (Token::check(Input::get("token"))) {

        $validate = new Validate();

        $validation = $validate->check($_POST, [
            "name" => [
                "required" => true,
                "min" => 2,
                "max" => 15,
                "unique" => "users" // таблица в базе с пользователями
            ],

            "email" => [
                "required" => true,
                "email" => true,
                "unique" =>  "users" // таблица в бд для проверки такого адреса
            ],

            "password" => [
                "required" => true,
                "min" => 3
            ],

            "password_again" => [
                "required" => true,
                "match" => "password"
            ]
        ]);

        if ($validation->passed()) {

            $password = password_hash(Input::get('password'), PASSWORD_DEFAULT);
            $user = new User();
            $user->create([
                'name' => Input::get('name'),
                'password' => $password,
                'email' => Input::get('email')
            ]);

            Session::flash('success', "register success!");
        } else
            foreach ($validation->errors() as $error) {
                echo $error . '<br>';
            }
    } else    echo "token error";
}


?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

<form action="register.php" method="post">
    <?php echo Session::flash('success'); ?>
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="name" id="username" value="<?php Input::get("name"); ?>">
    </div>

    <div class="field">
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
    </div>

    <div class="field">
        <label for="username">password</label>
        <input type="text" name="password" id="username">
    </div>

    <div class="field">
        <label for="username">password again</label>
        <input type="text" name="password_again" id="username">
    </div>

    <div class="field">
        <button type="submit">Submit</button>
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
</form>

</body>
</html>
