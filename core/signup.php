<?php
session_start();
include_once "Config.php";
$uname = mysqli_real_escape_string($conn, $_POST['uname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$cfpass = $_POST['cfpassword'];
date_default_timezone_set('Asia/Ho_Chi_Minh');
$today = date("y/m/d H:i:s");
if (!empty($uname) && !empty($email) && !empty($password)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = mysqli_query($conn, "SELECT * FROM user WHERE email = '{$email}'");
        if ($cfpass != $password) {
            echo "Incorrect password";
        } else {
            if (mysqli_num_rows($sql) > 0) {
                echo "$email - This email already exist!";
            } else {
                if (isset($_FILES['image'])) {
                    $img_name = $_FILES['image']['name'];
                    $img_type = $_FILES['image']['type'];
                    $tmp_name = $_FILES['image']['tmp_name'];

                    $img_explode = explode('.', $img_name);
                    $img_ext = end($img_explode);

                    $extensions = ["jpeg", "png", "jpg", "JPEG", "PNG", "JPG"];
                    if (in_array($img_ext, $extensions) === true) {
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        if (in_array($img_type, $types) === true) {
                            $time = time();
                            $new_img_name = $time . $img_name;
                            if (move_uploaded_file($tmp_name, "../assets/img/" . $new_img_name)) {
                                $ran_id = time();
                                $status = "Active now";
                                $encrypt_pass = md5($password);
                                $insert_query = mysqli_query($conn, "INSERT INTO user ( id_user, name, password , email, img, status, create_at )
                                VALUES ( '{$ran_id}', '{$uname}', '{$encrypt_pass}', '{$email}', '{$new_img_name}', '{$status}', '{$today}')");
                                if ($insert_query) {
                                    $select_sql2 = mysqli_query($conn, "SELECT * FROM user WHERE email = '{$email}'");
                                    if (mysqli_num_rows($select_sql2) > 0) {
                                        $result = mysqli_fetch_assoc($select_sql2);
                                        $_SESSION['id_user'] = $result['id_user'];
                                        echo "success";
                                    } else {
                                        echo "This email address not Exist!";
                                    }
                                } else {
                                    echo "Something went wrong. Please try again!" ;
                                }
                            }
                        } else {
                            echo "Please upload an image file - jpeg, png, jpg";
                        }
                    } else {
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                }
            }
        }
    } else {
        echo "$email is not a valid email!";
    }
} else {
    echo "All input fields are required!";
}
