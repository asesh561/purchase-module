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

$sql = "SELECT DISTINCT aq, rq, price,shrinkage,bag_type,bag FROM quantity WHERE po='" . $po . "'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $data = array(
    'aq' => $row['aq'],
    'rq' => $row['rq'],
    'price' => $row['price'],
    'shrinkage' => $row['shrinkage'],
    'bag_type' => $row['bag_type'],
    'bag' => $row['bag'],
  );
  echo json_encode($data);
} else {
  echo "No items found";
}

mysqli_close($conn);
?>