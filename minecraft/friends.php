<?php

include "scripts/database.php";
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>

<body>
    <a class="register-back" href="index.php">
        <img src="assets/Back_arrow.svg" alt="" />
    </a>
    <div class="register-body" style="flex-direction: column;">

        <div class="friends-container" style="display: flex; flex-direction: column;">
            <div class="friends-tabs">
                <div class="friends-tab top-tab-active">
                    <div>Friends</div>
                </div>
                <div class="friends-tab top-tab-inactive">
                    <div>Add</div>
                </div>
            </div>
            <div class="friends-container border-gui" style="display: flex; flex-direction: column; z-index: 1;">
                <?php if (isset($_SESSION["username_s"])) {
                ?>
                    <div class="friends-panel">
                        <div class="inventory-container" id="friends-output">
                            Friends:
                            <?php
                            // Check if you have friends :<
                            $query = "
                            SELECT f.user_id AS adder_id, f.friend_id AS accepter_id, f.status_id AS friends_status, u.username AS adder_username, u2.username AS accepter_username, uo.status_id AS online_status
                            FROM friends f
                            JOIN users u
                            ON u.user_id = f.user_id
                            JOIN users u2
                            ON u2.user_id = f.friend_id
                            JOIN users_online uo
                            ON uo.user_id = f.friend_id
                            WHERE u.username = '{$_SESSION["username_s"]}' AND f.status_id = 1 OR u2.username = '{$_SESSION["username_s"]}' AND f.status_id = 1;
                            ";
                            $result = mysqli_query($conn, $query);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    if ($row['adder_username'] == $_SESSION["username_s"]) {
                                        $html = "class='offline'";
                                        if ($row['online_status'] == 0) {
                                            $html = "class='offline'";
                                        } else {
                                            $html = "";
                                        }
                                        echo "
                                        <div class='input-box-big border-inventory' id='friend-user-{$row['accepter_username']}' style='justify-content: space-between;'>
                                            <div style='margin: 0 10px;'>{$row['accepter_username']}</div>
                                            <div style='margin: 0 10px;'>
                                                <img src='assets/Online_Indicator.svg' alt='online_indicator' style='width: 20px;' {$html}>
                                            </div>
                                        </div>";
                                    } else {
                                        echo "
                                        <div class='input-box-big border-inventory' id='friend-user-{$row['adder_username']}' style='justify-content: space-between;'>
                                            <div style='margin: 0 10px;'>{$row['adder_username']}</div>
                                            <div style='margin: 0 10px;'>
                                                <img src='assets/Online_Indicator.svg' alt='online_indicator' style='width: 20px;' {$html}>
                                            </div>
                                        </div>";
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div class="inventory-container">
                            Friends requests:
                            <?php
                            // Check if anyone's pending
                            $query = "
                            SELECT f.user_id AS 'pending_user_id', u2.username, f.status_id
                            FROM `friends` f
                            JOIN users u
                            ON u.username = '{$_SESSION["username_s"]}' AND f.friend_id = u.user_id AND f.status_id = 0
                            JOIN users u2
                            ON u2.user_id = f.user_id;
                            ";
                            $result = mysqli_query($conn, $query);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "
                                    <div class='input-box-big border-inventory' id='pending-user-{$row['username']}' style='justify-content: space-between;'>
                                        <div style='padding: 0 10px;'>{$row['username']}</div>
                                        <div style='padding: 0 10px; cursor: pointer; ' onclick='acceptFriend(\"{$row['username']}\")'><img src='assets/add_friends.svg' alt='add_friends.svg' width='30px'></div>
                                    </div>";
                                }
                            }
                            ?>
                            <div class="text-container" id="friends-warning-output" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="add-panel" style="display: none;">
                        <div> Add a friend:</div>
                        <div>
                            <form style="display: flex;" id="friend-search-form">
                                <input type="search" name="search_name" id="" class="input-box border-inventory" placeholder="Username" onkeyup="searchHint(this.value)" required>
                                <input type="submit" class="border-button-no-outline" value="Submit">
                            </form>
                            <div class="inventory-container" id="search-output"></div>
                            <div class="text-container" id="search-warning-output" style="max-width: 320px; display: none;"></div>
                        </div>
                    </div>

            </div>
        <?php } else { ?>
            <div>You are not logged in!</div>
        <?php } ?>
        </div>
    </div>
</body>

<script src="friends.js"></script>

<?php
if (isset($_SESSION["username_s"])) {
    echo "<script src='scripts/user_is_online.js'></script>";
}
?>

</html>