<?php
require_once "init.php";
$user = new User();


if (Input::exists()) {
    if (Token::check(Input::get("token"))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, [
            "current_password" => ["required" => true, "min" => 3],
            "new_password" => ["required" => true, "min" => 3],
            "new_password_again" => ["required" => true, "min" => 3, "match" => "new_password"]
        ]);


        if($validation->passed())
        {
            if(password_verify(Input::get("current_password"), $user->data()->password))
            {
                $user->update(["password" => password_hash(Input::get("new_password"), PASSWORD_DEFAULT)]);
                Session::flash("success", "password has been updated");
                Redirect::to("index.php");
            }
            else
            {
                echo "invalid current password";
            }

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

<form action="changepassword.php" method="post">

    <div class="field">
        <label for="username">currnet password</label>
        <input type="text" name="current_password" >
    </div>

    <div class="field">
        <label for="username">new password</label>
        <input type="text" name="new_password" >
    </div>

    <div class="field">
        <label for="username">new password again</label>
        <input type="text" name="new_password_again" >
    </div>

    <div class="field">
        <button type="submit">Submit</button>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
</form>

