<?php
//https://mniprince.com
//01711368394
$connect = new PDO("mysql:host=localhost;dbname=testing4", "root", "");
if(isset($_POST["pr_title"]))
{
 
 
 for($count = 0; $count < count($_POST["pr_title"]); $count++)
 {  
  $query = "INSERT INTO products 
  (pr_title, pr_quantity, unit_type, u_price, bid, rid) 
  VALUES (:pr_title, :item_quantity, :unit, :u_price, :item_brand, :item_region)
  ";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    ':pr_title'  => $_POST["pr_title"][$count], 
    ':item_quantity' => $_POST["item_quantity"][$count], 
    ':unit' => $_POST["unit"][$count], 
    ':u_price' => $_POST["u_price"][$count], 
    ':item_region' => $_POST["item_region"][$count], 
    ':item_brand'  => $_POST["item_brand"][$count]
   )
  );
 }
 $result = $statement->fetchAll();
 if(isset($result))
 {
  echo 'ok';
 }
}
?>
