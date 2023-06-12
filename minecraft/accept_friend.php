<?php

include('database.php');
session_start();

$adder = filter_input(
    INPUT_GET,
    "u",
    FILTER_SANITIZE_SPECIAL_CHARS
);
$accepter = $_SESSION['username_s'];
$query = "
SELECT f.user_id, f.friend_id, f.status_id, u.username AS 'adder_username', u2.username AS 'accepter_username'
FROM friends f
JOIN users u
ON f.user_id = u.user_id
JOIN users u2
ON f.friend_id = u2.user_id
WHERE u.username = '{$adder}' AND u2.username = '{$accepter}';
";
$result = mysqli_query($conn, $query);

try {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($row['status_id'] == 0) {
            $query = "
            UPDATE friends f 
            JOIN users u
            ON f.user_id = u.user_id
            JOIN users u2
            ON f.friend_id = u2.user_id
            SET status_id = '1' 
            WHERE u.username = '{$adder}' AND u2.username = '{$accepter}';
            ";
            mysqli_query($conn, $query);
            echo "<div class='success'>Success!</div>";
        } else if ($row['status_id'] == 1) {
            echo "<div class='error'>You are already friends!</div>";
        } else {
            echo "<div class='error'>What you doing here?</div>";
        }
    } else {
        echo "<div class='error'>Please add friend first!</div>";
    }
} catch (mysqli_sql_exception) {
    echo "<div class='error'>Error!<br>Have you tried logging in first?</div>";
}

mysqli_close($conn);
