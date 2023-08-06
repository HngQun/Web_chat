<?php
ob_start();
include_once "Config.php";
$id1 = $_GET['iduser'];
$id2 = $_GET['iduser2'];
$sql1 = mysqli_query($conn, "UPDATE friend SET status=1,from_user='0' WHERE from_id=$id1 and to_id=$id2");
$sql2 = mysqli_query($conn, "UPDATE friend SET status=1,from_user='0' WHERE to_id=$id1 and from_id=$id2");
header("location:../");

