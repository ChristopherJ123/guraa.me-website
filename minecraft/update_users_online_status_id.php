<?php
include('database.php');

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
