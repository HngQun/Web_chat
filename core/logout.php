<?php
session_start();
if (isset($_SESSION['id_user'])) {
    include_once "Config.php";
    $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
    if (isset($logout_id)) {
        $status = "Offline now";
        $sql = mysqli_query($conn, "UPDATE user SET status = '{$status}' WHERE id_user ={$_GET['logout_id']}");
        if ($sql) {
            session_unset();
            session_destroy();
            $id_user = "";
            header("location: ../login.php");
        }
    } else {
        header("location: ../users.php");
    }
} else {
    header("location: ../login.php");
}
