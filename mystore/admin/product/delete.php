<?php
// Include database connection
include "../../db.php";

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the delete SQL query
    $sql = "DELETE FROM product WHERE id = $id";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product deleted successfully!'); window.location.href='addproduct.php';</script>";
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }
} else {
    echo "No product selected!";
}

// Close the database connection
mysqli_close($conn);
?>
