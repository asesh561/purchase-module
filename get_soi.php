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

$sql = "SELECT DISTINCT item_code, description, quantity,tax FROM purchase_order WHERE po='" . $po . "'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $data = array(
    'item_code' => $row['item_code'],
    'description' => $row['description'],
    'quantity' => $row['quantity'],
    'tax' => $row['tax']
  );
  echo json_encode($data);
} else {
  echo "No items found";
}

mysqli_close($conn);
?>