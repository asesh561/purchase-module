<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_module";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());

 }
 ?>
 
<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid green;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
.container{
  text-align: right;
}

</style>
</head>

<body>

<h2>Supplier Order Invoice TABLE</h2>
<div style="padding:0.5%; float: right;">
  <button onclick="pagechange()">CREATE TABLE</button>
</div>
<div style="padding:0.5%;">
  <button onclick="Home()">Home</button>
</div>
<script>
function Home(){
   window.location.href='Home.php';
}
</script>

<div style="text-align:center">

 <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_module";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
 }


?>
 
<table id="table">
  <tr>
    <th>ID</th>
    <th>DATE</th>
    <th>SOBI</th>
    <th>INVOICE</th>
    <th>TYPE</th>
    <th>VENDOR</th>
    <th>VENDOR CODE</th>
    <th>PO</th>
    <th>ITEM_CODE</th>
    <th>DESCRIPTION</th>
    <th>QUANTITY</th>
    <th>PRICE</th>
    <th>AMOUNT</th>
    <th>TAX</th>
    <th>FREIGHT</th>
    <th>DISCOUNT</th>
    <th>TOTAL</th>
    <th>ACTION</th>
 </tr>
  <?php
  //$id=12;//$_GET['id'];
  $sql= "select * from supplier_order_invoice ";
  $result = mysqli_query($conn,$sql);
  if(mysqli_num_rows($result)>0)
  {
    while($row=mysqli_fetch_assoc($result))
    {
      
      
      ?>
      <tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['date']; ?></td>
    <td><?php echo $row['sobi']; ?></td>
    <td><?php echo $row['invoice']; ?></td>
    <td><?php echo $row['type']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['code']; ?></td>
    <td><?php echo $row['po']; ?></td>
    <td><?php echo $row['item_code']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td><?php echo $row['quantity']; ?></td>
    <td><?php echo $row['price']; ?></td>
    <td><?php echo $row['Amount']; ?></td>
    <td><?php echo $row['tax']; ?></td>
    <td><?php echo $row['Freight']; ?></td>
    <td><?php echo $row['Discount']; ?></td>
    <td><?php echo $row['total']; ?></td>
    <td><a href="delete_soi.php?id=<?php echo $row['id']; ?> ">&#10060;</td>
    </tr>
  
  <?php } } ?>
 
</table>

</body>
</form>
<script>
  function pagechange(){
    window.location.href = 'taxmaster.php';
  }
</script>

</html>