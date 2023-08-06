<?php
ob_start();
session_start();
if (isset($_SESSION['id_user'])) {
    include_once "Config.php";
    $outgoing_id = $_SESSION['id_user'];
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $id_gr = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $today = date("y/m/d H:i:s");
    if (!empty($message)) {
        $sql = mysqli_query($conn, "INSERT INTO message (id_room, from_id, msg, id_type, status, create_at)
                                        VALUES ({$id_gr}, {$outgoing_id}, '{$message}',1 , 0,'{$today}')") or die();
    }
} else {
    header("location: ../login.php");
}

