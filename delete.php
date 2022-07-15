<?php
include "./config.php";

if (isset($_GET['action']) && $_GET['action'] === "delete") {
    $file_id = $_GET["file_id"];

    // delete the file from the server
    $sql = "SELECT * from file where id = ? ";
    $statement = $conn->prepare($sql);
    $statement->execute([$file_id]);
    $file = $statement->fetch(PDO::FETCH_ASSOC);
    $file_name = $file["file_name"];

    if (unlink("./uploads/" . $file_name)) {
        try {
            $sql = "DELETE from file where id= ? ";
            $statement = $conn->prepare($sql);
            $statement->execute([$file_id]);
            $affected_rows = $statement->rowCount();

            if ($affected_rows > 0) {
                header("Location: index.php");
            } else {
                echo "<div style='padding: 10px 30px; background-color: #777777; color: #ffffff; border-radius: 10px;'>
                    <strong>Database Error</strong> The system couldn't delete the file from the database
                </div>";
            }
        } catch (PDOException $e) {
            echo Show_alert("There was an error while trying to delete this file <br />" . $e->getMessage());
        }
    }
}

function show_alert($message, $type = "error")
{
    $style = "background-color: #b52419";
    if ($type == "success") {
        $style = "background-color: #1fab21";
    }

    return "
    <div style='display: flex;'>
        <a href='./index.php' style='padding: 10px; border-radius: 10px; background-color: #42379e; color: #fff'>go Back</a>
        <div style='padding: 10px 30px; margin: 0 10px; color: #ffffff; border-radius: 10px; $style'>
            $message
        </div>
    </div>
    ";
}
