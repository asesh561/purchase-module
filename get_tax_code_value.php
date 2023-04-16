<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_module";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());

}

$tc = $_GET['tc'];
$sql = "SELECT tcv FROM tax_master WHERE tc='$tc'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $tcv = $row["tcv"];

    // Pass the $tcv value to JavaScript
    echo $tcv;
} else {
    echo "No results found.";
}

mysqli_close($conn);
?>