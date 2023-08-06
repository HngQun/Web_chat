<?php
session_start();
include_once "core/Config.php";
if (!isset($_SESSION['id_user'])) {
  header("location: login.php");
}
?>
<?php include_once "header.php"; ?>

<body>
  <div id="turn"></div>
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
            <span><?php echo $row['name']; ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
        <div class="dropdown">
          <div id="myDropdown" class="dropdown-content">
            <a><label class="switch"><span style="font-size:12px;">change display</span>
                <input type="checkbox" onclick="turnon()">
                <span class="slider"></span>
              </label>
              <div id="kq"></div>
            </a>
            <a href="#" style="font-size:13px;">personal information</a>
          </div>
        </div>
      </header>
      </br>
      <form action="./core/updateinf.php" method="POST" enctype="multipart/form-data" autocomplete="off">
        <p style="float:left;">User name:</p>
        <input type="text" style="float:right;width:280px; height:30px;" name="name" value="<?php echo $row['name'] ?>">
        </br>
        </br>
        <p style="float:left;">Email:</p>
        <input type="text" style="float:right;width:280px; height:30px;" value="<?php echo $row['email'] ?>" disabled>
        </br>
        </br>
        <p style="float:left;">Pass change:</p>
        <input type="Password" style="float:right;width:280px; height:30px;" name="pass" value=""></br>
        </br>
        <p style="float:left;">Pass confirm:</p>
        <input type="Password" style="float:right;width:280px; height:30px;" name="passcf" value=""></br>
        </br>
        <label>Change Image:</label>
        <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" >
        </br>
        </br>
        <input type="submit" style="padding:3px 8px" name="save" value="save">
        <a href="users.php"><input type="button" style="padding:3px 8px" value="Back"></a>
      </form>
    </section>
  </div>

  </html>