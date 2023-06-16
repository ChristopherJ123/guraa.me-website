<?php

session_start();

if (isset($_SESSION['username_s'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include "database.php";

        $name = filter_input(
            INPUT_POST,
            's',
            FILTER_SANITIZE_SPECIAL_CHARS
        );

        $query = "SELECT * FROM server_chat_names WHERE name = '{$name}'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<div class='error'>Server already exist!</div>";
        } else {
            $query = "INSERT INTO server_chat_names (name) VALUES ('{$name}')";
            mysqli_query($conn, $query);
            echo "<div class='success'>Server created</div>";
        }
    }
}
