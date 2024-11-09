<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION["email"])) {
    header("Location: /public/login.php");
	exit();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
	<?php
    include("../src/controller/db.php");
    include("navbar.php") 
    ?>
    <br>
    <?php 
        if(isset($_SESSION["email"])) {
            $email = $_SESSION["email"];
            $user = getUser($email); 
        } else {
            header("Location: /login.php");
            exit();
        }
    ?>
    <div class="container">
        <div class="card border-dark mb-3" style="max-width: 18rem;">
            <div class="card-header">Myself</div>
            <div class="card-body">
                <h5 class="card-title">Displayname</h5>
                <p class="card-text"><?php echo $user["displayname"] ?></p>
            </div>
            <div class="card-body">
                <h5 class="card-title">Email</h5>
                <p class="card-text"><?php echo $user["email"] ?></p>
            </div>
            <div class="card-body">
                <h5 class="card-title">About Me</h5>
                <p class="card-text"><?php echo $user["description"] ?></p>
            </div>
        </div>
    </div>
</body>
</html>