<?php
include "class.php";
$change = new Person();
 if(isset($_POST["id"]) && isset($_POST["check"]))   { 
    $id = $_POST['id'];
    $check = $_POST['check'];

$query = "UPDATE users SET status = $check WHERE  id = $id";

$sql = $change->con->query($query);
if ($sql == true) {
    header("Location:customers.php");
} else {
    echo "Registration updated failed try again!";
}


    // $stmt = $this->con->prepare("UPDATE register SET status=? WHERE id=?");
    // $stmt->bind_param('si', $check, $id);
    // $stmt->execute();
    //  $statement->close();

}
?>