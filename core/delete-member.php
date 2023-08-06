<?php
ob_start();
session_start();
include_once "Config.php";
$idgroup = $_POST['idgr'];
$idusr = $_POST['idusr'];
$sql4 = mysqli_query($conn, "DELETE from user_room where id_user=$idusr and id_room=$idgroup");
header("location:../insert-member-group.php?idgroup=$idgroup");

