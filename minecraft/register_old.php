<?php

include("database.php");

$username = $_POST['username_name'];
$email = $_POST['email_name'];
$password = $_POST['password_name'];

$sql_query_select_username = "SELECT * FROM `users` WHERE username = '{$username}'";
$sql_query_select_email = "SELECT * FROM `users` WHERE email = '{$email}'";
$sql_query_insert = "INSERT INTO `users`(`username`, `email`, `password`) VALUES ('{$username}','{$email}','{$password}')";

try {
  if (mysqli_num_rows(mysqli_query($conn, $sql_query_select_username)) > 0) {
    echo "This username has already registered.";
  } else if (mysqli_num_rows(mysqli_query($conn, $sql_query_select_email)) > 0) {
    echo "This email has already registered.";
  } else {
    mysqli_query($conn, $sql_query_insert);
    echo "{$username} is now registered";
  }
} catch (mysqli_sql_exception) {
  echo "Could not register";
}

mysqli_close($conn);
