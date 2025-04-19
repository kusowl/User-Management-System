<?php
session_start();
include_once "../config.php";
include_once "process.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $messages  = [];
    $id = $_SESSION["id"];
    $name = trim(htmlspecialchars(mysqli_real_escape_string($conn, $_POST['name']), ENT_QUOTES, "UTF-8") ?? "");
    $email      = trim(htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']), ENT_QUOTES, "UTF-8") ?? "");
    $image = "";
    $image_file = "";

    if (empty($name)) {
        $messages[] = "Name must not be empty\n";
    }
    if (empty($email)) {
        $messages[] = "Email must not be empty\n";
    }


    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $image_file = $_FILES['profile_image'];

        // Check image size
        if ($image_file['size'] > 2097152)
            $messages[] = "Image size must be under 2 MB\n";

        // Generate image path
        $image = store_image($image_file);
    } else if (isset($_SESSION["picture"])) {
        $image = $_SESSION["picture"];
    }

    // If there is any error
    if (empty($messages)) {
        // If there is no error
        // insert into database

        if (update_data($conn, $id, $name, $email, $image)) {
            $_SESSION["name"] = $name;
            $_SESSION["email"] = $email;
            $_SESSION["picture"] = $image;
            header("location:../public/index.php");
        } else {
            $_SESSION["messages"][] = "Error in Profile Update";
            $_SESSION['messages_type'] = 'error';
            header("location:../public/index.php");
        }
    } else {
        $_SESSION['messages'] = $messages;
        $_SESSION['messages_type'] = 'error';
        header("location:../public/index.php");
    }
}
