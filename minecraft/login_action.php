<?php

session_start();
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = filter_input(
    INPUT_POST,
    "username_name",
    FILTER_SANITIZE_SPECIAL_CHARS
  );
  $password = filter_input(
    INPUT_POST,
    "password_name",
    FILTER_SANITIZE_SPECIAL_CHARS
  );

  if (empty($username)) {
    echo "Please enter a username.";
  } elseif (empty($password)) {
    echo "Please enter a password.";
  } else {
    $sql_query_select_username = "SELECT * FROM `users` WHERE username = '{$username}'";
    $sql_query_result = mysqli_query($conn, $sql_query_select_username);

    try {
      if (mysqli_num_rows($sql_query_result) > 0) {
        while ($row = mysqli_fetch_assoc($sql_query_result)) {
          if ($password_unhash = password_verify($password, $row["password"])) {
            echo "Login succesful!";
            $_SESSION["username_s"] = $username;
            $_SESSION["email_s"] = $row['email'];
            header("Location: index.php");
            exit();
          } else {
            echo "Login failed!";
            $_SESSION["login_failed_s"] = 2;
            header("Location: login.php");
            exit();
          }
        }
      } else {
        echo "Username does not exist!";
        $_SESSION["login_failed_s"] = 1;
        header("Location: login.php");
        exit();
      }
    } catch (mysqli_sql_exception) {
      echo "System error";
    }
  }
}

mysqli_close($conn);
