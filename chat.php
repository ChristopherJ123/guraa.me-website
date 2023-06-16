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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>

<body>
    <a class="register-back" href="index.php">
        <img src="assets/Back_arrow.svg" alt="" />
    </a>
    <div class="middle-screen">
        <div class="messages-container border-gui">
            <div class="inventory-container" id="friends-output">

                <!-- Friends tab -->
                <div style="font-size: 24px;">Friends:</div>

                <div class="inventory-container" style="padding: 4px; box-sizing:border-box; overflow-y: scroll; max-height: 40vh;">
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
                                <div class='input-box-big border-inventory' onclick='redirect(\"?u={$row['accepter_username']}\")' id='friend-user-{$row['accepter_username']}' style='justify-content: space-between;'>
                                    <a href='profile.php?u={$row['accepter_username']}' style='margin: 0 10px;'>{$row['accepter_username']}</a>
                                    <div style='margin: 0 10px;'>
                                        <img src='assets/Online_Indicator.svg' alt='online_indicator' style='width: 20px;' {$html}>
                                    </div>
                                </div>
                                ";
                            } else {
                                if ($row['adder_online_status'] == 0) {
                                    $html = "class='offline'";
                                } else {
                                    $html = "class='online'";
                                }
                                echo "
                                <div class='input-box-big border-inventory' onclick='redirect(\"?u={$row['adder_username']}\")' id='friend-user-{$row['adder_username']}' onclick='selectDirectChat(\"{$row['adder_username']}\")' style='justify-content: space-between;'>
                                    <a href='profile.php?u={$row['adder_username']}' style='margin: 0 10px;'>{$row['adder_username']}</a>
                                    <div style='margin: 0 10px;'>
                                        <img src='assets/Online_Indicator.svg' alt='online_indicator' style='width: 20px;' {$html}>
                                    </div>
                                </div>
                                ";
                            }
                        }
                    }
                    ?>
                </div>


                <!-- Servers tab -->
                <div style="font-size: 24px; margin-top:8px;">Servers:</div>

                <div class="inventory-container" style="padding: 4px; box-sizing:border-box; overflow-y: scroll; max-height: 40vh;">
                    <div class="inventory-container">
                        <?php
                        $query = "SELECT * FROM server_chat_names";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "
                                <div class='input-box-big border-inventory' onclick='redirect(\"?s={$row['name']}\")' style='justify-content: space-between;'>
                                    <div style='margin: 0 10px;'>{$row['name']}</div>
                                </div>
                                ";
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="new-server-chat shop-item-name" onclick="formOpen()" style="margin-top:10px; font-size:22px; cursor:pointer;">
                    Create a server
                </div>
                <div class="new-server-name">
                    <form id="server-name">
                        <input type=" text" id="new-server-name" onmouseleave="formClose()" class="input-box-big border-inventory" placeholder="Server name">
                    </form>
                </div>

                <div id="output"></div>
            </div>

            <div class="messages-area">
                <!-- Default msg -->
                <?php
                if (isset($_SESSION['username_s'])) {

                    $server = filter_input(
                        INPUT_GET,
                        's',
                        FILTER_SANITIZE_SPECIAL_CHARS
                    );
                    $user = filter_input(
                        INPUT_GET,
                        'u',
                        FILTER_SANITIZE_SPECIAL_CHARS
                    );

                    if (isset($server)) {
                        // Chat with server
                        $query = "SELECT * FROM server_chat_names WHERE name = '{$server}'";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);
                        $type = "server";
                ?>
                        <div style="font-size: 24px;" id="chat-user"><?= $row['name'] ?></div>
                        <div class="border-inventory chat-text-area" id="<?= $type ?>">

                            <div class="chat-messages" id="chat-output">
                                <?php
                                $query = "
                                SELECT sc.server_id, sc.user_id, sc.message, TIME(CONVERT_TZ(sc.time,'+00:00','+7:00')) as time, u.username
                                FROM `server_chats` sc
                                JOIN users u
                                ON u.user_id = sc.user_id
                                JOIN server_chat_names scn
                                ON scn.server_id = sc.server_id
                                WHERE scn.name = '{$server}'
                                ";
                                $result = mysqli_query($conn, $query);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "
                                        <div class='chat-message'>
                                        <i>{$row['time']}</i> <a href='profile.php?u={$row['username']}'><b>{$row['username']}</b></a> 
                                            <div>{$row['message']}</div>
                                        </div>
                                        ";
                                    }
                                }
                                ?>
                                <div id="anchor"></div>
                            </div>

                        </div>

                    <?php
                    } else if (isset($user)) {
                        // Chat with user
                        $type = "direct";
                    ?>
                        <div style="font-size: 24px;" id="chat-user"><?= $user ?></div>
                        <div class="border-inventory chat-text-area" id="<?= $type ?>">

                            <div class="chat-messages" id="chat-output">
                                <?php
                                $query = "
                                SELECT dc.time, u.username, dc.message
                                FROM direct_chats dc
                                JOIN users u
                                ON dc.user_id = u.user_id
                                JOIN users u2
                                ON dc.friend_id = u2.user_id
                                WHERE u.username = '{$_SESSION['username_s']}' AND u2.username = '{$user}' OR u.username = '{$user}' AND u2.username = '{$_SESSION['username_s']}'
                                ";
                                $result = mysqli_query($conn, $query);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "
                                        <div class='chat-message'>
                                        <i>{$row['time']}</i> <a href='profile.php?u={$row['username']}'><b>{$row['username']}</b></a> 
                                            <div>{$row['message']}</div>
                                        </div>
                                        ";
                                    }
                                }
                                ?>
                                <div id="anchor"></div>
                            </div>

                        </div>

                    <?php
                    } else {
                        // Default chat = server chat = 1
                        $query = "SELECT name FROM server_chat_names WHERE server_id = 1";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);
                        $type = "server";
                    ?>
                        <div style="font-size: 24px;" id="chat-user"><?= $row['name'] ?></div>
                        <div class="border-inventory chat-text-area" id="<?= $type ?>">

                            <div class="chat-messages" id="chat-output">
                                <?php
                                $query = "
                                SELECT sc.server_id, sc.user_id, sc.message, TIME(CONVERT_TZ(sc.time,'+00:00','+7:00')) as time, u.username
                                FROM `server_chats` sc
                                JOIN users u
                                ON u.user_id = sc.user_id
                                WHERE sc.server_id = {$_SESSION['server_id_s']}
                                ";
                                $result = mysqli_query($conn, $query);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "
                                        <div class='chat-message'>
                                        <i>{$row['time']}</i> <a href='profile.php?u={$row['username']}'><b>{$row['username']}</b></a> 
                                            <div>{$row['message']}</div>
                                        </div>
                                        ";
                                    }
                                }
                                ?>
                                <div id="anchor"></div>
                            </div>

                        </div>
                    <?php
                    }
                    ?>

                    <div class="chat-text-box">
                        <form method="post" id="chat-text-box-form" style="width: 100%; margin-block-end: 0;">
                            <?php
                            if (isset($_SESSION["username_s"])) {
                                echo '<input type="text" name="chat_name" id="chat-input" class="input-box-big border-inventory" placeholder="Write a message" style="width: 100%;">';
                            } else {
                                echo '<input type="text" name="chat_name" readonly="readonly" class="input-box-big border-inventory" placeholder="Login to write a message" style="width: 100%;">';
                            }
                            ?>
                        </form>
                    </div>
                <?php
                } else {
                    echo "Please select a chat";
                }
                ?>
            </div>

        </div>
    </div>
</body>

<script src="chat.js"></script>

<?php
if (isset($_SESSION["username_s"])) {
    echo "<script src='scripts/user_is_online.js'></script>";
}
?>

</html>