<?php
session_start();
include_once "core/Config.php";
if (!isset($_SESSION['id_user'])) {
  header("location: login.php");
}
$id = $_SESSION['id_user'];
$group_id = $_GET['idgroup'];
?>
<?php include_once "header.php"; ?>

<body>
  <div id="kq"></div>
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <?php

          $sql = mysqli_query($conn, "SELECT * FROM room,user_room,user WHERE user_room.id_user= user.id_user and room.id=$group_id");
          ?>
          <img src="./assets/img/anhgroup.jpeg" alt="">
          <div class="details">
            <span style="padding-left:10px;">
              <?php
              $namegr = "";
              while ($value = mysqli_fetch_assoc($sql)) {
                if ($value['namegr'] == NULL || $value['namegr'] == '') {
                  $name = $value['namegr'];
                  $namegr .= $name . " ";
                } else {
                  $namegr = $value['namegr'];
                }
              }
              ?>
              <form action="core/update-group.php" method="post">
                <input type="hidden" name="idgr" value="<?php echo $group_id ?>">
                <input style="font-size:20px;2px 2px 2px 10px; border:solid 1px white;font-size:15px; width:150px;outline: none;" type="text" name="namegr" value="<?php echo $namegr ?>">
                <input type="submit" style="background-color:gray;color:white;" name="update" value="update">
              </form>
            </span>
          </div>
        </div>
        <a href="./" class="logout">back</a>
      </header>
      <div class="">
        <?php
        $sql4 = mysqli_query($conn, "SELECT * FROM room,user_room,user WHERE user_room.id_user= user.id_user and room.id=$group_id group by user_room.id_user");
        while ($row4 = mysqli_fetch_assoc($sql4)) {
          if ($row4['id_user'] != $id) {
        ?>
            <div class="content" style="padding-top:10px">
              <img src="./assets/img/<?php echo  $row4['img'] ?>" style="width:20px; height:20px" alt="">
              <span><?php echo $row4['name']; ?></span>
              <div class="details">
                <form action="core/delete-member.php" method="post">
                  <input type="hidden" name="idusr" value="<?php echo $row4['id_user'] ?>">
                  <input type="hidden" name="idgr" value="<?php echo $group_id ?>">
                  <input style="background-color:gray;font-size:13px;padding:4px ;color:white;border-radius:3px;" type="submit" value="delete">
                </form>
              </div>
            </div>
          <?php
          } else {
          ?>
            <div class="content" style="padding-top:10px">
              <img src="./assets/img/<?php echo  $row4['img'] ?>" style="width:20px; height:20px" alt="">
              <span><?php echo $row4['name'] ?></span>
              <div class="details">
              </div>
            </div>
        <?php  }
        }
        ?>

        </br>
        <hr>
        <?php
        $sql1 = mysqli_query($conn, "SELECT user.id_user FROM user LEFT JOIN user_room  on user.id_user = user_room.id_user where user_room.id_user IS NULL");
        while ($row1 = mysqli_fetch_assoc($sql1)) {
          $idfl = $row1['id_user'];
          $sql2 = mysqli_query($conn, "SELECT * from friend where (friend.from_id = {$id} and friend.to_id={$idfl}) or (friend.to_id = {$id} and friend.from_id={$idfl}) and friend.status='1' ");
          $row2 = mysqli_fetch_assoc($sql2);
          if (isset($row2['status']) == 1) {
            $sql3 = mysqli_query($conn, "SELECT * FROM user where user.id_user= $idfl");
            $row3 = mysqli_fetch_assoc($sql3);
        ?>
            <div class="content" style="padding-top:10px">
              <img src="./assets/img/<?php echo  $row3['img'] ?>" style="width:20px; height:20px" alt="">
              <span><?php echo $row3['name'] ?></span>
              <div class="details">
                <form action="core/insert-member.php" method="post">
                  <input type="checkbox" name="<?php echo $row3['id_user'] ?>">
              </div>
            </div>
        <?php }
        } ?>
      </div>
      <br>
      <input type="hidden" name="idgroup" value="<?php echo $group_id ?>">
      <input type="submit" value="Add members">
      </form>
    </section>
  </div>
</body>
</html>