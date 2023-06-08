<?php

include "database.php";
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
                    $query = "SELECT * FROM users WHERE username = '{$_SESSION['username_s']}'";
                    $query_result = mysqli_query($conn, $query);
                    $credentials = mysqli_fetch_assoc($query_result);
                ?>
                    <div class="friends-panel">
                        <div>Friends online:</div>
                    </div>
                    <div class="add-panel" style="display: none;">
                        <div> Add a friend:</div>
                        <div>
                            <form style="display: flex;" id="friend-search-form">
                                <input type="search" name="search_name" id="" class="input-box border-inventory" placeholder="Username" onkeyup="searchHint(this.value)" required>
                                <input type="submit" class="border-button-no-outline" value="Submit">
                            </form>
                            <div class="inventory-container" id="search-output"></div>
                            <div class="text-container" id="friends-output" style="width: 320px; display: none;"></div>
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

</html>