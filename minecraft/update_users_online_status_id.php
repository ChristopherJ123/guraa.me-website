<?php
include('database.php');

$query = "
UPDATE users_online
SET status_id = 0
WHERE end_time < CURRENT_TIMESTAMP
";
mysqli_query($conn, $query);

mysqli_close($conn);
