<?php

include "database.php";
session_start();

$_SESSION["login_failed_s"] = null;
$_SESSION["register_failed_s"] = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="style.css" />
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
            $query = "
            UPDATE users_online uo
            JOIN users u
            ON u.user_id = uo.user_id
            SET uo.status_id = 1
            WHERE u.username = '{$_SESSION["username_s"]}';
            ";
            mysqli_query($conn, $query);

          ?>
            <div class="login-item login-username"> Welcome, <?php echo $_SESSION["username_s"]; ?>
              <div class="login-profile border-gui">
                <div>Hello, <?php echo $_SESSION["username_s"]; ?> </div>
                <div style="overflow-wrap:break-word;"> <?php echo $_SESSION["email_s"]; ?> </div>
                <a class="border-button" href="profile.php">View profile</a>
                <a class="border-button" href="friends.php">Friends</a>
                <a class="border-button" href="logout.php">Logout</a>
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
      <div class="menu-container border-gui">

        <div class="search-container">
          <form style="display:flex">
            <input type="search" name="search_name" id="" class="register-input border-inventory" placeholder="Search" style="height:auto">
            <input type="submit" class="border-button-no-outline" value="Submit">
          </form>
        </div>

        <?php if (isset($_SESSION["username_s"])) { ?>
          <a class="login-item border-button" href="register-item.php">Register product!</a>
        <?php } ?>
      </div>

      <div class="shop-container">
        <?php
        if (isset($_GET['search_name'])) {
          $search = filter_input(
            INPUT_GET,
            "search_name",
            FILTER_SANITIZE_SPECIAL_CHARS
          );
          $query = "SELECT * FROM `products` WHERE name LIKE '%" . $search . "%'";
        } else {
          $query = "SELECT * FROM `products` ";
        }
        $query_result = mysqli_query($conn, $query);
        try {
          if (mysqli_num_rows($query_result) > 0) {
            while ($row = mysqli_fetch_assoc($query_result)) { ?>
              <div class="shop-items">
                <div class="shop-item border-inventory" onclick="updateCart(<?php echo $row['product_id']; ?>, 1)">
                  <div class="shop-item-image">
                    <img src="<?php echo $row['image']; ?>" id="shop-item-image-<?php echo $row['product_id']; ?>" alt="<?php echo $row['name']; ?>" class="shop-image" />
                  </div>
                  <p class="shop-item-name" id="shop-item-name-<?php echo $row['product_id']; ?>"><?php echo $row['name']; ?></p>
                  <p class="shop-item-price" id="shop-item-price-<?php echo $row['product_id']; ?>"><?php echo '$' . $row['price']; ?></p>
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

</html>