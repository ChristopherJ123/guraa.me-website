<?php
session_start();

if (isset($_SESSION["username_s"])) {
    include('database.php');
    // Set user status_id to 0 and timeout_time to CURRENT_TIMESTAMP
    $query = "
    UPDATE users_online uo
    JOIN users u
    ON u.user_id = uo.user_id
    SET uo.status_id = 0, uo.timeout_time = CURRENT_TIMESTAMP, uo.total_time = ADDTIME(uo.total_time, TIMEDIFF(CURRENT_TIMESTAMP, uo.last_seen_time))
    WHERE u.username = '{$_SESSION["username_s"]}';
    ";
    mysqli_query($conn, $query);

    session_unset();
    session_destroy();

    header('Location: ../index.php');
} else {
    echo "Log in first.";
}
