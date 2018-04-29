<?php
require_once "System.php";
session_start();
unset($_SESSION["SYSTEM_SESSION"]);
?>
<!doctype html>
<html lang="en">
<head>
    <?php echo System::headContent()?>
</head>

<body>


<form class="login" method="post" action="login-post.php">
    <header class="aers-header">
        <h1 class="display-6"><img src="src/circuit.png">AERS Login</h1>
    </header>
    <div class="input-group mb-3">
        <input name="userID" type="text" class="form-control" aria-label="Default"
               aria-describedby="inputGroup-sizing-default" placeholder="user ID: A12345678">
    </div>
    <div class="input-group mb-3">
        <input name="passWD" type="password" class="form-control" aria-label="Default"
               aria-describedby="inputGroup-sizing-default" placeholder="password: surprise">
    </div>

    <?php
    if (isset($_SESSION["LOGIN_ERROR"])){
        $html = '<div class="alert alert-danger" role="alert">'.$_SESSION["LOGIN_ERROR"].'</div>';
        unset($_SESSION["LOGIN_ERROR"]);
        echo $html;
    }
    ?>

    <input id="loginbtn" type="submit" class="btn btn-aers btn-md btn-block" value="Login">
    <button id="randomuser" type="button" class="btn btn-aers btn-md btn-block">Get a random user ID</button>
    <div class="alert alert-success" role="alert" id="showrandom"></div>
    <p class="git-icon"><a href="https://github.com/by-the-w3i/AERS"><i class="fab fa-github"></i></a></p>
</form>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/jquery.loading.min.js"></script>
<script src="js/aers.js"></script>
</body>
</html>
