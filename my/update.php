<?php
require_once "init.php";
$user = new User;


if (Input::exists()) {
    if (Token::check(Input::get("token"))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, [
            "name" => [
                "requred" => true,
                "min" => 3
                ]
        ]);


        if($validation->passed())
        {
            $user->update(["name" => Input::get("name")]);
            //var_dump($user); die;
            Redirect::to("update.php");
        }
        else
        {
            foreach($validate->errors() as $error)
            {
                echo $error." <br>";
            }
        }
    }
}
?>

<form action="update.php" method="post">

    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="name"  value="<?php echo $user->data()->name;?>">
    </div>

    <div class="field">
        <button type="submit">Submit</button>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
</form>

