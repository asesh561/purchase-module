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

<h2>SUPPLIER DETAILS</h2>
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
    <th>name</th>
    <th>code</th>
    <th>place</th>
    <th>email</th>
    <th>address</th>
    <th>phone</th>
    <th>contact</th>
    <th>pan</th>
    <th>supplier_group</th>
    <th>currency</th>
    <th>note</th>
    <th>Action</th>
  </tr>
  <?php
  //$id=12;//$_GET['id'];
  $sql= "select * from supplier ";
  $result = mysqli_query($conn,$sql);
  if(mysqli_num_rows($result)>0)
  {
    while($row=mysqli_fetch_assoc($result))
    {
      
      
      ?>
      <tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['code']; ?></td>
    <td><?php echo $row['place']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['address']; ?></td>
    <td><?php echo $row['phone']; ?></td>
    <td><?php echo $row['contact']; ?></td>
    <td><?php echo $row['pan']; ?></td>
    <td><?php echo $row['supplier_group']; ?></td>
    <td><?php echo $row['currency']; ?></td>
    <td><?php echo $row['note']; ?></td>
    <td><a href="delete.php?id=<?php echo $row['id']; ?> ">&#10060;</td>
    </tr>
  
  <?php } } ?>
 
</table>

</body>
</form>
<script>
  function pagechange(){
    window.location.href = 'createsupplier.php';
  }
</script>

</html>