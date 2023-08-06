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
    <section class="users">
      <header>
        <div class="content">
          <?php
          $sql = mysqli_query($conn, "SELECT * FROM user WHERE id_user = {$_SESSION['id_user']}");
          if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
          }
          ?>
          <img src="./assets/img/<?php echo $row['img']; ?>" alt="">
          <div class="details">
            <span style="padding-left:10px;"><?php echo $row['name']; ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
        <a href="./users.php" class="logout">back</a>
      </header>
      <div class="">
          <div class="search" style="display:block;">
            <input type="text" placeholder="Enter name to search...">
            <span class="text"> click to search for members</span>
            <button><i class="fas fa-search"></i></button>
          </div>

          <div class="users-list">

          </div>
          <br>
          <hr>
        <span class="text">friend list</span>
        <?php
        $sql = mysqli_query($conn, "SELECT * FROM user");

        while ($row = mysqli_fetch_assoc($sql)) {
          if ($row['id_user'] != $_SESSION['id_user']) { ?>

          
            <div class="content" style="padding-top:10px">
              <img src="./assets/img/<?php echo  $row['img'] ?>" style="width:50px; height:50px" alt="">
              <span><?php echo $row['name']; ?></span>

              <div class="details">
                <?php $id2 = $row['id_user'];
                $sql4 = mysqli_query($conn, "SELECT * FROM friend where (from_id=$id and to_id=$id2) or (to_id='$id' and from_id='$id2')");
                $row3 = mysqli_fetch_assoc($sql4);
                ?>
                <a style="color:#3578E5;float:right;" href="core/follow.php?to_id=<?php echo $row['id_user'] ?>">
                  <?php if (empty($row3) || ($row3['status'] == 0 && $row3['from_user'] == NULL)) { ?>Add friend 
                  <?php } elseif ($row3['status'] == 0 && $row3['from_user'] != NULL) { ?> pending approval 
                  <?php } else { ?> unfriend <?php } ?>
                </a>
              </div>
            </div>
        <?php }
        } ?>
      </div>
    </section>
  </div>
  <script src="./assets/js/jquery-3.6.4.min.js"></script>    
  <script src="./assets/js/follow.js"></script>

</body>

</html>