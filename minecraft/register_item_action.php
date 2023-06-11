<?php

session_start();
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name              = filter_input(
    INPUT_POST,
    "name_name",
    FILTER_SANITIZE_SPECIAL_CHARS
  );
  $description       = filter_input(
    INPUT_POST,
    "description_name"
  );
  $image             = filter_input(
    INPUT_POST,
    "image_name",
    FILTER_SANITIZE_URL
  );
  $quantity_in_stock = filter_input(
    INPUT_POST,
    "quantity_in_stock_name",
    FILTER_SANITIZE_NUMBER_INT
  );
  $price =             filter_input(
    INPUT_POST,
    "price_name",
    FILTER_SANITIZE_NUMBER_FLOAT
  );
  $tags =              filter_input(
    INPUT_POST,
    "tags_name",
    FILTER_SANITIZE_SPECIAL_CHARS
  );

  if (empty($name)) {
    echo "Please enter a name.";
  } elseif (empty($image)) {
    echo "Please enter an image URL.";
  } elseif (empty($quantity_in_stock)) {
    echo "Please enter a quantity.";
  } elseif (empty($price)) {
    echo "Please enter a price.";
  } elseif (empty($_SESSION['username_s'])) {
    echo "You are not logged in.";
  } else {
    $query = "INSERT INTO `products`(`name`, `description`, `image`, `quantity_in_stock`, `price`, `tags`, `author`) 
    VALUES ('" . htmlentities($name);
    "','{$description}','" . htmlentities($image);
    "','{$quantity_in_stock}','{$price}','" . htmlentities($tags);
    "','{$_SESSION['username_s']}')";

    try {
      mysqli_query($conn, $query);
      header("Location: index.php");
      exit();
    } catch (mysqli_sql_exception) {
      echo "System error.";
    }
  }
}

mysqli_close($conn);
