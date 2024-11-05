


<?php
// Include db connection

include "../../db.php";

// include "../../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables
    $productName = mysqli_real_escape_string($conn, $_POST['Pname']);
    $productPrice = mysqli_real_escape_string($conn, $_POST['Pprice']);
    $pageCategory = mysqli_real_escape_string($conn, $_POST['Ppages']);
    $uploadOk = 1;

    // Debug: Print values to check if they're being set correctly
    // var_dump($productName, $productPrice, $pageCategory);

    // Check if the product name and price are not empty
    if (empty($productName) || empty($productPrice)) {
        echo "<script>alert('Product Name and Price are required!');</script>";
        $uploadOk = 0;
    }

    // Check if price is a valid number
    if (!is_numeric($productPrice)) {
        echo "<script>alert('Please enter a valid price.');</script>";
        $uploadOk = 0;
    }

    // Handle file upload
    $targetDir = "uploadimages/";  // Make sure this folder exists and has write permissions
    $targetFile = $targetDir . basename($_FILES["Pimage"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Debug: Check uploaded file
    var_dump($_FILES["Pimage"]);

    // Check if image file is a valid image
    $check = getimagesize($_FILES["Pimage"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File is not an image.');</script>";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["Pimage"]["size"] > 5000000) {
        echo "<script>alert('Sorry, your file is too large.');</script>";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.');</script>";
    } else {
        // Try to upload the file
        if (move_uploaded_file($_FILES["Pimage"]["tmp_name"], $targetFile)) {
            // Success: Save product info
            $sql = "INSERT INTO product (pname, pprice, pimage, pcategory) VALUES ('$productName', '$productPrice', '$targetFile', '$pageCategory')";

            // Debug: Print SQL query
            var_dump($sql);

            // Execute the query
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Product added successfully!'); window.location.href='addproduct.php'</script>";
                
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        }
    }

    // Close the database connection
    mysqli_close($conn);
}

?>

</body>
</html>
