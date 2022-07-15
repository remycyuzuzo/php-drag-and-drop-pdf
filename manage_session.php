<?php
session_start();
if (isset($_SESSION["loggedIn"]["userdata"])) {
    $user_data = $_SESSION["loggedIn"]["userdata"];
} else {
    header("login.php");
}
