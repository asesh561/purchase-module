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

<h2>PAYMENT TABLE</h2>
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
    <th>DOC NO</th>
    <th>DATE</th>
    <th>COST CENTER</th>
    <th>VENDOR</th>
    <th>VENCOR CODE</th>
    <th>PAYMENT METHOD</th>
    <th>CHOICE</th>
    <th>PAYMENT MODE</th>
    <th>COSH CODE</th>
    <th>CODE</th>
    <th>DESCRIPTION</th>
    <th>CR</th>
    <th>AMOUNT</th>
    <th>NARRATION</th>
    <th>ACTION</th>
 </tr>
  <?php
  //$id=12;//$_GET['id'];
  $sql= "select * from payment_details ";
  $result = mysqli_query($conn,$sql);
  if(mysqli_num_rows($result)>0)
  {
    while($row=mysqli_fetch_assoc($result))
    {
      
      
      ?>
      <tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['dn']; ?></td>
    <td><?php echo $row['date']; ?></td>
    <td><?php echo $row['cost_center']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['code']; ?></td>
    <td><?php echo $row['payment_method']; ?></td>
    <td><?php echo $row['choice']; ?></td>
    <td><?php echo $row['payment_mode']; ?></td>
    <td><?php echo $row['cash_code']; ?></td>
    <td><?php echo $row['code1']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td><?php echo $row['cr']; ?></td>
    <td><?php echo $row['Amount']; ?></td>
    <td><?php echo $row['narration']; ?></td>
    <td><a href="delete_payment.php?id=<?php echo $row['id']; ?> ">&#10060;</td>
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