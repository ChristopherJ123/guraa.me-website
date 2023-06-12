<?php
include('database.php');

$u = filter_input(
    INPUT_GET,
    "u",
    FILTER_SANITIZE_SPECIAL_CHARS
);

$query = "SELECT username FROM users WHERE username LIKE '%" . $u . "%'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "
        <div class='input-box-big border-inventory' style='justify-content: space-between;'>
            <div style='padding: 0 10px;'>{$row['username']}</div>
            <div style='padding: 0 10px; cursor: pointer; ' onclick='addFriend(\"{$row['username']}\")'><img src='assets/add_friends.svg' alt='add_friends.svg' width='30px'></div>
        </div>";
    }
} else {
    echo "No usernames found";
}

mysqli_close($conn);
