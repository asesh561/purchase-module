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

<h2>Purchase Order TABLE</h2>
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
    <th>P.O</th>
    <th>DOC.NO</th>
    <th>VENDOR</th>
    <th>VENDOR CODE</th>
    <th>CATEGORY</th>
    <th>ITEM CODE</th>
    <th>DESCRIPTION</th>
    <th>QUANTITY</th>
    <th>UNITS</th>
    <th>RATE/UNIT</th>
    <th>DELIVERY DATE</th>
    <th>TAX</th>
    <th>ACTION</th>
    
 </tr>
  <?php
  //$id=12;//$_GET['id'];
  $sql= "select * from purchase_order";
  $result = mysqli_query($conn,$sql);
  if(mysqli_num_rows($result)>0)
  {
    while($row=mysqli_fetch_assoc($result))
    {
      
      
      ?>
      <tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['date']; ?></td>
    <td><?php echo $row['po']; ?></td>
    <td><?php echo $row['dn']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['code']; ?></td>
    <td><?php echo $row['category']; ?></td>
    <td><?php echo $row['item_code']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td><?php echo $row['quantity']; ?></td>
    <td><?php echo $row['units']; ?></td>
    <td><?php echo $row['rate_unit']; ?></td>
    <td><?php echo $row['delivery_date']; ?></td>
    <td><?php echo $row['tax']; ?></td>
    <td><a href="delete_taxmaster.php?id=<?php echo $row['id']; ?> ">&#10060;</td>
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