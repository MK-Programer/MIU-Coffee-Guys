<?php
include "product_class.php";
session_start();
if (empty($_SESSION['admin'])) {
    header('location: index.php');
}
if ($_SESSION['admin']['role'] == 'user') {
    header('location: user_page.php');
}
$addProducts = new Products();

if (isset($_POST['submit'])) {
    $addProducts->add_Products($_POST);
}
?>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="admin.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Hello, world!</title>
</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Coffee Shop</a>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse ">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">


                        <li class="nav-item  mb-2">
                            <a class="nav-link  text-white" href="product.php">
                                <i class="fas fa-shopping-cart"></i>
                                Products
                            </a>
                        </li>
                        <li class="nav-item  mb-2">
                            <a class="nav-link  active" href="add_product.php">
                                <i class="fas fa-cart-plus"></i>
                                Add Products
                            </a>
                        </li>
                        <li class="nav-item  mb-2">
                            <a class="nav-link  text-white" href="customers.php">
                                <i class="fas fa-users"></i>
                                Customers
                            </a>
                        </li>
                        <li class="nav-item  mb-2">
                            <a class="nav-link text-white" href="changePassword.php">
                                <i class="fas fa-key"></i>
                                Change Password
                            </a>
                        </li>

                    </ul>
                    <div class="border-top border-light p-3 mb-4 mt-5">

                        <div class="text-center">
                            <a href="logoutadmin.php" class="btn btn-outline-danger">Log Out</a>
                        </div>

                    </div>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Add Products</h1>

                </div>
                <div class="container">
                    <div class="row justify-content-md-center">

                        <div class="col-md-auto">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    Add New Products
                                </div>
                                <div class="card-body">
                                    <form class="row g-3" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                                        <div class="col-md-4">
                                            <label for="inputCity" class="form-label">Model</label>
                                            <input type="text" name="model" class="form-control" id="inputCity">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputCity" class="form-label">Title</label>
                                            <input type="text" name="title" class="form-control" id="inputCity">
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label for="inputCity" class="form-label">Ingrediants</label>
                                            <input type="text" name="description" class="form-control" id="inputCity">
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label for="inputZip" class="form-label">Price</label>
                                            <input type="number" name="price" class="form-control" id="inputZip">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="formFileMultiple" class="form-label">Select a file</label>
                                            <input class="form-control" name="file" type="file" id="formFileMultiple" multiple>
                                        </div>


                                        <div class="">
                                            <button class="btn btn-primary" name="submit" type="submit" style = "width: 150px; height: 50px; margin-top:20px;">Add</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>






            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>