<?php

include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST["displayname"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
        $displayname = filter_input(INPUT_POST, "displayname", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if(register($displayname, $email, $password)) {
            header("Location: /login.php");
            exit();
        } else {
            echo "Registration failed!!";
        }
    }
}

?>