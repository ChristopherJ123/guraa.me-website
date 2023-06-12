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
</head>

<body>
    <a class="register-back" href="index.php">
        <img src="assets/Back_arrow.svg" alt="" />
    </a>
    <div class="register-body">
        <div class="profile-container border-gui" style="display: flex; flex-direction: column;">
            <?php if (isset($_SESSION["username_s"])) {
                $query = "SELECT * FROM users WHERE username = '{$_SESSION['username_s']}'";
                $query_result = mysqli_query($conn, $query);
                $credentials = mysqli_fetch_assoc($query_result);
            ?>
                <div class="profile-username">
                    <div>
                        <img class="profile-picture" src="assets/Blank_Profile.webp" alt="Blank_Profile">
                    </div>
                    <div>Hello, <?= $_SESSION['username_s'] ?>. </div>
                </div>
                <div>Username: <?= $_SESSION['username_s'] ?> </div>
                <div>Email: <?= $credentials['email'] ?> </div>
                <div>Register date: <?= $credentials['register_date'] ?> </div>
            <?php } else { ?>
                <div>You are not logged in!</div>
            <?php } ?>
        </div>
    </div>
</body>

</html>