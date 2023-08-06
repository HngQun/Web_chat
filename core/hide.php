<?php
ob_start();
include_once "Config.php";

// Nhận dữ liệu từ yêu cầu AJAX
$id = mysqli_real_escape_string($conn, $_POST['id']);

// Thực hiện truy vấn SQL để thay đổi cơ sở dữ liệu
$sql = "UPDATE message SET hidden='1' WHERE id='$id'";
$sql1 = mysqli_query($conn, $sql);

