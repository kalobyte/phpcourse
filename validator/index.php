<?php
require_once "validator.php";

$rules = [
        "form_user" =>[
                "min" => 3,
                "max" =>10,
            "required" => true,
        ],
    "form_email" =>[
        "email" => true,
        "required" => true,
        ],

    "form_pass" =>[
        "required" => true

    ],

    "form_pass_2" =>[
        "required" => true,
        "match" => "form_pass"
    ]
];

$out = "";
if(!empty($_POST))
{
    $validator = new Validator($rules);
    $validator->validate();

    if(!$validator->isValidated())
    {
        $errors = $validator->getErrors();
        foreach ($errors as $error)
            $out .= $error . "<br>";
    }
    else
    {
        $out = "no errors";
    }

}





?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="index.php" method="post">

    <div>
        <lable>User:</lable>
        <input type="text" name="form_user" value="bb">
    </div>
    <div>
        <lable>Email:</lable>
        <input type="text" name="form_email" value="aaa@mail.ru">
    </div>
    <div>
        <lable>Password:</lable>
        <input type="text" name="form_pass" value="aaa">
    </div>
    <div>
        <lable>Password again:</lable>
        <input type="text" name="form_pass_2" value="aaa">
    </div>
    <?php echo $out; ?>
    <button type="submit">send</button>

</form>
</body>
</html>
