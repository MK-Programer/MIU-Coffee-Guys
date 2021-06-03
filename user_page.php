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
$Products = new Products();

$display = $Products->displayProduct();
$message = '';
if (isset($_GET["action"])) {
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
<!-- <a class="dropdown-item" href="logoutadmin.php">Long Out</a> -->

<?php
//  if(isset($_SESSION['License']) && !empty($_SESSION['License'])){
?>
<!-- <div class="alert alert-success text-center"> -->
<?php
// echo $_SESSION['License'];
?>
<!-- </div> -->
<?php
// }
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
                    <div class="col-lg-6 col-sm-12">
                        <form action="#" class="search  ms-5">
                            <div class="input-group w-100">
                                <input type="text" class="form-control" id="search_button" placeholder="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form> <!-- search-wrap .end// -->
                    </div> <!-- col.// -->
                    <div class="col-lg-4 col-sm-6 col-12">
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
                                            if(in_array($session_id,$session))
                                            {
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
                        <!-- <div class="widgets-wrap float-md-right">
			<div class="widget-header  mr-3">
				
			</div>
			<div class="widget-header icontext">
				<a href="#" class="icon icon-sm rounded-circle border"><i class="fa fa-user"></i></a>
				<div class="text">
					<span class="text-muted">Welcome!</span>
					<div> 
						<a href="#">Sign in</a> |  
						<a href="#"> Register</a>
					</div>
				</div>
			</div>

        </div>  -->
                        <!-- widgets-wrap.// -->
                    </div> <!-- col.// -->
                </div> <!-- row.// -->
            </div> <!-- container.// -->
        </section> <!-- header-main .// -->
    </header>

    <main class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-5 col-lg-3  p-3">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Brand
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <?php
                                    if (count($display)) {
                                        $events = array();
                                        foreach ($display as $row) {
                                            $events[] = $row['model'];
                                            $events = array_unique($events);
                                        }
                                        foreach ($events as $e) {
                                    ?>
                                            <div class="list-group-item checkbox">
                                                <label><input type="checkbox" class="common_selector brand" value="<?php echo $e ?>"> <?php echo ucfirst($e) ?></label>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 col-lg-9  p-3">
                    <div class="container  mb-5">
                        <div class="row">
                            <div class="col-md-7 offset-md-3">
                                <div class="d-flex">
                                    <hr class="my-auto flex-grow-1">
                                    <div class="px-3 text-uppercase fs-2">ALL PRODUCT</div>
                                    <hr class="my-auto flex-grow-1">
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="container">
                        <div class="row filter_data">
                            <?php
                            if (isset($display) && !empty($display)) {
                                foreach ($display as $row) {


                            ?>

                            <?php
                                }
                            }
                            ?>
                        </div>
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
                                                        if($cart_data[$keys]["session_id"] ==  $session_id){



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
    <script>
        $(document).ready(function() {
            $('input[type="radio"]').click(function() {
                var radio = $(this).val();
                console.log(radio);
                $.ajax({
                    url: "fetch_radio.php",
                    method: "POST",
                    data: {
                        radio: radio

                    },
                    success: function(data) {
                        $('.filter_data').html(data);
                    }
                });
            });
            filter_data();
            load_data();

            function filter_data() {
                var action = 'fetch_data';
                var brand = get_filter('brand');
                var hardware = get_filter('hardware');
                var display = get_filter('display');


                $.ajax({
                    url: "fetch_data.php",
                    method: "POST",
                    data: {
                        action: action,
                        brand: brand,
                        hardware: hardware,
                        display: display
                    },
                    success: function(data) {
                        $('.filter_data').html(data);
                    }
                });
            }

            function get_filter(class_name) {
                var filter = [];
                $('.' + class_name + ':checked').each(function() {
                    filter.push($(this).val());
                });
                return filter;
            }

            function load_data(query) {
                $.ajax({
                    url: "fetch.php",
                    method: "POST",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('.filter_data').html(data);
                    }
                });
            }
            $('#search_button').keyup(function() {
                var search = $(this).val();

                if (search != '') {
                    load_data(search);
                } else {
                    load_data();
                }
            });
            $('.common_selector').click(function() {
                filter_data();
            });



        });
    </script>

</body>

</html>