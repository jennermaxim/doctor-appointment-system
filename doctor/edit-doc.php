<?php
//import database
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("../connection.php");

if ($_POST) {
    $result = $database->query("select * from webuser");
    $name = $_POST['name'];
    $oldemail = $_POST["oldemail"];
    $nic = $_POST['nic'];
    $spec = $_POST['spec'];
    $email = $_POST['email'];
    $tele = $_POST['Tele'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $experience_years = $_POST['experience_years'];
    $licence_number = $_POST['licence_number'];
    $languages_spoken = $_POST['languages_spoken'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $id = $_POST['id00'];

    if ($password == $cpassword) {
        $error = '3';
        $result = $database->query("select doctor.docid from doctor inner join webuser on doctor.docemail=webuser.email where webuser.email='$email';");
        if ($result->num_rows == 1) {
            $id2 = $result->fetch_assoc()["docid"];
        } else {
            $id2 = $id;
        }

        if ($id2 != $id) {
            $error = '1';
        } else {
            $sql1 = "UPDATE doctor SET docemail='$email',docname='$name',docpassword='$password',
            docnic='$nic',doctel='$tele',specialties=$spec, gender = '$gender', dob = '$dob',
            experience_years = '$experience_years', licence_number = '$licence_number',
            languages_spoken = '$languages_spoken' WHERE docid=$id ;";
            $database->query($sql1);
            $sql1 = "UPDATE webuser SET email='$email' WHERE email='$oldemail' ;";
            $database->query($sql1);
            echo $sql1;
            $error = '4';
        }
    } else {
        $error = '2';
    }
} else {
    $error = '3';
}
header("location: settings.php?action=edit&error=" . $error . "&id=" . $id);