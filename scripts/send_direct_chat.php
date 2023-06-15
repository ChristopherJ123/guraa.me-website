<?php

session_start();

if (isset($_SESSION['username_s'])) {
    include('database.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $friend = filter_input(
            INPUT_POST,
            'u',
            FILTER_SANITIZE_SPECIAL_CHARS
        );
        $message = filter_input(
            INPUT_POST,
            'msg',
            FILTER_SANITIZE_SPECIAL_CHARS
        );

        $query = "
        SELECT u.user_id AS user, u2.user_id AS friend
        FROM users u
        JOIN users u2
        ON u2.username = '{$friend}'
        WHERE u.username = '{$_SESSION['username_s']}'
        ";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $query = "INSERT INTO `direct_chats`(`user_id`, `friend_id`, `message`) VALUES ('{$row['user']}','{$row['friend']}','{$message}')";
            mysqli_query($conn, $query);
            echo "Success!";
        } else {
            echo "User does not exist = {$friend} {$_SESSION['username_s']}";
        }
    }
} else {
    echo "Please login first";
}
