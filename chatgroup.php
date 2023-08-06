<?php
session_start();
include_once "core/Config.php";
if (!isset($_SESSION['id_user'])) {
  header("location: login.php");
}
$id = $_SESSION['id_user'];

include_once "header.php";
?>

<body>
  <div id="kq"></div>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php
        $temp = 0;
        $group_id = mysqli_real_escape_string($conn, $_GET['group_id']);
        $_SESSION['group_id'] = $group_id;
        $sql11 = mysqli_query($conn, "SELECT * FROM user_room,room WHERE  user_room.id_user=$id and user_room.id_room={$group_id}");
        while ($row = mysqli_fetch_assoc($sql11)) {
          if (isset($row['id_user'])) {
            $temp += 1;
          }
        }
        if ($temp == 0) {
          header("location: users.php");
        }
        $sql = mysqli_query($conn, "SELECT * FROM user,user_room,room WHERE user.id_user = user_room.id_user and user_room.id_room={$group_id}");
        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="./assets/img/anhgroup.jpeg" alt="">
        <div class="details" style="width:90%;">

          <span>
            <?php
            $name = "";
            while ($value = mysqli_fetch_assoc($sql)) {
              if ($value['namegr'] == NULL || $value['namegr'] == '') {
                $namegr = $value['namegr'];
                $name .= $namegr . " ";
              } else {
                $name = $value['namegr'];
              }
            }
            echo "$name";
            ?>
          </span>

          <!-- <p style="font-size:13px;"><?php echo $row['status']; ?></p> -->
        </div>
        <div class="dropdown1" style="float:right">
          <button onclick="myFunction()" class="dropbtn">...</button>
          <div id="myDropdown" class="dropdown-content" style="  position: absolute;left:50%">
            <a href="insert-member-group.php?idgroup=<?php echo $group_id ?>" style="font-size:13px;">Manager group</a>
            <a href="./core/outgroup.php?idgroup=<?php echo $group_id ?>" style="font-size:13px;">Out group</a>
          </div>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="./core/chatgr-img.php" method="post" enctype="multipart/form-data" autocomplete="off" style="position:absolute;margin-top: 30px;margin-left:5px;float:left; width:30px; height: 30px;">
        <input type="hidden" name="group_id" value="<?php echo $group_id ?>">
        <span class="material-symbols-outlined" style="width:30px; height: 30px;">
          <input type="file" onchange="form.submit()" style="position:absolute; width:30px; height: 30px;opacity:0 ;" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg,image/png,image/PNG,video/mp4,video/mov,video/wmv" required>
          attach_file
        </span>
      </form>

      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" id="roomid" value="<?php echo $group_id ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="./assets/js/jquery-3.6.4.min.js"></script>
  <script src="./assets/js/chatgroup.js"></script>
  <script>
    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction() {
      document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }
  </script>

</body>

</html>