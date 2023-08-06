<?php
session_start();
include_once "core/Config.php";
if (!isset($_SESSION['id_user'])) {
  header("location: login.php");
}
$id = $_SESSION['id_user'];
?>
<?php include_once "header.php"; ?>

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
            <span style="padding-left:10px;"><?php echo $row['name'] ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
        <a href="./" class="logout">back</a>
      </header>
      <div class="">
        <?php
        $sql = mysqli_query($conn, "SELECT * FROM user,friend where (  (friend.from_id = {$id} and user.id_user=friend.to_id) or (friend.to_id = {$id} and user.id_user=friend.from_id)) and friend.status='1' ");
        while ($row = mysqli_fetch_assoc($sql)) {
          if ($row['id_user'] != $_SESSION['id_user']) { ?>
            <div class="content" style="padding-top:10px">
              <img src="./assets/img/<?php echo  $row['img'] ?>" style="width:20px; height:20px" alt="">
              <span><?php echo $row['name'] ?></span>
              <div class="details">
                <form action="./core/group.php" method="post">
                  <input type="checkbox" name="<?php echo $row['id_user'] ?>">
              </div>
            </div>
        <?php }
        } ?>
      </div>
      <br>
      <input style="background-color:gray;color:white;padding:2px 5px;border-radius:4px;border:solid 1px gray" type="submit" value="Create">
      </form>
    </section>
  </div>
</body>

</html>