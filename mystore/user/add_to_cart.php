<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $product_name = $_POST["product_name"];
    $product_price = $_POST["product_price"];
    $quantity = $_POST["quantity"];

    // If the cart session is not already set, initialize it
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Check if the product already exists in the cart
    $product_exists = false;
    foreach ($_SESSION['cart'] as &$product) {
        if ($product['id'] == $product_id) {
            $product['quantity'] += $quantity;
            $product_exists = true;
            break;
        }
    }

    // If the product doesn't exist, add it to the cart
    if (!$product_exists) {
        $_SESSION['cart'][] = array(
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $quantity
        );
    }

    // Redirect to the cart page
    header("Location: cart.php");
    exit();
}
?>
