<?php

include "scripts/database.php";
session_start();

$_SESSION["login_failed_s"] = null;
$_SESSION["register_failed_s"] = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Guramee Website</title>
  <link rel="stylesheet" href="style.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>

<body>
  <div class="container">
    <div class="container-up">
      <div class="login-container border-gui">
        <div></div>
        <div class="login-container-middle">
          <div class="login-item" style="font-size: 24px">Server Shop</div>
        </div>
        <div class="login-container-right">
          <div class="login-item" href="">
            <img class="login-item-image" src="assets/shopping_cart.svg" alt="cart" />
            <span class="quatity" id="total-items">0</span>
          </div>

          <?php if (isset($_SESSION["username_s"])) {
          ?>

            <div class="login-item login-username"> Welcome, <?php echo $_SESSION["username_s"]; ?>
              <div class="login-profile border-gui">
                <div>Hello, <?= $_SESSION["username_s"]; ?> </div>
                <div style="overflow-wrap:break-word;"> <?php echo $_SESSION["email_s"]; ?> </div>
                <a class="border-button" href="profile.php">View profile</a>
                <a class="border-button" href="friends.php">Friends</a>
                <a class="border-button" href="chat.php">Messages</a>
                <a class="border-button" href="scripts/logout.php">Logout</a>
              </div>
            </div>
          <?php } else { ?>
            <a class="login-item" href="login.php">Login</a>
            <a class="login-item" href="register.php">Register</a>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="container-down">
      <div class="menu-container border-gui" style="max-width: 400px;">

        <div class="search-container">
          <form style="display:flex; margin-block-end: 0;">
            <input type="search" name="search_name" id="" class="register-input border-inventory" placeholder="Search" style="height:auto">
            <input type="submit" class="border-button-no-outline" value="Submit">
          </form>
        </div>

        <?php if (isset($_SESSION["username_s"])) { ?>
          <a class="login-item border-button" href="register-item.php">Register product!</a>
        <?php } ?>

        <div class="inventory-container" style="height: 500px;">
          <div class="border-inventory chat-text-area">

            <!-- server_chats html -->
            <?php
            // Session Var for server_id for Server Chat
            $query = "SELECT name FROM server_chat_names WHERE server_id = 1";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            ?>
            <div class="shop-item-name" style="flex-direction: column;">
              Welcome to,
              <br>
              <b id="chat-user"><?= $row['name'] ?></b>
            </div>
            <div class="chat-messages" id="chat-output">
              <?php
              $query = "
              SELECT sc.server_id, sc.user_id, sc.message, TIME(CONVERT_TZ(sc.time,'+00:00','+7:00')) as time, u.username
              FROM `server_chats` sc
              JOIN users u
              ON u.user_id = sc.user_id
              WHERE sc.server_id = {$_SESSION['server_id_s']}
              ";
              $result = mysqli_query($conn, $query);
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "
                  <div class='chat-message'>
                  <i>{$row['time']}</i> <a href='profile.php?u={$row['username']}'><b>{$row['username']}</b></a> 
                    <div>{$row['message']}</div>
                  </div>";
                }
              }
              ?>
              <div id="anchor"></div>
            </div>

          </div>
          <div class="chat-text-box">
            <form action="" method="post" id="chat-text-box-form" style="width: 100%;">
              <?php
              if (isset($_SESSION["username_s"])) {
                echo '<input type="text" name="chat_name" id="chat-input" class="input-box-big border-inventory" placeholder="Write a message" style="width: 100%;">';
              } else {
                echo '<input type="text" name="chat_name" readonly="readonly" class="input-box-big border-inventory" placeholder="Login to write a message" style="width: 100%;">';
              }
              ?>
            </form>
          </div>
        </div>

      </div>

      <div class="shop-container">
        <?php
        // Display items
        if (isset($_GET['search_name'])) {
          $search = filter_input(
            INPUT_GET,
            "search_name",
            FILTER_SANITIZE_SPECIAL_CHARS
          );
          $query = "SELECT * FROM `products` WHERE name LIKE '%" . $search . "%'";
        } else {
          $query = "SELECT * FROM `products`";
        }
        $query_result = mysqli_query($conn, $query);
        try {
          if (mysqli_num_rows($query_result) > 0) {
            while ($row = mysqli_fetch_assoc($query_result)) { ?>
              <div class="shop-items">
                <div class="shop-item border-inventory" onclick="updateCart(<?= $row['product_id']; ?>, 1)">
                  <div class="shop-item-image">
                    <img src="<?= $row['image']; ?>" id="shop-item-image-<?= $row['product_id']; ?>" alt="<?= $row['name']; ?>" class="shop-image" />
                  </div>
                  <p class="shop-item-name" id="shop-item-name-<?= $row['product_id']; ?>"><?= $row['name']; ?></p>
                  <p class="shop-item-price" id="shop-item-price-<?= $row['product_id']; ?>"><?= '$' . $row['price']; ?></p>
                </div>
              </div>
        <?php }
          }
        } catch (mysqli_sql_exception) {
          echo "System error";
        }
        ?>

      </div>
    </div>
  </div>

  <div class="cart border-gui">
    <h1>Your cart</h1>
    <ul class="cart-list"></ul>

    <div class="cart-bottom">
      <div class="cart-total border-button">0</div>
      <div class="cart-close border-button">Close</div>
    </div>
  </div>

</body>
<script src="app.js"></script>

<?php
if (isset($_SESSION["username_s"])) {
  echo "<script src='scripts/user_is_online.js'></script>";
}
?>

</html>