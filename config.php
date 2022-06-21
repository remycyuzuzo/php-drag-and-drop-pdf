<?php

$server = "localhost";
$dbuser = "root";
$dbpass = "";
$database = "first";

$conn = mysqli_connect($server, $dbuser, $dbpass, $database);

if (!$conn) {
    die("<div style='padding: 10px 30px; background-color: #777777; color: #ffffff; border-radius: 10px;'>
        <strong>Database Error</strong> The system couldn't connect to the database server
    </div>");
}
