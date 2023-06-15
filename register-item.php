<?php

include 'scripts/database.php';
session_start();

if (!isset($_SESSION['username_s'])) {
    echo "You must be logged in to view this page.";
    return;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guramee Website</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <a class="register-back" href="index.php">
        <img src="assets/Back_arrow.svg" alt="" />
    </a>
    <div class="register-body">
        <div class="register-container border-gui">
            <form class="register-form" action="scripts/register_item_action.php" method="post" name="register_form" style="width: 400px; gap:10px">
                <legend>Create your item!</legend>
                <label for="name">Name: <b style="color: red">*</b> </label>
                <input class="register-input border-inventory" type="text" name="name_name" id="name_id" placeholder="Name" required />
                <label for="description">Description: </label>
                <textarea class="register-input border-inventory" type="text" name="description_name" id="description_id" placeholder="Description" style="height: 80px;" required></textarea>
                <label for="image">Image (URL): <b style="color: red">*</b> </label>
                <input class="register-input border-inventory" type="text" name="image_name" id="name_id" placeholder="URL" required />
                <label for="quantity_in_stock">Quantity in stock: <b style="color: red">*</b> </label>
                <input class="register-input border-inventory" type="text" name="quantity_in_stock_name" id="qiantity_in_stock_id" placeholder="Quantity" required />
                <label for="price">Price: <b style="color: red">*</b> </label>
                <input class="register-input border-inventory" type="text" name="price_name" id="price_id" placeholder="Price" required />
                <label for="username">Tags (Seperate by ','): </label>
                <input class="register-input border-inventory" type="text" name="tags_name" id="tags_id" placeholder="Tags" />

                <div class="register-submit-container">
                    <input class="register-submit border-gui" type="submit" value="Enter" />
                </div>
            </form>
        </div>
    </div>
</body>

<?php
if (isset($_SESSION["username_s"])) {
    echo "<script src='scripts/user_is_online.js'></script>";
}
?>

</html>