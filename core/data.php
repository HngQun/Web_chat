<?php
ob_start();
if ($flag == true) {
    while ($row = mysqli_fetch_assoc($query10)) {
        $idgroup = $row['id'];
        $sql4 = "SELECT * FROM room,user_room WHERE room.id = $idgroup and user_room.id_user = {$row['id_user']}";
        $query4 = mysqli_query($conn, $sql4);
        $namegroup = "";

        while ($row4 = mysqli_fetch_assoc($query4)) {
            if ($row4['namegr'] == NULL || $row4['namegr'] == '') {
                $name = $row4['namegr'];
                $namegroup .= $name . " ";
            } else {
                $namegroup = $row4['namegr'];
            }
        }

        $sql3 = "SELECT * FROM message WHERE id_room = $idgroup ORDER BY message.id DESC LIMIT 1";
        $query3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_assoc($query3);
        $result = ($row3) ? $row3['msg'] : "No message available";
        $msg = (strlen($result) > 28) ? substr($result, 0, 28) . '...' : $result;

        if (isset($row2['from_id'])) {
            $you = ($row3['from_id'] == $outgoing_id) ? "You: " : "";
        } else {
            $you = "";
        }
        
        $offline = (isset($row3['status']) && $row3['status'] == "Offline now") ? "offline" : "";
        $hid_me = ($outgoing_id == $row['id_user']) ? "hide" : "";

        $output .= '<a href="chatgroup.php?group_id=' . $row['id'] . '">
            <div class="content">
                <img src="./assets/img/anhgroup.jpeg" alt="#">
                <div class="details">
                    <span>' . $namegroup . '</span>
                    <p>' . $you . $msg . '</p>
                </div>
            </div>
            <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
        </a>';
    }
}


while ($row = mysqli_fetch_assoc($query)) {
    $sql2 = "SELECT * FROM message WHERE (to_id = {$row['id_user']}
    OR from_id = {$row['id_user']}) AND (from_id = {$outgoing_id} 
    OR to_id = {$outgoing_id}) ORDER BY id DESC LIMIT 1";
    $query2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($query2);

    $sql3 = "SELECT * FROM user WHERE id_user = {$row['id_user']}";
    $query3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_assoc($query3);

    $result = (mysqli_num_rows($query2) > 0) ? $row2['msg'] : "No message available";
    $msg = (strlen($result) > 28) ? substr($result, 0, 28) . '...' : $result;

    if (isset($row2['from_id'])) {
        ($outgoing_id == $row2['from_id']) ? $you = "You: " : $you = "";
    } else {
        $you = "";
    }

    $offline = ($row3['status'] == "Offline now") ? "offline" : "";
    $hid_me = ($outgoing_id == $row['id_user']) ? "hide" : "";

    if (isset($row2['status']) && $row2['status'] == 1 || $you != "") {
        $output .= '<a href="index.php?id_user=' . $row['id_user'] . '">
        <div class="content">
        <img src="./assets/img/' . $row['img'] . '" alt="">
        <div class="details">
            <span>' . $row['name'] . '</span>
            <p>' . $you . $msg . '</p>
        </div>
        </div>
        <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
    </a>
    <script>
    document.title = "Demo freetut title";
    </script>';
    } else {
        $output .= '<a href="index.php?id_user=' . $row['id_user'] . '">
        <div class="content">
        <img src="./assets/img/' . $row['img'] . '" alt="">
        <div class="details">
            <span>' . $row['name'] . '</span>
            <p><b>' . $you . $msg . '</b></p>
        </div>
        </div>
        <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
    </a>
    <script>
    document.title = "Demo freetut title";
    </script>';
    }
}
