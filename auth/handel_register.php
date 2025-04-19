<?php
session_start();
include_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $messages  = [];
    $name = trim(htmlspecialchars(mysqli_real_escape_string($conn, $_POST['name']), ENT_QUOTES, "UTF-8") ?? "");
    $email      = trim(htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']), ENT_QUOTES, "UTF-8") ?? "");
    $password   = trim(htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password']), ENT_QUOTES, "UTF-8") ?? "");
    $cpassword  = trim(htmlspecialchars(mysqli_real_escape_string($conn, $_POST['cpassword']), ENT_QUOTES, "UTF-8") ?? "");
    $image = "";

    if (empty($name)) {
        $messages[] = "Name must not be empty\n";
    }
    if (empty($email)) {
        $messages[] = "Email must not be empty\n";
    }
    if (empty($password)) {
        $messages[] = "Password must not be empty\n";
    }

    if ($password !== $cpassword) {
        $messages[] = "Password and Confirm password must be same\n";
    }

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['profile_image'];

        // Check image size
        if ($image['size'] > 2097152)
            $messages[] = "Image size must be under 2 MB\n";
    } else {
        $messages[] = "Image is required\n";
    }

    // If there is any error
    if (empty($messages)) {

        include_once "process.php";

        $check_email_exist = mysqli_query($conn, "SELECT `email` FROM `ums` WHERE email = '$email'");

        if (mysqli_num_rows($check_email_exist) > 0) {
            $_SESSION["messages"][]      = "Email already exist, Kindly &nbsp <a class='btn btn-ghost' href='login.php' >Login Now</a></button>";
            $_SESSION["messages_type"] = "warning";
            header("location:../public/register.php");
            exit;
        }

        // Hash the password
        $hpassword = password_hash($password, PASSWORD_BCRYPT);
        if (store_data($conn, $name, $email, $hpassword, $image)) {
            $_SESSION["messages"][] = "Accounted Created Successfully";
            $_SESSION['messages_type'] = 'success';
            header("location:../public/register.php");
        }
    } else {
        $_SESSION['messages'] = $messages;
        $_SESSION['messages_type'] = 'error';
        header("location:../public/register.php");
    }
}
