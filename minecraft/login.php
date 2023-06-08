<?php
session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="style.css" />
  <script src="register.js"></script>
</head>

<body>
  <a class="register-back" href="index.php">
    <img src="assets/Back_arrow.svg" alt="" />
  </a>
  <div class="register-body">
    <div class="register-container border-gui">
      <form class="register-form" action="login_action.php" method="post" name="register_form">
        <legend>Let's Login!</legend>
        <label for="username">Minecraft Username: </label>
        <input class="register-input border-inventory" type="text" name="username_name" id="username_id" placeholder="Username" required />
        <label for="password">Password: </label>
        <input class="register-input border-inventory" type="password" name="password_name" id="password_id" placeholder="Password" required />
        <?php if (!empty($_SESSION["login_failed_s"])) {
          if ($_SESSION["login_failed_s"] == 1) {
            echo "<div class='error;>Username does not exist!</div>";
        ?> <?php } elseif ($_SESSION["login_failed_s"] == 2) {
            echo "            
            <div>
              <div class='error'>Login failed!</div>
            </div>";
          }
        } ?>
        <div class="register-submit-container">
          <input class="register-submit border-gui" type="submit" value="Enter" />
        </div>
      </form>
    </div>
  </div>
</body>

</html>