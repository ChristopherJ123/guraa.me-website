<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $server = filter_input(
        INPUT_POST,
        's',
        FILTER_SANITIZE_SPECIAL_CHARS
    );
    if (isset($_SESSION['username_s'])) {
        include('database.php');
        $query = "
        SELECT sc.server_id, sc.user_id, sc.message, TIME(CONVERT_TZ(sc.time,'+00:00','+7:00')) as time, u.username, scn.name
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
    } else {
        echo "You must log in first!";
    }
}
