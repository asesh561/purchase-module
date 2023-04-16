<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_module";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$po = $_GET['po'];

$sql = "SELECT DISTINCT Freight, Discount FROM other_expances WHERE po='" . $po . "'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $data = array(
    'Freight' => $row['Freight'],
    'Discount' => $row['Discount']
   
  );
  echo json_encode($data);
} else {
  echo "No items found";
}

mysqli_close($conn);
?>