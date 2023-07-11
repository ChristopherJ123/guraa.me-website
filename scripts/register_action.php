<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include "database.php";
  $username = filter_input(
    INPUT_POST,
    "username_name",
    FILTER_SANITIZE_SPECIAL_CHARS
  );
  $email = filter_input(
    INPUT_POST,
    "email_name",
    FILTER_SANITIZE_SPECIAL_CHARS
  );
  $password = filter_input(
    INPUT_POST,
    "password_name",
    FILTER_SANITIZE_SPECIAL_CHARS
  );

  if (empty($username)) {
    echo "Please enter a username.";
  } elseif (empty($email)) {
    echo "Please enter an email.";
  } elseif (empty($password)) {
    echo "Please enter a password.";
  } else {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql_query_select_username = "SELECT * FROM `users` WHERE username = '{$username}'";
    $sql_query_select_email = "SELECT * FROM `users` WHERE email = '{$email}'";
    $sql_query_insert = "INSERT INTO `users`(`username`, `email`, `password`) VALUES ('{$username}','{$email}','{$password_hash}')";
    $sql_query_insert2 = "INSERT INTO `users_online`(user_id) VALUES (LAST_INSERT_ID())";

    try {
      if (
        mysqli_num_rows(mysqli_query($conn, $sql_query_select_username)) > 0
      ) {
        echo "This username has already registered.";
        $_SESSION["register_failed_s"] = 1;
        header("Location: ../register.php");
        exit();
      } elseif (
        mysqli_num_rows(mysqli_query($conn, $sql_query_select_email)) > 0
      ) {
        echo "This email has already registered.";
        $_SESSION["register_failed_s"] = 2;
        header("Location: ../register.php");
        exit();
      } else {
        mysqli_query($conn, $sql_query_insert);
        mysqli_query($conn, $sql_query_insert2);
        echo "{$username} is now registered.";
        $_SESSION["register_failed_s"] = 3;
        $_SESSION["username_s"] = $username;
        $_SESSION["email_s"] = $email;
        header("Location: ../register.php");
        exit();
      }
    } catch (mysqli_sql_exception) {
      echo "System error.";
    }
  }

  mysqli_close($conn);
}
