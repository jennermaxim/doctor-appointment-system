<?php
session_start();
if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'd') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

if ($_POST) {
    include("../connection.php");
    $userid = $_POST['userid'];
    if ($_FILES['profile']['error'] !== UPLOAD_ERR_NO_FILE) {
        $profile_name = $_FILES['profile']['name'];
        $profile_tmp = $_FILES['profile']['tmp_name'];
        $profile_err = $_FILES['profile']['error'];
        $profile_type = $_FILES['profile']['type'];
        $profile_size = $_FILES['profile']['size'];

        $profile_ext = explode(".", $profile_name);
        $profile_actExt = strtolower(end($profile_ext));
        $profile_allowExt = array("png", "jpg", "jpeg");
        if (in_array($profile_actExt, $profile_allowExt)) {
            if ($profile_size < 10048576) {
                if ($profile_err === 0) {
                    // $profile_name = uniqid("", true) . "." . $profile_actExt;
                    $destination = "profile/" . $userid . "." . $profile_actExt;
                    $upload = move_uploaded_file($profile_tmp, $destination);
                    if ($upload) {
                        $query = "UPDATE doctor SET `profile` = '$destination' WHERE docid = '$userid'";
                        $update = $database->query($query);
                        if ($update) {
                            header("location: index.php");
                        } else {
                            echo "Error: Failed to update your profile";
                        }
                    } else {
                        echo "Error: Failed to upload your profile...!";
                    }
                } else {
                    echo "Error: Please try again";
                }
            }
            echo "File to big";
        } else {
            echo "File type not supported";
        }
    }

}