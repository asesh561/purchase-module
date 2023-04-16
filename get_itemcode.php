<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_module";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

$category = $_GET['category'];

$sql = "SELECT DISTINCT item_code FROM item WHERE category='" . $category . "'";
$result = mysqli_query($conn, $sql);

if
($result && mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['item_code'] . "'>" . $row['item_code'] . "</option>";
}
} else {
echo "<option value=''>No cities found</option>";
}

mysqli_close($conn);
?>