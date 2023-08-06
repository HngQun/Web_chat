<?php
session_start();
include_once "Config.php";

$outgoing_id = $_SESSION['id_user'];
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

$sql = "SELECT * FROM user,friend WHERE ((friend.from_id = {$outgoing_id} AND user.id_user=friend.to_id) OR (friend.to_id = {$outgoing_id} AND user.id_user=friend.from_id)) AND friend.status='1' AND (name LIKE '%{$searchTerm}%') ";
$query = mysqli_query($conn, $sql);
$output = ""; 
$flag = false;
if (mysqli_num_rows($query) > 0) {
    include_once "data.php";
} 
else {
    $output .= 'No user found related to your search term';
}
echo $output;
