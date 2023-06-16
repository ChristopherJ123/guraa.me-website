<?php

session_start();

if (isset($_SESSION['username_s'])) {
    include('database.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $server_name = filter_input(
            INPUT_POST,
            's',
            FILTER_SANITIZE_SPECIAL_CHARS
        );
        $message = filter_input(
            INPUT_POST,
            'msg',
            FILTER_SANITIZE_SPECIAL_CHARS
        );

        $query = "SELECT user_id FROM users WHERE username = '{$_SESSION['username_s']}'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $row_user = mysqli_fetch_assoc($result);

            $query = "SELECT server_id FROM server_chat_names scn WHERE name = '{$server_name}'";
            $result = mysqli_query($conn, $query);
            $row_server = mysqli_fetch_assoc($result);

            $query = "INSERT INTO `server_chats`(`server_id`, `user_id`, `message`) VALUES ({$row_server['server_id']}, {$row_user['user_id']}, '{$message}')";
            mysqli_query($conn, $query);
            echo "Success!";
        } else {
            echo "User does not exist.";
        }
    }
} else {
    echo "Please login first";
}
