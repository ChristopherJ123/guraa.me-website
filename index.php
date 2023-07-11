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
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; margin:50px">
        <div style="display: flex; justify-content:flex-start; align-items: center; gap: 30px;">
            <a href="friends.php" class="border-gui" style="padding: 5px;">Friends</a>
            <a href="chat.php" class="border-gui" style="padding: 5px;">Chat</a>
            <a href="shop.php" class="border-gui" style="padding: 5px;">Shop</a>
        </div>

        <div style="display: flex; justify-content:center; align-items: center; gap: 30px;">
            <a href="https://www.youtube.com/channel/UC4ZIYVSrF-OFJ-9uqbeHSzA">
                <img class="border-button" src="assets/guramee.jpg" alt="guramee" width="50px">
            </a>
            <div class="border-gui" style="padding: 5px;">
                <div>Hello, welcome to my website</div>
            </div>
        </div>

        <div style="display: flex; justify-content:flex-end; align-items: center; gap: 30px;">
            <?php if (isset($_SESSION["username_s"])) {
            ?>
                <div class="border-gui login-profile-dropdown" style="padding: 5px;">
                    <div class="login-profile-dropbtn">Welcome, <?= $_SESSION["username_s"]; ?></div>
                    <div class="login-profile-dropdown-content border-gui">
                        <div>Hello, <?= $_SESSION["username_s"]; ?> </div>
                        <div style="overflow-wrap:break-word;"> <?= $_SESSION["email_s"]; ?> </div>
                        <a class="border-button" href="profile.php">View profile</a>
                        <a class="border-button" href="friends.php">Friends</a>
                        <a class="border-button" href="chat.php">Messages</a>
                        <a class="border-button" href="scripts/logout.php">Logout</a>
                    </div>
                </div>
            <?php } else { ?>
                <div class="border-gui" style="display: flex; box-sizing:content-box;">
                    <a class="login-item" href="login.php">Login</a>
                    <a class="login-item" href="register.php">Register</a>
                </div>
            <?php } ?>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; margin: 50px;">
        <div class="border-gui messages-area flex-gap-padding" style="max-width: 400px; width: unset;">
            <?php
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
                                WHERE sc.server_id = 1;
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
                        echo '<input type="text" name="chat_name" id="chat-input" class="input-box-big border-inventory" placeholder="Write a message" style="width: 100%;" autofocus>';
                    } else {
                        echo '<input type="text" name="chat_name" readonly="readonly" class="input-box-big border-inventory" placeholder="Login to write a message" style="width: 100%;">';
                    }
                    ?>
                </form>
            </div>
        </div>

        <div>
            <div class="border-gui flex-gap-padding" style="flex-direction: column; flex-wrap:wrap">
                <div> Here is my latest YouTube videos:</div>
                <div>
                    <iframe class="latestVideoEmbed" vnum='0' cid="UC4ZIYVSrF-OFJ-9uqbeHSzA" allowfullscreen></iframe>
                    <iframe class="latestVideoEmbed" vnum='1' cid="UC4ZIYVSrF-OFJ-9uqbeHSzA" allowfullscreen></iframe>
                    <iframe class="latestVideoEmbed" vnum='2' cid="UC4ZIYVSrF-OFJ-9uqbeHSzA" allowfullscreen></iframe>
                    <iframe class="latestVideoEmbed" vnum='3' cid="UC4ZIYVSrF-OFJ-9uqbeHSzA" allowfullscreen></iframe>
                    <iframe class="latestVideoEmbed" vnum='4' cid="UC4ZIYVSrF-OFJ-9uqbeHSzA" allowfullscreen></iframe>
                    <iframe class="latestVideoEmbed" vnum='5' cid="UC4ZIYVSrF-OFJ-9uqbeHSzA" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

</body>

<script src="chat.js"></script>
<script src="youtube.js"></script>

<?php
if (isset($_SESSION["username_s"])) {
    echo "<script src='scripts/user_is_online.js'></script>";
}
?>

</html>