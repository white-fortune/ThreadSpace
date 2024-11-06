<?php

use WebSocket\Client;

session_start();
require dirname(__DIR__, 2) . "\\vendor\\autoload.php";
include("db.php");

$server = "ws://localhost:9000/chat";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if(varifyPassword($email, $password)) {
            try {
                $_SESSION["email"] = $email;
                $displayname = getUser($email)["displayname"];
                setcookie("displayname", $displayname, time() + 86400, "/");
                // $client = new Client($server);
                // $client->send("NEWUSER: $displayname joined");

                header("Location: /public/dashboard.php");
                exit();
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        } else {
            echo "Login failed!";
        }  
    }
}

?>