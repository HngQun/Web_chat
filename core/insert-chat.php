<?php
ob_start();
session_start();
if (isset($_SESSION['id_user'])) {
    include_once "Config.php";
    $outgoing_id = $_SESSION['id_user'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $in = $_POST['incoming_id'];
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $today = date("y/m/d H:i:s");
    if (!empty($message)) {
        $sql = mysqli_query($conn, "INSERT INTO message (to_id, from_id, msg, id_type, status, hidden, create_at)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', 1, 0,0 ,'{$today}')") or die();
    }
} else {
    header("location: ../login.php");
}
