<?php
include('scripts/database.php');
session_start();

$query = "
UPDATE users_online uo
JOIN users u
ON u.user_id = uo.user_id
SET uo.status_id = 0
WHERE u.username = '{$_SESSION["username_s"]}';
";
mysqli_query($conn, $query);

session_unset();
session_destroy();

header('Location: index.php');
