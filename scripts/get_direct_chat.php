<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $friend = filter_input(
        INPUT_POST,
        'u',
        FILTER_SANITIZE_SPECIAL_CHARS
    );
    // TODO bikin perbedaan chat antara yang friend dan guest
    if (isset($_SESSION['username_s'])) {
        include('database.php');
        $query = "
        SELECT dc.time, u.username, dc.message
        FROM direct_chats dc
        JOIN users u
        ON dc.user_id = u.user_id
        JOIN users u2
        ON dc.friend_id = u2.user_id
        WHERE u.username = '{$_SESSION['username_s']}' AND u2.username = '{$friend}' OR u.username = '{$friend}' AND u2.username = '{$_SESSION['username_s']}'
        ";
        $result = mysqli_query($conn, $query);
        echo "<div style=\"font-size: 24px;\" id=\"chat-user\">{$friend}</div>,";
        // 
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
    } else {
        echo "You must log in first!";
    }
}
