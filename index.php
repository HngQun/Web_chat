<?php
ob_start();
session_start();
include_once "core/Config.php";
if (!isset($_SESSION['id_user'])) {
  header("location:login.php");
}
$myId = $_SESSION['id_user'];
include_once "header.php";
?>

<style>
  .dialog {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    visibility: hidden;
    opacity: 0;
    transition: opacity linear 0.2s;
  }

  .overlay {
    background-color: rgba(0, 0, 0, 0.5);
  }

  .dialog-body {
    max-width: 400px;
    position: relative;
    padding: 16px;
    background-color: #fff;
  }

  .dialog:target {
    visibility: visible;
    opacity: 1;
  }

  .close {
    position: absolute;
    font-size: 40px;
    top: 90%;
    right: 30%;
  }
  .share{
    position: absolute;
    font-size: 20px;
    top: 90%;
    left: 30%;
  }
  .hidden-message {
    display: none;
  }
</style>

<body>
  <div id="kq"></div>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php
        if (isset($_GET['id_user'])) {
          $id_user = mysqli_real_escape_string($conn, $_GET['id_user']);
          // Tiếp tục xử lý
        }
        else{
          $id_user = $_SESSION['id_user'];
        }
        $sql = mysqli_query($conn, "SELECT * FROM user WHERE id_user = {$id_user}");
        if (mysqli_num_rows($sql) > 0) {
          $row = mysqli_fetch_assoc($sql);
        } else {
          echo '<script>window.location.href = "users.php";</script>';
        }

        $sql7 = mysqli_query($conn, "SELECT * FROM friend WHERE (from_id = {$id_user} and to_id= {$myId}) or (from_id = {$myId} and to_id= {$id_user})");
        if (mysqli_num_rows($sql7) > 0) {
          $row7 = mysqli_fetch_assoc($sql7);
        } else {
          // Chuyển hướng người dùng đến trang "users.php"
          echo '<script>window.location.href = "users.php";</script>';
          exit();
        }
        ?>

        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="./assets/img/<?php echo $row['img']; ?>" alt="">
        <div class="details" style="width:90%;position:relative;">
          <span><?php echo $row['name']; ?></span>
          <p style="font-size:13px;"><?php echo $row['status']; ?></p>
          <a href="#my-dialog" id="myBtn" style="position:absolute;right:10px;top:0px; ">

            <input type="text" id="idcall" value="<?php echo $row7['id_call']; ?>" hidden>
            <input type="text" id="myId" value="<?php echo $myId; ?>" hidden>

            <span class="material-symbols-outlined" style="float: right; font-size: 35px; padding-top: 5px;">
              video_call
            </span>
          </a>
          <div class="dialog overlay" id="my-dialog">
            <div class="dialog-body">

              <a href="#my-dialog" class="share" id="share"><img src="./assets/img/computer-screen.jpg" alt="#"></a>
              <a href="#" class="close" id="close"><img src="./assets/img/hang-up.jpg" alt="#"></a>

              <video id="user-1" playsinline autoplay style=" width: 400px; height: 250px; margin-bottom: 20px;margin-top:20px;"></video>
              <video id="user-2" playsinline autoplay style=" width: 400px; height: 250px;"></video>

              <div style="display:none;">
                <button id="create-offer">Create Offer</button>
                <label>SDP Offer</label>
                <textarea id="offer-sdp"></textarea>

                <button id="create-answer">Create Answer</button>
                <label>SDP Answer</label>
                <textarea id="answer-sdp"></textarea>

                <button id="add-answer">Add Answer</button>
              </div>
            </div>
          </div>
        </div>
      </header>
      <div class="chat-box" id="chat_box">

      </div>

      

      <form action="./core/chatimg.php" id="chat_img" method="post" enctype="multipart/form-data" autocomplete="off" style="position:absolute;margin-top: 30px;margin-left:5px;float:left; width:30px; height: 30px;">
        <input type="hidden" name="iduser" value="<?php echo $id_user ?>">
        <span class="material-symbols-outlined" style="width:30px; height: 30px;">
          <input type="file" onchange="form.submit()" style="position:absolute; width:30px; height: 30px; opacity:0 ;" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg,image/png,image/PNG,video/mp4,video/mov,video/wmv" required>
          attach_file
        </span>
      </form>

      <form action="#" class="typing-area" id="chat_form" style="float:left; width: 100%;">
        <input type="text" class="incoming_id" name="incoming_id" id="userId" value="<?php echo $id_user; ?>" hidden>
        <input type="text" name="message" id="chat_message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button type="submit"><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="./assets/js/agora-rtm-sdk-1.5.1.js"></script>
  <script src="./assets/js/videochat.js"></script>
  <script src="./assets/js/chat.js"></script>
  <script src="./assets/js/hide-mess.js"></script>

</body>

</html>