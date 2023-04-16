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

$sql = "SELECT DISTINCT total_value FROM purchase_order WHERE po='" . $po . "'";
$result = mysqli_query($conn, $sql);


if($result && mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)) {
    echo $row['total_value'];
}
} else {
  echo "No items found";
}

mysqli_close($conn);
?>