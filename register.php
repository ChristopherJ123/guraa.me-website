<?php
session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Guramee Website</title>
  <link rel="stylesheet" href="style.css" />
  <script src="register.js"></script>
</head>

<body>
  <a class="register-back" href="index.php">
    <img src="assets/Back_arrow.svg" alt="" />
  </a>
  <div class="register-body">
    <div class="register-container border-gui">
      <form class="register-form" action="scripts/register_action.php" method="post" name="register_form" style="width: 350px">
        <legend>Let's Register!</legend>
        <label for="username_id">Minecraft Username: </label>
        <input class="register-input border-inventory" type="text" name="username_name" id="username_id" placeholder="Username" maxlength="16" required />
        <label for="email_id">E-mail: </label>
        <input class="register-input border-inventory" type="email" name="email_name" id="email_id" placeholder="Email" maxlength="50" required />
        <label for="password_id">Password: </label>
        <input class="register-input border-inventory" type="password" name="password_name" id="password_id" placeholder="Password" onchange="confirmPasswordIsSame('register_form')" required />
        <label for="password_confirm_id">Confirm Password: </label>
        <input class="register-input border-inventory" type="password" name="password_confirm_name" id="password_confirm_id" placeholder="Password Confirm" onchange="confirmPasswordIsSame('register_form')" required />
        <?php if (!empty($_SESSION["register_failed_s"])) {
          if ($_SESSION["register_failed_s"] == 3) { ?>
            <div class="success">Registered succesfully!</div> <?php } elseif ($_SESSION["register_failed_s"] == 1) {
                                                                ?>
            <div class="error">This username has already registered!</div> <?php } elseif ($_SESSION["register_failed_s"] == 2) {
                                                                            ?>
            <div class="error">This email has already registered.</div> <?php }
                                                                        } ?>
        <div class="register-submit-container">
          <input class="register-submit border-gui" type="submit" value="Enter" />
        </div>
      </form>
    </div>
  </div>
</body>

</html>