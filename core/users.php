<?php
session_start();
include_once "Config.php";
$outgoing_id = $_SESSION['id_user'];
$sql = "SELECT * FROM user,friend WHERE NOT id_user = {$outgoing_id}  and ((user.id_user=friend.from_id and friend.to_id=$outgoing_id) OR (user.id_user=friend.to_id and friend.from_id=$outgoing_id)) AND friend.status=1 ORDER BY user.name DESC";
$sql10 = "SELECT * FROM user_room,room WHERE user_room.id_user=$outgoing_id and room.id = user_room.id_room group by user_room.id_room ORDER BY user_room.id_room DESC";
$query = mysqli_query($conn, $sql);
$query10 = mysqli_query($conn, $sql10);
$flag = true;
$output = "";
if (mysqli_num_rows($query) > 0) {
    include_once "data.php";
}
if (mysqli_num_rows($query10) > 0) {
    include_once "data.php";
}
echo $output;
