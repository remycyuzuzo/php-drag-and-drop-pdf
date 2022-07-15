<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> login form</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./form-styles.css">
</head>

<body class="bg-light">
    <div class="container d-flex flex-column justify-content-center">
        <div class="head bg-white py-4 py-3">
            <h1>User LogIn</h1>
            <form action="./login-backend.php" method="POST">
                <div class="input">
                    <input type="text" name="email" placeholder="User email address">
                </div>
                <div class="input mb-2">
                    <input type="password" name="password" placeholder="Password">
                </div>
                <?= (isset($_SESSION["error"])) ? "<div class='alert alert-danger my-2'>$_SESSION[error]</div>" : "" ?>
                <div class="input">
                    <button type="submit" name="sbmt" class="button1">Log in</button>
                </div>
                <div class="password">
                    Forgot password?
                </div>
                <hr />
            </form>
        </div>
    </div>
    <script src="../index.js"></script>
</body>

</html>