<?php
include "config.php";
if (isset($_POST['form'])) { // If isset upload button or not
    // Declaring Variables
    $location = "./uploads/";
    $file_name = $_FILES['file']['name'];
    $number_of_files = count($file_name);

    for ($i = 0; $i < $number_of_files; $i++) {
        $file_name = $_FILES['file']['name'][$i];
        $file_size = $_FILES['file']['size'][$i];
        $tmp_name = $_FILES['file']['tmp_name'][$i];
        $file_title = $_POST["fileTitle_$i"];

        // $file_title = $conn->real_escape_string($_POST["file_title"]);
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_new_name = date("dMYHis") . "_$i" . strtolower(str_replace(' ', '-', $file_name));

        if (empty($file_name)) {
            die(show_alert("<strong>No file</strong> Please select a valid file first!"));
        }

        if (strtolower($file_ext) !== "pdf") {
            die(show_alert("Only PDF files are supported", "error"));
        }

        if ($file_size > 6485760) { // Check file size 10mb or not
            die(show_alert("The maximum allowed size is 6MB", "error"));
        }

        if (move_uploaded_file($tmp_name, $location . $file_new_name)) {
            echo show_alert("The file \"$file_title\" was successfully uploaded", "success");
        } else {
            die(show_alert("The file \"$file_title\" was not uploaded", "error"));
        }

        // saving query in the databases if the file was uploaded successfully
        try {
            $sql = "INSERT INTO file (file_name, user_id, file_title)
                    VALUES (:file_name, :user_id, :file_title)";
            $statement = $conn->prepare($sql);
            $statement->execute([
                ':file_name' => $file_new_name,
                ':user_id' => 1,
                ':file_title' => $file_title
            ]);
        } catch (PDOException $e) {
            die(show_alert("<strong>Database Error</strong> The system couldn't perform the database operation. " . $e->getMessage(), "error"));
        }
    }
}

/**
 * @param string $message    Specify the message to be alerted on the users screen
 * @param string $type       Specify whether the message is an error or a success notifier 
 * @return string            Returns a formatted HTML message
 */
function show_alert($message, $type = "error")
{
    $style = "background-color: #b52419";
    if ($type == "success") {
        $style = "background-color: #1fab21";
    }

    return "
    <div style='display: flex; margin-bottom: 10px;'>
        <a href='./index.php' style='padding: 10px; border-radius: 10px; background-color: #42379e; color: #fff'>go Back</a>
        <div style='padding: 10px 30px; margin: 0 10px; color: #ffffff; border-radius: 10px; $style'>
            $message
        </div>
    </div>
    ";
}
