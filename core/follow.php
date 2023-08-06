<?php
ob_start();
session_start();
include_once "Config.php";
$outgoing_id = $_SESSION['id_user'];
$unique_id2 = $_GET['to_id'];
$flag = false;
$idcall = rand(1000,9999);
$sql3 = mysqli_query($conn, "SELECT * FROM friend");
while ($row = mysqli_fetch_assoc($sql3)) {
    if ((($row['from_id'] == $outgoing_id && $row['to_id'] == $unique_id2) || ($row['to_id'] == $outgoing_id && $row['from_id'] == $unique_id2)) && $row['status'] == 0) {
        $sql1 = mysqli_query($conn, "UPDATE friend SET status=0,from_user=$outgoing_id WHERE from_id=$outgoing_id and to_id=$unique_id2");
        $sql2 = mysqli_query($conn, "UPDATE friend SET status=0,from_user=$outgoing_id WHERE to_id=$outgoing_id and from_id=$unique_id2");
        $flag = true;
    } elseif ((($row['from_id'] == $outgoing_id && $row['to_id'] == $unique_id2) || ($row['to_id'] == $outgoing_id && $row['from_id'] == $unique_id2)) && $row['status'] == 1) {
        $sql1 = mysqli_query($conn, "DELETE from friend WHERE from_id=$outgoing_id and to_id=$unique_id2");
        $sql2 = mysqli_query($conn, "DELETE from friend WHERE to_id=$outgoing_id and from_id=$unique_id2");
        $flag = true;
    }
}
if ($flag == false) {
    $sql3 = mysqli_query($conn, "INSERT into friend(from_id, to_id, status, from_user, id_call) value($outgoing_id,$unique_id2,0,$outgoing_id,$idcall)");
}
header("location:../follow.php");