<?php
include "product_class.php";
session_start();

$changePassword = new Products();
$id = $_SESSION['admin']['id'];

if (isset($_POST['submit'])) {
    $changePassword->changePassword($_POST, $id);
    $error = $changePassword->get_errors();
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

    <title>Hello, world!</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-5 offset-md-3">
                <div class="card">
                    <div class="card-header  text-white bg-primary">
                        Change Password
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($error)) {
                            foreach ($error as $e) { ?>

                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo $e; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                        <?php }
                        } ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Old Password</label>
                                <input type="password" class="form-control" id="formGroupExampleInput" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput2" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="formGroupExampleInput2" name="Newpassword">
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput2" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="formGroupExampleInput2" name="CNewpassword">
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button class="btn btn-outline-primary" type="submit" name="submit">Button</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>

</body>

</html>