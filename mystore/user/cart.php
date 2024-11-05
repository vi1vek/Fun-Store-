<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}



// Remove a product from the cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    // Loop through the cart and remove the product if IDs match
    foreach ($_SESSION['cart'] as $key => $product) {
        if ($product['id'] == $remove_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
}

// Update the quantity of products in the cart
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        // Update quantity in session if product exists
        foreach ($_SESSION['cart'] as &$product) {
            if ($product['id'] == $product_id) {
                $product['quantity'] = $quantity;
            }
        }
    }
}

// Initialize total price
$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Your Cart</h1>

        <?php if (!empty($_SESSION['cart'])): ?>
        <!-- Form to update cart quantities -->
        <form method="POST" action="cart.php">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <!-- Loop through each product in the cart -->
                    <?php foreach ($_SESSION['cart'] as $product): ?>
                    <tr>
                        <td><?php echo ucwords($product['name']); ?></td>
                        <td>$<?php echo $product['price']; ?></td>
                        <td>
                            <!-- Input to change the quantity -->
                            <input type="text" class="text-center" readonly name="quantity[<?php echo $product['id']; ?>]" value="<?php echo $product['quantity']; ?>" style="border:none; ouline:none">
                        </td>
                        <td>$<?php echo $product['price'] * $product['quantity']; ?></td>
                        <td>
                            <!-- Remove button -->
                            <a href="cart.php?remove=<?php echo $product['id']; ?>" class="btn btn-danger">Remove</a>
                        </td>
                    </tr>
                    <?php
                    // Update total price
                    $total_price += $product['price'] * $product['quantity'];
                    ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Display total price and update cart button -->
            <div class="d-flex justify-content-between">
                <h4>Total Price: $<?php echo $total_price; ?></h4>
                <!-- <button type="submit" class="btn btn-primary">Update Cart</button> -->
            </div>
        </form>
        <?php else: ?>
        <!-- If cart is empty -->
        <p>Your cart is empty.</p>
        <?php endif; ?>

        <!-- Continue shopping button -->
        <a href="index.php" class="btn btn-secondary mt-3">Continue Shopping</a>
    </div>
</body>
</html>
