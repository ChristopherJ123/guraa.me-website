<?php

session_start();
include "../database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name              = filter_input(
    INPUT_POST,
    "name_name",
    FILTER_SANITIZE_SPECIAL_CHARS
  );
  $description       = filter_input(
    INPUT_POST,
    "description_name",
    FILTER_SANITIZE_SPECIAL_CHARS
  );
  $image             = filter_input(
    INPUT_POST,
    "image_name",
    FILTER_SANITIZE_SPECIAL_CHARS
  );
  $quantity_in_stock = str_replace(
    '-',
    '',
    filter_input(
      INPUT_POST,
      "quantity_in_stock_name",
      FILTER_SANITIZE_NUMBER_INT
    )
  );
  $price =             str_replace(
    '-',
    '',
    filter_input(
      INPUT_POST,
      "price_name",
      FILTER_SANITIZE_NUMBER_FLOAT,
      FILTER_FLAG_ALLOW_FRACTION
    )
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
    VALUES ('{$name}','{$description}','{$image}','{$quantity_in_stock}','{$price}','{$tags}','{$_SESSION['username_s']}')";

    try {
      mysqli_execute_query($conn, $query);
      header("Location: ../index.php");
      exit();
    } catch (mysqli_sql_exception) {
      echo "System error.";
    }
  }
}

mysqli_close($conn);
