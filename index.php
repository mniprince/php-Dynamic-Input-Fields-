<?php
//https://mniprince.com
//01711368394
$connect = new PDO("mysql:host=localhost;dbname=testing4", "root", "");


function fill_brand_select_box($connect)
{ 
 $brandoutput = '';
 $query = "SELECT * FROM brands ORDER BY brand ASC";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $brandoutput .= '<option value="'.$row["bid"].'">'.$row["brand"].'</option>';
 }
 return $brandoutput;
}

function fill_region_select_box($connect)
{ 
 $brandoutput = '';
 $query = "SELECT * FROM regions ORDER BY region ASC";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $brandoutput .= '<option value="'.$row["rid"].'">'.$row["region"].'</option>';
 }
 return $brandoutput;
}

?>
<!DOCTYPE html>
<html>
 <head>
  <title>Add Remove Select Box Fields Dynamically using jQuery Ajax in PHP</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br />
  <div class="container">
   <h3 align="center">Add Remove Select Box Fields Dynamically using jQuery Ajax in PHP</h3>
   <br />
   <h4 align="center">Enter Item Details</h4>
   <br />
   <form method="post" id="insert_form">
    <div class="table-repsonsive">
     <span id="error"></span>
     <table class="table" id="item_table">
      <tr >
       <th style="background-color:#87CEFA;">Product title</th>
       <th style="background-color:#87CEFA;">Quantity</th>
       <th style="background-color:#87CEFA;">Unit</th>
       <th style="background-color:#87CEFA;">Unit Price</th>
       <th style="background-color:#87CEFA;">Region</th>
       <th style="background-color:#87CEFA;">Brand</th>
        </tr>
     </table>
	 <div align="left">
      <button type="button" name="add" class="btn btn-info btn-sm add"><span class="glyphicon glyphicon-plus"></span></button>
     </div>
     <div align="center">
      <input type="submit" name="submit" class="btn btn-primary" value="Add Products" />
     </div>
    </div>
   </form>
  </div>
 </body>
</html>

<script>
$(document).ready(function(){

 $(document).on('click', '.add', function(){
	 
  var html = '';
  html += '<tr style="border: 0px solid white;">';
  html += '<td><input type="text" name="pr_title[]" class="form-control pr_title" placeholder="Title" required/></td>';
  html += '<td><input type="number" name="item_quantity[]" class="form-control item_quantity" placeholder="Quantity" required/></td>';
  html += '<td><input type="text" name="unit[]" class="form-control unit" placeholder="Unit" required/></td>';
  html += '<td><input type="number" name="u_price[]" class="form-control u_price" placeholder="Unit Price" required/></td>';
  html += '<td><select name="item_region[]" class="form-control item_region"><option value="">Select Region</option><?php echo fill_region_select_box($connect); ?></select></td>';
  html += '<td><select name="item_brand[]" class="form-control item_brand"><option value="">Select Brand</option><?php echo fill_brand_select_box($connect); ?></select></td>';
  html += '<td style="border: 0px solid white;"><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';
  $('#item_table').append(html);
  
 });
 
 $(document).on('click', '.remove', function(){
  $(this).closest('tr').remove();
  
 });
 
 

 
 $('#insert_form').on('submit', function(event){
  event.preventDefault();
  var error = '';
  $('.pr_title').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Enter Product Title at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });
  
  
  
  $('.item_quantity').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Enter Item Quantity at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });
  
  $('.unit').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Enter Unit Type at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });
  
  $('.u_price').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Enter Unit Price at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });
  
  $('.item_region').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Select Region at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });
  
  $('.item_brand').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Select Brand at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });
  var form_data = $(this).serialize();
  if(error == '')
  {
   $.ajax({
    url:"pro_insert.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     if(data == 'ok')
     {
      $('#item_table').find("tr:gt(0)").remove();
      $('#error').html('<div class="alert alert-success">Item Details Saved</div>');
     }
    }
   });
  }
  else
  {
   $('#error').html('<div class="alert alert-danger">'+error+'</div>');
  }
 });
 
});


</script>
