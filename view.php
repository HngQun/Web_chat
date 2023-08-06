<?php
session_start();
include_once "core/Config.php";
if (!isset($_SESSION['id_user'])) {
  header("location: login.php");
}
$vid = $_GET['vid_id'];
$to_id = $_GET['to_id'];
include_once "header.php";
?>

<body>
    <a href="index.php?id_user=<?php echo $to_id;?>" class="back-icon" style="position: absolute; top: 30px;left: 30px;font-size: 20px"><i class="fas fa-arrow-left"></i></a>
    <video src="./core/file/<?php echo $vid; ?>" width="720" height="360" controls autoplay></video>
</body> 
</html>