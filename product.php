<?php
include "product_class.php";
session_start();
if (empty($_SESSION['admin'])) {
    header('location: index.php');
}
if ($_SESSION['admin']['role'] == 'user') {
    header('location: index.php');
}
$addProducts = new Products();

$display = $addProducts->displayProduct();
// Update product in  table
if (isset($_POST['update'])) {
    $addProducts->updateRecord($_POST);
}
if (isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
    $deleteId = $_GET['deleteId'];
    $addProducts->delete($deleteId);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Product View!</title>
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
                            <a class="nav-link  active" href="product.php">
                                <i class="fas fa-shopping-cart"></i>
                                Products
                            </a>
                        </li>
                        <li class="nav-item  mb-2">
                            <a class="nav-link  text-white" href="add_product.php">
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
                        <?php
                        if (isset($_GET['msg2']) == "change") {
                            echo "
                                            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                            Password change successfully !
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>
";
                        }
                        ?>
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
                    <h1 class="h2">Display All Products</h1>
                </div>

                <div class="container">
                    <div class="row justify-content-md-center">
                        <div class="col-md-11">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    All Products
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (isset($_GET['msg3']) == "delete") {
                                        echo "
                                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                            Product deleted successfully
                                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                             </div>
                                            
                                            ";
                                    }elseif (isset($_GET['msg4']) == "update") {
                                        echo " <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                        Product update successfully
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                         </div>";
                                    }
                                    ?>
                                    <table id="example" class="table  responsive nowrap  table-responsive-sm" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Price</th>
                                                <th>Acion</th>
                                                <th>Image</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if (count($display)) {
                                                foreach ($display as $row) {
                                            ?>
                                                    <tr>

                                                        <td><?php echo ucfirst($row['title']) ?></td>
                                                        <td><?php echo $row['price'] ?> €</td>

                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm edit_data" id="<?php echo $row["id"]; ?>"  data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="fa fa-edit"></i> Update</button>
                                                            &nbsp;
                                                            <a href="product.php?deleteId=<?php echo $row['id'] ?>" class="btn btn-danger btn-sm" onclick="confirm('Are you sure want to delete this record')"><i class="fas fa-trash-alt"></i> Delete</a>
                                                        </td>

                                                        <td>
                                                            <?php $result = $row['images'] ?>
                                                            <img src="image/<?php echo $result ?>" class="img-responsive" width="50" height="50">

                                                        </td>


                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
             


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="product.php" method="POST">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update the product </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="update_details">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="update" class="btn btn-primary" id="update">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({
                "scrollX": true,
                "paging": true,
                "ordering": true,
                "info": false,

                "lengthMenu": [
                    [10, 15, 20, -1],
                    [10, 15, 20, "All"]
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search..."
                }

            });
            $(document).on("click", '.edit_data', function() {
            var edit_id = $(this).attr('id');
            console.log(edit_id);
            $.ajax({
                url: "update_product.php",
                type: "post",
                data: {
                    edit_id: edit_id
                },
                success: function(data) {
                    $('#update_details').html(data);
                    $('#exampleModal').modal('show');
                }
            });

        });



        });
    </script>

</body>

</html>