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

$name = $_GET['name'];

$sql = "SELECT DISTINCT code FROM supplier WHERE name='" . $name . "' ORDER BY code";
$result = mysqli_query($conn, $sql);

if
($result && mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['code'] . "'>" . $row['code'] . "</option>";
}
} else {
echo "<option value=''>No cities found</option>";
}

mysqli_close($conn);
?>