<?php
session_start();
include_once "core/Config.php";
if (!isset($_SESSION['id_user'])) {
  header("location: login.php");
}
if (isset($_SESSION['alert_message'])) {
  $alertMessage = $_SESSION['alert_message'];
  echo "<script>alert('$alertMessage');</script>";

  // Remove the alert message from the session
  unset($_SESSION['alert_message']);
}

include_once "header.php";
?>

<body>
  <div id="turn"></div>
  <div class="wrapper">
    <div id="kq"></div>
    <section class="users">
      <header>
        <div class="content">
          <?php
          $sql = mysqli_query($conn, "SELECT * FROM user WHERE id_user = {$_SESSION['id_user']}");
          if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
          }
          ?>
          <a href="infuser.php">
          <img src="./assets/img/<?php echo $row['img']; ?>" alt="#" style="float: left;">
          <div class="details" style="float: left;">
            <span><?php echo $row['name']; ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
          </a>
        </div>

        <!-- <div class="dropdown">
          <button onclick="myFunction()" class="dropbtn">Setting</button>

          <div id="myDropdown" class="dropdown-content">
            <a><label class="switch"><span style="font-size:12px;">change display</span>
                <input type="checkbox" onclick="turnon()">
                <span class="slider"></span>
              </label></a>
            <a href="infuser.php" style="font-size:13px;">personal information</a>
          </div>

        </div> -->

        <a href="./core/logout.php?logout_id=<?php echo $row['id_user']; ?>" class="logout">Logout</a>
      </header>

      <div style="background-color:#3578E5; padding:10px;width:115px;border-radius:5px;float:left;">
        <a href="follow.php" style="color:white">
          <p>Add friend</p>
        </a>
      </div>
      <div style="background-color:#3578E5; padding:10px;width:115px;border-radius:5px;float:right;">
        <a href="group.php" style="color:white">
          <p>Add Group</p>
        </a>
      </div>


      <?php $iduser = $_SESSION['id_user'];
      $sql2 = mysqli_query($conn, "SELECT * FROM friend WHERE from_id=$iduser or to_id=$iduser ") ?>
      <?php while ($row = mysqli_fetch_assoc($sql2)) {
        if ($row['from_user'] != 0 && $row['from_user'] != $iduser) {
          $follow = $row['from_id'];
          $sql3 = mysqli_query($conn, "SELECT * from user where id_user=$follow");
          $row2 = mysqli_fetch_assoc($sql3);
      ?>

          <div class="content" style="padding-top:10px;clear:left">
            <img src="./assets/img/<?php echo  $row2['img'] ?>" style="width:50px; height:50px" alt="">
            <span><?php echo $row2['name']; ?></span>

            <div class="details">
              <a style="color:#3578E5;clear:left;display:block;" href="./core/insert-follow.php?iduser=<?php echo $iduser ?>&iduser2=<?php echo $follow ?> ">Confirm</a>
            </div>
          </div>
      <?php }
      } ?>
      <br>


      <div class="search" style="display:block;">
        <input type="text" placeholder="Enter name to search...">
        <span class="text"> click to search for members</span>
        <button><i class="fas fa-search"></i></button>
      </div>

      <div class="users-list">

      </div>

    </section>
  </div>
  <script src="./assets/js/jquery-3.6.4.min.js"></script>
  <script src="./assets/js/users.js"></script>
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