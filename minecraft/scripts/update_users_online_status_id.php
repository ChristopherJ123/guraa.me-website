<?php
include('database.php');
session_start();

$condition = $_POST['condition'];
echo $condition;

if ($condition == 'false') {
    $set_time = '00:01:00';
} else {
    $set_time = '00:00:00';
}

if (isset($_SESSION['username_s'])) {
    $query = "
    UPDATE users_online uo
    JOIN users u
    ON u.user_id = uo.user_id
    SET uo.status_id = 1, 
    uo.last_seen_time = CURRENT_TIMESTAMP, 
    uo.timeout_time = TIMESTAMPADD(minute, 2, CURRENT_TIMESTAMP), 
    uo.total_time = ADDTIME(uo.total_time, '{$set_time}')
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
