
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>





    <div class="container mt-5 ">
        <div class="card   shadow  bg-body-tertiary rounded">
            <div class=" bg-white text-center">
                <h2 class="font-weight-bold">Product Detail </h2>
            </div>
            <div class="card-body">
                <form  method="post" enctype="multipart/form-data" action="insert.php">
                    <!-- Product Name -->
                    <div class="form-group">
                        <label for="productName">Product Name:</label>
                        <input type="text" name="Pname" class="form-control" id="productName" placeholder="Enter product name">
                    </div>

                    <!-- Product Price -->
                    <div class="form-group">
                        <label for="productPrice">Product Price:</label>
                        <input type="text" name="Pprice"  class="form-control" id="productPrice" placeholder="Enter product price">
                    </div>

                    <!-- Product Image -->
                    <div class="form-group">
                        <label for="productImage">Add Product Image:</label>
                        <input type="file" name="Pimage"  class="form-control-file" id="productImage">
                    </div>

                    <!-- Page Category -->
                    <div class="form-group">
                        <label for="category">Select Page Category:</label>
                        <select class="form-control" id="category" name="Ppages">
                            <option value="home">Home</option>
                            <option value="laptop">Laptop</option>
                            <option value="bag">Bag</option>
                            <option value="mobile">Mobile</option>
                        </select>
                    </div>

                    <!-- Upload Button -->
                    <button type="submit" class="btn btn-primary rounded-1 btn-block font-weight-bold" name="submit">Upload</button>
                </form>
            </div>
        </div>


    <div class=" container ">
        <h2 class=" mt-3 text-center card shadow p-1   bg-body-tertiary rounded ">Product List</h2>

        <!-- Bootstrap Table -->
        <table class="table align-middle  bg-white border border-opacity-25 shadow ">
        <thead class=" align-middle bg-primary text-white ">
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Picture</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include database connection
            include "../../db.php";

            // Fetch data from the product table
            $sql = "SELECT * FROM product";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['pname'] . "</td>";
                    echo "<td>$" . $row['pprice'] . "</td>";
                    echo "<td>" . ucfirst($row['pcategory']) . "</td>"; // Capitalize category name
                    echo "<td><img src='" . $row['pimage'] . "' alt='Product Image' style='width: 80px; height: 80px;'></td>";
                    echo "<td>
                            <a href='update.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Update</a>
                            <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No products found</td></tr>";
            }

            // Close database connection
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>

</div>






    
    
     
    

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
