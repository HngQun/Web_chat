<?php
    ob_start();
    session_start();
    include_once "Config.php";
    $group_id=isset($_POST['group_id'])? $_POST["group_id"]: '';
    $outgoing_id=$_SESSION['id_user'];
    if(isset($_FILES['image'])){
        $img_name = $_FILES['image']['name'];
        $img_type = $_FILES['image']['type'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $img_explode = explode('.',$img_name);
        $img_ext = end($img_explode);
        $extensions = ["jpeg", "png", "jpg","JPEG","PNG","JPG","MP4","mp4","mov","MOV","WMV","wmv"];
        if(in_array($img_ext, $extensions) === true){
            $types = ["image/jpeg", "image/jpg", "image/png","image/JPEG","image/PNG","image/JPG","video/MP4","video/mp4","video/mov","video/wmv    ",];
            if(in_array($img_type, $types) === true){
                $time = time();
                $new_img_name = $time.$img_name;
                if(move_uploaded_file($tmp_name,"file/".$new_img_name)){
                    $ran_id = rand(time(), 100000000);
                    $status = "Active now";
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $today = date("y/m/d H:i:s");
                    $insert_query = mysqli_query($conn, "INSERT INTO message (from_id, id_room, msg, id_type,                                   status, hidden, create_at)
                                                        VALUES ({$outgoing_id}, {$group_id}, '{$new_img_name}',2 ,0 ,0 ,'{$today}')");
                    header("location:../chatgroup.php?group_id=$group_id");
                    }else{
                        echo "Something went wrong. Please try again!";
                    }
                }
            }else{
                echo "Please upload an image file - jpeg, png, jpg";
            }
        }else{
            echo "Please upload an image file - jpeg, png, jpg";
        }
