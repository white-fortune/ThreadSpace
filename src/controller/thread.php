<?php

include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["threadname"]) && isset($_POST["description"]) && isset($_POST["password"])) {
        $threadname = filter_input(INPUT_POST, "threadname", FILTER_SANITIZE_SPECIAL_CHARS);
        $desc = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        // echo $threadname . ":" . $desc . ":" . $password;
        $allThreads = addThread($threadname, $desc, $password, 'Public');
        foreach($allThreads as $thread) {
            echo $thread["name"];
        }
    } else {
        echo "Bruh";
    }
}