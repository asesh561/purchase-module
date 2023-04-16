<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<style>
    div,lebel{
        color: blue;
    }
</style>

<script>
    function loadcode() {
  var name = document.getElementById("name").value;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("code").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "get_code.php?name=" + name, true);
  xhttp.send();
}
function loaditem() {
  var category = document.getElementById("category").value;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("item_code").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "get_itemcode.php?category=" + category, true);
  xhttp.send();
}
function loaddesc(){
  var item_code = document.getElementById("item_code").value;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("description").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "get_desc.php?item_code="+item_code,true);
  xhttp.send();
}

</script> 


<body>
  <button onclick="loadpurchaseordertable()">purchase order table</button>
  <script>
  function loadpurchaseordertable()
  {
    window.location.href = 'purchaseordertable.php';
  }

</script>
    <form action="" method="post" >
    <h3>Purchase order</h3>
    Date:<input type="date" name="date">
   
   <?php

// Get the current date and time
$now = new DateTime();

// Format the date as month and year
$date = $now->format('my');


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_module";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());

 }
 $sql = "SELECT MAX(id) as max_id FROM purchase_order"; 
 $result = mysqli_query($conn, $sql);
  
 if($result && mysqli_num_rows($result) > 0) {
   $row = mysqli_fetch_assoc($result);
   $id = $row['max_id'] + 1;
 } else {
   $id = 1;
 }
 
$id_formatted = sprintf("%03d", $id);


$po_number = "PO-" . $date . "-" . $id_formatted;



?>
 <label for="po">P.O:</label>
    <input type="text" id="po" name="po" value="<?php echo $po_number; ?>">
    <br><br>
    vendar:<select name="name" id="name" onchange="loadcode()";>
        <option>--select option--</option>
        <?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_module";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());

 }
 $sql= "select distinct name from supplier";
 $result = mysqli_query($conn,$sql);
 while($row= mysqli_fetch_assoc($result))
 {
    echo "<option value=\"" . $row['name'] . "\">" . $row['name'] . "</option>";
 }
 ?>
    </select>
    vendar_code:<select name="code" id="code">
        <option>--select option--</option>
    </select> 
    Doc no :<input type="text" name="dn">
    <script>
      // Get the counter value from local storage or set it to 0
      var counter = localStorage.getItem('counter') || 0;
      
      // Increment the counter value and display it on the page
      document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('input[name="dn"]').value = ++counter;
        localStorage.setItem('counter', counter);
      });
    </script>
    <br><br>

    <div style="display: inline-block; width:12% ;">
        <label for="category">category</label><br><br>
        <select name="category" id="category" onchange = "loaditem()";>
            <option>--select option--</option>
            <?php 
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "purchase_module";
            
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if (!$conn) {
               die("Connection failed: " . mysqli_connect_error());
            
             }
             $sql= "select distinct category from item";
             $result = mysqli_query($conn,$sql);
             while($row= mysqli_fetch_assoc($result))
             {
                echo "<option value=\"" . $row['category'] . "\">" . $row['category'] . "</option>";
             }
            ?>
        </select>
    </div>
    <div style="display: inline-block; width:12% ;">
        <label for="Iteam code">Iteam code</label><br><br>
        <select name="item_code" id="item_code" onchange="loaddesc()"; >
            <option>--select option--</option>
        </select>
    </div>
    <div style="display: inline-block; width:12% ;">
        <label for="Description">Description</label><br><br>
        <select name="description" id="description">
            <option>--select option--</option>
        </select>
    </div>
    <div style="display: inline-block; width: 12%; position: relative; right: 33px;">
        <label for="Quantity">Quantity</label><br><br>
        <input type="number" name="quantity"id="quantity">
    </div>

    <div style="display: inline-block; width: 12%;">
        <label for="Units">Units</label><br><br>
        <input type="number" name="units" id="units">
    </div>

    <div style="display: inline-block; width: 12%; position: relative; left: 30px;">
  <label for="rate_unit">Rate/Unit</label><br><br>
  <input type="number" name="rate_unit" id="rate_unit">
</div>

<div style="display: inline-block; width: 12%; position: relative; left: 77px;">
  <label for="Delivery Date">Delivery Date</label><br><br>
  <input type="date" name="delivery_date">
</div>
<div style="display: inline-block; width:12%;position: relative;
   left: 50px;">
    <label for="Tax">Tax</label><br><br>
    <select name="tax" id="tax" onchange="calculateTotal()">
        <option>--select option--</option>

        <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "purchase_module";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
       die("Connection failed: " . mysqli_connect_error());
    
    }
     
    $sql = "SELECT DISTINCT tc FROM tax_master";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "<option value=\"" . $row['tc'] . "\">" . $row['tc'] . "</option>";
        }
    } else {
        echo "No results found.";
    }
     
    mysqli_close($conn);
    ?>
        
    </select>
</div><br><br>
<div style="text-align: center;">
<div style="display: inline-block; width:12%; ">
<label for="total value">Total value</label>
<input type="float" name="total_value" id="total_value">

</div><br><br>
<div style="text-align: center;">
<input type="submit" value="save">
<input type="submit" value="cancel">
</div>
</form>
<script>
  function calculateTotal() {
    const rate_unit = parseFloat(document.getElementById("rate_unit").value);
    const quantity = parseFloat(document.getElementById("quantity").value);
    const units = parseFloat(document.getElementById("units").value);
    const taxCode = document.getElementById("tax").value;
    
    if (!isNaN(units) && taxCode) {
      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          const taxCodeValue = parseFloat(this.responseText);
          if (!isNaN(taxCodeValue)) {
            const x = units * rate_unit*quantity;
            var total = x+x*(taxCodeValue/100);
            document.getElementById("total_value").value = total.toFixed(2);
          } else {
            document.getElementById("total_value").value = "";
          }
        }
      };
      xhr.open("GET", "get_tax_code_value.php?tc=" + encodeURIComponent(taxCode), true);
      xhr.send();
    } else {
      document.getElementById("total_value").value = "";
    }
  }
</script>
<script src = script.js></script>
</body>
</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_module";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());

}
if(isset($_POST['rate_unit'])){
$date=$_POST['date'];
$rate_unit=$_POST['rate_unit'];
$units = $_POST['units'];
$quantity = $_POST['quantity'];
$description = $_POST['description'];
$total_value=$_POST['total_value'];
$tax=$_POST['tax'];
$delivery_date=$_POST['delivery_date'];
$po=$_POST['po'];
$dn = $_POST['dn'];
$category= $_POST['category'];
$item_code = $_POST['item_code'];
$name = $_POST['name'];
$code = $_POST['code'];

$sql = "INSERT INTO `purchase_order` ( `date`, `rate_unit`, `units`, `quantity`, `description`, `total_value`, `tax`, `delivery_date`, `po`, `dn`, `category`, `item_code`, `name`, `code`) VALUES ( '$date', '$rate_unit', '$units', '$quantity', '$description', '$total_value', '$tax', '$delivery_date', '$po', '$dn', '$category', '$item_code', '$name', '$code')";

if(mysqli_query($conn,$sql))
  {
    echo "data created successfully";
  }
  else
  {
    echo "data creation failed". mysqli_error($conn);
  }

}


?>


  
  
