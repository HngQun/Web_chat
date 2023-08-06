<?php
session_start();
include_once "Config.php";
$name = isset($_POST['name']) ? $_POST['name'] : "";
$pass = isset($_POST['pass']) ? $_POST['pass'] : "";
$passcf = isset($_POST['passcf']) ? $_POST['passcf'] : "";
$id = $_SESSION['id_user'];
$sql = mysqli_query($conn, "UPDATE user set name='$name' where id_user='$id'");
if ($pass != "" && $pass == $passcf) {
    $password = md5($pass);
    $sql3 = mysqli_query($conn, "UPDATE user set password='$password' where id_user='$id'");
    $_SESSION['alert_message'] = "Profile updated successfully.";
}
else{
    $_SESSION['alert_message'] = "Profile updated fail.";
}

if (isset($_FILES['image'])) {
    $img_name = $_FILES['image']['name'];
    $img_type = $_FILES['image']['type'];
    $tmp_name = $_FILES['image']['tmp_name'];

    $img_explode = explode('.', $img_name);
    $img_ext = end($img_explode);

    $extensions = ["jpeg", "png", "jpg", "JPEG", "PNG", "JPG"];
    if (in_array($img_ext, $extensions) === true) {
        $types = ["image/jpeg", "image/jpg", "image/png"];
        if (in_array($img_type, $types) === true) {
            $time = time();
            $new_img_name = $time . $img_name;
            if (move_uploaded_file($tmp_name, "../assets/img/" . $new_img_name)) {
                $sql4 = mysqli_query($conn, "UPDATE user SET img = '$new_img_name' WHERE id_user='$id'");
            } 
        }
    }
}

header("location:../users.php");
