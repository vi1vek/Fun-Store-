<?php
// Include database connection
include "../../db.php";

// Check if the ID is provided via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing product data
    $sql = "SELECT * FROM product WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    // If product exists, fetch data
    if ($row = mysqli_fetch_assoc($result)) {
        $productName = $row['pname'];
        $productPrice = $row['pprice'];
        $pageCategory = $row['pcategory'];
        $productImage = $row['pimage'];
    } else {
        echo "Product not found!";
        exit();
    }
} else {
    echo "No product selected!";
    exit();
}

// Update product data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = mysqli_real_escape_string($conn, $_POST['Pname']);
    $productPrice = mysqli_real_escape_string($conn, $_POST['Pprice']);
    $pageCategory = mysqli_real_escape_string($conn, $_POST['Ppages']);
    $uploadOk = 1;

    // Handle image upload if a new image is provided
    if (!empty($_FILES["Pimage"]["name"])) {
        $targetDir = "uploadimages/";
        $targetFile = $targetDir . basename($_FILES["Pimage"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate image and file size
        $check = getimagesize($_FILES["Pimage"]["tmp_name"]);
        if ($check !== false && $_FILES["Pimage"]["size"] <= 5000000 &&
            ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif")) {
            
            // Upload new image
            move_uploaded_file($_FILES["Pimage"]["tmp_name"], $targetFile);
            $productImage = $targetFile; // Update image path
        } else {
            echo "<script>alert('Invalid image file.');</script>";
            $uploadOk = 0;
        }
    }

    if ($uploadOk) {
        // Update the product in the database
        $sql = "UPDATE product SET pname = '$productName', pprice = '$productPrice', pcategory = '$pageCategory', pimage = '$productImage' WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Product updated successfully!'); window.location.href='addproduct.php';</script>";
        } else {
            echo "Error updating product: " . mysqli_error($conn);
        }
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white text-center">
                <h2>Update Product</h2>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" name="Pname" class="form-control" id="productName" value="<?php echo $productName; ?>" required>
                    </div>

                    <!-- Product Price -->
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Product Price</label>
                        <input type="text" name="Pprice" class="form-control" id="productPrice" value="<?php echo $productPrice; ?>" required>
                    </div>

                    <!-- Product Image -->
                    <div class="mb-3">
                        <label for="productImage" class="form-label">Product Image</label>
                        <input type="file" name="Pimage" class="form-control" id="productImage">
                        <p>Current Image: <img src="<?php echo $productImage; ?>" style="width: 80px; height: 80px;"></p>
                    </div>

                    <!-- Page Category -->
                    <div class="mb-4">
                        <label for="category" class="form-label">Select Page Category</label>
                        <select class="form-select" id="category" name="Ppages">
                            <option value="home" <?php if ($pageCategory == 'home') echo 'selected'; ?>>Home</option>
                            <option value="laptop" <?php if ($pageCategory == 'laptop') echo 'selected'; ?>>Laptop</option>
                            <option value="bag" <?php if ($pageCategory == 'bag') echo 'selected'; ?>>Bag</option>
                            <option value="mobile" <?php if ($pageCategory == 'mobile') echo 'selected'; ?>>Mobile</option>
                        </select>
                    </div>

                    <!-- Update Button -->
                    <button type="submit" class="btn btn-success w-100">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
