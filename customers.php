<?php
include "product_class.php";
session_start();
//  echo $_SESSION['admin']['id'];
//  echo $_SESSION['admin']['email'];
//  echo $_SESSION['admin']['password'];
//  echo $_SESSION['admin']['role'];
if (empty($_SESSION['admin'])) {
    header('location: index.php');
}
if ($_SESSION['admin']['role'] == 'user') {
    header('location: index.php');
}
$users = new Products();

$display = $users->displayUsers();

if(isset($_GET['deleteId']) && !empty($_GET['deleteId'])){
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
                            <a class="nav-link  text-white" href="product.php">
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
                            <a class="nav-link  active" href="customers.php">
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
                    <h1 class="h2">Display All Customers</h1>
                </div>
                
                <div class="container">
                    <div class="row justify-content-md-center">
                        <div class="col-md-11">
                            <div class="card">
                                <div class="card-header bg-primary">
                                Customers
                                </div>
                                <div class="card-body">
                                    <?php 
                                          if (isset($_GET['msg3']) == "delete") {
                                            echo "<div class='alert alert-danger alert-dismissible'>
                                              <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                              Record deleted successfully
                                            </div>";
                                        }
                                        ?>
                                <table id="example" class="table  responsive nowrap  table-responsive-sm" style="width:100%">  
                                        <thead>
                                            <tr>        
                                                <th>Name</th>
                                                <th>Surname</th>
                                                <th>Email</th>
                                                <th>Create at</th>
                                                <th>License</th>
                                                <th>Activited</th>
                                                <th>Statusi</th>
                                                <th>Online</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if (count($display)) {
                                                foreach ($display as $row) {
                                            ?>
                                                    <tr>
                                              
                                                        <td><?php echo ucfirst($row['name']) ?></td>
                                                        <td><?php echo $row['lastname'] ?></td> 
                                                        <td><?php echo $row['email'] ?></td>
                                                        <td><?php
                                                        echo date("Y-m-d",strtotime($row['create_date']));
                                                       ?></td>
                                                        <td><?php echo $row['license_date'] ?></td> 
                                                        <td class="text-center"><?php  if($row['active_status'] == "verified"){
                                                            ?> <i class="fas fa-check text-success"></i>
                                                         <?php }else{
                                                             ?>
                                                             <i class="fas fa-exclamation text-warning"></i>
                                                             <?php 
                                                         }
                                                         ?>
                                                    
                                                       </td>
                                                       <td class="text-center">
                                                       <div class="form-check form-switch">
  <input type="checkbox"   id='<?php echo $row['id'] ?>' class="form-check-input " <?php echo $row['status']=='0'?'checked':'' ?> > 
</div>
                </td>  
                                                       
                <td>
                  <?php 
                     if($row['online'] == '0'){ ?>
               <div class="text-center">
                <i class="fa fa-user fa-lg" style="color:red"></i>
              </div>
                   <?php
                     }if($row['online'] == '1'){ ?>
                       <div class="text-center">
                <i class="fa fa-user fa-lg" style="color:green"></i>
              </div>
                  <?php
                     }
                  ?>
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
//    $('#example').DataTable( {
//        "scrollX": true,
//         "paging":   true,
//         "ordering": true,
//         "info":     false,

//         "lengthMenu": [[10, 15, 20, -1], [10, 15, 20, "All"]],
//         language: {
//         search: "_INPUT_",
//         searchPlaceholder: "Search..."
//     }
  
//     } );
    $('.form-check-input').change(function () {
        var id = $(this).attr("id");  
        var check = ($(this).is(':checked')) ? '0' : '1';
        console.log(id);
        $.ajax({
            type: 'POST',
            url: 'changeStatus.php',  
            data: { id:id, check: check },
            success: function (result) {
               setTimeout(function() {
                  location.reload();
                     }, 1000);
            }
          
        });
    });

  
} );
</script>

</body>

</html>