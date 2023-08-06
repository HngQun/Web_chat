<?php
ob_start();
session_start();
include_once "Config.php";

date_default_timezone_set('Asia/Ho_Chi_Minh');
$today = date("y/m/d H:i:s");

$id_gr = time();
$idme = $_SESSION['id_user'];

$sql6 = mysqli_query($conn, "INSERT into room values ($id_gr,'$id_gr','anhgroup.jpg',0,'$today')");
$sql7 = mysqli_query($conn, "INSERT into user_room values ($idme,$id_gr,0)");

foreach ($_POST as $id => $check) {
  $sql3 = mysqli_query($conn, "SELECT * FROM user");
  $row = mysqli_fetch_assoc($sql3);
  $sql4 = mysqli_query($conn, "INSERT into user_room values ($id,$id_gr,0)");
}

header('location:../users.php');
