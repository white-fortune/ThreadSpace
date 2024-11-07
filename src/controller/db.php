<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "users";
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    

    function register($displayname, $email, $password) {
        global $conn;
        $sql = "INSERT INTO users (displayname, email, password) 
        VALUES ('$displayname', '$email', '$password')
        ";

        try {
            mysqli_query($conn, $sql);
            mysqli_close($conn);
            return true;
        } catch (mysqli_sql_exception) {
            mysqli_close($conn);
            return false;
        }
    }

    function getUser($email) {
        global $conn;
        $sql = "SELECT * FROM users WHERE email='$email'";
        $data = mysqli_query($conn, $sql);
        if(mysqli_num_rows($data) == 1) {
            $user = mysqli_fetch_assoc($data);
            mysqli_close($conn);

            return $user;
        }
    }

    function getAllUsers() {
        global $conn;
        $sql = "SELECT * FROM users";
        $data = mysqli_query($conn, $sql);
        return mysqli_fetch_all($data, MYSQLI_ASSOC);;
    }

    function varifyPassword($email, $password) {
        global $conn;
        $sql = "SELECT * FROM users WHERE email='$email'";
        $data = mysqli_query($conn, $sql);
        if(mysqli_num_rows($data) == 1) {
            $pass = mysqli_fetch_assoc($data)["password"];
            return $pass === $password;
        } else {
            return false;
        }
    }

    function getAllThread() {
        global $conn;
        $sql = "SELECT name, description, state FROM threads WHERE 1=1";
        $getallsql = mysqli_query($conn, $sql);
        return mysqli_fetch_all($getallsql, MYSQLI_ASSOC);;
    }

    function getThread(string $roomname) {
        $db_server = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "users";
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

        $sql = "SELECT name, description, state, password FROM threads WHERE name='$roomname'";
        $getthread = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($getthread);
    }

    function addThread($threadname, $description, $password, $state) {
        global $conn;
        $sql = "INSERT INTO threads (name, description, password, state) 
        VALUES ('$threadname', '$description', '$password', '$state')
        ";

        try {
            mysqli_query($conn, $sql);
        } catch (mysqli_sql_exception) {
            mysqli_close($conn);
            return false;
        }
    }
?>