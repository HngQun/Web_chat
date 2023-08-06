<?php
session_start();
include_once "Config.php";

$id = $_SESSION['id_user'];
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

$sql = "SELECT * FROM user WHERE name LIKE '%{$searchTerm}%' ";
$query = mysqli_query($conn, $sql);

$output = "";
$flag = false;

if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $sql2 = mysqli_query($conn, "SELECT * FROM user");
        while ($row2 = mysqli_fetch_assoc($sql2)) {

            if ($row2['id_user'] != $_SESSION['id_user']) {
                $id2 = $row2['id_user'];
                $sql4 = mysqli_query($conn, "SELECT * FROM friend,user where (from_id= $id and to_id= $id2) or (to_id='$id' and from_id='$id2') and user.name LIKE '%{$searchTerm}%'");
                $row3 = mysqli_fetch_assoc($sql4);
                if (empty($row3) || ($row3['status'] == 0 && $row3['from_user'] == NULL)) {
                    $output = '<div class="content" style="padding-top:10px">
                            <img src="./assets/img/' . $row2['img'] . '" style="width:50px; height:50px" alt="">
                            <span>' . $row2['name'] . '</span>
            
                            <div class="details">
                            <a style="color:#3578E5;float:right;" href="core/follow.php?to_id=' . $row2['id_user'] . '">
                                Add friend 
                            </a>
                            </div>
                        </div>';
                }
            }
        }
    }
} else {
    $output .= 'No user found related to your search term';
}
echo $output;
