<?php
session_start();
include_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $messages  = [];
    $email      = trim(htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']), ENT_QUOTES, "UTF-8") ?? "");
    $password   = trim(htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password']), ENT_QUOTES, "UTF-8") ?? "");

    if (empty($email)) {
        $messages[] = "Email must not be empty\n";
    }
    if (empty($password)) {
        $messages[] = "Password must not be empty\n";
    }

    // If there is any error
    if (empty($messages)) {

        $check_user_exist = mysqli_query($conn, "SELECT *  FROM `ums` WHERE email = '$email'");
        if (! $check_user_exist) {
            echo "Error in insert query " . mysqli_error($conn);
            exit;
        }

        if (mysqli_num_rows($check_user_exist) == 0) {
            $_SESSION["messages"][] = "No User found, Kindly &nbsp <a class='btn btn-ghost' href='register.php' >Register Now</a></button>";
            $_SESSION["messages_type"] = "warning";
            header("location:../public/login.php");
            exit;
        }
        $result            = mysqli_fetch_assoc($check_user_exist);
        $password_mathched = password_verify($password, $result['password']);

        if ($password_mathched) {

            $_SESSION["name"] = $result['name'];
            $_SESSION["email"] = $result['email'];
            $_SESSION["picture"] = $result['proifle_pic'];
            $_SESSION["id"] = $result['id'];
            header("location:../public/index.php");
            exit;
        } else {
            $_SESSION["messages"][]      = "Login Failed ! Password does not matched.";
            $_SESSION["messages_type"] = "error";
            header("location:../public/login.php");
            exit;
        }
    } else {
        $_SESSION['messages'] = $messages;
        $_SESSION['messages_type'] = 'error';
        header("location:../public/login.php");
    }
}
