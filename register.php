<?php
session_start();
include_once "core/Config.php";
if (isset($_SESSION['id_user'])) {
    header("location: login.php");
}
include_once "header.php";
?>

    <div class="wrapper">
        <section class="form signup">
            <header>ChatApp HngQun</header>
            <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text" id="error"></div>

                <div class="field input">
                    <label>User Name</label>
                    <input type="text" name="uname" placeholder="User name" required>
                </div>

                <div class="field input">
                    <label>Email Address</label>
                    <input type="text" name="email" placeholder="Enter your email" required>
                </div>

                <div class="field input">
                    <label>Password</label>
                    <input type="password" id="pswd1" name="password" placeholder="Enter new password" required>
                    <i class="fas fa-eye"></i>
                </div>

                <div class="field input">
                    <label>Confirm Password</label>
                    <input type="password" id="pswd2" name="cfpassword" placeholder="Confirm the password" required>
                </div>
                <div class="field image">
                    <label>Select Image</label>
                    <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
                </div>

                <div class="field button">
                    <input type="submit" name="submit" value="Continue to Chat">
                </div>

            </form>
            <div class="link">Already signed up? <a href="login.php">Login now</a></div>
        </section>
    </div>
    <script src="./assets/js/jquery-3.6.4.min.js"></script>
    <script src="./assets/js/pass-show-hide.js"></script>
    <script src="./assets/js/signup.js"></script>

</body>

</html>