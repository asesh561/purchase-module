<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_module";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());

}

$quantity = $_GET['quantity'];
$sql = "SELECT rate_unit,units FROM purchase_order WHERE quantity='$quantity'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $data = array(
        'units' => $row['units'],
        'rate_unit' => $row['rate_unit'],
        
      );
      echo json_encode($data);
} else {
    echo "No results found.";
}

mysqli_close($conn);
?>