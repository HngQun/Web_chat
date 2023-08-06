<?php
session_start();
include_once "Config.php";
$namegr = $_POST['namegr'];
$idgr = $_POST['idgr'];
$sql4 = mysqli_query($conn, "UPDATE room set namegr='$namegr' where id=$idgr");
header("location:../insert-member-group.php?idgroup=$idgr");
