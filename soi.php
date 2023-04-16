<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Supplier Order Invoice </title>
  </head>
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

function loadvalues() {
  var po = document.getElementById("po").value;

var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function () {
  if (this.readyState == 4 && this.status == 200) {
    var response = JSON.parse(this.responseText);
    document.getElementById("item_code").value = response.item_code;
    document.getElementById("description").value = response.description;
    document.getElementById("quantity").value = response.quantity;
    document.getElementById("tax").value = response.tax;
   

    var quantity = document.getElementById("quantity").value;
    if (!isNaN(quantity)) {
      const xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          const response = JSON.parse(this.responseText);
          const units = parseFloat(response.units);
          const rate_unit = parseFloat(response.rate_unit);
          const x = rate_unit;
          const price = x * units;
          document.getElementById("price").value = price.toFixed(2);
          const y = price * quantity;
          document.getElementById("Amount").value = y.toFixed(2);
        } else {
          document.getElementById("Amount").value = "";
        }
      };
      xhttp.open("GET", "get_units_rate_unit_value.php?quantity=" + encodeURIComponent(quantity), true);
      xhttp.send();
    } else {
      document.getElementById("xhttp").value = "";
    }//from here i break
    }
};
xhr.open("GET", "get_soi.php?po=" + po, true);
xhr.send();

var xnr = new XMLHttpRequest();
xnr.onreadystatechange = function () {
  if (this.readyState == 4 && this.status == 200) {
    var response = JSON.parse(this.responseText);
   var Freight= document.getElementById("Freight").value = response.Freight;
  var Discount=  document.getElementById("Discount").value = response.Discount;
  
}
};
xnr.open("GET", "get_otherexpances.php?po=" + po, true);
xnr.send();

  var F = document.getElementById("Freight").value;
  var D = document.getElementById("Discount").value;

var xpr = new XMLHttpRequest();
xpr.onreadystatechange = function() {

  if (this.readyState == 4 && this.status == 200) {
          const response = JSON.parse(this.responseText);
           const t = parseFloat(response.total_value);
         
          const x = (t*F/100)+t;
   
          const y = x-(t*D/100);
           document.getElementById("total").value = y.toFixed(2);
          
       } else {
          document.getElementById("total").value = "";
        }
    };
      xpr.open("GET", "get_total.php?po=" + encodeURIComponent(po), true);
      xpr.send();

}
</script>
  <body>
    <h3>Supplier Order Invoice</h3>
    <button onclick="loadsoitable()">Supplier order table</button>
  <script>
  function loadsoitable()
  {
    window.location.href = 'soitable.php';
  }
  </script><br><br>
    <form action="" method="post">
    Date:<input name= "date" type="date" value="date" /> 
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
 $sql = "SELECT MAX(id) as max_id FROM supplier_order_invoice"; 
 $result = mysqli_query($conn, $sql);
  
 if($result && mysqli_num_rows($result) > 0) {
   $row = mysqli_fetch_assoc($result);
   $id = $row['max_id'] + 1;
 } else {
   $id = 1;
 }
 
$id_formatted = sprintf("%03d", $id);
$SOBI_number = "SOBI-" . $date . "-" . $id_formatted;
?>
    <label for="po">SOBI:</label>
    <input type="text" id="sobi" name="sobi" value="<?php echo $SOBI_number; ?>">
    <br><br>

   <?php
    $now = new dateTime();
    $date= $now->format('Y');

    $servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_module";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
  }
  $sql = "SELECT MAX(id) as max_id FROM supplier_order_invoice";

  $result = mysqli_query($conn,$sql);

  while($row = mysqli_fetch_assoc($result))
  {
    $id = $row['max_id'] + 1;
  }
  $SOBI_formatted = sprintf("%02d", $id);
  $BOOK_INVOICE =$date."\\"."INV-". $SOBI_formatted;

    ?>
      <label for="invoice">INVOICE:</label>
    <input type="text" id="invoice" name="invoice" value="<?php echo $BOOK_INVOICE; ?>">
    <br><br>

   TYPE:<select name= type>
      <option name="type">Supplier</option>
      <option name="type">Tax master</option>
    </select>
    Vendor:<select name="name" id="name" onchange="loadcode()";>
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
    Vendor code:<select  name="code" id="code">
      <option>--select option--</option>
    </select>
    GR:<select name="po" id="po" onchange="loadvalues()" >
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
            $sql= "select distinct po from purchase_order";
            $result = mysqli_query($conn,$sql);
            while($row= mysqli_fetch_assoc($result))
            {
               echo "<option value=\"" . $row['po'] . "\">" . $row['po'] . "</option>";
            }
            ?>
    </select>
    <br><br><br>
    <div style="display: inline-block; width: 12%;">
        <label for="code">code</label><br><br>
        <input type="text" name="item_code" id="item_code">
    </div>
    <div style="display: inline-block; width: 12%;">
        <label for="Description">Description</label><br><br>
        <input type="text" name="description" id="description">
    </div>
    <div style="display: inline-block; width: 12%;">
        <label for="Quantity">Quantity</label><br><br>
        <input type="number" name="quantity" id="quantity">
    </div>
    <div style="display: inline-block; width: 12%;">
        <label for="Price">Price</label><br><br>
        <input type="number" name="price" id="price">
    </div>
    <div style="display: inline-block; width: 12%;">
        <label for="Amount">Amount</label><br><br>
        <input type="number" name="Amount" id="Amount">
    </div>
    <div style="display: inline-block; width: 12%;">
        <label for="Tax">Tax</label><br><br>
        <input type="text" name="tax" id="tax">
    </div>
    <div style="display: inline-block; width: 12%;">
        <label for="Freight">Freight(in percent)</label><br><br>
        <input type="float" name="Freight" id="Freight">
    </div>
    <div style="display: inline-block; width: 12%;">
        <label for="Discount">Discount(in percent)</label><br><br>
        <input type="float" name="Discount" id="Discount">
    </div>
    <div style="display: inline-block; width: 12%;">
        <label for="Total">Total</label><br><br>
        <input type="double" name="total" id="total">
    </div>

    <div style="text-align:center">
   <input type="submit" value="submit">
   <button>cancel</button>
   </div>
  </form>
   
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
 if(isset( $_POST['type'])){
 $type = $_POST['type'];
 $date = $_POST['date'];
 $sobi = $_POST['sobi'];
 $invoice = $_POST['invoice'];
 $name = $_POST['name'];
 $code = $_POST['code'];
 $po = $_POST['po'];
 $item_code = $_POST['item_code'];
 $description = $_POST['description'];
 $quantity = $_POST['quantity'];
 $price = $_POST['price'];
 $Amount = $_POST['Amount'];
 $tax = $_POST['tax'];
 $Freight = $_POST['Freight'];
 $Discount= $_POST['Discount'];
 $total = $_POST['total'];


$sql= "INSERT INTO `supplier_order_invoice` ( `type`, `date`, `sobi`, `invoice`, `name`, `code`, `po`, `item_code`, `description`, `quantity`, `price`, `Amount`, `tax`, `Freight`, `Discount`, `total`) VALUES ( '$type', '$date', '$sobi', '$invoice', '$name', '$code', '$po', '$item_code', '$description', '$quantity', '$price', '$Amount', '$tax', '$Freight', '$Discount', '$total')";

 if(mysqli_query($conn,$sql))
 {
  echo "Data inserted successfully";
 }
 else
 {
  echo "data creation failed". mysqli_error($conn);
 }
}
?>

