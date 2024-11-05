

<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch admin details if needed
$username = $_SESSION['username'];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Store</title>
    <style>
      
    </style>
    <!-- bootstrap cdn link css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

     <!-- fontawesome cdn link  -->
    <script src="https://kit.fontawesome.com/2fe212be02.js" crossorigin="anonymous"></script>

    <!-- css file -->
     <link rel="stylesheet" href="./style.css">
  </head>

  <body>
    <!-- nav bar -->
    <nav class="navbar  bg-dark">
  <div class="container-fluid text-white">
    <a class="navbar-brand text-white" ><h1>Admin</h1></a>
    <span  class="">
        <i class="fa-solid fa-user-tie p-2 "></i>Hello, <?php echo $username; ?>
       <a href="logout.php"  class="text-decoration-none text-white p-2"> <i class="fa-solid fa-arrow-right-from-bracket "></i>Logout</a>
        <a href="" class="text-decoration-none text-white p-2">userpanel</a>
    </span>
   
  </div>
</nav>
<div class="container mt-5">
        <!-- Dashboard Content -->
        <div class="border border-primary border-opacity-25 rounded-1 p-4 shadow">
            <h1 class="text-center">Content Dashboard</h1>
            <p class="text-center">Welcome to your dashboard! You can manage posts and users from here.</p>

            <!-- Buttons -->
            <div class="text-center mt-4">
                <a href="./product/addproduct.php"><button class="btn btn-primary rounded-1 mr-2">Add Product</button></a>
                <button class="btn btn-success px-4 rounded-1">Add User</button>
            </div>
        </div>

    </div>
     
        
            

          







     <!-- bootstrap cdn link js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>