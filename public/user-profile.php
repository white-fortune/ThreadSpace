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
    <style>
        .card-client {
            background: #2cb5a0;
            width: 60%;
            padding-top: 25px;
            padding-bottom: 25px;
            padding-left: 20px;
            padding-right: 20px;
            border: 4px solid #7cdacc;
            box-shadow: 0 6px 10px rgba(207, 212, 222, 1);
            border-radius: 10px;
            text-align: center;
            color: #fff;
            font-family: "Poppins", sans-serif;
            transition: all 0.3s ease;
            margin: 10px;
            display: flex;
        }

        .card-client:hover {
            transform: translateY(-10px);
        }

        .user-picture {
            overflow: hidden;
            object-fit: cover;
            width: 5rem;
            height: 5rem;
            border: 4px solid #7cdacc;
            border-radius: 999px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 50px;
        }

        .user-picture svg {
            width: 2.5rem;
            fill: currentColor;
        }

        .name-client {
            margin-top: 20px;
            font-weight: 600;
            font-size: 18px;
        }

        .name-client span {
            display: block;
            font-weight: 200;
            font-size: 16px;
        }

        .contain {
            margin-left: 150px;
        }
    </style>
</head>
<body>
    <?php
        include("../src/controller/db.php");
        include("navbar.php"); 

        echo '<div class="contain">';
        foreach(getAllUsers() as $user) {
            echo <<<HTML
                <div class="card-client">
                    <div class="user-picture">
                        <svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                            <path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"></path>
                        </svg>
                    </div>
                    <p class="name-client"> 
                        {$user["displayname"]}
                        <span>{$user["email"]}</span>
                    </p>
                </div>
            HTML;
        }
        echo '</div>';
    ?>
</body>
</html>