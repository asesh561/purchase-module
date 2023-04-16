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

$item_code = $_GET['item_code'];


$sql = "SELECT DISTINCT description FROM item WHERE item_code='" . $item_code . "'";
$result = mysqli_query($conn, $sql);

if
($result && mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['description'] . "'>" . $row['description'] . "</option>";
}
} else {
echo "<option value=''>No cities found</option>";
}

mysqli_close($conn);
?>