<?php
class DB {
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "Shopping Cart EAV";
	public $conn;

	function __construct() {
		$this->conn = $this->connectDB();
	}

	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
}

class Product {
	public $id;
	public $name;
	public $image;
	public $price;
	public $options;
	function __construct($id) {
		$db_handle = new DB();
		$sql="SELECT * FROM product WHERE id=".$id;
		$product = mysqli_query($conn,$sql);
		if($id!="")
		{
			if ($row=mysqli_fetch_array($product))
			{
				$this->id=$row["id"];
				$this->name=$row["name"];
				$this->image=$row["image"];
				$this->price=$row["price"];
				$this->options=new productType($row["product_Type"]);
			}

		}
	}

	static function getAllProducts()	{
		$conn=mysqli_connect("localhost","root","","shopping cart eav");
		$sql="select * from products";
		$products=mysqli_query($conn,$sql);
		$i=0;
		$result;
		while($row = mysqli_query($conn,$sql);
		{
			$myobj=new product($row["id"]);
			$result[$i]=$myobj;
			$i++;
		}
		return $result;
	}
}

class Cart{
	public $productsQuantity;

	function __construct(){
		$this->productsQuantity=array();
	}

	function addProduct($productID,$q){		
	/////////////complete////////////////////
	}

	function removeProduct($productID){
	/////////////complete////////////////////
	}

	function emptyCart(){
	/////////////complete////////////////////
	}
}

?>