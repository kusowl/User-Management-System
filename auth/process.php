<?php
session_start();
function store_data($conn, $name, $email, $password, $image)
{
    $image_path = store_image($image);
    if ($image_path !== false) {

        $sql = "INSERT INTO `ums`(`name`, `email`, `password`, `proifle_pic`) VALUES ('$name','$email','$password','$image_path')";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            $_SESSION['messages']= "Error in insert query -> " . mysqli_error($conn);
            return false;
        }
        return true;
    } else {
        $_SESSION['messages']= "Image path cannot be generated | ".$image_path;
        return false;
    }
}

function delete_data($conn, $id)
{
    $sql = "DELETE FROM `advance_crud` WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    if(!$result){
        $_SESSION['messages']= "Error while deleting record | ".mysqli_errno($conn);
        return false;
    }
    return true;
}

function update_data($conn, $id, $name, $email, $image_path)
{
    $update_query = "UPDATE `ums` SET `name`='$name',`email`='$email',`proifle_pic`='$image_path' WHERE id = '$id'";

    $result = mysqli_query($conn, $update_query);
    if ($result) {
        $_SESSION["messages"][]      = "Profile Updated Successfully";
        $_SESSION["messages_type"] = "success";
        return true;
    } else {
        $_SESSION["messages"][]      = "Error in Update query";
        $_SESSION["messages_type"] = "error";
        return false;
    }
    return false;
}

function store_image(array $image): mixed
{
    $dir = "/opt/lampp/htdocs/jphp21/UMS/images/";

    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "Created directory $dir\n";
        } else {
            $_SESSION['messages'] = "Directory $dir cannot be created\n";
            return false;
        }
    }
    $img_name = $image['name'];
    $path = "../images/". $img_name;
    if (move_uploaded_file($image['tmp_name'], $path)) {
        return $path;
    }
    return false;
}