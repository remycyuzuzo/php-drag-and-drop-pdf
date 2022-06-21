

<?php
include "config.php";
if (isset($_POST['submit_btn'])) { // If isset upload button or not
    // Declaring Variables
    $location = "./uploads/";
    $file_new_name = date("dmy") . time() . $_FILES["file"]["name"]; // New and unique name of uploaded file
    $file_name = $_FILES["file"]["name"]; // Get uploaded file name
    $file_temp = $_FILES["file"]["tmp_name"]; // Get uploaded file temp
    $file_size = $_FILES["file"]["size"]; // Get uploaded file size
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

    if (empty($file_name)) {
        die(show_alert("<strong>No file</strong> Please select a valid file first!"));
    }

    if (strtolower($file_ext) !== "pdf") {
        die(show_alert("Only PDF files are supported", "error"));
    }

    if ($file_size > 6485760) { // Check file size 10mb or not
        die(show_alert("The maximum allowed size is 6MB", "error"));
    }

    $sql = "INSERT INTO file (file_name, user_id)
				VALUES ('$file_name', 1)";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        move_uploaded_file($file_temp, $location . $file_new_name);
        echo show_alert("The file was successfully uploaded", "success");
    } else {
        echo show_alert("There was an error while saving database data", "error");
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
