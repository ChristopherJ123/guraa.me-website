<?php

include "scripts/database.php";
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guramee Website</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <a class="register-back" href="index.php">
        <img src="assets/Back_arrow.svg" alt="" />
    </a>
    <div class="middle-screen">
        <div class="messages-container border-gui">
            <div class="inventory-container" id="friends-output">
                <div style="font-size: 24px;">Friends:</div>
                <?php
                // Check if you have friends :<
                $query = "
                SELECT f.user_id AS adder_id, f.friend_id AS accepter_id, f.status_id AS friends_status, u.username AS adder_username, u2.username AS accepter_username, uo.status_id AS accepter_online_status, uo2.status_id AS adder_online_status
                FROM friends f
                JOIN users u
                ON u.user_id = f.user_id
                JOIN users u2
                ON u2.user_id = f.friend_id
                JOIN users_online uo
                ON uo.user_id = f.friend_id
                JOIN users_online uo2
                ON uo2.user_id = f.user_id
                WHERE u.username = '{$_SESSION["username_s"]}' AND f.status_id = 1 OR u2.username = '{$_SESSION["username_s"]}' AND f.status_id = 1;
                ";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Check friends if you have some
                        if ($row['adder_username'] == $_SESSION["username_s"]) {
                            if ($row['accepter_online_status'] == 0) {
                                $html = "class='offline'";
                            } else {
                                $html = "class='online'";
                            }
                            echo "
                            <div class='input-box-big border-inventory' id='friend-user-{$row['accepter_username']}' style='justify-content: space-between;'>
                                <a href='profile.php?u={$row['accepter_username']}' style='margin: 0 10px;'>{$row['accepter_username']}</a>
                                <div style='margin: 0 10px;'>
                                    <img src='assets/Online_Indicator.svg' alt='online_indicator' style='width: 20px;' {$html}>
                                </div>
                            </div>";
                        } else {
                            if ($row['adder_online_status'] == 0) {
                                $html = "class='offline'";
                            } else {
                                $html = "class='online'";
                            }
                            echo "
                            <div class='input-box-big border-inventory' id='friend-user-{$row['adder_username']}' style='justify-content: space-between;'>
                                <a href='profile.php?u={$row['adder_username']}' style='margin: 0 10px;'>{$row['adder_username']}</a>
                                <div style='margin: 0 10px;'>
                                    <img src='assets/Online_Indicator.svg' alt='online_indicator' style='width: 20px;' {$html}>
                                </div>
                            </div>";
                        }
                    }
                }
                ?>
            </div>

            <div class="messages-area">
                <div style="font-size: 24px;" id="chat-user">Server chat:</div>
                <div class="border-inventory chat-text-area">
                    <div class="chat-messages" id="chat-output">
                        <?php
                        $query = "
                        SELECT sc.message_id, sc.user_id, sc.message, TIME(CONVERT_TZ(sc.time,'+00:00','+7:00')) as time, u.username FROM `server_chats` sc
                        JOIN users u
                        ON u.user_id = sc.user_id;
                        ";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "
                            <div class='chat-message'>
                            <i>{$row['time']}</i> <a href='profile.php?u={$row['username']}'><b>{$row['username']}</b></a> 
                                <div>{$row['message']}</div>
                            </div>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="chat-text-box">
                    <form action="" method="post" id="chat-text-box-form" style="width: 100%; margin-block-end: 0;">
                        <?php
                        if (isset($_SESSION["username_s"])) {
                            echo '<input type="text" name="chat_name" id="chat-input" class="input-box-big border-inventory" placeholder="Write a message" style="width: 100%;">';
                        } else {
                            echo '<input type="text" name="chat_name" readonly="readonly" class="input-box-big border-inventory" placeholder="Login to write a message" style="width: 100%;">';
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>