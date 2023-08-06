<?php
session_start();
include_once "Config.php";
$idgroup = $_POST['idgroup'];
foreach ($_POST as $id => $check) {
    $sql4 = mysqli_query($conn, "INSERT into user_room values ($id,$idgroup,0)");
}
header("location:../chatgroup.php?group_id=$idgroup");
