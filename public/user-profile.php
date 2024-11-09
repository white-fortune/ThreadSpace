<?php
session_start();
if(!isset($_SESSION["email"])) {
    header("Location: /public/login.php");
	exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        include("../src/controller/db.php");
        include("navbar.php"); 

        echo '<br><div class="container">';
        foreach(getAllUsers() as $user) {
            echo <<<HTML
                <div class="card border-dark mb-3 w-75">
                    <div class="card-header">{$user["displayname"]}</div>
                    <div class="card-body">
                        <h5 class="card-title">Bio</h5>
                        <p class="card-text">{$user["description"]}</p>
                    </div>
                </div>
            HTML;
        }
        echo '</div>';
    ?>
</body>
</html>