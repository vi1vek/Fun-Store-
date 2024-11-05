<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if user is not logged in
    exit();
}

// Function to calculate total items in cart
function getCartItemCount() {
    $total_items = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total_items += $item['quantity'];
        }
    }
    return $total_items;
}

$cart_item_count = getCartItemCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage</title>
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light d-flex border align-items-center fw-bold " style="height:70px; font-family: Poppins, serif;">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#"><img src="./assets/logo-Photoroom.png" alt="" style="width:100px;">Fun Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <!-- Categories Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Category</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php?category=home">All Products</a></li>
                            <li><a class="dropdown-item" href="index.php?category=bag">Bag</a></li>
                            <li><a class="dropdown-item" href="index.php?category=mobile">Mobiles</a></li>
                            <li><a class="dropdown-item" href="index.php?category=laptop">Laptops</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex align-items-center" style="gap: 15px;">
                    

                    <?php if (isset($_SESSION['username'])): ?>
                        <h6>Hello <?php echo $_SESSION['username']; ?></h6>
                        <a href="logout.php" class="btn btn-danger px-3">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-success px-3">Login</a>
                    <?php endif; ?>

                    <!-- Update the cart badge dynamically with the total items in the cart -->
                    <a href="cart.php" class="btn btn-outline-dark">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">
                            <?php echo $cart_item_count; ?>
                        </span>
                    </a>
                    
                </form>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-dark py-5 mt-2" style="background-image: url('./assets/banner.jpg'); background-size: cover; background-position: center; height: 45vh;">
        <div class="container px-4 px-lg-5 my-5">
            <!-- Optional header content -->
        </div>
    </header>

    <!-- Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                // Database connection
                include "../db.php";

                // Handle category filter from URL parameters
                $category = isset($_GET['category']) ? $_GET['category'] : 'home';

                // Build SQL query based on the selected category
                if ($category == 'home') {
                    $sql = "SELECT * FROM product";
                } else {
                    $sql = "SELECT * FROM product WHERE pcategory = '" . mysqli_real_escape_string($conn, $category) . "'";
                }

                // Execute the query
                $result = mysqli_query($conn, $sql);

                // Check if any products exist
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $image = !empty($row["pimage"]) ? '../admin/product/' . $row["pimage"] : 'path/to/placeholder.jpg';

                        echo '<div class="col mb-5">';
                        echo '    <div class="card h-100">';
                        echo '        <img class="card-img-top" src="' . $image . '" alt="Product Image" />';
                        echo '        <div class="card-body p-4">';
                        echo '            <div class="text-center">';
                        echo '                <h5 class="fw-bolder">' . ucwords($row["pname"]) . '</h5>';
                        echo '                <p>Price $' . $row["pprice"] . '</p>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
                        echo '            <div class="text-center">';
                        echo '                <form action="add_to_cart.php" method="POST">';
                        echo '                    <input type="hidden" name="product_id" value="' . $row["id"] . '">';
                        echo '                    <input type="hidden" name="product_name" value="' . $row["pname"] . '">';
                        echo '                    <input type="hidden" name="product_price" value="' . $row["pprice"] . '">';
                        echo '                    <div class="my-1"><input type="number" name="quantity" min="1" max="10" value="1"/></div>';
                        echo '                    <button type="submit" class="btn btn-primary fw-bolder text-white mt-auto rounded-1">Add to Cart</button>';
                        echo '                </form>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '    </div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-12"><h5 class="text-center card">No products found in this category.</h5></div>';
                }

                // Close database connection
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Fun Store 2024 by Soumen Das</p>
        </div>
    </footer>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>
