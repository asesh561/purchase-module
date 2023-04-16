<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_module";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());

 }
 $id=$_GET['id'];
 $sql= "DELETE FROM supplier WHERE id='$id';";
  if(mysqli_query($conn,$sql))
  {
    echo "Deleated successfully";
  }
  else
  {
    echo "Error deleting data: " . mysqli_error($conn);
  }
 ?>