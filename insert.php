

<?php
include "config.php";
if (isset($_POST['submit_btn'])) { // If isset upload button or not
    // Declaring Variables
    $location = "uploads/";
    $file_new_name = date("dmy") . time() . $_FILES["file"]["name"]; // New and unique name of uploaded file
    $file_name = $_FILES["file"]["name"]; // Get uploaded file name
    $file_temp = $_FILES["file"]["tmp_name"]; // Get uploaded file temp
    $file_size = $_FILES["file"]["size"]; // Get uploaded file size


    /*
	How we can get mb from bytes
	(mb*1024)*1024

	In my case i'm 10 mb limit
	(10*1024)*1024
	*/

    if ($file_size > 10485760) { // Check file size 10mb or not
        echo "<script>alert('Woops! File is too big. Maximum file size allowed for upload 10 MB.')</script>";
    } else {
        $sql = "INSERT INTO file (file_name, user_id)
				VALUES ('$file_name', 1)";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            move_uploaded_file($file_temp, $location . $file_new_name);
            echo "<script>alert('Wow! File uploaded successfully.')</script>";
        } else {
            echo "<script>alert('Woops! Something went wrong.')</script>";
        }
    }
}
