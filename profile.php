<?php

include "scripts/database.php";
session_start();

if (isset($_GET['u'])) {
    $username = $_GET['u'];
} else {
    $username = $_SESSION['username_s'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guramee Website</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <a class="register-back" href="javascript:history.back()">
        <img src="assets/Back_arrow.svg" alt="" />
    </a>
    <div class="register-body">
        <div class="profile-container border-gui" style="display: flex; flex-direction: column;">

            <?php if (isset($username) && $username != $_SESSION["username_s"]) {
                $query = "
                SELECT *, CONVERT_TZ(uo.last_seen_time,'+00:00','+7:00') as converted_last_seen_time
                FROM users u
                JOIN users_online uo
                ON uo.user_id = u.user_id
                WHERE u.username = '{$username}'
                ";
                $query_result = mysqli_query($conn, $query);
                $userinfo = mysqli_fetch_assoc($query_result);
                if ($userinfo['status_id'] == 0) {
                    $status = "Offline";
                    $lastseen = $userinfo['converted_last_seen_time'];
                    $html = $status;
                } else {
                    $status = "Online";
                    $lastseen = "Now";
                    $html = $status;
                }
            ?>

                <div class="profile-username">
                    <div>
                        <img class="profile-picture" src="assets/Blank_Profile.webp" alt="Blank_Profile">
                    </div>
                    <div><?= $userinfo['username'] ?>. </div>
                </div>
                <div>Username: <?= $userinfo['username'] ?> </div>
                <div>Register date: <?= $userinfo['register_date'] ?> </div>
                <div>Online status: <?= $status ?> <img src='assets/Online_Indicator.svg' alt='online_indicator' style='width: 20px;' class='<?= $html ?>'> </div>
                <div>Last seen: <?= $lastseen ?> </div>
                <div>Time spent on website: <?= $userinfo['total_time'] ?> </div>

            <?php } else if ($username == $_SESSION["username_s"] || isset($_SESSION["username_s"])) {
                $query = "
                SELECT *, CONVERT_TZ(uo.last_seen_time,'+00:00','+7:00') as converted_last_seen_time
                FROM users u
                JOIN users_online uo
                ON uo.user_id = u.user_id
                WHERE u.username = '{$username}'
                ";
                $query_result = mysqli_query($conn, $query);
                $userinfo = mysqli_fetch_assoc($query_result);
                if ($userinfo['status_id'] == 0) {
                    $status = "Offline";
                    $lastseen = $userinfo['converted_last_seen_time'];
                    $html = $status;
                } else {
                    $status = "Online";
                    $lastseen = "Now";
                    $html = $status;
                }
            ?>

                <div class="profile-username">
                    <div>
                        <img class="profile-picture" src="assets/Blank_Profile.webp" alt="Blank_Profile">
                    </div>
                    <div>Hello, <?= $userinfo['username'] ?>. </div>
                </div>
                <div>Username: <?= $userinfo['username'] ?> </div>
                <div>Email: <?= $userinfo['email'] ?> </div>
                <div>Register date: <?= $userinfo['register_date'] ?> </div>
                <div>Online status: <?= $status ?> <img src='assets/Online_Indicator.svg' alt='online_indicator' style='width: 20px;' class='<?= $html ?>'> </div>
                <div>Last seen: <?= $lastseen ?> </div>
                <div>Time spent on website: <?= $userinfo['total_time'] ?> </div>

            <?php } else { ?>
                <!-- TODO create guest profile page -->
                <div>You are not logged in!</div>
            <?php } ?>
        </div>
    </div>
</body>

<?php
if (isset($_SESSION["username_s"])) {
    echo "<script src='scripts/user_is_online.js'></script>";
}
?>

</html>