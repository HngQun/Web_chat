<?php
session_start();
include_once "Config.php";
$idgroup = $_GET['idgroup'];
$id = $_SESSION['id_user'];
$sql4 = mysqli_query($conn, "DELETE from user_room where id_user=$id and id_room=$idgroup");
header("location:../users.php");
