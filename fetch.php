
<?php

//fetch_data.php

include "product_class.php";
$display = new Products();

 if(isset($_POST["query"])){
    $search = $_POST["query"];
    $query = "
  SELECT * FROM products 
  WHERE title LIKE '%".$search."%'
  OR model LIKE '%".$search."%' 
 ";
 }else
 {
  $query = "
   SELECT * FROM products ORDER BY id
  ";
 }
 
 $res = $display->con->query($query);
 $result = $res->fetch_all(MYSQLI_ASSOC);

 $total_row = $res->num_rows;
 $output = '';
 if($total_row > 0)
 {
  foreach($res as $row)
  {
   $output .= '
   <div class="col-md-3  col-lg-4 ">
   <form method="POST" action="add_to_card.php">
   <div class="card h-100 my-2">
       <img src="image/'. $row['images'] .'" class="img card-img-top position-relative" alt="..." style="height: 250px;">
       <div class="w3-animate-top img-s d-grid gap-2 col-12 mx-auto position-absolute bottom-50 start-0">
       <a href="showmore.php?action=show&id='. $row["id"] .'" class="btn mx-2 fw-bolder btn-primary" role="button">Show Info  <i class="fas fa-eye"></i></a>
       </div>
       <div class="card-body">
           <h5 class="card-title">'. $row['title'] .'</h5>
           <h6 class="card-subtitle mb-2 text-muted">'. $row['price'] .' €</h6>
  
           <div class="input-group mb-3">
           <input type="number" name="quantity" class="form-control form-control-sm" value="1" aria-describedby="button-addon2">
           <input type="hidden" name="hidden_name" value="'.$row['title'].'">
          <input type="hidden" name="hidden_price" value='. $row["price"] .' />
          <input type="hidden" name="hidden_id" value='. $row["id"] .' />
          <button class="btn btn-sm btn-primary px-4 ms-2" name="add_to_cart" type="submit" id="button-addon2"><i class="fas fa-cart-plus"></i> Add To Card</button>
        </div>


         
       </div>
    </div>
  
   </form>

   </div>
   ';
  }
 }
 else
 {
  $output = '<h3>No Data Found</h3>';
 }
 echo $output;



?>