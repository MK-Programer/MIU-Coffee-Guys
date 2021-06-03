<?php

session_start();
include "product_class.php";
if (empty($_SESSION['admin'])) {
    header('location: index.php');
}
if ($_SESSION['admin']['role'] == 'admin') {
    header('location: admin_panel.php');
}
$session_id = $_SESSION['admin']['id'];

$Products= new Products();
$message = '';
if (isset($_GET["action"])) {
    if ($_GET["action"] == "show") {
        $id = $_GET['id'];
        $query = "SELECT * FROM products WHERE id = $id";
        $res = $Products->con->query($query);
        $result = $res->fetch_all(MYSQLI_ASSOC);
        $total_row = $res->num_rows;
    }
    if ($_GET["action"] == "delete") {
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);
        $cart_data = json_decode($cookie_data, true);
        foreach ($cart_data as $keys => $values) {
            if ($cart_data[$keys]['item_id'] == $_GET["id"] && $cart_data[$keys]['session_id'] == $session_id) {
                unset($cart_data[$keys]);
                $item_data = json_encode($cart_data);
                setcookie("shopping_cart", $item_data, time() + (86400 * 30));
                header("location:user_page.php?remove=1");
            }
        }
    }
    if ($_GET["action"] == "clear") {
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);
        $cart_data = json_decode($cookie_data, true);
        foreach ($cart_data as $keys => $values) {
            if ($cart_data[$keys]['session_id'] == $session_id) {
                unset($cart_data[$keys]);
                $item_data = json_encode($cart_data);
                setcookie("shopping_cart", $item_data, time() + (86400 * 30));
                header("location:user_page.php?clearall=1");
            }
        }


        //   setcookie("shopping_cart", "", time() - 3600);
        //   header("location:user_page.php?clearall=1");
    }
}

if (isset($_GET["success"])) {
    $message = '

 <div class="alert alert-success alert-dismissible fade show" role="alert">
 Item Added into Cart
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
 ';
}

if (isset($_GET["remove"])) {
    $message = '
 
 <div class="alert alert-danger alert-dismissible fade show" role="alert">
 Item removed from Cart
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
 ';
}
if (isset($_GET["clearall"])) {
    $message = '
 
 <div class="alert alert-danger alert-dismissible fade show" role="alert">
 Your Shopping Cart has been clear...
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
 ';
}


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>E-Commerce</title>
    <style>
        .img-s {
            opacity: 0;
            transition: 0.3s;
        }

        .card:hover .img-s {
            opacity: 1;
        }
    </style>
</head>

<body>
    <header class="section-header">

        <section class="header-main border-bottom py-2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-4">
                        <a href="user_page.php" class="brand-wrap">
                            <img class="logo" src="image/logoupper.png" style = "width: 150px;">
                        </a> <!-- brand-wrap.// -->
                    </div>

                    <div class="col-lg-10 col-sm-6 col-12">
                        <div class="d-flex justify-content-end">

                            <ul class="nav">

                                <li class="nav-item me-3 pe-3">
                                    <button type="button" class="btn btn-primary position-relative" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="fa fa-shopping-cart"></i> <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                            <?php

                                            if (isset($_COOKIE["shopping_cart"])) {
                                                $cookie_data = stripslashes($_COOKIE['shopping_cart']);

                                                $cart_data = json_decode($cookie_data, true);
                                            } else {
                                                $cart_data = array();
                                            }

                                            $session = array_column($cart_data, 'session_id');
                                            if (in_array($session_id, $session)) {
                                                echo array_count_values($session)[$session_id];
                                            } else {
                                                echo "0";
                                            }

                                            ?>
                                        </span>
                                    </button>
                                </li>
                                <li class="nav-item me-2">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-user"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="changePassword.php">Change Password</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="logoutadmin.php">Log Out</a></li>
                                        </ul>
                                    </div>
                                </li>


                            </ul>
                        </div>

                        <!-- widgets-wrap.// -->
                    </div> <!-- col.// -->
                </div> <!-- row.// -->
            </div> <!-- container.// -->
        </section> <!-- header-main .// -->
    </header>

    <main class="mt-5">
        <div class="container">
            <?php
            if ($total_row > 0) {
                foreach ($res as $row) {
            ?>
                    <div class="card mb-3 mx-auto" style="max-width: 850px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img style = "width:300px; height:300px;" src="image/<?php echo $row['images'] ?> " alt="..." class="mt-2" style="height: 300px;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"> <?php echo $row['title'] ?></h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item text-uppercase"> <label style = "font-family: consolas;">Ingrediants:</label><span class = ""><br><?php echo $row['description'] ?></span></li>
                                        <li class="list-group-item text-uppercase"><i class="fas fa-money-check-alt fa-lg"></i> Price: <span class="fw-bolder ps-2"><?php echo $row['price'] ?> €</span></li>
                                    </ul>
                                    <div class="container">
                                        <div class="row justify-content-md-center">
                                            <div class="col-md-auto">
                                                <form method="POST" action="add_to_card.php">
                                                    <div class="input-group mt-3">
                                                        <input type="number" name="quantity" class="form-control form-control-sm px-0 ms-5" value="1" min="1" max="<?= $row['qty'] ?>" aria-describedby="button-addon2">
                                                        <input type="hidden" name="hidden_name" value="<?php echo $row['title'] ?>">
                                                        <input type="hidden" name="hidden_price" value="<?php echo $row['price'] ?>">
                                                        <input type="hidden" name="hidden_id" value="<?php echo $row['id'] ?>">
                                                        <button class="btn btn-sm btn-primary px-5 me-5 me-5" name="add_to_cart" type="submit" id="button-addon2"><i class="fas fa-cart-plus"></i> Add To Card</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php  }
            } ?>
        </div>

        <!-- modal for shoping card -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <?php echo $message; ?>
                            <div align="right">

                                <a href="user_page.php?action=clear" class="btn btn-danger btn-sm mb-1"><b>Clear Cart <i class="fa fa-trash-alt"></i></b></a>
                            </div>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Item Name</th>
                                    <th width="10%">Quantity</th>
                                    <th width="20%">Price</th>
                                    <th width="15%">Total</th>
                                    <th width="5%">Action</th>
                                </tr>
                                <?php
                                if (isset($_COOKIE["shopping_cart"])) {

                                    //    echo "<pre>";
                                    //   print_r($_COOKIE["shopping_cart"]);

                                    $total = 0;
                                    $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                                    $cart_data = json_decode($cookie_data, true);


                                    $session_ID = array_column($cart_data, 'session_id');
                                    if (in_array($session_id, $session_ID)) {
                                        foreach ($cart_data as $keys => $values) {
                                            if ($cart_data[$keys]["session_id"] ==  $session_id) {



                                ?>
                                                <tr>
                                                    <td>

                                                        <?php echo $values["item_name"]; ?></td>
                                                    <td><?php echo $values["item_quantity"]; ?></td>
                                                    <td>$ <?php echo $values["item_price"]; ?></td>
                                                    <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                                                    <td><a href="user_page.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger"><i class="fa fa-trash"></i></span></a></td>
                                                </tr>
                                    <?php
                                                $total = $total + ($values["item_quantity"] * $values["item_price"]);
                                            }
                                        }
                                    }

                                    ?>
                                    <tr>
                                        <td colspan="3" align="right">Total</td>
                                        <td align="right">$ <?php echo number_format($total, 2); ?></td>
                                        <td></td>
                                    </tr>
                                <?php
                                } else {
                                    echo '
    <tr>
     <td colspan="5" align="center">No Item in Cart</td>
    </tr>
    ';
                                }

                                ?>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </main>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->


</body>

</html>