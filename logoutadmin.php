<?php
session_start();

include "class.php";
$class = new Person();
$id =  $_SESSION['admin']['id'];
$query = "UPDATE users SET online='0' WHERE id='$id'";

$sql = $class->con->query($query);

if($sql){
    header("location: index.php");
    session_destroy();
}else{
    header("location: user_page.php");
}



?>