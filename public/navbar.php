<?php
if($_SERVER["REQUEST_METHOD"] == "GET") {
	if(isset($_GET["logout"])) {
		if(isset($_SESSION["email"])) {
			session_unset();
			session_destroy();
      setcookie("displayname", "", time() - 86400, "/");
      			
			header("Location: /public/login.php");
			exit();
		}
	}
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link" href="/public/threads.php">All threads</a>
          <a class="nav-link" href="/public/register.php">Register</a>
          <a class="nav-link" href="/public/login.php">Login</a>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Others
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/public/dashboard.php">Myself</a></li>
            <li><a class="dropdown-item" href="/public/chat.php">Chat with friends</a></li>
            <li><hr class="dropdown-divider"></li>
            <form action="<?php $_SERVER["PHP_SELF"]?>" method="get" style="margin-left: 10px;">
              <li><button class="btn btn-outline-danger" type="submit" name="logout">Logout</button></li>
            </form>
          </ul>
        </li>
        </div>
      </div>
    </div>
  </nav>
</div>
</body>

</html>