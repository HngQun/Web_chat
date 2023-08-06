<?php
ob_start();
session_start();
if (isset($_SESSION['id_user'])) {
    include_once "Config.php";
    $outgoing_id = $_SESSION['id_user'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $sql1 = mysqli_query($conn, "UPDATE message SET status=1 WHERE from_id='$incoming_id' and to_id='$outgoing_id'");
    $output = "";
    $sql = "SELECT *,DATE_FORMAT(message.create_at, '%r') FROM message LEFT JOIN user ON user.id_user = message.from_id
                WHERE (from_id = {$outgoing_id} AND to_id = {$incoming_id})
                OR (from_id = {$incoming_id} AND to_id = {$outgoing_id}) ORDER BY message.id";
    $query = mysqli_query($conn, $sql);
    $query1 = mysqli_query($conn, $sql);
    $query2 = mysqli_query($conn, "SELECT * FROM user WHERE id_user = {$incoming_id}");
    $img1 = null;
    while ($img = mysqli_fetch_assoc($query2)) {
        $img1 = $img['img'];
    }
    $count = 0;
    while ($row = mysqli_fetch_assoc($query1)) {
        if ($row['from_id'] === $outgoing_id) {
            $count++;
        }
    }
    $count1 = 0;
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $img = $row['msg'];
            $img_explode = explode('.', $img);
            $img_ext = end($img_explode);


            // $output .= '<div class="chat outgoing">
            //                         <div class="details" onclick="toggleMessage(this)">
            //                             <p id="' . $row['id'] . '">' . $row['msg'] . '<span style="position: relative;top:17px;left:7px;float:right;font-size:11px;">' . $row["DATE_FORMAT(message.create_at, '%r')"] . '</span></p>
            //                         </div>
            //                         </div>';

            if ($row['from_id'] === $outgoing_id) {
                $count1++;
                if ($count1 == $count) {
                    if ((($img_ext == 'jpeg') || ($img_ext == 'JPEG') || ($img_ext == 'jpg') || ($img_ext == 'JPG') || ($img_ext == 'PNG') || ($img_ext == 'png')) && $row['id_type'] == 2) {
                        $output .= '<div class="chat outgoing">
                                    <div class="details">
                                        <img style="border-radius:5px;width:270px;height:180px;position: relative;top:10px;right:15px;" src="./core/file/' . $row['msg'] . '"><span style="position: relative;top:17px;left:7px;float:right;font-size:11px;">' . $row["DATE_FORMAT(message.create_at, '%r')"] . '</span>
                                    </div>
                                    </div>';
                    } elseif ((($img_ext == 'mp4') || ($img_ext == 'MP4') || ($img_ext == 'mov') || ($img_ext == 'mov') || ($img_ext == 'wmv') || ($img_ext == 'WMV')) && $row['id_type'] == 2) {
                        $output .= '<div class="chat outgoing">
                                    <div class="details">
                                        <a href="./view.php?vid_id=' . $row['msg'] . '&to_id=' . $incoming_id . '"><img style="border-radius:5px;width:100px;height:100px;position: relative;top:10px;right:15px;" src="./assets/img/iconplay.png" /></a><span style="position: relative;top:100px;left:-10px;float:right;font-size:11px;">' . $row["DATE_FORMAT(message.create_at, '%r')"] . '</span>
                                    </div>
                                    </div>';
                    } elseif($row['hidden'] == 1){
                        $output .= '<div class="chat outgoing">
                                    <div class="details">
                                        <p>Đã thu hồi.</p>
                                    </div>
                                    </div>';
                    } else {
                        $output .= '<div class="chat outgoing">
                                    <div class="details" onclick="toggleMessage(this)">
                                        <p id="' . $row['id'] . '">' . $row['msg'] . '<span style="position: relative;top:17px;left:7px;float:right;font-size:11px;">' . $row["DATE_FORMAT(message.create_at, '%r')"] . '</span></p>
                                    </div>
                                    </div>';
                    }
                } else {
                    if ((($img_ext == 'jpeg') || ($img_ext == 'JPEG') || ($img_ext == 'jpg') || ($img_ext == 'JPG') || ($img_ext == 'PNG') || ($img_ext == 'png')) && $row['id_type'] == 2) {
                        $output .= '<div class="chat outgoing">
                                    <div class="details">
                                        <img style="border-radius:5px;width:270px;height:180px;position: relative;top:10px;right:15px;" src="./core/file/' . $row['msg'] . '"><span style="position: relative;top:17px;left:7px;float:right;font-size:11px;">' . $row["DATE_FORMAT(message.create_at, '%r')"] . '</span>
                                    </div>
                                    </div>';
                    } elseif ((($img_ext == 'mp4') || ($img_ext == 'MP4') || ($img_ext == 'mov') || ($img_ext == 'mov') || ($img_ext == 'wmv') || ($img_ext == 'WMV')) && $row['id_type'] == 2) {
                        $output .= '<div class="chat outgoing">
                                    <div class="details">
                                        <a href="./view.php?vid_id=' . $row['msg'] . '&to_id=' . $incoming_id . '"><img style="border-radius:5px;width:100px;height:100px;position: relative;top:10px;right:15px;" src="./assets/img/iconplay.png" /></a><span style="position: relative;top:100px;left:-10px;float:right;font-size:11px;">' . $row["DATE_FORMAT(message.create_at, '%r')"] . '</span>
                                    </div>
                                    </div>';
                    } elseif($row['hidden'] == 1){
                        $output .= '<div class="chat outgoing">
                                    <div class="details">
                                        <p>Đã thu hồi.</p>
                                    </div>
                                    </div>';
                    } else {
                        $output .= '<div class="chat outgoing">
                                    <div class="details" onclick="toggleMessage(this)">
                                        <p id="' . $row['id'] . '">' . $row['msg'] . '<span style="position: relative;top:17px;left:7px;float:right;font-size:11px;">' . $row["DATE_FORMAT(message.create_at, '%r')"] . '</span></p>
                                    </div>
                                    </div>';
                    }
                }
            } else {
                if ((($img_ext == 'jpeg') || ($img_ext == 'JPEG') || ($img_ext == 'jpg') || ($img_ext == 'JPG') || ($img_ext == 'PNG') || ($img_ext == 'png')) && $row['id_type'] == 2) {
                    $output .= '<div class="chat incoming">
                                <img src="./assets/img/' . $row['img'] . '" alt="#">
                                <div class="details">
                                    <img style="border-radius:5px;width:270px;height:180px;position: relative;top:10px;right:0px;" src="./core/file/' . $row['msg'] . '"><span style="position: relative;top:17px;left:7px;float:right;font-size:11px;">' . $row["DATE_FORMAT(message.create_at, '%r')"] . '</span>
                                </div>
                                </div>';
                } elseif ((($img_ext == 'mp4') || ($img_ext == 'MP4') || ($img_ext == 'mov') || ($img_ext == 'mov') || ($img_ext == 'wmv') || ($img_ext == 'WMV')) && $row['id_type'] == 2) {
                    $output .= '<div class="chat incoming">
                                <img src="./assets/img/' . $row['img'] . '" alt="#">
                                <div class="details">
                                    <a href="./view.php?vid_id=' . $row['msg'] . '&to_id=' . $incoming_id . '"><img style="border-radius:5px;width:100px;height:100px;position: relative;top:10px;left:20px;" src="./assets/img/iconplay.png" /></a><span style="position: relative;top:100px;left:30px;float:right;font-size:11px;">' . $row["DATE_FORMAT(message.create_at, '%r')"] . '</span>
                                </div>
                                </div>';
                } elseif($row['hidden'] == 1) {
                    $output .= '<div class="chat incoming">
                                <img src="./assets/img/' . $row['img'] . '" alt="#">
                                <div class="details">
                                    <p>Đã bị thu hồi.</p>
                                </div>
                                </div>';
                } else {
                    $output .= '<div class="chat incoming">
                                <img src="./assets/img/' . $row['img'] . '" alt="#">
                                <div class="details">
                                    <p>' . $row['msg'] . '<span style="position: relative;top:17px;left:7px;float:right;font-size:11px;">' . $row["DATE_FORMAT(message.create_at, '%r')"] . '</span></p>
                                </div>
                                </div>';
                }
            }
        }
    } else {
        $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
    }
    echo $output;
} else {
    header("location: ../login.php");
}
