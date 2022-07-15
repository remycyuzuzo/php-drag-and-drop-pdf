<?php
session_start();

if (isset($_POST["email"])) {
    include "./config.php";

    $email = $_POST["email"];
    $pswd = $_POST['password'];

    try {
        $sql = "SELECT * from users where email = :email AND password = :password";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ":email" => $email,
            ":password" => $pswd
        ]);
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            $_SESSION["error"] = "incorrect username or password";
            header("location:login.php");
        } else {
            $_SESSION["loggedIn"]["userdata"] = $data;
            header("location:index.php");
        }
    } catch (PDOException $e) {
        echo "There was an error in database operation";
    }
}
