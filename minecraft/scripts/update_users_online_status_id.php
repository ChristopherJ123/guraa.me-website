<?php
include('database.php');
session_start();

$total_time = 0;

// TODO add start_time column to users_online table

if (isset($_SESSION['username_s'])) {
    $query = "
    UPDATE users_online uo
    JOIN users u
    ON u.user_id = uo.user_id
    SET uo.status_id = 1, uo.last_seen_time = CURRENT_TIMESTAMP, uo.timeout_time = TIMESTAMPADD(minute, 2, CURRENT_TIMESTAMP)
    WHERE u.username = '{$_SESSION["username_s"]}';
    ";
    mysqli_query($conn, $query);
}

try {
    $query = "
    UPDATE users_online
    SET status_id = 0
    WHERE timeout_time < CURRENT_TIMESTAMP
    ";
    mysqli_query($conn, $query);
    echo "Success!";
} catch (mysqli_sql_exception) {
    echo "System error!";
}

mysqli_close($conn);
