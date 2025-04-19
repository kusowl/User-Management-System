<?php
session_start();
include_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $messages  = [];
    $id = $_SESSION["id"];
    $old_password      = trim(htmlspecialchars(mysqli_real_escape_string($conn, $_POST['old_password']), ENT_QUOTES, "UTF-8") ?? "");
    $password   = trim(htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password']), ENT_QUOTES, "UTF-8") ?? "");
    $cpassword   = trim(htmlspecialchars(mysqli_real_escape_string($conn, $_POST['cpassword']), ENT_QUOTES, "UTF-8") ?? "");

    if (empty($old_password)) {
        $messages[] = "Old must not be empty\n";
    }
    if (empty($password)) {
        $messages[] = "Password must not be empty\n";
    }
    if ($cpassword !== $password) {
        $messages[] = "Password and Confirm password must be same\n";
    }

    // If there is any error
    if (empty($messages)) {

        $check_old_password = mysqli_query($conn, "SELECT *  FROM `ums` WHERE id = '$id'");

        $result = mysqli_fetch_assoc($check_old_password);
        $password_mathched = password_verify($old_password, $result['password']);

        if ($password_mathched) {

            $hpassword = password_hash($password, PASSWORD_BCRYPT);
            $update_query = "UPDATE `ums` SET `password`='$hpassword' WHERE id = '$id'";
            $result = mysqli_query($conn, $update_query);
            if ($result) {
                $_SESSION["messages"][]      = "Password Updated";
                $_SESSION["messages_type"] = "success";
                header("location:../public/index.php");
                exit;
            } else {
                $_SESSION["messages"][]      = "Error in Update query";
                $_SESSION["messages_type"] = "error";
                header("location:../public/index.php");
                exit;
            }
        } else {
            $_SESSION["messages"][]      = "Old Password does not match.";
            $_SESSION["messages_type"] = "error";
            header("location:../public/index.php");
            exit;
        }
    } else {
        $_SESSION['messages'] = $messages;
        $_SESSION['messages_type'] = 'error';
        header("location:../public/index.php");
    }
}
